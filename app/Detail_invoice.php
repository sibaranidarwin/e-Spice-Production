<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_invoice extends Model
{
    //
    protected $table ="detail_invoice";
    public function invoice()
    {
        return $this->belongsTo("App\invoice");
    }
}
