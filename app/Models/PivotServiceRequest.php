<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotServiceRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];


    protected $fillable = [
        "service_id",
        "service_requests_id",
        "quantity",
        "subtotal",
        "total",
        "iva",
        "iva_value",
        "petro_quantity",
    ];

    public function serviceRequests(){
        return $this->belongsToMany(ServiceRequest::class,"service_requests_id");
    }

    public function services() {
        return $this->belongsToMany(Service::class,'service_id');
    }

}
