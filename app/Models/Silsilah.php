<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silsilah extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nama', 'JenisKelamin', 'Parent'
    ];


}
