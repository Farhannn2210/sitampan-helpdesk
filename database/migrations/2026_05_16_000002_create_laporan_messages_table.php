<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->cascadeOnDelete();
            $table->enum('sender', ['admin', 'mahasiswa']);
            $table->text('message');
            $table->string('source', 20)->nullable();
            $table->timestamps();

            $table->index(['laporan_id', 'created_at']);
        });

        // Backfill: jika sebelumnya sudah ada kolom respon_admin, masukkan sebagai pesan pertama admin.
        if (Schema::hasColumn('laporans', 'respon_admin')) {
            $rows = DB::table('laporans')
                ->select(['id', 'respon_admin', 'respon_admin_sumber', 'respon_admin_pada', 'created_at', 'updated_at'])
                ->whereNotNull('respon_admin')
                ->get();

            foreach ($rows as $row) {
                $timestamp = $row->respon_admin_pada ?? $row->updated_at ?? $row->created_at;

                DB::table('laporan_messages')->insert([
                    'laporan_id' => $row->id,
                    'sender' => 'admin',
                    'message' => $row->respon_admin,
                    'source' => $row->respon_admin_sumber ?: 'manual',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_messages');
    }
};
