<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function getImageAttribute($value = '')
    {
        if (!empty($value)) {
            return asset('/uploads/sub_category/' . $value);
        }
        return asset('/images/default-profile.jpg');
    }
}
