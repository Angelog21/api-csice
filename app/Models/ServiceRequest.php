<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "service_id",
        "price",
        "iva",
        "total",
        "quantity",
        "status"
    ];

    public function service() {
        return $this->belongsTo(Service::class,'service_id');
    }
}
