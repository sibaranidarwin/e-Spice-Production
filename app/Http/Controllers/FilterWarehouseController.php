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
        if (request()->start_date || request()->end_date || request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $status = request()->status;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->orderBy('gr_date', 'ASC')->get();
            }
            elseif($vendor != null){
            $good_receipts = good_receipt::where("vendor_name", $vendor)->orderBy('gr_date', 'ASC')->get();  
            }
            elseif($start_date != null && $end_date != null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->orderBy('gr_date', 'ASC')->get();
            }
            else{
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->orderBy('gr_date', 'ASC')->get();
            }
            
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
           
        } else {
            $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::distinct()->get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.all',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filternot(){
        if (request()->start_date || request()->end_date || request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('material_number', 'LG2KOM00707010F691' )->WhereNull('status')->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null){
                    $good_receipts = good_receipt::where("vendor_name", $vendor)->where('material_number', 'LG2KOM00707010F691' )->WhereNull('status')->orderBy('gr_date', 'ASC')->get();  
                    }
            elseif($start_date != null && $end_date != null){
                    $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('material_number', 'LG2KOM00707010F691' )->WhereNull('status')->orderBy('gr_date', 'ASC')->get();
                }
            else{
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('material_number', 'LG2KOM00707010F691' )->WhereNull('status')->orderBy('gr_date', 'ASC')->get();
                }

            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        } else {
            $good_receipts = good_receipt::where('material_number','LG2KOM00707010F691')->where("status","Not Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;

            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.index',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterver(){
        if (request()->start_date || request()->end_date ||  request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null){
                    $good_receipts = good_receipt::where("vendor_name", $vendor)->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();  
                }
            elseif($start_date != null && $end_date != null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }
            else{
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }

            $dispute = good_receipt::all()->where("status", "Disputed")->count();
        } else {
            $good_receipts = good_receipt::where("status","Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
    
        }
        return view('warehouse.po.ver',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status','vendor', 'vendor_name'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterreject(){
        if (request()->start_date || request()->end_date || request()->status || request()->vendor){
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null ){
                    $good_receipts = good_receipt::where("vendor_name", $vendor)->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();  
                }
            elseif($start_date != null && $end_date != null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();
                }
            else{
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();
                }
            
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
        } else {
            $good_receipts = good_receipt::where("status","Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

            $dispute = good_receipt::all()->where("status", "Disputed")->count();
        }
        return view('warehouse.po.reject',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdisp(){
        if (request()->start_date || request()->end_date || request()->vendor){
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $status = request()->status;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null ){
                $good_receipts = good_receipt::where("vendor_name", $vendor)->where("status", "Disputed")->orderBy('gr_date', 'ASC')->get();  
                }
            elseif($start_date != null && $end_date != null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->orderBy('gr_date', 'ASC')->get();
                }
            else{
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->orderBy('gr_date', 'ASC')->get();
                }

            } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        }
        return view('warehouse.po.disputed',compact('good_receipts', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))->with('i',(request()->input('page', 1) -1) *5);
    }
    
    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();

            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "GR")->get();
        } else {
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
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "BA")->get();
        } else {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $invoice = Invoice::latest()->Where("data_from", "BA")->get();
        }
        
        return view('warehouse.invoice.indexba', compact('invoice', 'dispute', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }
}
