<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('subjek');
            $table->text('pesan');
            $table->boolean('is_displayed')->default(false); // untuk filter tampil/tidak
            $table->boolean('is_read')->default(false); // status sudah dibaca admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};
