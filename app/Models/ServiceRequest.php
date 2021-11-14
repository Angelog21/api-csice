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
        "expiration_date",
        "start_date",
        "end_date",
        "observation"
    ];

    public function service() {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function files() {
        return $this->hasMany(PaymentFile::class,"service_requests_id");
    }
}
