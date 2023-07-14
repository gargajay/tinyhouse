<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable=[
        'report_user_id',
        'reportBy_user_id',
        'title',
        ];

        public function user()
     {
        return $this->belongsTo(User::class,'user_id')->select(['name', 'image', 'id']);
     }

}