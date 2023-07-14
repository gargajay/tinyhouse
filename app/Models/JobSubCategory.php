<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSubCategory extends Model
{
    use HasFactory;

    protected $appends = ['sub_category_detail'];

    public function getSubCategoryDetailAttribute()
    {
        $categoryId = $this->sub_category_id ?? 0;

        if(isset($categoryId) && !empty($categoryId)) {
            return SubCategory::find($categoryId);
        }

        return NULL;
    }
}
