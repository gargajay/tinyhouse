<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

      protected $appends = ['car_price'];

    public function sender_detail()
    {
        return $this->belongsTo('App\Models\User', 'sender_id')->withTrashed();
    }

    public function receiver_detail()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id')->withTrashed();
    }

    public function last_message()
    {
        return $this->hasOne('App\Models\Message', 'chat_id')->orderBy('created_at', 'DESC');
    }
//
    public function first_message()
    {
        return $this->hasOne('App\Models\Message', 'chat_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'chat_id');
    }

    public function getUnseenMessageCountAttribute()
    {
        $userId = \Auth::user()->id ?? 0;
        return Message::where(['chat_id' => $this->id])
            ->where('sent_by', '!=', $userId)
            ->where('is_seen', '0')
            ->count();
    }

    public function cars_images()
    {
        return $this->hasMany(CarImage::class, 'car_id','car_id');
    }

    public function getCarPriceAttribute()
    {
       $car =  Car::where('id',$this->car_id)->first(); 
       
       if(!empty($car)){
      return   $car->amount;
       }
       return "";
    }

    
}
