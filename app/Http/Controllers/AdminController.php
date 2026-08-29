<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Models\Perlengkapans;
use App\Models\Produks;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function laporan()
    {
        $laporan = $this->ambilDataLaporan();

        return view('admin.laporan', compact('laporan'));
    }

    public function filterLaporan(Request $request)
    {
        $kategori = $request->kategori;
        $tanggal  = $request->tanggal;
        $periode  = $request->periode ?? 'Harian';
        $bulan    = $request->bulan;

        $laporan = $this->ambilDataLaporan();

        // FILTER KATEGORI
        $filtered = $laporan->filter(function ($item) use ($kategori) {
            if ($kategori && $kategori !== 'Semua Kategori') {
                return strtolower($item['kategori']) === strtolower($kategori);
            }
            return true;
        });

        // FILTER PERIODE
        if ($periode === 'Harian' && $tanggal && $tanggal !== 'Semua Tanggal') {
            $tgl = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');
            $filtered = $filtered->filter(fn($item) => $item['tanggal_raw'] === $tgl);
        } elseif ($periode === 'Mingguan' && $tanggal && $tanggal !== 'Semua Tanggal') {
            $tgl = Carbon::createFromFormat('d/m/Y', $tanggal);
            $start = $tgl->copy()->startOfWeek(Carbon::MONDAY);
            $end = $tgl->copy()->endOfWeek(Carbon::SUNDAY);
            $filtered = $filtered->filter(fn($item) => Carbon::parse($item['tanggal_raw'])->between($start, $end));
        } elseif ($periode === 'Bulanan' && $bulan) {
            $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
            $end = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();
            $filtered = $filtered->filter(fn($item) => Carbon::parse($item['tanggal_raw'])->between($start, $end));
        }

        // SORT DESC
        $filtered = $filtered->sortByDesc('tanggal_raw')->values();

        // =========================
        // PAGINATION
        // =========================
        $perPage = 20;
        $page = $request->page ?? 1;
        $paginated = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        // STATISTIK
        $total = $filtered->count();
        $eskrim = $filtered->where('kategori', 'Es Krim')->count();
        $perlengkapan = $filtered->where('kategori', 'Perlengkapan')->count();

        // PERIODE TAMPIL
        $periodeTampil = '-';
        if ($filtered->count() > 0) {
            $first = Carbon::parse($filtered->last()['tanggal_raw'])->format('d/m/Y');
            $last  = Carbon::parse($filtered->first()['tanggal_raw'])->format('d/m/Y');
            $periodeTampil = $first === $last ? $first : "$first - $last";
        }

        $html = view('admin.partials.tabel-laporan', ['laporan' => $paginated])->render();

        return response()->json([
            'html' => $html,
            'total' => $total,
            'eskrim' => $eskrim,
            'perlengkapan' => $perlengkapan,
            'periode' => $periodeTampil,
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
        ]);
    }

    private function ambilDataLaporan()
    {
        return \App\Models\StokHistory::orderBy('recorded_at', 'desc')
            ->get()
            ->map(function ($item) {

                $tanggal = \Carbon\Carbon::parse($item->recorded_at);

                return [
                    'tanggal'      => $tanggal->format('d/m/Y'),
                    'tanggal_raw'  => $tanggal->format('Y-m-d'),
                    'nama'         => $item->nama_item,      // accessor dari model
                    'kategori'     => $item->kategori_item,  // accessor dari model
                    'stok'         => $item->stok,
                ];
            });
    }


    // =====================
    // HALAMAN STOK ADMIN
    // =====================
    public function stok()
    {
        $produks = Produks::all();
        $perlengkapan = Perlengkapans::all();
        $dataBarang = [
            'Es Krim' => $produks->pluck('nama_produk')->toArray(),
            'Perlengkapan' => $perlengkapan->pluck('nama_perlengkapan')->toArray(),
        ];

        // Hitung persentase stok produk
        foreach ($produks as $p) {
            $p->persentase = $p->stok_maksimum > 0
                ? round(($p->stok / $p->stok_maksimum) * 100)
                : 0;
        }

        return view('admin.stok', compact('produks', 'perlengkapan', 'dataBarang'));
    }
    // =====================
    // TAMBAH PRODUK BARU
    // =====================
    public function storeProduk(Request $request)
    {
        try {
            $request->validate([
                'nama_produk' => 'required|string|max:20',
                'stok' => 'required|numeric|min:0|max:100',
            ]);

            Produks::create([
                'nama_produk' => $request->nama_produk,
                'stok' => $request->stok,
                'stok_maksimum' => 100,
                'status' => 'Normal',
                'warna' => 'bg-green-100 text-green-700',
            ]);

            return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->with('error', 'Data terlalu banyak atau tidak valid.')
                ->withInput();
        }
    }

    // =====================
    // TAMBAH PERLENGKAPAN BARU
    // =====================
    public function storePerlengkapan(Request $request)
    {
        try {
            $request->validate([
                'nama_perlengkapan' => 'required|string|max:20',
                'stok' => 'required|numeric|min:0',
            ]);

            Perlengkapans::create([
                'nama_perlengkapan' => $request->nama_perlengkapan,
                'stok' => $request->stok,
            ]);

            return redirect()->back()->with('success', 'Perlengkapan baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Data terlalu banyak atau tidak valid.')
                ->withInput();
        }
    }

    // =====================
    // UPDATE PRODUK
    // =====================
    public function updateProduk(Request $request, $id)
    {
        try {
            $produk = Produks::findOrFail($id);

            $request->validate([
                'nama_produk' => 'required|string|max:20',
                'level_stok' => 'nullable|numeric|min:0|max:100',
            ]);

            if ($request->filled('level_stok') && $produk->stok_maksimum > 0) {
                $produk->stok = round(($request->level_stok / 100) * $produk->stok_maksimum);
            }

            $persentase = $produk->stok_maksimum > 0
                ? ($produk->stok / $produk->stok_maksimum) * 100
                : 0;

            $produk->nama_produk = $request->nama_produk;
            $produk->save();

            return redirect()->back()->with('success', 'Data produk berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Data terlalu banyak atau tidak valid.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    // =====================
    // UPDATE PERLENGKAPAN
    // =====================
    public function updatePerlengkapan(Request $request, $id)
    {
        try {
            $perlengkapan = Perlengkapans::findOrFail($id);

            $request->validate([
                'nama_perlengkapan' => 'required|string|max:20',
                'stok' => 'nullable|numeric|min:0',
            ]);

            $perlengkapan->nama_perlengkapan = $request->nama_perlengkapan;

            if ($request->has('stok')) {
                $perlengkapan->stok = $request->stok;
            }

            $perlengkapan->save();

            return redirect()->back()->with('success', 'Data perlengkapan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }


    // =====================
    // HAPUS PRODUK
    // =====================
    public function destroyProduk($id)
    {
        $produk = Produks::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.stok')->with('success', 'Produk berhasil dihapus.');
    }

    // =====================
    // HAPUS PERLENGKAPAN
    // =====================
    public function destroyPerlengkapan($id)
    {
        $perlengkapan = Perlengkapans::findOrFail($id);
        $perlengkapan->delete();

        return redirect()->route('admin.stok')->with('success', 'Perlengkapan berhasil dihapus.');
    }

    //RESTORE PRODUKS
    public function restoreProduk($id)
    {
        $produk = Produks::withTrashed()->findOrFail($id);
        $produk->restore();

        $produk->deleted_by = null;
        $produk->saveQuietly();

        return redirect()->route('admin.stok')->with('success', 'Produk berhasil direstore.');
    }

    //RESTORE PERLENGKAPANS
    public function restorePerlengkapan($id)
    {
        $perlengkapan = Perlengkapans::withTrashed()->findOrFail($id);
        $perlengkapan->restore();

        $perlengkapan->deleted_by = null;
        $perlengkapan->saveQuietly();

        return redirect()->route('admin.stok')
            ->with('success', 'Perlengkapan berhasil direstore.');
    }
}
