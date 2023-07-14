<?php

namespace App\Imports;

use App\Models\Carmake;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 

class CarmakeImport implements ToModel ,WithHeadingRow
{
    protected $fillable = ['year_id','name'];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Carmake([
        
            'year_id' => $row['year_id'],
            'name' => $row['name'],
        ]);
    }
}
