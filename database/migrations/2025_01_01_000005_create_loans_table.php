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
        Schema::create('loans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('member_id'); // Relasi ke tabel anggota
            $table->decimal('amount', 15, 2); // Jumlah pinjaman
            $table->decimal('interest_rate', 5, 2); // Suku bunga (%)
            $table->integer('duration'); // Durasi pinjaman (dalam bulan)
            $table->decimal('total_payment', 15, 2); // Total pembayaran (pokok + bunga)
            $table->string('status')->default('pending'); // Status pinjaman (pending, disetujui, ditolak)
            $table->date('loan_date'); // Tanggal pinjaman disetujui
            $table->timestamps();

            // Relasi ke tabel anggota
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
