<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jurusan';

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'jurusan_id', 'id_jurusan');
    }
}
