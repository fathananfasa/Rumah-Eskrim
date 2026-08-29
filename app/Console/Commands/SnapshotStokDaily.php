<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produks;
use App\Models\Perlengkapans;
use App\Models\StokHistory;
use Carbon\Carbon;

class SnapshotStokDaily extends Command
{
    protected $signature = 'stok:snapshot';
    protected $description = 'Simpan snapshot stok harian ke tabel stok_histories';

    public function handle()
    {
        $now = Carbon::now(); // waktu lengkap menit dan detik

$this->info('Snapshot dibuat: ' . $now);

Produks::chunk(100, function ($produks) use ($now) {
    foreach ($produks as $p) {
        StokHistory::create([
            'item_type' => 'produk',
            'item_id' => $p->id_prod,
            'nama' => $p->nama_produk,
            'stok' => $p->stok,
            'stok_maksimum' => $p->stok_maksimum,
            'recorded_at' => $now,
        ]);
    }
});

Perlengkapans::chunk(100, function ($items) use ($now) {
    foreach ($items as $i) {
        StokHistory::create([
            'item_type' => 'perlengkapan',
            'item_id' => $i->id_per,
            'nama' => $i->nama_perlengkapan,
            'stok' => $i->stok,
            'stok_maksimum' => null,
            'recorded_at' => $now,
        ]);
    }
});


        $this->info('Snapshot stok selesai.');
    }
}
