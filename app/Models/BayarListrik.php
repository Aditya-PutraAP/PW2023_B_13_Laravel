<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayarListrik extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tagihan';
    protected $table = 'pembayarans';
    public $incrementing = true;

    protected $fillable = [
        'no_pelanggan',
        'token',
        'harga',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}