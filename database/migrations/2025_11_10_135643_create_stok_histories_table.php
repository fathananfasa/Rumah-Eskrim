<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_histories', function (Blueprint $table) {
            $table->id('id_his');

            // item_type tidak perlu 20 karakter, 12 sudah sangat cukup
            $table->string('item_type', 12); // 'produk' atau 'perlengkapan'

            // item_id gunakan unsignedBigInteger (optimal untuk FK)
            $table->unsignedBigInteger('item_id');

            // stok tidak akan negatif. smallInteger sudah cukup
            // smallInteger: range -32,768 sampai 32,767
            // smallUnsignedInteger: 0 sampai 65,535 => lebih aman
            $table->unsignedSmallInteger('stok')->default(0);

            // tanggal pencatatan
            $table->date('recorded_at');

            // created_at & updated_at
            $table->timestamps();

            // Index composite (paling optimal untuk polymorphic)
            $table->index(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_histories');
    }
};
