<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Produks;
use App\Models\Perlengkapans;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // =====================
    // MANAJEMEN USER
    // =====================
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('users.index')->with('success', 'Akun staff berhasil dibuat.');
    }

    public function destroy($id_user)
{
    $user = User::where('id_user', $id_user)->firstOrFail();
    $user->delete();

    return redirect()->back()->with('success', 'Akun berhasil dihapus.');
}


    public function update(Request $request, $id_user)
{
    $user = User::where('id_user', $id_user)->firstOrFail();

    $request->validate([
        'name' => 'required|string|max:20',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
        ],
        'role' => 'required|in:admin,staff',
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Akun berhasil diperbarui.');
}



    // =====================
    // HALAMAN STOK STAFF
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

        return view('staff.stok', compact('produks', 'perlengkapan', 'dataBarang'));
    }

    // =====================
    // UPDATE PRODUK
    // =====================
    public function updateProduk(Request $request, $id)
    {
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
    }

    // =====================
    // UPDATE PERLENGKAPAN
    // =====================
    public function updatePerlengkapan(Request $request, $id)
    {
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
    }
    // =====================
    // HALAMAN ADMIN & STAFF
    // =====================
    public function profil()
    {
        $user = auth()->user();
        $users = User::all();

        return view('admin.profil', compact('user', 'users'));
    }

    public function staffDashboard()
    {
        $produks = Produks::all();
        $perlengkapans = Perlengkapans::all();

        foreach ($produks as $produk) {
            $produk->persentase = $produk->stok_maksimum > 0
                ? round(($produk->stok / $produk->stok_maksimum) * 100)
                : 0;
        }

        return view('staff.dashboard', compact('produks', 'perlengkapans'));
    }
}
