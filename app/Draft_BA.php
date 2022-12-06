<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft_BA extends Model
{
    //
    protected $table = 'draft_ba';
    protected $primaryKey = 'id_draft_ba'; 
    protected $fillable = ['id_gr','id_vendor','no_draft','date_draft','po_number','gr_number','mat_desc','material_number','vendor_part_number','selisih_harga','uom','currency','jumlah_harga','harga_satuan','delivery_note','ref_doc_no','jumlah_harga','gr_date','jumlah','valuation_type','po_item','tax_code','doc_header_text','status_draft','status_invoice_proposal','reason'];
   
    public function good_receipt(){
        return $this->belongsTo(good_receipt::class);
  }
}
