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
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Carbon\Carbon;

class FilterController extends Controller
{
    //
    function filterdash(){
        if (request()->month || request()->yer){
                $user_vendor2 = Auth::User()->name;
                $user_vendor = Auth::User()->id_vendor;
                $a = date('Y-m-d');
                $b = date('Y-m-d',strtotime('+1 days'));
                $range = [$a, $b];
                $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();

                $draft = Draft_BA::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->Where("id_vendor", $user_vendor)->count();
                $ba = BA_Reconcile::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->Where("id_vendor", $user_vendor)->count();
                $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
                $month = 1;
                $date = \Carbon\Carbon::parse($year."-".$month."-01"); // universal truth month's first day is 1
                $start = $date->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
                $end = $date->endOfMonth()->format('Y-m-d H:i:s');
                $invgr =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "GR")->sum('total_harga_everify');
                $invba =Invoice::whereBetween('created_at', [$start, $end])->where("data_from", "BA")->sum('total_harga_everify');
                // dd($invgr);
                $month = request()->input('month');
                $yer = request()->input('yer');
            
                $year = CarbonImmutable::now()->locale('id_ID')->format('Y');
                $invthngr =Invoice::whereYear('created_at', $year)->where("data_from", "GR")->sum('total_harga_everify');
                $invthnba =Invoice::whereYear('created_at', $year)->where("data_from", "BA")->sum('total_harga_everify');
                $invoicegr = Invoice::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where("data_from", "GR")->Where("id_vendor", $user_vendor)->count();
                $invoiceba = Invoice::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where("data_from", "BA")->Where("id_vendor", $user_vendor)->count();
                
                $good_receipt = good_receipt::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where('id_vendor', $user_vendor)->where('id_inv',0)->orwhere('status','Auto Verify')->where('status','Verified')->orWhereNull('status')->count();

                $dispute = good_receipt::whereMonth('created_at', $month = request()->input('month'))->whereYear('created_at', $yer = request()->input('yer'))->where("status", "Disputed")->Where("vendor_name", $user_vendor)->count();
               
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

                $notif = good_receipt::all()->where("status", "Disputed")->whereBetween('updated_at', $range)->count();
        
            }
            return view('vendor.dashboard',compact('month','yer','good_receipt', 'notif', 'draft', 'ba', 'invgr', 'invba', 'invoicegr', 'invoiceba', 'dispute', 'invthngr', 'invthnba'))
            ->with('i',(request()->input('page', 1) -1) *5);
        }
    
    function filter(Request $request){
          if (request()->start_date || request()->end_date || $request['minpo'] || $request['maxpo'])  {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $minpo = request()->minpo;
            $maxpo = request()->maxpo;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            
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
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();

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
        return view('vendor.po.index', compact('good_receipts', 'not', 'ver', 'start_date', 'end_date', 'notif'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterreject(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status","Rejected")->orderBy('gr_date', 'ASC')->get();
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->where("status","Rejected")->get();
    
        }
        return view('vendor.po.reject',compact('good_receipts', 'start_date', 'end_date', 'notif'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterdisp(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where("status", "Disputed")->Where("id_vendor", $user_vendor)->orderBy('gr_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();
        }
        return view('vendor.dispute.index',compact('good_receipts', 'start_date', 'end_date', 'notif'))->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterhistorydraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $draft = Draft_BA::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->orwhere('status_invoice_proposal', 'Verified - Draft BA')->orderBy('created_at', 'ASC')->get();
           } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $draft = Draft_BA::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - Draft BA')->get();
        }
        return view('Vendor.ba.historydraft',compact('draft', 'start_date', 'end_date', 'notif'));
    }

    function filterhistoryba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $ba = BA_Reconcile::whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->orderBy('created_at', 'ASC')->get();

        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $ba = BA_Reconcile::where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA')->get();
        }
        return view('Vendor.ba.historyba',compact('ba', 'start_date', 'end_date', 'notif'));
    }
    
    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->orderBy('posting_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();
        }
        
        return view('vendor.invoice.index', compact('invoice', 'start_date', 'end_date', 'notif'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterinvba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->orderBy('posting_date', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->get();
        }
        
        return view('vendor.invoice.indexba', compact('invoice', 'start_date', 'end_date','notif'))->with('i',(request()->input('page', 1) -1) *5);
    }
    function filterdraft(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->whereBetween('created_at',[$start_date,$end_date])->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->orderBy('created_at', 'ASC')->get();
        } else {
            $user_vendor = Auth::User()->id_vendor;
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
            $draft = Draft_BA::select('no_draft','status_invoice_proposal', 'created_at')->distinct()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->get();
        }
        return view('Vendor.ba.draft',compact('draft','start_date', 'end_date', 'notif'));
    }
    function filterba(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
           
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
            $name = Auth::User()->name;
            $a = date('Y-m-d');
            $b = date('Y-m-d',strtotime('+1 days'));
            $range = [$a, $b];

            $notif = good_receipt::all()->where("status", "Disputed")->Where("vendor_name", $name)->whereBetween('updated_at', $range)->count();
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
        
        return view('Vendor.ba.detail',compact('BA', 'start_date', 'end_date', 'notif'));
    }
}
