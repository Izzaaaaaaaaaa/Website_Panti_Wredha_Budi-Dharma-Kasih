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
        $galleries = Gallery::latest()->get();
        return view('admin.galeri.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $data = $request->only('caption');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }

        Gallery::create($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function edit(Gallery $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Gallery $galeri)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $data = $request->only('caption');
        
        if ($request->hasFile('image')) {
            if ($galeri->image && Storage::disk('public')->exists($galeri->image)) {
                Storage::disk('public')->delete($galeri->image);
            }
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }

        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(Gallery $galeri)
    {
        if ($galeri->image && Storage::disk('public')->exists($galeri->image)) {
            Storage::disk('public')->delete($galeri->image);
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
