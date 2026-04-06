<?php

namespace App\Services;

use Illuminate\Support\Str;

class ContentFormatter
{
    private const HEADING_LEVELS = [
        'h2' => '/^(#{2}|==)/s',  // Markdown ##
        'h3' => '/^(#{3}|--)/s',  // Markdown ###
    ];

    /**
     * Format raw content into clean, structured HTML
     *
     * @param array|string $content Raw content (array of paragraphs or single string)
     * @return string Formatted HTML
     */
    public function format($content): string
    {
        if (is_array($content)) {
            $content = implode("\n", $content);
        }

        $lines = array_filter(array_map('trim', explode("\n", $content)), fn($line) => !empty($line));
        if (empty($lines)) {
            return '';
        }

        return $this->renderLines($lines);
    }

    /**
     * Main rendering engine
     */
    private function renderLines(array $lines): string
    {
        $html = '';
        $i = 0;
        $total = count($lines);

        while ($i < $total) {
            if (!isset($lines[$i])) {
                $i++;
                continue;
            }
            $line = $lines[$i];
            $classification = $this->classifyLine($line, $i, $total, $lines);

            switch ($classification) {
                case 'h2':
                    $html .= $this->renderHeading($line, 2);
                    $i++;
                    break;

                case 'h3':
                    $html .= $this->renderHeading($line, 3);
                    $i++;
                    break;

                case 'h4':
                    $html .= $this->renderHeading($line, 4);
                    $i++;
                    break;

                case 'ol':
                    [$html_segment, $i] = $this->renderOrderedList($lines, $i);
                    $html .= $html_segment;
                    break;

                case 'ul':
                    [$html_segment, $i] = $this->renderUnorderedList($lines, $i);
                    $html .= $html_segment;
                    break;

                case 'p':
                default:
                    [$html_segment, $i] = $this->renderParagraphs($lines, $i, $total);
                    $html .= $html_segment;
                    break;
            }
        }

        return trim($html);
    }

    /**
     * Classify a single line
     */
    private function classifyLine(string $line, int $index, int $total, array $allLines): string
    {
        $trimmed = trim($line);
        if (empty($trimmed)) {
            return 'skip';
        }

        // Numbered list: 1., 2., a), i), etc.
        if ($this->isNumberedListItem($trimmed)) {
            return 'ol';
        }

        // Bullet/Unordered list
        if ($this->isBulletListItem($trimmed)) {
            return 'ul';
        }

        // Heading detection
        if ($headingLevel = $this->detectHeading($trimmed, $index, $total, $allLines)) {
            return $headingLevel;
        }

        // Default: paragraph
        return 'p';
    }

