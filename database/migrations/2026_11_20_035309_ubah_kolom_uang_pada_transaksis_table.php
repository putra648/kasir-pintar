<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('total')->default(0)->change();
            $table->unsignedBigInteger('uang_bayar')->default(0)->change();
            $table->unsignedBigInteger('kembalian')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->integer('total')->default(0)->change();
            $table->integer('uang_bayar')->default(0)->change();
            $table->integer('kembalian')->default(0)->change();
        });
    }
};