<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BA_Reconcile extends Model
{
    //
    protected $table = 'ba_reconcile';
    protected $primaryKey = 'id_ba'; 
    protected $fillable = ['id_draft_ba', 'id_inv','id_vendor', 'no_ba','gr_date','po_number','po_mkp','material_bp','item', 'material_description','reference','qty','amount_vendor','material_mkp','amount_mkp','confirm_price','status_ba'];
    
    public function Draft_BA()
    {
        return $this->belongsTo('App\Draft_BA');
    }
}
