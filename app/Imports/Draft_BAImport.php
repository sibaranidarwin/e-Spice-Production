<?php

namespace App\Imports;

use App\Draft_BA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Draft_BAImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $now = date('Y-m-d H:i:s');
        return new Draft_BA([
            'no_draft'=>$row['no_draft'],
            'date_draft'=>$row['date_draft'],
            'po_number'=>$row['po_number'],
            'material'=>$row['material'],
            'status_draft'=>$row['status_draft'],
            'reason'=>$row['reason'],
            'created_at'=>$now
        ]);
    }
}
