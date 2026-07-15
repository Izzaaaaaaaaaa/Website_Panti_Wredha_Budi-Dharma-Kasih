<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key');
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $data = $request->except(['_token']);
        
        // Handle file uploads explicitly
        $fileKeys = ['sejarah_image', 'donasi_image', 'qris_image', 'persyaratan_image'];
        
        foreach ($fileKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            }
            // Remove from $data so we don't process it as text
            if (array_key_exists($key, $data)) {
                unset($data[$key]);
            }
        }

        // Process remaining text inputs
        foreach ($data as $key => $value) {
            // we will save it even if it's null, so they can empty a field
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
