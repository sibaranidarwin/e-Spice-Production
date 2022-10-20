<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft_BA extends Model
{
    //
    protected $table = 'draft_ba';
    protected $fillable = ['id_draft_ba','id_gr','no_draft','date_draft','po_number','material','status_draft','reason'];
   
    public function good_receipt(){
        return $this->belongsTo(good_receipt::class);
  }
}
