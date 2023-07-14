<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function getImageAttribute($value = '')
    {
        if (!empty($value)) {
            return asset('/uploads/category/' . $value);
        }
        return asset('/images/default-profile.jpg');
    }

    public function getTitleAttribute($value = '')
    {

        $cat =  Category::find($this->id);

        if (App::getLocale() == 'es') {

            return $cat ? $cat->es_title : $cat->title;
        }

        return $value;
    }
}
