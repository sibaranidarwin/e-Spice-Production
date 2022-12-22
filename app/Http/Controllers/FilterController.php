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
class FilterController extends Controller
{
    //
    
    function filter(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
                $query->where('status','Verified')
                            ->orWhereNull('status');})->orderBy('gr_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;

            $good_receipts = good_receipt::where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
                $query->where('status','Verified')
                            ->orWhereNull('status');})->orderBy('updated_at', 'ASC')->get();
        }
        
        return view('vendor.po.index', compact('good_receipts'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdisp(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        }
        return view('vendor.dispute.index',compact('good_receipts'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterhistorydraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - Draft BA')->get();
           } else {
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - Draft BA')->get();
        }
        return view('Vendor.ba.historydraft',compact('draft'));
    }

    function filterhistoryba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $ba = BA_Reconcile::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->get();

        } else {
            $user_vendor = Auth::User()->id_vendor;
            $ba = BA_Reconcile::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->get();
        }
        return view('Vendor.ba.historyba',compact('ba'));
    }
    
    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            // dd($user_vendor);
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();
        }
        
        return view('vendor.invoice.index', compact('invoice'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterinvba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            // dd($user_vendor);
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->get();
        }
        
        return view('vendor.invoice.indexba', compact('invoice'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->get();
        }
        return view('Vendor.ba.draft',compact('draft'));
    }
    function filterba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
           
             $BA = Ba::select("ba.no_ba",
             "ba.status_ba",
             "ba_reconcile.status_invoice_proposal",
             )
             ->distinct()
             ->JOIN("ba_reconcile","ba.no_ba", "=", "ba_reconcile.no_ba")
             ->whereBetween('ba.created_at',[$start_date,$end_date])
             ->where("ba.id_vendor", "=", $user_vendor)
             ->where("ba_reconcile.status_invoice_proposal", "=", "Not Yet Verified - BA")
             ->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $BA = Ba::select("ba.no_ba",
            "ba.status_ba",
            "ba_reconcile.status_invoice_proposal",
            )
            ->distinct()
            ->JOIN("ba_reconcile","ba.no_ba", "=", "ba_reconcile.no_ba")
            ->where("ba.id_vendor", "=", $user_vendor)
            ->where("ba_reconcile.status_invoice_proposal", "=", "Not Yet Verified - BA")
            ->get();
        }
        
        return view('Vendor.ba.detail',compact('BA'));
    }
}
