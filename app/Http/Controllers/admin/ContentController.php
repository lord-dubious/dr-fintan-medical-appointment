<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Show content management dashboard
     */
    public function index()
    {
        $pages = [
            'home' => 'Landing Page',
            'about' => 'About Page',
            'contact' => 'Contact Page',
        ];

        return view('admin.content.index', compact('pages'));
    }

    /**
     * Show page content editor
     */
    public function editPage($page)
    {
        $pageContent = PageContent::getPageContent($page);
        $pageName = ucfirst($page).' Page';

        return view('admin.content.edit-page', compact('page', 'pageContent', 'pageName'));
    }

    /**
     * Update page content
     */
    public function updatePageContent(Request $request, $page)
    {
        $request->validate([
            'content' => 'required|array',
            'content.*' => 'nullable|string',
        ]);

        foreach ($request->content as $key => $value) {
            // Parse the key to get section and content_key
            $parts = explode('.', $key);
            $section = $parts[0] ?? 'general';
            $contentKey = $parts[1] ?? $key;

            PageContent::setContent($page, $section, $contentKey, $value, 'rich_text');
        }

        return response()->json([
            'success' => true,
            'message' => 'Page content updated successfully!',
        ]);
    }

    /**
     * Get page content as JSON
     */
    public function getPageContent($page)
    {
        $content = PageContent::getPageContent($page);

        return response()->json([
            'success' => true,
            'content' => $content,
        ]);
    }

    /**
     * Delete page content
     */
    public function deletePageContent(Request $request, $page)
    {
        $request->validate([
            'section' => 'required|string',
            'key' => 'required|string',
        ]);

        PageContent::where('page_name', $page)
            ->where('section_name', $request->section)
            ->where('content_key', $request->key)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Content deleted successfully!',
        ]);
    }
}
