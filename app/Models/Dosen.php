<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table ='dosens';
    protected $fillable = ['dosen_name', 'dosen_notelp', 'dosen_alamat', 'dosen_deskripsi'];
}
