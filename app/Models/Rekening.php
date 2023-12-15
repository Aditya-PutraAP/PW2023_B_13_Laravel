<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'rekening';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama', 
        'nik', 
        'alamat', 
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'jenis_tabungan',
        'no_rek',
    ];
}
