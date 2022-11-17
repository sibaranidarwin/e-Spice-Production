<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
     protected $table = 'invoice';
     protected $primaryKey = 'id_inv'; 
     protected $fillable = ['id_inv','id_vendor','posting_date','vendor_invoice_number','no_invoice_proposal','everify_number','faktur_pajak_number','total_harga_everify','total_harga_gross','del_costs','ppn','baselinedate','invoice_doc_item','header_text','valuation_type','status','status_invoice_proposal','data_from','komentar','invoice_park_document'];
    
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