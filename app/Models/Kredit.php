<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kredit extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'kredit';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'nama',
        'jumlah_uang',
        'waktu_pengembalian',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
