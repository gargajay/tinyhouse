<?php

namespace App\Imports;

use App\Models\Modelyear;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ModelImport implements ToModel, WithHeadingRow 
{
    protected $fillable = ['year'];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
       
        return new  Modelyear([
            
                'year' => $row['year'],
            ]);
        
      

            
    }
}
