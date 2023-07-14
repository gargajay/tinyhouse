<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    use HasFactory;

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function reviewer_detail()
    {
        return $this->hasOne(User::class, 'id', 'review_by');
    }

    public function service_detail()
    {
        return $this->hasOne(User::class, 'service_id');
    }

    public function buyerDetail()
    {
        return $this->belongsTo(User::class,'review_by');
    }
    public function sellerDetail()
    {
        return $this->belongsTo(User::class,'review_by');
    }
}
