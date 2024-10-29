<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'no_induk' => fake()->randomNumber(8),
            'no_telp' => fake()->phoneNumber(),
            'asal_institusi' => 'Universitas Batu Duduk',
            'jurusan' => 'Teknik Pertambangan',
            'bidang_diambil' => 'Bidang TIK',
            'surat_pengantar' => 'surat pengantar.pdf',
            'tanggal_awal_magang' => '2024-1-1',
            'tanggal_akhir_magang' => '2024-5-5',
        ];
    }
}
