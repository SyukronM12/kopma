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
        Schema::create('savings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('member_id'); // Relasi ke tabel anggota
            $table->decimal('amount', 15, 2); // Jumlah simpanan
            $table->string('type'); // Jenis simpanan (wajib, sukarela, pokok)
            $table->date('date'); // Tanggal simpanan
            $table->string('status')->default('pending'); // Status simpanan (pending, disetujui, ditolak)
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
        Schema::dropIfExists('savings');
    }
};
