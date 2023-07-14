<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCompany extends Model
{
    use HasFactory;
    public function vehicleModel()
    {
       return $this->hasMany(VehicleModel::class, 'vehicle_companies_id');
    }
}
