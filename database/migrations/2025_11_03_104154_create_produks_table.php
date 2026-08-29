<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_prod');
            $table->string('nama_produk', 20);
            $table->integer('stok')->default(0);
            $table->integer('stok_maksimum')->default(100);
            $table->enum('status', ['normal', 'menipis'])->default('normal');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
