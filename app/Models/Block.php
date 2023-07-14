<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class Block extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    use HasFactory;
    protected $fillable=[
        'block_user_id',
        'blockBy_user_id',
        'title',
        'image'
        ];
    protected $hidden=[
        'title',
        'deleted_at',
        'blockBy_user_id',

    ];
   

    protected $appends =['block_user_name'];
    
    public function blockUser()
    {
        $user = User::where('id',$this->block_user_id)->first();

        if(!empty($user)){
            return $user->first_name.' '.$user->last_name;
        }
    }
    public function blocBykUser()
    {
        $user = User::where('id',$this->blockBy_user_id)->first();
        if(!empty($user)){
            return $user->first_name.' '.$user->last_name;
        }
        
    }

    public function getblockUserNameAttribute($value)
    {
        return $this->blockUser();
    }

 



    public function user_block()
    {
        return $this->belongsTo(User::class,'block_user_id','id');
    }

}