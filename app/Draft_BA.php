<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft_BA extends Model
{
    //
    protected $table = 'draft_ba';
    protected $fillable = ['id_draft_ba','id_gr','id_vendor','no_draft','date_draft','po_number','mat_desc','vendor_part_number','selisih_harga','jumlah_harga','gr_date','jumlah','po_item','doc_header_text','status_draft','status_invoice_proposal','reason'];
   
    public function good_receipt(){
        return $this->belongsTo(good_receipt::class);
  }
}
