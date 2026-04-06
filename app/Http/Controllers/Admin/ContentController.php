<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Content;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    /**
     * Display contents for a module.
     */
    public function index(Module $module): View
    {
        $contents = $module->contents()
            ->with('creator', 'updater')
            ->latest()
            ->get();

        return view('admin.contents.index', [
            'module' => $module,
            'contents' => $contents,
        ]);
    }

    /**
     * Show the form for creating new content.
     */
    public function create(Module $module): View
    {
        return view('admin.contents.create', [
            'module' => $module,
        ]);
    }

    /**
     * Store a newly created content.
     */
    public function store(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,publish'],
        ]);

        $validated['content'] = $this->sanitizeHtml($validated['content']);
        $validated['module_id'] = $module->id;
        $validated['created_by'] = auth()->id();

        $content = Content::create($validated);

        ActivityLog::log(
            auth()->user(),
            'create_content',
            $module,
            "Created new content: {$content->title}"
        );

        return redirect()->route('admin.modules.contents.index', $module)
            ->with('success', 'Content created successfully.');
    }

    /**
     * Show the form for editing content.
     */
    public function edit(Module $module, Content $content): View
    {
        if ($content->module_id !== $module->id) {
            abort(404);
        }

        return view('admin.contents.edit', [
            'module' => $module,
            'content' => $content,
        ]);
    }

    /**
     * Update the content.
     */
    public function update(Request $request, Module $module, Content $content): RedirectResponse
    {
        if ($content->module_id !== $module->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,publish'],
        ]);

        $validated['content'] = $this->sanitizeHtml($validated['content']);
        $validated['updated_by'] = auth()->id();

        $content->update($validated);

        ActivityLog::log(
            auth()->user(),
            'update_content',
            $module,
            "Updated content: {$content->title}"
        );

        return redirect()->route('admin.modules.contents.index', $module)
            ->with('success', 'Content updated successfully.');
    }

    /**
     * Delete the content.
     */
    public function destroy(Module $module, Content $content): RedirectResponse
    {
        if ($content->module_id !== $module->id) {
            abort(404);
        }

        ActivityLog::log(
            auth()->user(),
            'delete_content',
            $module,
            "Deleted content: {$content->title}"
        );

        $content->delete();

        return redirect()->route('admin.modules.contents.index', $module)
            ->with('success', 'Content deleted successfully.');
    }

    /**
     * Publish content (draft to publish).
     */
    public function publish(Module $module, Content $content): RedirectResponse
    {
        if ($content->module_id !== $module->id) {
            abort(404);
        }

        $content->publish();

        ActivityLog::log(
            auth()->user(),
            'publish_content',
            $module,
            "Published content: {$content->title}"
        );

        return back()->with('success', 'Content published successfully.');
    }

    /**
     * Save as draft (publish to draft).
     */
    public function draft(Module $module, Content $content): RedirectResponse
    {
        if ($content->module_id !== $module->id) {
            abort(404);
        }

        $content->draft();

        ActivityLog::log(
            auth()->user(),
            'draft_content',
            $module,
            "Moved content to draft: {$content->title}"
        );

        return back()->with('success', 'Content moved to draft.');
    }

    private function sanitizeHtml(string $html): string
    {
        $html = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style\b[^>]*>(.*?)</style>#is', '', $html);
        $html = preg_replace('/\son\w+="[^"]*"/i', '', $html);
        $html = preg_replace("/\son\w+='[^']*'/i", '', $html);
        $html = preg_replace('/javascript:/i', '', $html);
        $allowed = '<p><ul><ol><li><h2><h3><h4><strong><em><a><img><table><thead><tbody><tr><td><th><blockquote><code><pre><br><hr><span>';
        $html = strip_tags($html, $allowed);
        return $html;
    }
}
