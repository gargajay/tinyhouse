<?php

namespace App\Exports;

use App\Models\Modelyear;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModelExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    // public function __construct(int $id)
    // {
    //     $this->id = $id;
    // }

    // public function query()
    // {
    //     return Modelyear::query()->where('id', $this->id);
    // }

    public function headings(): array
    {
        return ["id", "year"];
    }
    public function collection()
    {
        return Modelyear::all();
    }
}
