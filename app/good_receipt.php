<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class good_receipt extends Model
{
    //
    protected $table = 'goods_receipt';
    protected $fillable = ['id_gr','vendor_id','vendor_name','no_po','po_item','GR_Date', 'alasan_disp', 'Delivery_Note','Doc_Header_Text','Material_Number','Vendor_Part_Number','Mat_Desc','Valuation_Type','GR_Number','UOM','Currency','harga_satuan','jumlah','jumlah_harga','total_harga','Tax_Code','Status','Mat_Doc_IT','Year','Comp_Code','Ref_Doc_No','Total_Ppn'];
}