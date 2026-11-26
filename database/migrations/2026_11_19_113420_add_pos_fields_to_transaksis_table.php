<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('nama_pembeli')->nullable()->after('kasir_name');
            $table->integer('uang_bayar')->default(0)->after('total');
            $table->integer('kembalian')->default(0)->after('uang_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['nama_pembeli', 'uang_bayar', 'kembalian']);
        });
    }
};