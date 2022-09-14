<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
	protected $table = 'users';
    protected $fillable = [
        'name','user_id','companycode', 'email', 'password','level','foto'
    ];

}
