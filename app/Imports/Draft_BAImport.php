<?php

namespace App\Imports;

use App\BA_Reconcile;
use App\Draft_BA;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\DB;
class Draft_BAImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user_vendor = Auth::User()->id_vendor;

        $q = DB::table('draft_ba')->select(DB::raw('MAX(RIGHT(no_draft, 4)) as kode'));
        $kd="";
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kode)+1;
                $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = date('d-m-Y').'-'."0001";
        }

        
        $now = date('Y-m-d H:i:s');
        $status_ba = "Verified - BA"; 
        return new BA_Reconcile([
            'id_vendor'=>$user_vendor,
            'no_ba'=>"MKP-BA-".$kd,
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
