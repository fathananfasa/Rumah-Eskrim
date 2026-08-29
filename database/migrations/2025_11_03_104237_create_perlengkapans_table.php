<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perlengkapans', function (Blueprint $table) {
            $table->id('id_per');
            $table->string('nama_perlengkapan', 20);
            $table->integer('stok')->default(0);
            $table->string('satuan', 3)->default('pcs');
            $table->enum('status', ['normal', 'menipis'])->default('normal');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perlengkapans');
    }
};
