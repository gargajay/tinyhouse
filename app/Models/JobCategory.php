<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $appends = ['category_detail'];

    public function getCategoryDetailAttribute()
    {
        $categoryId = $this->category_id ?? 0;

        if(isset($categoryId) && !empty($categoryId)) {
            return Category::find($categoryId);
        }

        return NULL;
    }
}
