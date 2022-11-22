<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BA_Reconcile extends Model
{
    //
    protected $table = 'ba_reconcile';
    protected $primaryKey = 'id_ba'; 
    protected $fillable = ['id_draft_ba', 'id_inv','id_vendor','no_ba','gr_date','po_number','item','material_description','vendor_part_number','reference','qty','amount_vendor','amount_mkp','confirm_price','status_ba','status_invoice_proposal'];
    
    public function Ba(){
        return $this->hasMany('App\Ba');
    }
}
