<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('anggota_id'); // Relasi ke tabel anggota
            $table->decimal('jumlah', 15, 2); // Jumlah simpanan
            $table->string('jenis'); // Jenis simpanan (wajib, sukarela, pokok)
            $table->date('tanggal'); // Tanggal simpanan
            $table->string('status')->default('pending'); // Status simpanan (pending, disetujui, ditolak)
            $table->timestamps();

            // Relasi ke tabel anggota
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};
