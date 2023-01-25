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
        "service_request_id",
        "document_type",
        "identification_card",
        "email",
        "names",
        "surnames",
        "state",
        "municipality",
        "direction",
        "institution_name",
        "organizational_unit",
        "phone",
        "office_phone"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    public function files(){
        return $this->hasMany(ClientFile::class);
    }

    public function ServiceRequest () {
        return $this->belongsTo(ServiceRequest::class,'service_request_id');
    }
}
