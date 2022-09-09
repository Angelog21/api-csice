<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'pivot_service_requests';

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];


    protected $fillable = [
        "service_id",
        "service_request_id",
        "quantity",
        "subtotal",
        "total",
        "iva",
        "iva_value",
        "petro_quantity",
    ];

    public function serviceRequests(){
        return $this->hasMany(ServiceRequest::class,"service_requests_id");
    }

    public function services() {
        return $this->hasMany(Service::class,"id");
    }

}
