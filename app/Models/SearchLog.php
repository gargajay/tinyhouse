<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $table= 'search_log';
    //
    // public function getCarsAttribute($value = "")
    // {
    //     if (!empty($value)) {
    //         return json_decode($value, TRUE);
    //     }
        
    //     return [];
    // }

    public function getSearchAttribute($value = "")
    {
        if (!empty($value)) {
            return json_decode($value, TRUE);
        }
        
        return [];
    }
}
