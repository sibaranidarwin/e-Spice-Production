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
        $good_receipt = good_receipt::count();
        $invoice = Invoice::count();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();
        $vendor = User::all()->where("level", "vendor")->count();

        return view('warehouse.dashboard',['good_receipt'=>$good_receipt, 'invoice'=>$invoice, 'dispute'=>$dispute, 'vendor'=>$vendor]);
    }
    public function po()
    {   
        $good_receipts = good_receipt::where("Status","Not Verified")->orWhere("Status"," ")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('warehouse.po.index',compact('good_receipts', 'dispute'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function pover(){
        $good_receipts = good_receipt::where("Status","Verified")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('warehouse.po.verified',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function poreject(){
        $good_receipts = good_receipt::where("Status","Reject")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('warehouse.po.reject',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function invoice()
    {
     $invoice = Invoice::latest()->get();
     $dispute = good_receipt::all()->where("Status", "Dispute")->count();

     return view('warehouse.invoice.index',compact('invoice','dispute'))
             ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function detailinvoice(Request $request, $id){
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();
        $invoices = good_receipt::select("goods_receipt.id_gr",
                                    "goods_receipt.no_po",
                                    "goods_receipt.GR_Number",
                                    "goods_receipt.po_item",
                                    "goods_receipt.GR_Date",
                                    "goods_receipt.Material_Number",
                                    "goods_receipt.harga_satuan",
                                    "goods_receipt.jumlah",
                                    "goods_receipt.Tax_Code",
                                    "goods_receipt.Status",
                                    "invoice.id_inv", 
                                    "invoice.posting_date", 
                                    "invoice.baselinedate",
                                    "invoice.vendor_invoice_number",
                                    "invoice.faktur_pajak_number",
                                    "invoice.total_harga_everify",
                                    "invoice.ppn",
                                    "invoice.DEL_COSTS",
                                    "invoice.total_harga_gross"
                                    )
                                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                                    ->get();
        return view('warehouse.invoice.detail', compact('invoices', 'dispute'))->with('i',(request()->input('page', 1) -1) *5);
    }
    public function disputed()
    {
        $good_receipts = good_receipt::where("Status", "Dispute")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('warehouse.dispute.index',compact('good_receipts', 'dispute'))
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
