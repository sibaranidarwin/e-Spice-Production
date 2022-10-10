<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Profile;
use App\good_receipt;

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
       
        return view('warehouse.dashboard');
    }
    public function po()
    {   
        $good_receipts = good_receipt::where("Status","Not Verified")->orWhere("Status"," ")->orWhere("Status","Reject")->get();
        return view('warehouse.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function invoice()
    {
     $invoice = Invoice::latest()->get();
     return view('warehouse.invoice.index',compact('invoice'))
             ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function detailinvoice(Request $request, $id){

        $invoices = Invoice::select("invoice.id", 
                                    "invoice.posting_date", 
                                    "invoice.baselinedate",
                                    "invoice.vendor_invoice_number",
                                    "invoice.faktur_pajak_number",
                                    "invoice.total_harga_everify",
                                    "invoice.ppn",
                                    "invoice.total_harga_gross",
                                    "goods_receipt.id",
                                    "goods_receipt.no_po",
                                    "goods_receipt.po_item",
                                    "goods_receipt.GR_Date",
                                    "goods_receipt.Material_Number",
                                    "goods_receipt.Tax_Code",
                                    "goods_receipt.Status"
                                    )
                                    ->join("goods_receipt", "goods_receipt.id", "=", "invoice.id_gr")
                                    ->get();
        return view('warehouse.invoice.detail', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
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
    public function showing($id){
        $user = \App\User::find($id);
        return view('warehouse.user.profile',compact('user'));  
    }
     public function profile($id){
        $user = \App\Masyarakat::find($id);
        return view('admin.masyarakat.ubah-masyarakat',compact('user'));  
    }
}
