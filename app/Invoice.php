<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
     protected $table = 'invoice';
     protected $fillable = ['id','id_gr','posting_date','vendor_invoice_number','everify_number','faktur_pajak_number','total_harga_everify','total_harga_gross','DEL_COSTS','ppn','baselinedate','INVOICE_DOC_ITEM','HEADER_TEXT','VALUATION_TYPE','status','komentar','Invoice_Park_Document'];
    
     public function good_receipt(){
        return $this->hasOne('App\good_receipt');
     }
  
}