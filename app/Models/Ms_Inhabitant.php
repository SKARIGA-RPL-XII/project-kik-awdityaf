<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsInhabitant extends Model
{
    protected $table = 'ms_inhabitants';

    public $timestamps = false;

    protected $fillable = [
        'nik',
        'kk',
        'name',
        'addres',
        'rt',
        'rw',
        'postalcode',
        'gender',
        'bloodtype',
        'placeofbirth',
        'dateofbirth',
        'religion',
        'education',
        'work',
        'maritalstatus',
        'relationshipstatus',
        'citizenship',
        'kbacceptor',
        'status',
    ];
}