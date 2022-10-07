<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
       //
       public function __construct()
       {
           $this->middleware('auth');
       }
       public function showing()
       {   
           $invoice = Invoice::latest()->get();
           return view('admin.invoice.index',compact('invoice'))
                   ->with('i',(request()->input('page', 1) -1) *5);
       }
       public function showingwarehouse()
       {
        $invoice = Invoice::latest()->get();
        return view('warehouse.invoice.index',compact('invoice'))
                ->with('i',(request()->input('page', 1) -1) *5);
       }
}
