<?php

namespace App\Imports;

use App\Models\Lga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class LgaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Lga([
            'lga' => $row['lga'],
            'state' => $row['state']
        ]);
    }
}
