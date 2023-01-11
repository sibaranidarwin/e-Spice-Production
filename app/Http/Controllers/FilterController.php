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
    
    function filter(Request $request){
          if (request()->start_date || request()->end_date || $request['minpo'] || $request['maxpo'])  {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $minpo = request()->minpo;
            $maxpo = request()->maxpo;
            // dd($minpo);
            
            $user_vendor = Auth::User()->id_vendor;
            $not = good_receipt::select(
                                "goods_receipt.status",
                                "goods_receipt.plant_code",
                                "goods_receipt.no_po",
                                "goods_receipt.po_item",
                                "goods_receipt.gr_number",
                                "goods_receipt.gr_date",
                                "goods_receipt.material_number",
                                "goods_receipt.vendor_part_number",
                                "goods_receipt.mat_desc",
                                "goods_receipt.valuation_type",
                                "goods_receipt.jumlah",
                                "goods_receipt.uom",
                                "goods_receipt.currency",
                                "goods_receipt.harga_satuan",
                                "goods_receipt.tax_code",
                                "goods_receipt.ref_doc_no",
                                "goods_receipt.delivery_note",
                                "draft_ba.status_invoice_proposal"
                                )
                ->JOIN("draft_ba","goods_receipt.id_gr", "=", "draft_ba.id_gr")
                ->whereBetween('goods_receipt.gr_date',[$start_date,$end_date])
                ->orwhereBetween('no_po',[$minpo,$maxpo])
                ->where("draft_ba.id_vendor", "=", $user_vendor)
                ->where('id_inv',0)
                ->where('status_invoice_proposal', 'Not Yet Verified - Draft BA')
                ->where(function($query) {
                $query->where('goods_receipt.status','Verified')
                ->orwhere('goods_receipt.status','Auto Verify')
                ->orWhereNull('status');})
                ->orderBy('goods_receipt.updated_at', 'ASC')
                ->get();

                $ver = good_receipt::select(
                "goods_receipt.status",
                "goods_receipt.plant_code",
                "goods_receipt.no_po",
                "goods_receipt.po_item",
                "goods_receipt.gr_number",
                "goods_receipt.gr_date",
                "goods_receipt.material_number",
                "goods_receipt.vendor_part_number",
                "goods_receipt.mat_desc",
                "goods_receipt.valuation_type",
                "goods_receipt.jumlah",
                "goods_receipt.uom",
                "goods_receipt.currency",
                "goods_receipt.harga_satuan",
                "goods_receipt.tax_code",
                "goods_receipt.ref_doc_no",
                "goods_receipt.delivery_note",
                "draft_ba.status_invoice_proposal"
                )
                ->JOIN("draft_ba","goods_receipt.id_gr", "=", "draft_ba.id_gr")
                ->whereBetween('goods_receipt.gr_date',[$start_date,$end_date])
                ->whereBetween('no_po',[$minpo,$maxpo])
                ->where("draft_ba.id_vendor", "=", $user_vendor)
                ->where('id_inv',0)
                ->where('status_invoice_proposal', 'Verified - BA')
                ->where(function($query) {
                    $query->where('goods_receipt.status','Verified')
                ->orwhere('goods_receipt.status','Auto Verify')
                ->orWhereNull('status');})
                ->orderBy('goods_receipt.updated_at', 'ASC')
                ->get();

            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
                $query->where('status','Verified')
                            ->orWhereNull('status');})->orderBy('gr_date', 'ASC')->get();
            // dd($good_receipts);
        } else {
            
            $start_date = request()->start_date;
            $end_date = request()->end_date;
           

            $user_vendor = Auth::User()->id_vendor;

            $not = good_receipt::select(
                                    "goods_receipt.status",
                                    "goods_receipt.plant_code",
                                    "goods_receipt.no_po",
                                    "goods_receipt.po_item",
                                    "goods_receipt.gr_number",
                                    "goods_receipt.gr_date",
                                    "goods_receipt.material_number",
                                    "goods_receipt.vendor_part_number",
                                    "goods_receipt.mat_desc",
                                    "goods_receipt.valuation_type",
                                    "goods_receipt.jumlah",
                                    "goods_receipt.uom",
                                    "goods_receipt.currency",
                                    "goods_receipt.harga_satuan",
                                    "goods_receipt.tax_code",
                                    "goods_receipt.ref_doc_no",
                                    "goods_receipt.delivery_note",
                                    "draft_ba.status_invoice_proposal"
                                    )
                    ->JOIN("draft_ba","goods_receipt.id_gr", "=", "draft_ba.id_gr")
                    ->where("draft_ba.id_vendor", "=", $user_vendor)
                    ->where('id_inv',0)
                    ->where('status_invoice_proposal', 'Not Yet Verified - Draft BA')
                    ->where(function($query) {
                    $query->where('goods_receipt.status','Verified')
                    ->orwhere('goods_receipt.status','Auto Verify')
                    ->orWhereNull('status');})
                    ->orderBy('goods_receipt.updated_at', 'ASC')
                    ->get();

                    $ver = good_receipt::select(
                    "goods_receipt.status",
                    "goods_receipt.plant_code",
                    "goods_receipt.no_po",
                    "goods_receipt.po_item",
                    "goods_receipt.gr_number",
                    "goods_receipt.gr_date",
                    "goods_receipt.material_number",
                    "goods_receipt.vendor_part_number",
                    "goods_receipt.mat_desc",
                    "goods_receipt.valuation_type",
                    "goods_receipt.jumlah",
                    "goods_receipt.uom",
                    "goods_receipt.currency",
                    "goods_receipt.harga_satuan",
                    "goods_receipt.tax_code",
                    "goods_receipt.ref_doc_no",
                    "goods_receipt.delivery_note",
                    "draft_ba.status_invoice_proposal"
                    )
                    ->JOIN("draft_ba","goods_receipt.id_gr", "=", "draft_ba.id_gr")
                    ->where("draft_ba.id_vendor", "=", $user_vendor)
                    ->where('id_inv',0)
                    ->where('status_invoice_proposal', 'Verified - BA')
                    ->where(function($query) {
                        $query->where('goods_receipt.status','Verified')
                    ->orwhere('goods_receipt.status','Auto Verify')
                    ->orWhereNull('status');})
                    ->orderBy('goods_receipt.updated_at', 'ASC')
                    ->get();
                $good_receipts = good_receipt::where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
                $query->where('status','Verified')
                            ->orWhereNull('status');})->orderBy('updated_at', 'ASC')->get();
        }
        return view('vendor.po.index', compact('good_receipts', 'not', 'ver', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterreject(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();
            
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->where("status","Rejected")->get();
    
        }
        return view('vendor.po.reject',compact('good_receipts', 'start_date', 'end_date'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterdisp(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->Where("id_vendor", $user_vendor)->orderBy('gr_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        }
        return view('vendor.dispute.index',compact('good_receipts', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterhistorydraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->orwhere('status_invoice_proposal', 'Verified - Draft BA')->orderBy('created_at', 'ASC')->get();
           } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $draft = Draft_BA::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - Draft BA')->get();
        }
        return view('Vendor.ba.historydraft',compact('draft', 'start_date', 'end_date'));
    }

    function filterhistoryba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $ba = BA_Reconcile::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->orderBy('created_at', 'ASC')->get();

        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $ba = BA_Reconcile::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->get();
        }
        return view('Vendor.ba.historyba',compact('ba', 'start_date', 'end_date'));
    }
    
    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->orderBy('posting_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            // dd($user_vendor);
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();
        }
        
        return view('vendor.invoice.index', compact('invoice', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterinvba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->orderBy('posting_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            // dd($user_vendor);
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->get();
        }
        
        return view('vendor.invoice.indexba', compact('invoice', 'start_date', 'end_date'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->orderBy('created_at', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->get();
        }
        return view('Vendor.ba.draft',compact('draft','start_date', 'end_date'));
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
             ->orderBy('ba.created_at', 'ASC')
             ->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
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
        
        return view('Vendor.ba.detail',compact('BA', 'start_date', 'end_date'));
    }
}
