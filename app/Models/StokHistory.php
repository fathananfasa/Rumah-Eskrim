<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokHistory extends Model
{
    protected $primaryKey = 'id_his';

    protected $fillable = [
        'item_type',
        'item_id',
        'stok',
        'recorded_at',
        'user_id'
    ];

    protected $dates = ['recorded_at'];

    public function item()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaItemAttribute()
{
     if ($this->item_type === 'produk') {
        return \App\Models\Produks::where('id_prod', $this->item_id)
            ->value('nama_produk');
    }

    if ($this->item_type === 'perlengkapan') {
        return \App\Models\Perlengkapans::where('id_per', $this->item_id)
            ->value('nama_perlengkapan');
    }

    return '-';
}

public function getKategoriItemAttribute()
{
    return $this->item_type === 'produk'
        ? 'Es Krim'
        : 'Perlengkapan';
}

}

