<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiclefeature extends Model
{
    use HasFactory;
    public function featureList()
    {
        return $this->belongsTo(Featurelist::class, 'feature_id');            
    }

    
}
