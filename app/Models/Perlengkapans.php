<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\WhatsAppService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Perlengkapans extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_perlengkapan', 'stok'];
    protected $primaryKey = 'id_per';
    protected $dates = ['deleted_at'];

    public function histories()
    {
        return $this->morphMany(StokHistory::class, 'item');
    }
    
    // Hitung status otomatis
    public function getStatusAttribute()
    {
        if ($this->stok <= 15) return 'menipis';
        if ($this->stok <= 35) return 'normal';
        return 'normal';
    }

    // Hitung warna otomatis
    public function getWarnaAttribute()
    {
        if ($this->stok <= 15) return 'bg-red-100 text-red-700';
        if ($this->stok <= 35) return 'bg-yellow-100 text-yellow-700';
        return 'bg-green-100 text-green-700';
    }

    // Event untuk kirim WhatsApp
    protected static function booted()
    {
        static::deleting(function ($perlengkapan) {
            if (Auth::check()) {
                $perlengkapan->deleted_by = Auth::id();
                $perlengkapan->saveQuietly();
            }
        });
        
        static::updated(function ($item) {
            $statusLama = $item->getOriginal('status');

            if ($item->status === 'menipis' && $statusLama !== 'menipis') {
                $wa = new WhatsAppService();
                $admin = env('WA_ADMIN');
                $wa->send($admin,
                    "⚠️ PERLENGKAPAN MENIPIS\n".
                    "Nama: {$item->nama_perlengkapan}\n".
                    "Stok tersisa: {$item->stok} pcs\n".
                    "Segera lakukan pembelian."
                );
            }
        });
    }
}
