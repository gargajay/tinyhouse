<?php

namespace App\Imports;

use App\Models\Carmodel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
class CarmodelImport implements ToModel ,WithHeadingRow
{
    protected $fillable = ['year_id','model_id','name'];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Carmodel([
            'year_id' => $row['year_id'],
            'model_id' => $row['model_id'],
            'name' => $row['name'],
        ]);
    }
}
