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
        "status",
        "responsed_at",
        "completed_at",
        "start_date",
        "end_date"
    ];

    public function service() {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
