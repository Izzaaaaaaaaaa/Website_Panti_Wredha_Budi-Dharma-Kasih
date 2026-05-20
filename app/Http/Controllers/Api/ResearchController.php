<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\JsonResponse;

/**
 * ResearchController
 * Endpoint khusus untuk penelitian perbandingan REST API vs GraphQL.
 * Tidak ada auth agar load testing bisa berjalan tanpa token.
 *
 * Catatan struktur database:
 * - "verifikasi admin" = kolom status_verifikasi + petugas di tabel donasi
 * - "metode pembayaran" = kolom detail di tabel donasi (Transfer, Cash, dll)
 * - Tidak ada tabel terpisah untuk keduanya
 */
class ResearchController extends Controller
{
    /**
     * Skenario 1 - Simple Query
     * Mengambil data donasi saja (1 tabel, tanpa relasi)
     *
     * Field yang diambil:
     * - id, donatur, jenis, detail (metode), jumlah, tanggal,
     *   status, status_verifikasi, petugas
     */
    public function simple(): JsonResponse
    {
        $data = Donasi::select(
                'id', 'donatur', 'jenis', 'detail',
                'jumlah', 'tanggal', 'status',
                'status_verifikasi', 'petugas'
            )
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Skenario 2 - Medium Query
     * Mengambil data donasi + data donatur/user (2 tabel, 1 relasi)
     *
     * Field yang diambil:
     * - donasi: id, donatur, jenis, detail, jumlah, tanggal, status, status_verifikasi, petugas
     * - user  : id, nama, email, no_hp
     */
    public function medium(): JsonResponse
    {
        $data = Donasi::select(
                'id', 'user_id', 'donatur', 'jenis', 'detail',
                'jumlah', 'tanggal', 'status',
                'status_verifikasi', 'petugas'
            )
            ->with(['user:id,nama,email,no_hp'])
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Skenario 3 - Complex Query
     * Mengambil data donasi + donatur/user + laporan donasi (3 tabel, 2 relasi)
     *
     * Field yang diambil:
     * - donasi  : id, donatur, jenis, detail (metode pembayaran), jumlah,
     *             tanggal, status, status_verifikasi (verifikasi admin), petugas, catatan
     * - user    : id, nama, email, no_hp
     * - laporan : id, donasi_id, email_donatur, isi_laporan, status, sent_at
     *
     * Keterangan untuk BAB 3:
     * - "verifikasi admin" direpresentasikan oleh kolom status_verifikasi dan petugas
     * - "metode pembayaran" direpresentasikan oleh kolom detail
     * - Keduanya merupakan bagian dari tabel donasi (bukan tabel terpisah)
     */
    public function complex(): JsonResponse
    {
        $data = Donasi::select(
                'id', 'user_id', 'donatur', 'jenis', 'detail',
                'jumlah', 'tanggal', 'status', 'petugas',
                'status_verifikasi', 'catatan'
            )
            ->with([
                'user:id,nama,email,no_hp',
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
