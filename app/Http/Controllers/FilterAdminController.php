<?php

namespace App\Http\Controllers;
use App\good_receipt;
use App\Invoice;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FilterAdminController extends Controller
{
    function filter(){
        if (request()->start_date || request()->end_date){
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $status = request()->status;
            $vendor_name = good_receipt::get();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->orwhere('status_invoice', $status)->where("status", "Verified")->where("status", "Rejected")->orderBy('gr_date', 'ASC')->get();

            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            // dd($good_receipts);
        } else {
            $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor_name = good_receipt::get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('admin.po.all',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
}
