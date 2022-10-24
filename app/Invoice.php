<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
     protected $table = 'invoice';
     protected $primaryKey = 'id_inv'; 
     protected $fillable = ['id_inv','posting_date','vendor_invoice_number','everify_number','faktur_pajak_number','total_harga_everify','total_harga_gross','DEL_COSTS','ppn','baselinedate','INVOICE_DOC_ITEM','HEADER_TEXT','VALUATION_TYPE','status','data_from','komentar','Invoice_Park_Document'];
    
     public function good_receipt()
     {
        return $this->belongsToMany('App\good_receipt', 'goods_receipt', 'id_gr','id_inv');
     }

     //DEFINE ACCESSOR
    public function getTaxAttribute()
    {
        //MENDAPATKAN TAX 2% DARI TOTAL HARGA
        return ($this->total * 2) / 100; 
    }
    
     public function getTotalPriceAttribute()
    {
        //MENDAPATKAN TOTAL HARGA BARU YANG TELAH DIJUMLAHKAN DENGAN TAX
        return ($this->total + (($this->total * 2) / 100));
    }
  
}