<?php

namespace App\Http\Controllers;

use App\good_receipt;
use Illuminate\Http\Request;

class PoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {   
        $good_receipts = good_receipt::latest()->get();
        return view('admin.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
}
