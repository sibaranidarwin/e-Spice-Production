<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    //
    protected $table = 'users';
    protected $fillable = [
        'name','user_id','companycode', 'email', 'password','level','foto'
    ];
}
