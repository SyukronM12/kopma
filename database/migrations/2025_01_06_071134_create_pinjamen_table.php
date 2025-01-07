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
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('anggota_id'); // Relasi ke tabel anggota
            $table->decimal('jumlah', 15, 2); // Jumlah pinjaman
            $table->decimal('suku_bunga', 5, 2); // Suku bunga (%)
            $table->integer('durasi'); // Durasi pinjaman (dalam bulan)
            $table->decimal('total_pembayaran', 15, 2); // Total pembayaran (pokok + bunga)
            $table->string('status')->default('pending'); // Status pinjaman (pending, disetujui, ditolak)
            $table->date('tanggal_pinjaman'); // Tanggal pinjaman disetujui
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
        Schema::dropIfExists('pinjamen');
    }
};
