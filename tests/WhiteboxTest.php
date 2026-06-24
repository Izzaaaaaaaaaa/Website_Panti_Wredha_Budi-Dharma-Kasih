<?php

namespace Tests;

use App\Http\Controllers\Api\PenghuniController;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class WhiteboxTest extends TestCase
{
    /**
     * TC_LANSIA_001: Verifikasi input usia lansia tepat di batas bawah valid (60 tahun)
     * [WBT - Validator Test]
     */
    public function test_validation_accepts_age_at_minimum_boundary_60()
    {
        $data = [
            'nama' => 'Siti Aminah',
            'usia' => 60,
        ];

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:60|max:110',
        ]);

        $this->assertFalse($validator->fails(), 'Validation should pass when age is 60.');
    }

    /**
     * TC_LANSIA_002: Verifikasi input usia 59 tahun (di bawah batas minimum - invalid)
     * [WBT - Validator Test]
     */
    public function test_validation_fails_age_below_minimum_boundary_59()
    {
        $data = [
            'nama' => 'Budi Santoso',
            'usia' => 59,
        ];

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:60|max:110',
        ], [
            'usia.min' => 'Usia penghuni minimal 60 tahun.',
        ]);

        $this->assertTrue($validator->fails(), 'Validation should fail when age is 59.');
        $this->assertEquals('Usia penghuni minimal 60 tahun.', $validator->errors()->first('usia'));
    }

    /**
     * TC_LANSIA_003: Verifikasi input usia lansia 110 tahun (batas atas valid)
     * [WBT - Validator Test]
     */
    public function test_validation_accepts_age_at_maximum_boundary_110()
    {
        $data = [
            'nama' => 'Mbah Karso',
            'usia' => 110,
        ];

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:60|max:110',
        ]);

        $this->assertFalse($validator->fails(), 'Validation should pass when age is 110.');
    }

    /**
     * TC_LANSIA_004: Verifikasi input usia 111 tahun (di atas batas maksimum - invalid)
     * [WBT - Validator Test]
     */
    public function test_validation_fails_age_above_maximum_boundary_111()
    {
        $data = [
            'nama' => 'Test User',
            'usia' => 111,
        ];

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:60|max:110',
        ], [
            'usia.max' => 'Usia penghuni tidak valid (max 110 tahun).',
        ]);

        $this->assertTrue($validator->fails(), 'Validation should fail when age is 111.');
        $this->assertEquals('Usia penghuni tidak valid (max 110 tahun).', $validator->errors()->first('usia'));
    }

    /**
     * TC_LANSIA_005: Verifikasi input NIK valid 16 digit angka
     * [WBT - Logic Test]
     */
    public function test_validation_passes_with_valid_16_digit_nik()
    {
        $nik = '3302015505640001';

        $this->assertEquals(16, strlen($nik), 'NIK must be exactly 16 characters.');
        $this->assertTrue(is_numeric($nik), 'NIK must contain only numeric characters.');
    }

    /**
     * WBT: Direct execution of Controller Store Method to verify internal path response.
     */
    public function test_controller_store_returns_correct_http_code_on_validation_failure()
    {
        $controller = new PenghuniController();
        $request = \Illuminate\Http\Request::create('/api/penghuni', 'POST', [
            'nama' => 'Budi Santoso',
            'usia' => 59,
        ]);

        $response = $controller->store($request);
        
        $this->assertEquals(422, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertFalse($responseData['success']);
        $this->assertEquals('Usia penghuni minimal 60 tahun.', $responseData['message']);
    }
}