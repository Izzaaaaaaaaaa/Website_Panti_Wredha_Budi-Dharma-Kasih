<?php

namespace Tests;

use App\Models\User;
use App\Models\Penghuni;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BlackboxTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an Admin user to perform authenticated operations
        $this->admin = User::create([
            'nama' => 'Admin Test',
            'email' => 'admin.test@pantiputra.com',
            'no_hp' => '081234567890',
            'password' => 'password123',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Helper to get standard valid form data for a new penghuni.
     */
    private function getValidData(array $overrides = []): array
    {
        return array_merge([
            'nik' => '3302010101640001',
            'nama' => 'Siti Aminah',
            'ttl' => 'Banyumas, 12 Mei 1964',
            'usia' => 60,
            'kota' => 'Purwokerto',
            'alamat' => 'Jl. Merdeka No. 10',
            'agama' => 'Islam',
            'gender' => 'Wanita',
            'status' => 'Janda',
            'pj' => 'Budi Utomo',
            'hubungan' => 'Anak',
            'telp' => '081234567890',
            'alamat_pj' => 'Jl. Diponegoro No. 5',
            'tgl_masuk' => '2026-06-10',
            'rujukan' => 'Yang Bersangkutan Sendiri',
            'paviliun' => 'MAWAR',
            'status_sehat' => 'Sehat',
            'penyakit' => '-',
            'alergi' => '-',
            'kebutuhan' => '-',
            'obat' => '-',
            'catatan' => '-'
        ], $overrides);
    }

    /**
     * TC_LANSIA_001: Verifikasi input usia lansia tepat di batas bawah valid (60 tahun)
     * [BBT - Integration Test]
     */
    public function test_api_accepts_age_at_minimum_boundary_60()
    {
        Sanctum::actingAs($this->admin);

        $payload = $this->getValidData([
            'nik' => '3302010101640001',
            'nama' => 'Siti Aminah',
            'usia' => 60,
            'gender' => 'Wanita',
            'paviliun' => 'MAWAR'
        ]);

        $response = $this->postJson('/api/penghuni', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Data penghuni berhasil ditambahkan'
        ]);

        $this->assertDatabaseHas('penghuni', [
            'nik' => '3302010101640001',
            'nama' => 'Siti Aminah',
            'usia' => 60
        ]);
    }

    /**
     * TC_LANSIA_002: Verifikasi input usia 59 tahun (di bawah batas minimum - invalid)
     * [BBT - Integration Test]
     */
    public function test_api_rejects_age_below_minimum_boundary_59()
    {
        Sanctum::actingAs($this->admin);

        $payload = $this->getValidData([
            'nik' => '3302010101650001',
            'nama' => 'Budi Santoso',
            'usia' => 59
        ]);

        $response = $this->postJson('/api/penghuni', $payload);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Usia penghuni minimal 60 tahun.'
        ]);

        $this->assertDatabaseMissing('penghuni', [
            'nik' => '3302010101650001'
        ]);
    }

    /**
     * TC_LANSIA_003: Verifikasi input usia lansia 110 tahun (batas atas valid)
     * [BBT - Integration Test]
     */
    public function test_api_accepts_age_at_maximum_boundary_110()
    {
        Sanctum::actingAs($this->admin);

        $payload = $this->getValidData([
            'nik' => '3302010101140001',
            'nama' => 'Mbah Karso',
            'usia' => 110
        ]);

        $response = $this->postJson('/api/penghuni', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Data penghuni berhasil ditambahkan'
        ]);

        $this->assertDatabaseHas('penghuni', [
            'nik' => '3302010101140001',
            'nama' => 'Mbah Karso',
            'usia' => 110
        ]);
    }

    /**
     * TC_LANSIA_004: Verifikasi input usia 111 tahun (di atas batas maksimum - invalid)
     * [BBT - Integration Test]
     */
    public function test_api_rejects_age_above_maximum_boundary_111()
    {
        Sanctum::actingAs($this->admin);

        $payload = $this->getValidData([
            'nik' => '3302010101130001',
            'nama' => 'Test User',
            'usia' => 111
        ]);

        $response = $this->postJson('/api/penghuni', $payload);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Usia penghuni tidak valid (max 110 tahun).'
        ]);

        $this->assertDatabaseMissing('penghuni', [
            'nik' => '3302010101130001'
        ]);
    }

    /**
     * TC_LANSIA_005: Verifikasi input NIK valid 16 digit angka (partisi valid)
     * [BBT - Integration Test]
     */
    public function test_api_accepts_valid_16_digit_nik()
    {
        Sanctum::actingAs($this->admin);

        $payload = $this->getValidData([
            'nik' => '3302015505640001',
            'nama' => 'Slamet Riyadi',
            'usia' => 70
        ]);

        $response = $this->postJson('/api/penghuni', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('penghuni', [
            'nik' => '3302015505640001',
            'nama' => 'Slamet Riyadi',
            'usia' => 70
        ]);
    }
}