    /**
     * Detect if line is a numbered list item
     */
    private function isNumberedListItem(string $line): bool
    {
        // Match: 1. , 2) , a. , (i) , etc.
        $patterns = [
            '/^\d+[\.)]\s+/',        // 1. or 1) 
            '/^[a-z][\.)]\s+/i',     // a. or a)
            '/^\([ivxlcdm]+\)\s+/i', // (i) or (v)
            '/^[-•→►*]\s+/',         // • or - or →
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $line)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if line is a bullet list item
     */
    private function isBulletListItem(string $line): bool
    {
        $bulletPatterns = [
            '/^\s*[-•●►▪→★✓✔➤⮞☑✗]\s+/',
            '/^\s*\*\s+/',
            '/^\s*\+\s+/',
        ];

        foreach ($bulletPatterns as $pattern) {
            if (preg_match($pattern, $line)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect heading level (h2, h3, h4)
     */
    private function detectHeading(string $line, int $index, int $total, array $allLines): ?string
    {
        $len = mb_strlen($line);

        // Rule 1: ALL CAPS + short = h2
        if ($line === mb_strtoupper($line) && preg_match('/[A-Z]/', $line) && $len >= 5 && $len <= 80) {
            return 'h2';
        }

        // Rule 2: Title Case + short + early position = h3
        if ($index <= 1 && $this->isTitleCase($line) && $len <= 60) {
            return 'h3';
        }

        // Rule 3: Ends with colon (section header) = h3
        if (str_ends_with($line, ':') && $len >= 5 && $len <= 80) {
            return 'h3';
        }

        // Rule 4: Bold pattern (indicators like ** or __) = h4
        if (preg_match('/^\*{1,2}[^*]+\*{1,2}$/i', $line) || preg_match('/^_{1,2}[^_]+_{1,2}$/i', $line)) {
            return 'h4';
        }

        // Rule 5: Title case, short, looks like heading = h3
        if ($this->isTitleCase($line) && $len >= 5 && $len <= 60) {
            return 'h3';
        }

        // Rule 6: Check if next lines form a list (header above list) = h3
        if ($index < $total - 1) {
            $nextNonEmpty = null;
            for ($j = $index + 1; $j < $total && $j < $index + 3; $j++) {
                $nextTrimmed = trim($allLines[$j] ?? '');
                if (!empty($nextTrimmed)) {
                    $nextNonEmpty = $nextTrimmed;
                    break;
                }
            }
            if ($nextNonEmpty && ($this->isNumberedListItem($nextNonEmpty) || $this->isBulletListItem($nextNonEmpty))) {
                if ($len >= 5 && $len <= 80) {
                    return 'h3';
                }
            }
        }

        return null;
    }

    /**
     * Check if string is title case
     */
    private function isTitleCase(string $text): bool
    {
        $words = explode(' ', trim($text));
        $skip = ['dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'atau', 'the', 'and', 'of', 'in', 'to', 'for', '&', '-', '/', 'a', 'an'];

        $capitalizedCount = 0;
        $checkableCount = 0;

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word) || in_array(strtolower($word), $skip)) {
                continue;
            }

            $checkableCount++;
            if (ctype_upper(mb_substr($word, 0, 1))) {
                $capitalizedCount++;
            }
        }

        return $checkableCount > 0 && ($capitalizedCount / max($checkableCount, 1)) >= 0.5;
    }

    /**
     * Render heading with proper formatting
     */
    private function renderHeading(string $line, int $level): string
    {
        $text = trim($line, ':#*_');
        $text = trim($text);

        // Convert ALL CAPS to Title Case
        if ($text === mb_strtoupper($text) && preg_match('/[A-Z]/', $text)) {
            $text = mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
            // Preserve abbreviations
            $abbrs = ['HRD', 'GA', 'SOP', 'BPJS', 'KPI', 'SLA', 'CAPEX', 'OPEX', 'QC', 'AC', 'HP', 'CK', 'HR', 'IT', 'UI', 'UX'];
            foreach ($abbrs as $a) {
                $text = preg_replace('/\b' . preg_quote(mb_convert_case($a, MB_CASE_TITLE, 'UTF-8'), '/') . '\b/i', $a, $text);
            }
        }

        $anchorId = Str::slug($text);
        $tag = 'h' . $level;

        return "<{$tag} id=\"{$anchorId}\" class=\"content-heading level-{$level}\">" . e($text) . "</{$tag}>\n";
    }

    /**
     * Render ordered list block
     */
    private function renderOrderedList(array $lines, int $startIndex): array
    {
        $html = '';
        $i = $startIndex;

        $html .= "<ol class=\"content-list ordered-list\">\n";

        while ($i < count($lines)) {
            $line = trim($lines[$i] ?? '');

            if (!empty($line) && $this->isNumberedListItem($line)) {
                $itemText = $this->stripListPrefix($line);
                $html .= "  <li>" . e($itemText) . "</li>\n";
                $i++;
            } elseif (empty($line)) {
                // Skip empty line, but check if next is list item
                $nextIdx = $i + 1;
                if ($nextIdx < count($lines) && $this->isNumberedListItem(trim($lines[$nextIdx]))) {
                    $i++;
                    continue;
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        $html .= "</ol>\n";

        return [$html, $i];
    }

    /**
     * Render unordered list block
     */
    private function renderUnorderedList(array $lines, int $startIndex): array
    {
        $html = '';
        $i = $startIndex;

        $html .= "<ul class=\"content-list unordered-list\">\n";

        while ($i < count($lines)) {
            $line = trim($lines[$i] ?? '');

            if (!empty($line) && $this->isBulletListItem($line)) {
                $itemText = $this->stripBulletPrefix($line);
                $html .= "  <li>" . e($itemText) . "</li>\n";
                $i++;
            } elseif (empty($line)) {
                // Skip empty line, but check if next is list item
                $nextIdx = $i + 1;
                if ($nextIdx < count($lines) && $this->isBulletListItem(trim($lines[$nextIdx]))) {
                    $i++;
                    continue;
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        $html .= "</ul>\n";

        return [$html, $i];
    }

    /**
     * Render paragraph block (group consecutive non-list lines)
     */
    private function renderParagraphs(array $lines, int $startIndex, int $total): array
    {
        $html = '';
        $i = $startIndex;
        $paragraphLines = [];

        while ($i < $total) {
            $line = trim($lines[$i] ?? '');

            // Stop if we hit a list or heading
            if (!empty($line) && ($this->isNumberedListItem($line) || $this->isBulletListItem($line))) {
                break;
            }

            if (!empty($line)) {
                // Check if this line is a heading (shouldn't happen, but safety check)
                if ($this->detectHeading($line, $i, $total, $lines)) {
                    break;
                }
                $paragraphLines[] = $line;
            } elseif (!empty($paragraphLines)) {
                // Empty line after content = end paragraph group
                $i++;
                break;
            }

            $i++;
        }

        if (!empty($paragraphLines)) {
            $combined = implode(' ', $paragraphLines);
            $html .= "<p class=\"content-paragraph\">" . e($combined) . "</p>\n";
        }

        return [$html, $i];
    }

    /**
     * Strip numbered list prefix (1., a), (i), etc.)
     */
    private function stripListPrefix(string $text): string
    {
        $text = trim($text);
        // Remove prefixes: "1. ", "a) ", "(i) ", etc.
        return trim(preg_replace('/^[\da-z][.)]\s*|\^(\([ivxlcdm]+\))\s*/i', '', $text));
    }

    /**
     * Strip bullet prefix
     */
    private function stripBulletPrefix(string $text): string
    {
        $text = trim($text);
        return trim(preg_replace('/^[-•●►▪→★✓✔➤⮞☑✗\*\+]\s*/', '', $text));
    }

    /**
     * Wrap formatted content with content-wrapper
     */
    public function wrapContent(string $html, ?string $title = null): string
    {
        $wrapper = '<div class="content-wrapper">' . "\n";

        if ($title) {
            $anchorId = Str::slug($title);
            $wrapper .= '<h2 id="' . e($anchorId) . '" class="content-title">' . e($title) . '</h2>' . "\n";
        }

        $wrapper .= $html;
        $wrapper .= '</div>' . "\n";

        return $wrapper;
    }

    /**
     * Format and wrap in one call
     */
    public function formatAndWrap($content, ?string $title = null): string
    {
        $formatted = $this->format($content);
        return $this->wrapContent($formatted, $title);
    }
}
