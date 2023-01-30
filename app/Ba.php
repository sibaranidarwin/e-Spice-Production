<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ba extends Model
{
    //
    protected $table = 'ba';
    protected $primaryKey = 'id'; 
    protected $fillable = ['no_ba','id_vendor','status_ba','status_invoice_proposal', 'lamp'];
    
 
}
