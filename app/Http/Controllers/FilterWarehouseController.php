<?php

namespace App\Http\Controllers;

use App\BA_Reconcile;
use App\Draft_BA;
use App\Exports\DraftbaExport;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;
use App\Ba;
use Maatwebsite\Excel\Facades\Excel;


use PDF; //library pdf
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Carbon\Carbon;

class FilterWarehouseController extends Controller
{
    //
    
    function filter(){
        if (request()->start_date || request()->end_date || request()->status){
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $status = request()->status;
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('status_invoice', $status)->where('status', 'Verified')->orderBy('gr_date', 'ASC')->get();
            
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            // dd($good_receipts);
        } else {
            $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.all',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filternot(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('material_number','LG2KOM00707010F691')->where("status","Not Verified")->get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        } else {
            $good_receipts = good_receipt::where('material_number','LG2KOM00707010F691')->where("status","Not Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.index',compact('good_receipts', 'dispute', 'start_date', 'end_date'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterver(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Verified")->get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        } else {
            $good_receipts = good_receipt::where("status","Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.verified',compact('good_receipts', 'dispute', 'start_date', 'end_date'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterreject(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
        } else {
            $good_receipts = good_receipt::where("status","Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
        }
        return view('warehouse.po.reject',compact('good_receipts', 'dispute', 'start_date', 'end_date'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();

            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "GR")->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $invoice = Invoice::latest()->Where("data_from", "GR")->get();
        }
        
        return view('warehouse.invoice.index', compact('invoice', 'dispute', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }

    
    function filterinvba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "BA")->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $invoice = Invoice::latest()->Where("data_from", "BA")->get();
        }
        
        return view('warehouse.invoice.indexba', compact('invoice', 'dispute', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }
}
