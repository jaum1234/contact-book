<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'postal_code',
        'street',
        'complement',
        'neighborhood',
        'city',
        'unit',
        'country',
        'state_abbreviation',
        'state',
        'ibge_code',
        'gia_code',
        'region',
        'area_code',
        'siafi_code'
    ];
}
