<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Notification extends Model
{
    use HasFactory;

    public function getMessageAttribute($value = "")
    {
        if(!empty($value)) 
        {
          
            $value = str_replace('Sent a message', __("message.SENT_MESSAGE"), $value);

        }
        return $value;
    } 


    

    public function userDetail()
    {
        return $this->belongsTo(User::class, 'user_id')->select(array('id', 'name', 'image'));
    }

    public function sellerDetail()
    {
        return $this->belongsTo(User::class, 'notification_from')->select(array('id', 'name', 'image'));
    }
    
    public function getDataAttribute($value=""){
        if (!empty($value)){
            return  json_decode($value);
        }
    
         return $value;
    
        }
}
