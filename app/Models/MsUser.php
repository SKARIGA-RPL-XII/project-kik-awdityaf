<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsUser extends Model
{
    protected $table = 'ms_users';

    public $timestamps = false; // karena pakai createddate, bukan created_at

    protected $fillable = [
        'name',
        'phonenumber',
        'username',
        'job',
        'password',
        'role',
        'createddate',
        'createdby',
        'updateddate',
        'updatedby',
    ];

    protected $hidden = [
        'password',
    ];
}