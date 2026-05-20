<?php

namespace App\GraphQL\Queries;

use App\Models\Donasi;

class DonasiMedium
{
    /**
     * Skenario 2 - Medium Query
     * Setara dengan REST GET /api/research/medium
     */
    public function __invoke($_, array $args): \Illuminate\Database\Eloquent\Collection
    {
        return Donasi::select('id', 'user_id', 'donatur', 'jenis', 'detail', 'jumlah', 'tanggal', 'status', 'status_verifikasi')
            ->with(['user:id,nama,email,no_hp,role'])
            ->limit(20)
            ->get();
    }
}
