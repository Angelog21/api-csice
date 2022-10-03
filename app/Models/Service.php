<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name",
        "unit",
        "petro_quantity",
        "service_to",
        "iva_value"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    public function serviceRequests() {
        return $this->belongsToMany(ServiceRequest::class,'pivot_service_requests');
    }
}
