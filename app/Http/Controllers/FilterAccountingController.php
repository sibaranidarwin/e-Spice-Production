<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\good_receipt;
use App\Invoice;
use App\User;
use App\BA_Reconcile;
use App\Draft_BA;
use Carbon\CarbonImmutable;

use Auth;
use Carbon\Carbon;

class FilterAccountingController extends Controller
{
    //
    function filterdash(){
        if (request()->month || request()->yer || request()->vendor){
                $user_vendor2 = Auth::User()->name;
                $user_vendor = Auth::User()->id_vendor;
                $a = date('Y-m-d');
                $b = date('Y-m-d',strtotime('+1 days'));
                $range = [$a, $b];
                $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
                
                $draft = Draft_BA::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->count();
                $ba = BA_Reconcile::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->count();
                $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
                $month = 1;
                $date = \Carbon\Carbon::parse($year."-".$month."-01"); // universal truth month's first day is 1
                $start = $date->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
                $end = $date->endOfMonth()->format('Y-m-d H:i:s');
                $invgr =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "GR")->sum('total_harga_everify');
                $invba =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "BA")->sum('total_harga_everify');
                // dd($invgr);
                $month = request()->input('month');
                $vendor_name1 = request()->input('vendor');
                $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
                
                $totalgr=good_receipt::where("vendor_name", request()->vendor)->whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->sum('jumlah_harga');
                $totalinv =Invoice::where("data_from", "GR")->sum('total_harga_everify');
                $totalinvba =Invoice::where("data_from", "BA")->sum('total_harga_everify');
                $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
                $invthngr =Invoice::whereYear('created_at', $year)->where("data_from", "GR")->sum('total_harga_everify');
                $invthnba =Invoice::whereYear('created_at', $year)->where("data_from", "BA")->sum('total_harga_everify');
                $invoicegr = Invoice::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where("data_from", "GR")->count();
                $invoiceba = Invoice::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where("data_from", "BA")->count();
                $good_receipt = good_receipt::where("vendor_name", request()->vendor)->whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->count();
                // dd($good_receipt);
                $dispute = good_receipt::all()->where("status", "Disputed")->count();
               
            } else {
            $good_receipt = good_receipt::count();
            $invoicegr = Invoice::all()->where("data_from", "GR")->count();
            $invoiceba = Invoice::all()->where("data_from", "BA")->count();
            $dispute = good_receipt::all()->where("status", "Disputed")->count();
            $vendor = User::all()->where("level", "vendor")->count();
            $draft = Draft_BA::count();
            $ba = BA_Reconcile::count();
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];
            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
            $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

            $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
            $month1 = 1;
            $date = \Carbon\Carbon::parse($year."-".$month1."-01"); // universal truth month's first day is 1
            $start = $date->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
            $end = $date->endOfMonth()->format('Y-m-d H:i:s');
            $invgr =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "GR")->sum('total_harga_everify');
            $invba =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "BA")->sum('total_harga_everify');
            $month = request()->input('month');
            $yer = request()->input('yer');
             
            $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
            $invthngr =Invoice::whereYear('created_at', $year)->where("data_from", "GR")->sum('total_harga_everify');
            $invthnba =Invoice::whereYear('created_at', $year)->where("data_from", "BA")->sum('total_harga_everify');
            $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
        
            }
            return view('accounting.dashboard',compact('vendor_name', 'vendor_name1', 'month','yer','good_receipt', 'notif', 'draft', 'ba', 'invgr', 'invba', 'invoicegr', 'invoiceba', 'dispute', 'invthngr', 'invthnba', 'totalgr', 'totalinv', 'totalinvba'))
            ->with('i',(request()->input('page', 1) -1) *5);
        }

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
