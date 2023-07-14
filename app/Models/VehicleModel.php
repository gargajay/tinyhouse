<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    public function VehicleCompany()
    {
        return $this->belongsTo(VehicleCompany::class, 'vehicle_companies_id');
    }
}
