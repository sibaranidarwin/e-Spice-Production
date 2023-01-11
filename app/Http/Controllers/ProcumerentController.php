<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Profile;
use App\good_receipt;
use App\BA_Reconcile;
use App\Draft_BA;
use App\Imports\Draft_BAImport;
use App\Invoice;



use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProcumerentController extends Controller 
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
        return view('admin.procumerent.index', compact('users'))
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
    
            return view('procumerent.dashboard',['good_receipt'=>$good_receipt,'draft'=>$draft, 'ba'=>$ba , 'invoicegr'=>$invoicegr, 'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
        }
    }

    public function all()
    { 

        $good_receipts = good_receipt::where("status", "Verified")->orwhere('material_number','LG2KOM00707010F691')->orwhere("status", "Rejected")->get();
        $start_date = null;
        $end_date = null;
        $status = null;
        $vendor = null;
        $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

        $dispute = good_receipt::all()->where("status", "Disputed")->count();

        return view('procumerent.po.all',compact('good_receipts', 'dispute', 'start_date', 'vendor_name', 'end_date', 'status', 'vendor'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function po()
    {   
        $good_receipts = good_receipt::where('material_number', 'LG2KOM00707010F691' )->where("status","Not Verified")->orderBy('gr_date', 'ASC')->get();
        $start_date = null;
        $end_date = null;
        $status = null;
        $vendor = null;
        $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

        $status= null;
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('procumerent.po.index',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function pover(){
        $good_receipts = good_receipt::where("Status","Verified")->get();
        $start_date = null;
        $end_date = null;
        $status = null;
        $vendor = null;
        $vendor_name = good_receipt::select('vendor_name')->distinct()->get();
        
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('procumerent.po.ver',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function poreject(){
        $good_receipts = good_receipt::where("Status","Reject")->get();
        $start_date = null;
        $end_date = null;
        $status = null;
        $vendor = null;
        $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('procumerent.po.reject',compact('good_receipts', 'dispute', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function disputed()
    {
        $good_receipts = good_receipt::where("Status", "Dispute")->get();
        $start_date = null;
        $end_date = null;
        $status = null;
        $vendor = null;
        $vendor_name = good_receipt::select('vendor_name')->distinct()->get();

        return view('procumerent.po.disputed',compact('good_receipts', 'start_date', 'end_date', 'status', 'vendor_name', 'vendor'))
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

    public function invoice(){

        $start_date = null;
        $end_date = null;    
        $invoice = Invoice::latest()->orWhere("data_from", "GR")->get();

        return view('procumerent.invoice.index',compact('invoice', 'start_date', 'end_date'))
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
            return view('procumerent.invoice.detail', compact('invoices', 'dispute'))->with('i',(request()->input('page', 1) -1) *5);
        }
        public function invoiceba()
        {
            $start_date = null;
            $end_date = null;

            $invoice = Invoice::latest()->orWhere("data_from", "BA")->get();
            return view('procumerent.invoice.indexba',compact('invoice', 'start_date', 'end_date'))
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
    
            return view('procumerent.invoice.detailba', compact('invoices','dispute'))->with('i',(request()->input('page', 1) -1) *5);
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masyarakat $user)
    {
        $fotoLama = $request->fotoLama;
            $foto = $request->file('foto');
            if(!empty($foto)){
                $foto = $request->file('foto');
                $namaBaru = Carbon::now()->timestamp . '_' . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('upload/'),$namaBaru);
            }else{
                $foto = $fotoLama;
                $namaBaru = $foto;
            }

               Profile::whereId($user->id)->update([
                "nik"     => $request->nike,
                "name"     => $request->name,
                "telp"     => $request->telp,
                'email'     => $request->email,
                "foto"        => $namaBaru,
                ]);  
       return redirect ('admin/masyarakat')->with('success','Data Has Been Update');
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
                ->with('destroy','1 User Telah Di Hapus.');
    }
   
    public function profile($id){
        $user = \App\User::find($id);
        return view('admin.procumerent.edit',compact('user'));  
    }

    public function showingprocumerent($id){
        $user = \App\User::find($id);
        return view('admin.procumerent.show',compact('user'));  
    }
}
