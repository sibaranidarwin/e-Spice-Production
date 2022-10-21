<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BA_Reconcile extends Model
{
    //
    protected $table = 'ba_reconcile';
    protected $fillable = ['id_ba','no_ba','gr_date','po_number','po_mkp','material_bp','status_ba'];
    
    public function Draft_BA()
    {
        return $this->belongsTo('App\Draft_BA');
    }
}
