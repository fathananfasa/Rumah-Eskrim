<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerlengkapansTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perlengkapans')->insert([
            [
                'nama_perlengkapan' => 'Sendok Plastik',
                'stok' => 120,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_perlengkapan' => 'Cup Kecil',
                'stok' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_perlengkapan' => 'Cup Besar',
                'stok' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_perlengkapan' => 'Tisu',
                'stok' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
