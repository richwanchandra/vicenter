<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Module;
use App\Models\User;
use App\Services\ContentFormatter;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportPptxContent extends Command
{
    protected $signature = 'content:import-pptx {--fresh : Clear all existing content before importing}';
    protected $description = 'Extract content and images from PPTX files, split by section, and distribute to deepest matching sub-module';

    /**
     * Mapping: PPTX filename => parent module slug.
     * Children are resolved dynamically from the database module tree.
     */
    protected array $pptxParentMap = [
        'HRD Website.pptx' => 'human-resource-development',
        'Production (CK-Cold) Website.pptx' => '5-4-produksi-gelato',
        'Project WEB peraturan umum perusahaan 2026.pptx' => 'how-we-work',
        'Store operation.pptx' => '5-5-store-operation',
        'Team Packaging Profile Website  (1).pptx' => 'packing-dept',
    ];

    /** @var Collection Full module tree (flat list with loaded descendants) */
    protected Collection $allModules;

    /** @var array Audit log entries */
    protected array $auditLog = [];

    public function handle(): int
    {
        $this->info('=== PPTX Content Importer v3 — Deep Sub-Module Distribution ===');
        $this->newLine();

        // Ensure images dir
        $imgDir = public_path('images/content');
        if (!File::isDirectory($imgDir)) {
            File::makeDirectory($imgDir, 0755, true);
        }

        // Get super admin
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->error('No super admin user found!');
            return 1;
        }

        // Fresh mode
        if ($this->option('fresh')) {
            $deleted = Content::count();
            Content::truncate();
            $this->warn("🗑  Cleared {$deleted} existing content entries.");
        }

        // --- Load full module tree from database ---
        $this->allModules = Module::where('is_active', true)
            ->orderBy('order_number')
            ->get();

        $this->info("📚 Loaded {$this->allModules->count()} modules from database");
        $this->newLine();

        $basePath = base_path();
        $totalContent = 0;
        $totalImages = 0;

        foreach ($this->pptxParentMap as $filename => $parentSlug) {
            $filepath = $basePath . DIRECTORY_SEPARATOR . $filename;

            if (!file_exists($filepath)) {
                $this->warn("  ⚠ File not found: {$filename} — skipping");
                continue;
            }

            $parentModule = $this->allModules->where('slug', $parentSlug)->first();
            if (!$parentModule) {
                $this->warn("  ⚠ Parent module '{$parentSlug}' not found — skipping");
                continue;
            }

            $this->info("📂 Processing: {$filename}");
            $this->info("   ↳ Parent module: {$parentModule->name}");

            [$contents, $images] = $this->processPptx($filepath, $filename, $imgDir, $parentModule, $admin);
            $totalContent += $contents;
            $totalImages += $images;

            $this->newLine();
        }

        // Print audit log
        $this->newLine();
        $this->info('📋 Distribution Audit Log:');
        $this->table(
            ['Section', 'Matched Module', 'Depth'],
            array_map(fn($log) => [$log['section'], $log['module'], $log['depth']], $this->auditLog)
        );

        $this->newLine();
        $this->info("✅ Done! Created {$totalContent} content entries with {$totalImages} images.");
        return 0;
    }

    /**
     * Process a single PPTX file: extract images, parse slides, split into sections,
     * and distribute each section to the deepest matching sub-module.
     */
    protected function processPptx(
        string $filepath,
        string $filename,
        string $imgDir,
        Module $parentModule,
        User $admin
    ): array {
        $zip = new \ZipArchive();
        if ($zip->open($filepath) !== true) {
            $this->error("  Cannot open: {$filename}");
            return [0, 0];
        }

        // --- Extract images ---
        $extractedImages = $this->extractImages($zip, $filename, $imgDir);
        $this->line("   📷 {$this->n(count($extractedImages), 'image')} extracted");

        // --- Parse slides ---
        $slideFiles = $this->findSlideFiles($zip);
        $slideImageMap = $this->mapImagesToSlides($zip, $slideFiles, $extractedImages);

        // --- Extract text from all slides, preserving paragraph structure ---
        $allSlideData = [];
        foreach ($slideFiles as $slideNum => $slidePath) {
            $slideXml = $zip->getFromName($slidePath);
            if (!$slideXml)
                continue;

            $paragraphs = $this->extractParagraphsFromSlideXml($slideXml);
            $images = $slideImageMap[$slideNum] ?? [];

            if (empty($paragraphs) && empty($images))
                continue;

            $allSlideData[] = [
                'num' => $slideNum,
                'paragraphs' => $paragraphs,
                'images' => $images,
            ];
        }

        $zip->close();

        // --- Split all slides into logical sections by heading ---
        $sections = $this->splitIntoSections($allSlideData);
        $this->line("   📑 {$this->n(count($sections), 'section')} detected");

        // --- Get the full descendant tree of the parent module ---
        $descendantTree = $this->getDescendants($parentModule->id);

        // --- Distribute each section to deepest matching module ---
        $contentCount = 0;
        $parentSections = []; // Sections that don't match any child

        foreach ($sections as $section) {
            $sectionTitle = $section['heading'] ?? '';
            $sectionText = $section['full_text'] ?? '';

            // Try to find deepest matching module in the tree
            $matchedModule = $this->findDeepestMatch($sectionTitle, $sectionText, $descendantTree);

            if ($matchedModule) {
                $html = $this->buildSectionHtml($section);
                $this->insertContent($matchedModule, $html, $admin);
                $contentCount++;

                $depth = $this->getModuleDepth($matchedModule, $parentModule);
                $this->auditLog[] = [
                    'section' => Str::limit($sectionTitle ?: '(no heading)', 50),
                    'module' => $matchedModule->name,
                    'depth' => $depth,
                ];
                $this->line("     ✅ \"{$sectionTitle}\" → <info>{$matchedModule->name}</info> (depth {$depth})");
            } else {
                $parentSections[] = $section;
            }
        }

        // --- Unmatched sections go to parent ---
        if (!empty($parentSections)) {
            $html = '';
            foreach ($parentSections as $section) {
                $html .= $this->buildSectionHtml($section) . "\n";
            }
            $this->insertContent($parentModule, trim($html), $admin);
            $contentCount++;

            foreach ($parentSections as $section) {
                $heading = $section['heading'] ?? '(no heading)';
                $this->auditLog[] = [
                    'section' => Str::limit($heading, 50),
                    'module' => $parentModule->name . ' (parent/fallback)',
                    'depth' => 0,
                ];
                $this->line("     📄 \"{$heading}\" → <comment>{$parentModule->name}</comment> (fallback)");
            }
        }

        return [$contentCount, count($extractedImages)];
    }

    // =====================================================================
    //  IMAGE EXTRACTION
    // =====================================================================

    protected function extractImages(\ZipArchive $zip, string $filename, string $imgDir): array
    {
        $extracted = [];
        $prefix = Str::slug(pathinfo($filename, PATHINFO_FILENAME));

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);
            if (!str_starts_with($entry, 'ppt/media/'))
                continue;

            $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'bmp', 'webp']))
                continue;

            $mediaName = basename($entry);
            $targetName = $prefix . '_' . $mediaName;
            $content = $zip->getFromIndex($i);

            if ($content !== false) {
                file_put_contents($imgDir . DIRECTORY_SEPARATOR . $targetName, $content);
                $extracted[$mediaName] = '/images/content/' . $targetName;
            }
        }

        return $extracted;
    }

    // =====================================================================
    //  SLIDE PARSING
    // =====================================================================

    protected function findSlideFiles(\ZipArchive $zip): array
    {
        $slides = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (preg_match('#^ppt/slides/slide(\d+)\.xml$#', $name, $m)) {
                $slides[(int) $m[1]] = $name;
            }
        }
        ksort($slides);
        return $slides;
    }

    protected function mapImagesToSlides(\ZipArchive $zip, array $slideFiles, array $images): array
    {
        $map = [];
        foreach ($slideFiles as $num => $path) {
            $rels = $zip->getFromName("ppt/slides/_rels/slide{$num}.xml.rels");
            if (!$rels)
                continue;

            $xml = @simplexml_load_string($rels);
            if (!$xml)
                continue;

            foreach ($xml->Relationship as $rel) {
                $target = (string) $rel['Target'];
                if (str_contains($target, 'media/')) {
                    $mediaName = basename($target);
                    if (isset($images[$mediaName])) {
                        $map[$num][] = $images[$mediaName];
                    }
                }
            }
        }
        return $map;
    }

    /**
     * Extract paragraphs (text blocks) from a slide XML, preserving structure.
     * Returns an array of paragraph strings.
     */
    protected function extractParagraphsFromSlideXml(string $xml): array
    {
        $xml = preg_replace('/\s+xmlns[^=]*="[^"]*"/', '', $xml);
        $xml = preg_replace('/(<\/?)([a-z]):/', '$1$2_', $xml);

        $doc = @simplexml_load_string($xml);
        if (!$doc)
            return [];

        $paragraphs = [];
        $this->extractParagraphsRecursive($doc, $paragraphs);

        return array_values(array_filter(array_map('trim', $paragraphs)));
    }

    protected function extractParagraphsRecursive(\SimpleXMLElement $el, array &$paragraphs, string $currentRun = ''): void
    {
        foreach ($el->children() as $child) {
            $name = $child->getName();

            // a:p is a paragraph element
            if ($name === 'a_p' || $name === 'p') {
                // Flush previous run if needed
                $paraText = '';
                $this->extractRunsFromParagraph($child, $paraText);
                $paraText = trim($paraText);
                if (!empty($paraText)) {
                    $paragraphs[] = $paraText;
                }
            } else {
                $this->extractParagraphsRecursive($child, $paragraphs, $currentRun);
            }
        }
    }

    protected function extractRunsFromParagraph(\SimpleXMLElement $el, string &$text): void
    {
        foreach ($el->children() as $child) {
            $name = $child->getName();
            if ($name === 'a_t' || $name === 't') {
                $text .= (string) $child;
            } else {
                $this->extractRunsFromParagraph($child, $text);
            }
        }
    }

    // =====================================================================
    //  SECTION SPLITTING
    // =====================================================================

    /**
     * Split all slides into logical sections.
     * A new section starts when a heading-like line is detected.
     */
    protected function splitIntoSections(array $allSlideData): array
    {
        $sections = [];
        $currentSection = null;

        foreach ($allSlideData as $slide) {
            $paragraphs = $slide['paragraphs'];
            $images = $slide['images'];

            if (empty($paragraphs) && empty($images))
                continue;

            // Check if the first paragraph of this slide is a heading → new section
            $firstPara = $paragraphs[0] ?? '';
            $isNewSection = $this->isHeadingLine($firstPara);

            if ($isNewSection) {
                // Save previous section
                if ($currentSection !== null) {
                    $sections[] = $this->finalizeSection($currentSection);
                }

                // Start new section
                $currentSection = [
                    'heading' => $firstPara,
                    'paragraphs' => array_slice($paragraphs, 1),
                    'images' => $images,
                ];
            } else {
                // Append to current section (or create first section)
                if ($currentSection === null) {
                    $currentSection = [
                        'heading' => $firstPara,
                        'paragraphs' => array_slice($paragraphs, 1),
                        'images' => $images,
                    ];
                } else {
                    $currentSection['paragraphs'] = array_merge(
                        $currentSection['paragraphs'],
                        $paragraphs
                    );
                    $currentSection['images'] = array_merge(
                        $currentSection['images'],
                        $images
                    );
                }
            }
        }

        // Don't forget the last section
        if ($currentSection !== null) {
            $sections[] = $this->finalizeSection($currentSection);
        }

        return $sections;
    }

    protected function finalizeSection(array $section): array
    {
        // Build full text for matching purposes
        $allText = $section['heading'] . ' '
            . implode(' ', $section['paragraphs']);
        $section['full_text'] = $allText;
        return $section;
    }

    protected function isHeadingLine(string $line): bool
    {
        $trimmed = trim($line);
        if (empty($trimmed))
            return false;

        $len = mb_strlen($trimmed);
        if ($len > 100)
            return false; // Too long for a heading
        if ($len < 3)
            return false;  // Too short

        // ALL CAPS (strong indicator of heading)
        if ($trimmed === mb_strtoupper($trimmed) && preg_match('/[A-Z]/', $trimmed) && $len >= 5) {
            return true;
        }
        // Title Case
        if ($this->isTitleCase($trimmed) && $len <= 70) {
            return true;
        }
        // Ends with colon (section header pattern)
        if (str_ends_with($trimmed, ':') && $len >= 5 && $len <= 90) {
            return true;
        }
        // Starts with number + dot or dash (common in procedures)
        if (preg_match('/^[\d]+[\.\)]\s+[A-Z]/', $trimmed) && $len <= 80) {
            return false; // This is a list item, not heading
        }
        // Short, Title-like line
        if ($this->isTitleCase($trimmed) && $len <= 50) {
            return true;
        }

        return false;
    }

    // =====================================================================
    //  DEEP MODULE MATCHING
    // =====================================================================

    /**
     * Get all descendants of a module as a flat collection.
     */
    protected function getDescendants(int $parentId): Collection
    {
        $children = $this->allModules->where('parent_id', $parentId);
        $descendants = collect();

        foreach ($children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getDescendants($child->id));
        }

        return $descendants;
    }

    /**
     * Find the deepest matching module in the tree for a given section.
     * Uses hierarchical heading depth to help find most specific match.
     * Priority: exact slug match → exact title match → partial title match → partial slug match.
     */
    protected function findDeepestMatch(string $heading, string $fullText, Collection $descendants): ?Module
    {
        if (empty(trim($heading)) && empty(trim($fullText)))
            return null;

        $headingLower = strtolower(trim($heading));
        $headingSlug = Str::slug($heading);
        $fullTextLower = strtolower($fullText);

        $bestMatch = null;
        $bestScore = 0;
        $bestDepth = 0;

        foreach ($descendants as $module) {
            $moduleName = strtolower($module->name);
            $moduleSlug = $module->slug;
            $moduleNameSlug = Str::slug($module->name);

            $score = 0;
            $depth = $this->getModuleDepthById($module->id);

            // --- Scoring system (Enhanced for deep matching) ---

            // 1. Exact slug match with heading slug (HIGHEST - no depth boost needed)
            if ($headingSlug === $moduleSlug || $headingSlug === $moduleNameSlug) {
                $score = 10000; // Absolute highest, exact match
            }
            // 2. Exact title match (case-insensitive) - very high
            elseif ($headingLower === $moduleName) {
                $score = 9000;
            }
            // 3. Module name exactly in heading (or vice versa) - exact word match
            elseif (!empty($headingLower)) {
                $headingWords = array_filter(explode(' ', $headingLower), fn($w) => mb_strlen($w) > 2);
                $moduleWords = array_filter(explode(' ', $moduleName), fn($w) => mb_strlen($w) > 2);
                
                // Count exact word matches
                $exactWordMatches = 0;
                foreach ($moduleWords as $mw) {
                    if (in_array($mw, $headingWords)) {
                        $exactWordMatches++;
                    }
                }
                
                if ($exactWordMatches > 0 && count($moduleWords) > 0) {
                    $wordMatchRatio = $exactWordMatches / count($moduleWords);
                    
                    // Require high word match before considering depth boost
                    if ($wordMatchRatio >= 0.7) {
                        // All or most words match - very specific
                        $score = 8000 + ($wordMatchRatio * 1000);
                    } elseif ($wordMatchRatio >= 0.5) {
                        // Half or more words match - good match
                        $score = 7000 + ($wordMatchRatio * 1000);
                    }
                }
                
                // Fallback: substring match (not as good)
                if ($score == 0) {
                    if (str_contains($headingLower, $moduleName) && mb_strlen($moduleName) > 4) {
                        $score = 3500 + (mb_strlen($moduleName) / 2);
                    } elseif (str_contains($moduleName, $headingLower) && mb_strlen($headingLower) > 4) {
                        $score = 3000 + (mb_strlen($headingLower) / 2);
                    }
                }
            }
            // 4. Full text contains module name (weak match)
            if ($score == 0 && str_contains($fullTextLower, $moduleName) && mb_strlen($moduleName) >= 5) {
                $score = 1000 + (mb_strlen($moduleName) / 2);
            }

            // When updating best match:
            // - Always update if score is strictly higher
            // - If scores are tied, prefer SHALLOWER module (closer to parent is safer)
            if ($score > $bestScore || ($score > 0 && abs($score - $bestScore) < 100 && $depth < $bestDepth)) {
                $bestScore = $score;
                $bestMatch = $module;
                $bestDepth = $depth;
            }
        }

        // Only return match if score is meaningful (>= 500)
        return $bestScore >= 500 ? $bestMatch : null;
    }

    protected function getModuleDepth(Module $module, Module $root): int
    {
        $depth = 0;
        $current = $module;
        while ($current && $current->id !== $root->id) {
            $depth++;
            $current = $this->allModules->where('id', $current->parent_id)->first();
        }
        return $depth;
    }

    protected function getModuleDepthById(int $moduleId): int
    {
        $depth = 0;
        $current = $this->allModules->where('id', $moduleId)->first();
        while ($current && $current->parent_id) {
            $depth++;
            $current = $this->allModules->where('id', $current->parent_id)->first();
        }
        return $depth;
    }

    // =====================================================================
    //  HTML BUILDER — Using ContentFormatter Service
    // =====================================================================

    /**
     * Build formatted HTML for a single section using ContentFormatter.
     */
    protected function buildSectionHtml(array $section): string
    {
        $formatter = new ContentFormatter();
        
        $html = '<div class="content-wrapper">' . "\n";

        // Heading
        if (!empty($section['heading'])) {
            $formatted = $this->formatHeading($section['heading']);
            $anchorId = Str::slug($formatted);
            $html .= '<h2 id="' . e($anchorId) . '">' . e($formatted) . '</h2>' . "\n";
        }

        // Body paragraphs - Use ContentFormatter for automatic formatting
        if (!empty($section['paragraphs'])) {
            $formattedContent = $formatter->format($section['paragraphs']);
            $html .= $formattedContent . "\n";
        }

        // Images
        if (!empty($section['images'])) {
            $html .= '<div class="content-images" style="margin: 1.5rem 0;">' . "\n";
            foreach ($section['images'] as $imgPath) {
                $html .= '  <figure style="margin: 1rem 0;">' . "\n";
                $html .= '    <img src="' . e($imgPath) . '" alt="Ilustrasi" style="max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" loading="lazy">' . "\n";
                $html .= '  </figure>' . "\n";
            }
            $html .= '</div>' . "\n";
        }

        $html .= '</div>' . "\n";
        return trim($html);
    }

    /**
     * Classify a line as h2, h3, ol, ul, or p.
     */
    protected function classifyLine(string $line, int $lineIndex, int $totalLines): string
    {
        $trimmed = trim($line);

        // Numbered list
        if (preg_match('/^\d+[\.)]\s+/', $trimmed))
            return 'ol';
        if (preg_match('/^[a-z][\.)]\s+/i', $trimmed) && mb_strlen($trimmed) < 120)
            return 'ol';

        // Bullet list
        if (preg_match('/^[\-\•\●\►\▪\→\★\✓\✔\➤\⮞\☑\*]\s*/', $trimmed))
            return 'ul';

        // Heading detection
        $isShort = mb_strlen($trimmed) <= 60;
        $isAllCaps = ($trimmed === mb_strtoupper($trimmed) && preg_match('/[A-Z]/', $trimmed));

        if ($isAllCaps && $isShort)
            return 'h3';
        if ($this->isTitleCase($trimmed) && $isShort && $lineIndex <= 2)
            return 'h3';
        if (str_ends_with($trimmed, ':') && mb_strlen($trimmed) <= 80)
            return 'h3';

        return 'p';
    }

    protected function renderClassifiedLines(array $classified): string
    {
        $html = '';
        $i = 0;
        $total = count($classified);

        while ($i < $total) {
            $type = $classified[$i]['type'];
            $text = $classified[$i]['text'];

            switch ($type) {
                case 'h2':
                    $f = $this->formatHeading($text);
                    $html .= '<h2 id="' . e(Str::slug($f)) . '">' . e($f) . '</h2>' . "\n";
                    $i++;
                    break;

                case 'h3':
                    $f = $this->formatHeading($text);
                    $html .= '<h3 id="' . e(Str::slug($f)) . '">' . e($f) . '</h3>' . "\n";
                    $i++;
                    break;

                case 'ol':
                    $html .= '<ol>' . "\n";
                    while ($i < $total && $classified[$i]['type'] === 'ol') {
                        $li = $this->stripListPrefix($classified[$i]['text']);
                        $html .= '  <li>' . e($li) . '</li>' . "\n";
                        $i++;
                    }
                    $html .= '</ol>' . "\n";
                    break;

                case 'ul':
                    $html .= '<ul>' . "\n";
                    while ($i < $total && $classified[$i]['type'] === 'ul') {
                        $li = $this->stripBulletPrefix($classified[$i]['text']);
                        $html .= '  <li>' . e($li) . '</li>' . "\n";
                        $i++;
                    }
                    $html .= '</ul>' . "\n";
                    break;

                default:
                    $parts = [];
                    while ($i < $total && $classified[$i]['type'] === 'p') {
                        $parts[] = e($classified[$i]['text']);
                        $i++;
                    }
                    if (count($parts) <= 3) {
                        $html .= '<p>' . implode(' ', $parts) . '</p>' . "\n";
                    } else {
                        foreach (array_chunk($parts, 3) as $chunk) {
                            $html .= '<p>' . implode(' ', $chunk) . '</p>' . "\n";
                        }
                    }
                    break;
            }
        }

        return $html;
    }

    // =====================================================================
    //  TEXT UTILITIES
    // =====================================================================

    protected function formatHeading(string $text): string
    {
        $text = rtrim(trim($text), ':');
        $text = trim($text);

        if ($text === mb_strtoupper($text) && preg_match('/[A-Z]/', $text)) {
            $text = mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
            $abbrs = ['HRD', 'GA', 'SOP', 'BPJS', 'KPI', 'SLA', 'CAPEX', 'OPEX', 'QC', 'AC', 'HP', 'CK', 'HR', 'IT'];
            foreach ($abbrs as $a) {
                $text = preg_replace(
                    '/\b' . preg_quote(mb_convert_case($a, MB_CASE_TITLE, 'UTF-8'), '/') . '\b/i',
                    $a,
                    $text
                );
            }
        }

        return $text;
    }

    protected function isTitleCase(string $text): bool
    {
        $words = explode(' ', $text);
        $capitalizedCount = 0;
        $skip = ['dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'atau', 'atau dan', 'the', 'and', 'of', 'in', 'to', 'for', '&', '-', '/', 'a', 'an'];

        foreach ($words as $w) {
            $w = trim($w);
            if (empty($w) || in_array(strtolower($w), $skip))
                continue;
            if (ctype_upper(mb_substr($w, 0, 1)) || ctype_digit(mb_substr($w, 0, 1)))
                $capitalizedCount++;
        }

        $total = count(array_filter($words, fn($w) => !empty(trim($w)) && !in_array(strtolower(trim($w)), $skip)));
        // More lenient: 40%+ capitalized words is acceptable
        return $total > 0 && ($capitalizedCount / max($total, 1)) >= 0.4;
    }

    protected function stripListPrefix(string $t): string
    {
        return trim(preg_replace('/^[\da-z]+[\.)]\s*/i', '', $t));
    }

    protected function stripBulletPrefix(string $t): string
    {
        return trim(preg_replace('/^[\-\•\●\►\▪\→\★\✓\✔\➤\⮞\☑\*]\s*/', '', $t));
    }

    // =====================================================================
    //  DATABASE
    // =====================================================================

    protected function insertContent(Module $module, string $html, User $admin): void
    {
        if (empty(trim($html)))
            return;

        $existing = Content::where('module_id', $module->id)->first();

        if ($existing) {
            $existing->update([
                'content' => $existing->content . "\n<hr style=\"border:none;border-top:1px solid #e2e6ed;margin:2rem 0;\">\n" . $html,
                'updated_by' => $admin->id,
            ]);
        } else {
            Content::create([
                'module_id' => $module->id,
                'title' => $module->name,
                'content' => $html,
                'status' => 'publish',
                'created_by' => $admin->id,
            ]);
        }
    }

    protected function n(int $count, string $noun): string
    {
        return $count . ' ' . $noun . ($count !== 1 ? 's' : '');
    }
}
