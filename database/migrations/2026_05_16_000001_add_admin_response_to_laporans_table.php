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
        Schema::table('laporans', function (Blueprint $table) {
            $table->text('respon_admin')->nullable()->after('hasil_ai');
            $table->string('respon_admin_sumber', 20)->nullable()->after('respon_admin');
            $table->timestamp('respon_admin_pada')->nullable()->after('respon_admin_sumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['respon_admin_pada', 'respon_admin_sumber', 'respon_admin']);
        });
    }
};
