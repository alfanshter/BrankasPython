<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Face extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function pengguna(){
        return $this->belongsTo(Pengguna::class,'nama','nama');
    }
}
