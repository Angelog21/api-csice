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
        "petro_quantity"
    ];

    public function serviceRequests() {
        return $this->hasMany(ServiceRequest::class);
    }
}
