<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create([
            'name' => "Syukron Ma'mun",
            'email' => 'syukron@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Tulip No. 5',
        ]);
    }
}
