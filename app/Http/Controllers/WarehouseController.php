<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Profile;
use App\BA_Reconcile;
use App\Draft_BA;
use App\good_receipt;
use DB;

use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class WarehouseController extends Controller
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
        return view('admin.warehouse.index', compact('users'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function index2()
    {
        $good_receipt = good_receipt::count();
        $invoice = Invoice::all()->where("data_from", "GR")->count();
        $invoiceba = Invoice::all()->where("data_from", "BA")->count();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();
        $vendor = User::all()->where("level", "vendor")->count();
        $draft = Draft_BA::count();
        $ba = BA_Reconcile::count();
        return view('warehouse.dashboard',['good_receipt'=>$good_receipt, 'invoice'=>$invoice,'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
    }
    
    public function all()
    { 

        $good_receipts = good_receipt::all();
        
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.po.all',compact('good_receipts', 'dispute'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function po(Request $request, good_receipt $id_gr)
    {   
        $good_receipts = good_receipt::where('material_number','LG2KOM00707010F691')->get();
        //  dd($good_receipts);
        //$good_receipts = good_receipt::where("status","Not Verified")->get();

        
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.po.index',compact('good_receipts', 'dispute'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function pover(){
        $good_receipts = good_receipt::where("status","Verified")->get();
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.po.verified',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function poreject(){
        $good_receipts = good_receipt::where("status","Reject")->get();
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.po.reject',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function invoice()
    {
     $invoice = Invoice::latest()->orWhere("data_from", "GR")->get();
     $dispute = good_receipt::all()->where("status", "Dispute")->count();

     return view('warehouse.invoice.index',compact('invoice','dispute'))
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
                                    "goods_receipt.tax_code",
                                    "goods_receipt.status",
                                    "invoice.id_inv", 
                                    "invoice.posting_date", 
                                    "invoice.baselinedate",
                                    "invoice.no_invoice_proposal",
                                    "invoice.vendor_invoice_number",
                                    "invoice.faktur_pajak_number",
                                    "invoice.total_harga_everify",
                                    "invoice.ppn",
                                    "invoice.del_costs",
                                    "invoice.total_harga_gross",
                                    "invoice.created_at"
                                    )
                                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                                    ->where("invoice.id_inv", "=", "$detail->id_inv")
                                    ->get();
        return view('warehouse.invoice.detail', compact('invoices', 'dispute'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function invoiceba()
    {
     $invoice = Invoice::latest()->orWhere("data_from", "BA")->get();
     $dispute = good_receipt::all()->where("Status", "Dispute")->count();

     return view('warehouse.invoice.indexba',compact('invoice','dispute'))
             ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function detailinvoiceba(Request $request, $id){
        $detail = Invoice::find($id);
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        // dd($detail->id_inv);
     $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
                                    "ba_reconcile.no_ba",
                                    "ba_reconcile.po_number",
                                    "ba_reconcile.item",
                                    "ba_reconcile.gr_date",
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
                                    "invoice.del_costs",
                                    "invoice.total_harga_gross",
                                    "invoice.created_at"
                                    )
                                    ->JOIN("invoice", "ba_reconcile.id_inv", "=", "invoice.id_inv")
                                    ->where("invoice.id_inv", "=", "$detail->id_inv")
                                    ->get();

        return view('warehouse.invoice.detailba', compact('invoices','dispute'))->with('i',(request()->input('page', 1) -1) *5);
    }
    public function disputed()
    {
        $good_receipts = good_receipt::where("status", "Dispute")->get();
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.dispute.index',compact('good_receipts', 'dispute'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function showing($id){
        $user = \App\User::find($id);
        $dispute = good_receipt::all()->where("status", "Dispute")->count();

        return view('warehouse.user.profile',compact('user', 'dispute'));  
    }

    public function heyupdate(Request $request, User $user)
    {
  
            $fotoLama = $request->fotoLama;
            $foto = $request->file('foto');
            if(!empty($foto)){
                $foto = $request->file('foto');
                $namaBaru = Carbon::now()->timestamp . '_' . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('upload/'),$namaBaru);
            }
            else{
                $foto = $fotoLama;
                $namaBaru = $foto;
            }
               User::whereId(auth()->user()->id)->update([
                "name"     => $request->name,
                'email'     => $request->email,
                "foto"        => $namaBaru,
                ]);  
        return back()->with('success','Data Telah di ubah.');
    }
    public function show($id){
        $user = \App\User::find($id);
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('warehouse.user.password',compact('user', 'dispute'));  
    }
    public function editpass(Request $request, $id){
        $password1 = $request->current_password;
        
        $user = User::where("id", $id)->first();
        // dd($user);
        if (password_verify($password1, $user->password)) {
            
                //Change Password
                $user =  User::whereId(auth()->user()->id)->update([
                
                    
                    'password' => Hash::make($request->get('new_password'))
                    
                ]);
                 
                return redirect()->back()->with("success","Kata Sandi Berhasil Di Ubah !");
        
        }
        
        else{
            // The passwords matches
        return redirect()->back()->with("error","Kata Sandi yang dimasukkan tidak sesuai. Coba Lagi.");

        }
    }
}