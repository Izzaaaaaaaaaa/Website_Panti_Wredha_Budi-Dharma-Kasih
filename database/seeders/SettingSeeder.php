<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'sejarah', 'value' => 'Panti Wredha Budi Dharma Kasih didirikan pada tahun ...', 'type' => 'text'],
            ['key' => 'visi', 'value' => 'Menjadi rumah yang nyaman dan penuh kasih bagi para lansia.', 'type' => 'text'],
            ['key' => 'misi', 'value' => '1. Memberikan pelayanan kesehatan yang baik.\n2. Memberikan dukungan emosional.', 'type' => 'text'],
            ['key' => 'alamat', 'value' => 'Jl. Contoh Alamat Panti Wredha, Kota Anda', 'type' => 'text'],
            ['key' => 'telepon', 'value' => '081234567890', 'type' => 'text'],
            ['key' => 'email', 'value' => 'info@pantiwredha.com', 'type' => 'text'],
            ['key' => 'nomor_rekening', 'value' => 'BCA 123456789 a/n Panti Wredha', 'type' => 'text'],
            ['key' => 'instruksi_donasi', 'value' => 'Silakan transfer ke rekening di atas dan konfirmasi melalui form di bawah ini.', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
