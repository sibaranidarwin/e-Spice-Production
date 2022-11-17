<?php

namespace App\Imports;

use App\BA_Reconcile;
use App\Draft_BA;
use Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
class Draft_BAImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $q = DB::table('draft_ba')->select(DB::raw('MAX(RIGHT(no_draft, 8)) as kode'));
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
                                                                                                                                            
         Validator::make($rows->toArray(), [
             '*.id_vendor' => '',
             '*.no_ba' => '',
             '*.gr_date' => 'required',
             '*.po_number' => 'required',
             '*.item' => 'required',
             '*.material_description' => 'required',
             '*.qty' => 'required',
             '*.amount_mkp' => 'required',
             '*.status_ba' => 'required',
             '*.status_invoice_proposal' => '',
             '*.created_at' => ''

         ])->validate();
        foreach ($rows as $row) {
            BA_Reconcile::create([
                'id_vendor' =>Auth::User()->id_vendor,
                'no_ba'=>"MKP-BA-".$kd,
                'gr_date'=>$row['gr_date'],
                // dd($row['gr_date']),
                'po_number'=>$row['po_number'],
                'item'=>$row['item'],
                'material_description'=>$row['material_description'],
                // 'reference'=>$row['reference'],
                'qty'=>$row['qty'],
                'amount_mkp'=>$row['amount_mkp'],
                'status_ba'=>"Verified",
                'status_invoice_proposal' =>"Not Yet Verified - BA",
                'created_at'=>$now = date('Y-m-d H:i:s'),
            ]);
        }
    }
    // public function model(array $row)
    // {
    //     $user_vendor = Auth::User()->id_vendor;

    //     $q = DB::table('draft_ba')->select(DB::raw('MAX(RIGHT(no_draft, 4)) as kode'));
    //     $kd="";
    //     if($q->count()>0)
    //     {
    //         foreach($q->get() as $k)
    //         {
    //             $tmp = ((int)$k->kode)+1;
    //             $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
    //         }
    //     }
    //     else
    //     {
    //         $kd = date('d-m-Y').'-'."0001";
    //     }

        
    //     $now = date('Y-m-d H:i:s');
    //     $status_ba = "Verified"; 
    //     $status_invoice = "Not Yet Verified - BA";
    //     return new BA_Reconcile([
    //         'id_vendor'=>$user_vendor,
    //         'no_ba'=>"MKP-BA-".$kd,
    //         'gr_date'=>$row['gr_date'],
    //         // dd($row['gr_date']),
    //         'po_number'=>$row['po_number'],
    //         'item'=>$row['item'],
    //         'material_description'=>$row['material_description'],
    //         // 'reference'=>$row['reference'],
    //         'qty'=>$row['qty'],
    //         'amount_mkp'=>$row['amount_mkp'],
    //         'status_ba'=>$status_ba,
    //         'status_invoice_proposal' =>$status_invoice,
    //         'created_at'=>$now
    //     ]);
    // }
}
