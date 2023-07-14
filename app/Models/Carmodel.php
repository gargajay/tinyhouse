<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    use HasFactory;

    protected $fillable = ['year_id' ,'model_id','name'];

    public function years()
    {
        return $this->belongsTo(Modelyear::class, 'year_id');
    }

    public function Carmake()
    {
        return $this->belongsTo(Carmake::class, 'model_id');
    }
}
