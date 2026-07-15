<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PavilionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pavilions = \App\Models\Pavilion::all();
        return view('admin.paviliun.index', compact('pavilions'));
    }

    public function create()
    {
        return view('admin.paviliun.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $data = $request->only('name', 'description');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pavilions', 'public');
        }

        \App\Models\Pavilion::create($data);
        return redirect()->route('admin.paviliun.index')->with('success', 'Paviliun & Fasilitas berhasil ditambahkan.');
    }

    public function edit(\App\Models\Pavilion $paviliun)
    {
        return view('admin.paviliun.edit', compact('paviliun'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Pavilion $paviliun)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $data = $request->only('name', 'description');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pavilions', 'public');
        }

        $paviliun->update($data);
        return redirect()->route('admin.paviliun.index')->with('success', 'Paviliun & Fasilitas berhasil diperbarui.');
    }

    public function destroy(\App\Models\Pavilion $paviliun)
    {
        $paviliun->delete();
        return redirect()->route('admin.paviliun.index')->with('success', 'Paviliun & Fasilitas berhasil dihapus.');
    }
}
