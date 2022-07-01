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
        "document_type",
        "identification_card",
        "email",
        "names",
        "surames",
        "state",
        "municipality",
        "direction",
        "institution_name",
        "organizational_unit",
        "phone",
        "office_phone"
    ];
}
