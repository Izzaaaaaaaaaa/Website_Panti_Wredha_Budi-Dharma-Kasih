<?php

namespace App\GraphQL\Queries;

use App\Models\Donasi;

class DonasiSimple
{
    /**
     * Skenario 1 - Simple Query
     * Setara dengan REST GET /api/research/simple
     */
    public function __invoke($_, array $args): \Illuminate\Database\Eloquent\Collection
    {
        return Donasi::select(
                'id', 'donatur', 'jenis', 'detail',
                'jumlah', 'tanggal', 'status',
                'status_verifikasi', 'petugas'
            )
            ->limit(20)
            ->get();
    }
}
