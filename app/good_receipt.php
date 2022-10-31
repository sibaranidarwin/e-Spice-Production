<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class good_receipt extends Model
{
    //
    protected $table = 'goods_receipt';
    protected $primaryKey = 'id_gr'; 
    protected $fillable = ['id_inv','vendor_id','vendor_name','no_po','po_item','gr_date', 'alasan_disp', 'delivery_note','doc_header_text','material_number','vendor_part_number','mat_desc','valuation_type','gr_number','uom','currency','harga_satuan','jumlah','jumlah_harga','total_harga','tax_code','status','mat_doc_it','year','comp_code','ref_doc_no','total_ppn','lampiran'];
    
    public function Invoice()
    {
       return $this->belongsToMany('App\Invoice', 'invoice', 'id_gr','id_inv');
    }
    public function Draft_BA(){
        return $this->hasOne(Draft_BA::class);
    }
}