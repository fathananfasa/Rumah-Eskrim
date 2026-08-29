<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokHistory;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class FileController extends Controller
{
    public function downloadPdf(Request $request)
    {
        $kategori = $request->kategori ?? null;
        $tanggal = $request->tanggal ?? null;
        $bulan = $request->bulan ?? null;
        $periode = $request->periode ?? null;

        $query = StokHistory::query();

        // Filter kategori case-insensitive
        if ($kategori && $kategori !== 'Semua Kategori') {
            $query->whereRaw(
                'LOWER(item_type) = ?',
                [strtolower($kategori === 'Es Krim' ? 'Produk' : 'Perlengkapan')]
            );
        }

        // Filter Harian
        if ($periode === 'Harian' && $tanggal && $tanggal !== 'Semua Tanggal') {
            $query->whereDate('recorded_at', Carbon::createFromFormat('d/m/Y', $tanggal));
        }

        // Filter Mingguan
        if ($periode === 'Mingguan' && $tanggal && $tanggal !== 'Semua Tanggal') {
            $startOfWeek = Carbon::createFromFormat('d/m/Y', $tanggal)->startOfWeek();
            $endOfWeek   = Carbon::createFromFormat('d/m/Y', $tanggal)->endOfWeek();
            $query->whereBetween('recorded_at', [$startOfWeek, $endOfWeek]);
        }
        // Filter bulan untuk Bulanan
        if ($periode === 'Bulanan' && $bulan) {
            $carbon = Carbon::parse($bulan);
            $query->whereMonth('recorded_at', $carbon->month)
                ->whereYear('recorded_at', $carbon->year);
        }

        // Ambil semua data sesuai filter, urut ascending
        $laporan = $query->orderBy('recorded_at', 'asc')->get();

        // Periode text dari tanggal pertama → terakhir atau sesuai filter
        if ($periode === 'Bulanan' && $bulan) {
            $carbon = Carbon::parse($bulan);
            $periodeText = $carbon->translatedFormat('F Y'); // November 2025
        } elseif ($periode === 'Harian' && $tanggal && $tanggal !== 'Semua Tanggal') {
            $periodeText = $tanggal; // tampilkan tanggal yang dipilih, misal 24/11/2025
        } else {
            $periodeText = $laporan->isEmpty()
                ? '-'
                : Carbon::parse($laporan->first()->recorded_at)->format('j F Y')
                . ' - '
                . Carbon::parse($laporan->last()->recorded_at)->format('j F Y');
        }



        // Render view PDF
        $html = view('admin.partials.pdf', compact('laporan', 'periodeText', 'periode'))->render();

        $mpdf = new Mpdf(['tempDir' => storage_path('app/tmp')]);
        $mpdf->SetTitle("Laporan Inventory ($periode) per $periodeText");
        $mpdf->WriteHTML($html);

        return $mpdf->Output("Laporan Inventory ($periode) per $periodeText.pdf", 'D');
    }
}
