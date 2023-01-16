<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\good_receipt;
use App\Invoice;
use App\User;

use Auth;
use Carbon\Carbon;

class FilterAccountingController extends Controller
{
    //
    function filter(){
    if (request()->start_date || request()->end_date || request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $status = request()->status;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->orderBy('gr_date', 'ASC')->get();
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
            
            $dispute = good_receipt::all()->where("status", "notif")->count();
           
        } else {
            $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::distinct()->get();
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
    
        }
        return view('accounting.po.all',compact('good_receipts', 'notif', 'start_date', 'end_date', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filternot(){
        if (request()->start_date || request()->end_date || request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
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

            $dispute = good_receipt::all()->where("status", "notif")->count();
    
        } else {
            $good_receipts = good_receipt::where('material_number','LG2KOM00707010F691')->where("status","Not Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
    
        }
        return view('accounting.po.notver',compact('good_receipts', 'notif', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    
    function filterver(){
        if (request()->start_date || request()->end_date ||  request()->vendor){
            $start_date =request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null ){
                    $good_receipts = good_receipt::where("vendor_name", $vendor)->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();  
                    }
            elseif($start_date != null && $end_date != null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }
            else{
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Verified")->orderBy('gr_date', 'ASC')->get();
                }

        } else {
            $good_receipts = good_receipt::where("status","Verified")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
    
        }
        return view('accounting.po.ver',compact('good_receipts', 'notif', 'start_date', 'end_date', 'status','vendor', 'vendor_name'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterreject(){
        if (request()->start_date || request()->end_date || request()->status || request()->vendor){
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
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
            
            $dispute = good_receipt::all()->where("status", "notif")->count();
        } else {
            $good_receipts = good_receipt::where("status","Rejected")->get();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
        }
        return view('accounting.po.reject',compact('good_receipts', 'notif', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdisp(){
        if (request()->start_date || request()->end_date || request()->vendor){
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $vendor = request()->vendor;
            $status = request()->status;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            
            if($vendor == null){
                $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->orderBy('gr_date', 'ASC')->get();
                }
            elseif($vendor != null){
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
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
            $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        }
        return view('accounting.dispute.index',compact('good_receipts', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor', 'notif'))->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $status = request()->status;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "GR")->orderBy('posting_date', 'ASC')->get();
        } else {
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $vendor = request()->vendor;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::latest()->Where("data_from", "GR")->get();
        }
        
        return view('accounting.invoice.index', compact('invoice', 'notif', 'start_date', 'end_date', 'status'))->with('i',(request()->input('page', 1) -1) *5);
    }

    
    function filterinvba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $status = request()->status;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();    
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("data_from", "BA")->orderBy('posting_date', 'ASC')->get();
        } else {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $status = request()->status;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::latest()->Where("data_from", "BA")->get();
        }
        
        return view('accounting.invoice.indexba', compact('invoice', 'notif', 'start_date', 'end_date', 'status'))->with('i',(request()->input('page', 1) -1) *5);
    }
}
