<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BA_Reconcile extends Model
{
    //
    protected $table = 'ba_reconcile';
    
    public function Draft_BA()
    {
        return $this->belongsTo('App\Draft_BA');
    }
}
