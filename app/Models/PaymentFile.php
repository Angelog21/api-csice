<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "service_requests_id",
        "name",
        "url"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function request() {
        return $this->belongsTo(ServiceRequest::class,'service_requests_id');
    }
}
