<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\WhatsAppService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Produks extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_produk', 'stok', 'stok_maksimum', 'status'];
    protected $primaryKey = 'id_prod';
    protected $dates = ['deleted_at'];

    public function histories()
    {
        return $this->morphMany(StokHistory::class, 'item');
    }
    
    protected static function booted()
    {
        static::deleting(function ($produk) {
        if (Auth::check()) {
            $produk->deleted_by = Auth::id();
            $produk->saveQuietly();
        }
        });
        static::updated(function ($produk) {

            $statusLama = $produk->getOriginal('status');

            // Hitung persentase stok
            $persen = ($produk->stok_maksimum > 0)
                ? ($produk->stok / $produk->stok_maksimum) * 100
                : 0;

            // Tentukan status baru
            if ($persen <= 25) {
                $statusBaru = 'menipis';
            } else {
                $statusBaru = 'normal';
            }

            // Simpan status jika berubah
            if ($statusBaru !== $produk->status) {
                $produk->status = $statusBaru;
                $produk->saveQuietly();
            }

            // Trigger WA hanya jika berganti menjadi menipis
            if ($statusBaru === 'menipis' && $statusLama !== 'menipis') {
                $wa = new WhatsAppService();
                $admin = env('WA_ADMIN');

                $wa->send($admin,
                    "⚠️ *STOK PRODUK MENIPIS*\n".
                    "Nama: {$produk->nama_produk}\n".
                    "Sisa Stok: {$produk->stok}%\n".
                    "Segera restock."
                );
            }
        });
    }

    // Persentase stok otomatis
    public function getPersenAttribute()
    {
        return ($this->stok_maksimum > 0)
            ? round(($this->stok / $this->stok_maksimum) * 100)
            : 0;
    }

    // Warna otomatis (tidak tersimpan di DB)
    public function getWarnaAttribute()
    {
        if ($this->persen <= 25) return 'bg-red-100 text-red-700';
        if ($this->persen <= 50) return 'bg-orange-100 text-orange-700';
        if ($this->persen <= 75) return 'bg-yellow-100 text-yellow-700';
        return 'bg-green-100 text-green-700';
    }
}
