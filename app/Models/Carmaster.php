<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Carmaster extends Model
{
    use QueryCacheable;
    protected $cacheFor = 60*15;

    protected $table = 'car_master';

    use HasFactory;

    
}
