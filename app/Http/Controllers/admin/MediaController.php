<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Show media library
     */
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = $request->get('search');

        $query = MediaLibrary::with('uploader');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        $media = $query->orderBy('created_at', 'desc')->paginate(20);

        $categories = MediaLibrary::distinct()->pluck('category')->filter();

        return view('admin.media.index', compact('media', 'categories', 'category', 'search'));
    }

    /**
     * Upload new media
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:10240',
            'category' => 'nullable|string|max:50',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $filePath = $file->storeAs('media', $filename, 'public');

            $media = MediaLibrary::create([
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'alt_text' => $request->alt_text,
                'category' => $request->category ?? 'general',
                'uploaded_by' => Auth::id(),
                'is_public' => true,
            ]);

            $uploadedFiles[] = [
                'id' => $media->id,
                'filename' => $media->filename,
                'original_name' => $media->original_name,
                'url' => $media->url,
                'is_image' => $media->isImage(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully!',
            'files' => $uploadedFiles,
        ]);
    }

    /**
     * Delete media
     */
    public function destroy(MediaLibrary $media)
    {
        // Delete file from storage
        Storage::disk('public')->delete($media->file_path);

        // Delete database record
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully!',
        ]);
    }

    public function mobileIndex(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = $request->get('search');

        $query = MediaLibrary::with('uploader');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        $media = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = MediaLibrary::distinct()->pluck('category')->filter();

        return view('mobile.admin.media', compact('media', 'categories', 'category', 'search'));
    }
}
