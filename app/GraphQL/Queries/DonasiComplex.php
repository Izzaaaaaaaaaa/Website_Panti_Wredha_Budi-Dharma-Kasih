<?php

namespace App\GraphQL\Queries;

use App\Models\Donasi;

class DonasiComplex
{
    /**
     * Skenario 3 - Complex Query
     * Setara dengan REST GET /api/research/complex
     */
    public function __invoke($_, array $args): \Illuminate\Database\Eloquent\Collection
    {
        return Donasi::select('id', 'user_id', 'donatur', 'jenis', 'detail', 'jumlah', 'tanggal', 'status', 'petugas', 'status_verifikasi', 'catatan')
            ->with([
                'user:id,nama,email,no_hp,role',
                'laporan:id,donasi_id,email_donatur,isi_laporan,status,sent_at',
            ])
            ->limit(20)
            ->get();
    }
}
