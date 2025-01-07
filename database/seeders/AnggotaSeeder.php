<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Anggota::create([
            'nama' => "Syukron Ma'mun",
            'email' => 'syukron@example.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Tulip No. 5',
        ]);
    }
}
