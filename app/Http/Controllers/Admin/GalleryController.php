<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Gallery::latest();

        if ($user->division !== 'super_admin') {
            $query->where('business_unit', $user->division);
        }

        $galleries = $query->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'title' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        // Determine unit. Default to photobooth if super_admin doesn't choose (simplified for now)
        // Ideally super_admin should have a dropdown, but let's default to 'visual' or 'photobooth' based on context or request.
        // For simplicity: If super_admin, we might need a dropdown. 
        // Let's assume for this specific flow, we check the request or default to photobooth if not specified.
        
        $businessUnit = ($user->division === 'super_admin') 
            ? ($request->business_unit ?? 'photobooth') 
            : $user->division;

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'business_unit' => $businessUnit,
            'image_path' => $path,
            'title' => $request->title,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroy(Gallery $gallery)
    {
        // Security check
        if (auth()->user()->division !== 'super_admin' && auth()->user()->division !== $gallery->business_unit) {
            abort(403);
        }

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Foto dihapus.');
    }

    public function toggleFeatured(Gallery $gallery)
    {
        // Security check
        if (auth()->user()->division !== 'super_admin' && auth()->user()->division !== $gallery->business_unit) {
            abort(403);
        }

        $gallery->is_featured = !$gallery->is_featured;
        $gallery->save();

        return response()->json([
            'success' => true,
            'is_featured' => $gallery->is_featured,
            'message' => 'Status featured diperbarui.'
        ]);
    }
}