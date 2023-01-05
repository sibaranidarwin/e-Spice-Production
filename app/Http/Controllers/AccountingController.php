<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BA_Reconcile;
use App\Draft_BA;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;


use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AccountingController extends Controller
{
    // //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::first()->paginate(10);
        return view('admin.accounting.index', compact('users'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function index2()
    {
        {
            $good_receipt = good_receipt::count();
            $invoicegr = Invoice::all()->where("data_from", "GR")->count();
            $invoiceba = Invoice::all()->where("data_from", "BA")->count();
            $dispute = good_receipt::all()->where("Status", "Dispute")->count();
            $vendor = User::all()->where("level", "vendor")->count();
            $draft = Draft_BA::count();
            $ba = BA_Reconcile::count();
    
            return view('accounting.dashboard',['good_receipt'=>$good_receipt,'draft'=>$draft, 'ba'=>$ba , 'invoicegr'=>$invoicegr, 'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
        }
    }
    public function all()
    { 

        $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
        $start_date = null;
        $end_date = null;
        $status= null;
        $dispute = good_receipt::all()->where("status", "Disputed")->count();

        return view('accounting.po.all',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function po()
    {   
        $good_receipts = good_receipt::where('material_number', 'LG2KOM00707010F691' )->WhereNull('status')->get();
        $start_date = null;
        $end_date = null;
        $vendor_name = good_receipt::get();

        $status= null;
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.index',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function pover(){
        $good_receipts = good_receipt::where("Status","Verified")->get();
        $start_date = null;
        $end_date = null;
        $status= null;
        
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.verified',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function poreject(){
        $good_receipts = good_receipt::where("Status","Reject")->get();
        $start_date = null;
        $end_date = null;
        $status= null;
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.reject',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function draft()
    {
    $draft = Draft_BA::all();
    return view('accounting.ba.draft',compact('draft'));
    }


    public function ba()
    {
        $ba = BA_Reconcile::all();
        
        return view('accounting.ba.upload',compact('ba'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-vendor-ba');
        Excel::import(new Draft_BAImport, $file);
        
        return back()->with('success', 'BA Imported Successfully');
    }
    public function disputed()
    {
        $good_receipts = good_receipt::where("Status", "Dispute")->get();
        return view('accounting.dispute.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function invoice(){

        $start_date = null;
        $end_date = null;    
        $invoice = Invoice::latest()->orWhere("data_from", "GR")->get();

        return view('accounting.invoice.index',compact('invoice', 'start_date', 'end_date'))
                ->with('i',(request()->input('page', 1) -1) *5);
   }
   public function detailinvoice(Request $request, $id){
    $dispute = good_receipt::all()->where("status", "Dispute")->count();
    $detail = Invoice::find($id);
    $invoices = good_receipt::select("goods_receipt.id_gr",
                                        "goods_receipt.no_po",
                                        "goods_receipt.gr_number",
                                        "goods_receipt.po_item",
                                        "goods_receipt.gr_date",
                                        "goods_receipt.material_number",
                                        "goods_receipt.harga_satuan",
                                        "goods_receipt.jumlah",
                                        "goods_receipt.uom",
                                        "goods_receipt.currency",
                                        "goods_receipt.tax_code",
                                        "goods_receipt.mat_desc",
                                        "goods_receipt.status",
                                        "goods_receipt.valuation_type",
                                        "invoice.id_inv", 
                                        "invoice.posting_date", 
                                        "invoice.baselinedate",
                                        "invoice.no_invoice_proposal",
                                        "invoice.vendor_invoice_number",
                                        "invoice.faktur_pajak_number",
                                        "invoice.total_harga_everify",
                                        "invoice.ppn",
                                        "invoice.total_doc_invoice",
                                        "invoice.unplan_cost",
                                        "invoice.del_costs",
                                        "invoice.total_harga_gross",
                                        "invoice.created_at"
                                    )
                                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                                    ->where("invoice.id_inv", "=", "$detail->id_inv")
                                    ->get();
            return view('accounting.invoice.detail', compact('invoices', 'dispute'))->with('i',(request()->input('page', 1) -1) *5);
        }
        public function invoiceba()
        {
            $start_date = null;
            $end_date = null;

            $invoice = Invoice::latest()->orWhere("data_from", "BA")->get();
            return view('accounting.invoice.indexba',compact('invoice', 'start_date', 'end_date'))
                    ->with('i',(request()->input('page', 1) -1) *5);
            
        }
        public function detailinvoiceba(Request $request, $id){
            $detail = Invoice::find($id);
            $dispute = good_receipt::all()->where("Status", "Dispute")->count();
    
            // dd($detail->id_inv);
                $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
                            "ba_reconcile.no_ba",
                            "ba_reconcile.po_number",
                            "ba_reconcile.gr_number",
                            "ba_reconcile.material_number",
                            "ba_reconcile.vendor_part_number",
                            "ba_reconcile.item",
                            "ba_reconcile.gr_date",
                            "ba_reconcile.harga_satuan",
                            "ba_reconcile.qty",
                            "ba_reconcile.currency",
                            "ba_reconcile.valuation_type",
                            "ba_reconcile.uom",
                            "ba_reconcile.tax_code",
                            "ba_reconcile.material_description",
                            "ba_reconcile.status_ba",
                            "invoice.id_inv", 
                            "invoice.posting_date", 
                            "invoice.baselinedate",
                            "invoice.vendor_invoice_number",
                            "invoice.no_invoice_proposal",
                            "invoice.faktur_pajak_number",
                            "invoice.total_harga_everify",
                            "invoice.ppn",
                            "invoice.total_doc_invoice",
                            "invoice.del_costs",
                            "invoice.total_harga_gross",
                            "invoice.created_at"
                            )
                                        ->JOIN("invoice", "ba_reconcile.id_inv", "=", "invoice.id_inv")
                                        ->where("invoice.id_inv", "=", "$detail->id_inv")
                                        ->get();
    
            return view('accounting.invoice.detailba', compact('invoices','dispute'))->with('i',(request()->input('page', 1) -1) *5);
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()
                ->with('destroy','1 User Has Been Deleted!');
    }

    public function profile($id){
        $user = \App\User::find($id);
        return view('admin.vendor.edit',compact('user'));  
    }

    public function showingaccounting($id){
        $user = \App\User::find($id);
        return view('admin.accounting.show',compact('user'));  
    }
}
