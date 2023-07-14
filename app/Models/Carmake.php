<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carmake extends Model
{
    use HasFactory;
    protected $fillable = ['year_id' ,'name'];


    public function years()
    {
        return $this->belongsTo(Modelyear::class, 'year_id');
    }
}
