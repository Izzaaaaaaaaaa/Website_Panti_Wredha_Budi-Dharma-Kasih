<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\AktivitasLog;
use App\Helpers\FileUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenghuniController extends Controller
{
    /**
     * Get All Penghuni
     */
    public function index(Request $request)
    {
        $query = Penghuni::query();

        if ($request->has('paviliun') && $request->paviliun) {
            $query->where('paviliun', $request->paviliun);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $penghuni = $query->get();

        return response()->json([
            'success' => true,
            'data' => $penghuni
        ]);
    }

    /**
     * Get Single Penghuni
     */
    public function show($id)
    {
        $penghuni = Penghuni::find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Data penghuni tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penghuni
        ]);
    }

    /**
     * Create Penghuni - Validasi minimal
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:60|max:110',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'usia.min' => 'Usia penghuni minimal 60 tahun.',
            'usia.max' => 'Usia penghuni tidak valid (max 110 tahun).',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors->has('usia') 
                ? $errors->first('usia') 
                : 'Nama wajib diisi';
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ], 422);
        }

        try {
            $data = $request->all();
            
            // Bersihkan data - hapus field kosong dan konversi tipe data
            $cleanData = [];
            foreach ($data as $key => $value) {
                if ($value !== null && $value !== '') {
                    if ($key === 'usia') {
                        $cleanData[$key] = is_numeric($value) ? (int) $value : null;
                    } elseif ($key === 'foto') {
                        // Simpan foto ke file storage (lebih baik untuk gambar besar)
                        if (FileUploadHelper::isBase64Image($value)) {
                            $filePath = FileUploadHelper::saveBase64ToFile($value, 'penghuni');
                            $cleanData[$key] = $filePath ?: $value; // Fallback ke base64 jika gagal
                        } else {
                            $cleanData[$key] = $value;
                        }
                    } else {
                        $cleanData[$key] = $value;
                    }
                }
            }
            
            $penghuni = Penghuni::create($cleanData);

            // Log aktivitas
            if (auth()->check()) {
                AktivitasLog::create([
                    'user_id' => auth()->id(),
                    'kategori' => 'Penghuni',
                    'text' => "Menambahkan data penghuni: {$penghuni->nama}",
                    'time' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data penghuni berhasil ditambahkan',
                'data' => $penghuni
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Penghuni
     */
    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Data penghuni tidak ditemukan'
            ], 404);
        }

        // Validasi usia
        if ($request->has('usia') && $request->usia !== null && $request->usia !== '') {
            $usia = (int) $request->usia;
            if ($usia < 60) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usia penghuni minimal 60 tahun.'
                ], 422);
            }
            if ($usia > 110) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usia penghuni tidak valid (max 110 tahun).'
                ], 422);
            }
        }

        $data = $request->all();
        
        // Handle foto - simpan ke file jika base64
        if (isset($data['foto']) && FileUploadHelper::isBase64Image($data['foto'])) {
            $filePath = FileUploadHelper::saveBase64ToFile($data['foto'], 'penghuni');
            if ($filePath) {
                // Hapus foto lama jika ada dan bukan base64
                if ($penghuni->foto && !FileUploadHelper::isBase64Image($penghuni->foto)) {
                    FileUploadHelper::delete($penghuni->foto);
                }
                $data['foto'] = $filePath;
            }
        }

        $penghuni->update($data);

        if (auth()->check()) {
            AktivitasLog::create([
                'user_id' => auth()->id(),
                'kategori' => 'Penghuni',
                'text' => "Mengupdate data penghuni: {$penghuni->nama}",
                'time' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data penghuni berhasil diupdate',
            'data' => $penghuni
        ]);
    }

    /**
     * Delete Penghuni
     */
    public function destroy($id)
    {
        $penghuni = Penghuni::find($id);

        if (!$penghuni) {
            return response()->json([
                'success' => false,
                'message' => 'Data penghuni tidak ditemukan'
            ], 404);
        }

        $nama = $penghuni->nama;
        $penghuni->delete();

        if (auth()->check()) {
            AktivitasLog::create([
                'user_id' => auth()->id(),
                'kategori' => 'Penghuni',
                'text' => "Menghapus data penghuni: {$nama}",
                'time' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data penghuni berhasil dihapus'
        ]);
    }

    /**
     * Get Statistics
     */
    public function statistics()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => Penghuni::count(),
            ]
        ]);
    }
}
