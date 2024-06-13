<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        "service_requests_id",
        "name",
        "type",
        "url"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function request() {
        return $this->belongsTo(ServiceRequest::class,'service_requests_id');
    }
}
