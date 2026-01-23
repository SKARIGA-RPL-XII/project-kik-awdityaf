<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAdmin extends Model
{
    protected $table = 'ms_users';

    protected $fillable = [
        // sesuaikan dengan kolom tabel ms_users
        // contoh:
        // 'username',
        // 'email',
        // 'password',
        // 'name',
        // 'role',
        // 'status',
        // 'created_at',
        // 'updated_at',
    ];
}