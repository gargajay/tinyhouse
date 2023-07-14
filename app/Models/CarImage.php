<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CarImage extends Model
{
    use QueryCacheable;
    protected $cacheFor = 180;
    use HasFactory;

    public function getImageAttribute($value = '')
    {
        $url = 'https://gocarhub.s3.us-east-2.amazonaws.com/images/';
        if (!empty($value)) 
        {
            return    $url.$value;

            // $imageDate = Carbon::parse($this->created_at);
            // $oldDate = Carbon::parse('2023-02-16 00:13:03');
            // if($imageDate->gt($oldDate))
            // {
            //  return    $url.$value;
            // }else{
            //  return asset('/uploads/images/' . $value);

            // }
        }

        return asset('/images/default-profile.jpg');

        
    } 
}
