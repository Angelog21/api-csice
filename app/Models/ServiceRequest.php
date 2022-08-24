<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "price",
        "iva",
        "total",
        "quantity",
        "status",
        "responsed_at",
        "completed_at",
        "expiration_date",
        "start_date",
        "correlativo",
        "end_date",
        "observation",
        "emailList",
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'expiration_date' => 'datetime:d-m-Y',
        'start_date' => 'datetime:d-m-Y'
    ];

    public function services() {
        return $this->hasMany(PivotServiceRequest::class,"service_requests_id");
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function files() {
        return $this->hasMany(PaymentFile::class,"service_requests_id");
    }
}
