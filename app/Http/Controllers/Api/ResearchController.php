<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\JsonResponse;

/**
 * ResearchController
 * Endpoint khusus untuk penelitian perbandingan REST API vs GraphQL.
 * Tidak ada auth agar load testing bisa berjalan tanpa token.
 */
class ResearchController extends Controller
{
    /**
     * Skenario 1 - Simple Query
     * Mengambil data donasi saja (tanpa relasi)
     * Setara dengan GraphQL: { donasi { id donatur jenis jumlah tanggal status status_verifikasi } }
     */
    public function simple(): JsonResponse
    {
        $data = Donasi::select('id', 'donatur', 'jenis', 'detail', 'jumlah', 'tanggal', 'status', 'status_verifikasi')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Skenario 2 - Medium Query
     * Mengambil data donasi + relasi user (donatur)
     * Setara dengan GraphQL: { donasi { id donatur jenis jumlah user { id nama email } } }
     */
    public function medium(): JsonResponse
    {
        $data = Donasi::select('id', 'user_id', 'donatur', 'jenis', 'detail', 'jumlah', 'tanggal', 'status', 'status_verifikasi')
            ->with(['user:id,nama,email,no_hp,role'])
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Skenario 3 - Complex Query
     * Mengambil data donasi + user + laporan_donasi
     * Setara dengan GraphQL: { donasi { id donatur jenis jumlah user { id nama email } laporan { id isi_laporan status } } }
     */
    public function complex(): JsonResponse
    {
        $data = Donasi::select('id', 'user_id', 'donatur', 'jenis', 'detail', 'jumlah', 'tanggal', 'status', 'petugas', 'status_verifikasi', 'catatan')
            ->with([
                'user:id,nama,email,no_hp,role',
                'laporan:id,donasi_id,email_donatur,isi_laporan,status,sent_at',
            ])
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
