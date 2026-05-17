<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * GalleryController
 * Handles requests related to Gallery.
 */
class GalleryController extends Controller
{
    /**
     * Store a newly created gallery image.
     */
    /**
     * Execute the store action.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'Image added to gallery successfully!');
    }

    /**
     * Remove the specified gallery image.
     */
    /**
     * Execute the destroy action.
     */
    public function destroy($id)
    {
        $image = Gallery::findOrFail($id);
        
        // Delete from storage
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $image->delete();

        return redirect()->back()->with('success', 'Image removed from gallery.');
    }
}
