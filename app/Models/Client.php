<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'state',
        'location',
        'institution',
        'organizational_unit',
        'position_designation',
        'address',
        'id_type', //enum
        'dni',
    ];
}
