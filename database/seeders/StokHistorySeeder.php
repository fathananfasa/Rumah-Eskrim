<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokHistorySeeder extends Seeder
{
    public function run()
    {
        $produk = [
            ['id' => 1, 'type' => 'Produk', 'nama' => 'Es Krim Coklat',   'max' => 100],
            ['id' => 2, 'type' => 'Produk', 'nama' => 'Es Krim Vanilla',  'max' => 100],
            ['id' => 3, 'type' => 'Produk', 'nama' => 'Es Krim Stroberi', 'max' => 100],
            ['id' => 4, 'type' => 'Produk', 'nama' => 'Es Krim Matcha',   'max' => 100],
        ];

        $perlengkapan = [
            ['id' => 5, 'type' => 'Perlengkapan', 'nama' => 'Sendok Plastik', 'max' => 300],
            ['id' => 6, 'type' => 'Perlengkapan', 'nama' => 'Cup Kecil',      'max' => 300],
            ['id' => 7, 'type' => 'Perlengkapan', 'nama' => 'Cup Besar',      'max' => 300],
            ['id' => 8, 'type' => 'Perlengkapan', 'nama' => 'Tisu',           'max' => 300],
        ];

        $items = array_merge($produk, $perlengkapan);

        $persen = [0.25, 0.50, 0.75, 1.00];

        $days = 30;

        for ($i = 0; $i < $days; $i++) {
            $tanggal = Carbon::now()->subDays($i);
            $hari = $tanggal->dayOfWeekIso;   // 1 = Senin, 7 = Minggu

            if ($hari >= 6) {
                continue; // Skip Sabtu dan Minggu
            }

            foreach ($items as $item) {
                if ($item['type'] === 'Produk') {
                    $p = $persen[array_rand($persen)];
                    $stok = intval($item['max'] * $p);
                } else {
                    $stok = rand(intval($item['max'] * 0.3), $item['max']);
                }

                DB::table('stok_histories')->insert([
                    'item_type'     => $item['type'],
                    'item_id'       => $item['id'],
                    'nama'          => $item['nama'],
                    'stok'          => $stok,
                    'stok_maksimum' => $item['max'],
                    'recorded_at'   => $tanggal->format('Y-m-d'),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
