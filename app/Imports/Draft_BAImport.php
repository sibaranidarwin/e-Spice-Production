<?php

namespace App\Imports;

use App\BA_Reconcile;
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
        $status_ba = "Verified - BA"; 
        return new BA_Reconcile([
            'no_ba'=>$row['no_ba'],
            'gr_date'=>$row['gr_date'],
            'po_number'=>$row['po_number'],
            'po_mkp'=>$row['po_mkp'],
            'material_bp'=>$row['material_bp'],
            'item'=>$row['item'],
            'material_description'=>$row['material_description'],
            'reference'=>$row['reference'],
            'qty'=>$row['qty'],
            'amount_vendor'=>$row['amount_vendor'],
            'material_mkp'=>$row['material_mkp'],
            'amount_mkp'=>$row['amount_mkp'],
            'confirm_price'=>$row['confirm_price'],
            'status_ba'=>$status_ba,
            'created_at'=>$now
        ]);
    }
}
