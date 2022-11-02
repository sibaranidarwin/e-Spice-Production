<?php

namespace App\Http\Controllers;

use App\BA_Reconcile;
use App\Draft_BA;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use PDF; //library pdf
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VendorController extends Controller
{
    //
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
        return view('admin.vendor.index', compact('users'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function index2()
    {
        $user_vendor = Auth::User()->id_vendor;
        
        $good_receipt = good_receipt::Where("id_vendor", $user_vendor)->count();
        $invoicegr = Invoice::all()->where("data_from", "GR")->count();
        $invoiceba = Invoice::all()->where("data_from", "BA")->count();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();
        $vendor = User::all()->where("level", "vendor")->count();
        $draft = Draft_BA::count();
        $ba = BA_Reconcile::count();

        return view('vendor.dashboard',['good_receipt'=>$good_receipt,'draft'=>$draft, 'ba'=>$ba , 'invoicegr'=>$invoicegr, 'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
    }
    public function po()
    {   
        $user_vendor = Auth::User()->id_vendor;
        //  dd($user_vendor);
        $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->Where("status", "Verified")->get();
        return view('vendor.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function puchaseorderreject()
    {   
        $user_vendor = Auth::User()->id_vendor;
        $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->where("Status", "Reject")->get();
        return view('vendor.po.reject',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function edit(Request $request) {
        switch ($request->input('action')) {
            case 'Dispute':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
                
                $good_receipts = [];
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                }
                return view('vendor.po.dispute', compact('good_receipts'));
                break;
    
            case 'Update':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
        
                $good_receipts = [];
                $total_dpp = 0;
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    $total_dpp += $good_receipt->jumlah_harga * $good_receipt->jumlah;
                    array_push($good_receipts, $good_receipt);
                }

                $total_ppn = $total_dpp * 0.02;
                // kondisi TAX code ma = 11%
                $total_harga = $total_dpp + $total_ppn;
                return view('vendor.po.edit', compact('good_receipts', 'total_dpp', 'total_ppn', 'total_harga'));
                break;

                case 'ba':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
        
                $good_receipts = [];
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                    
                    $draft = Draft_BA::create([
                        'id_gr' =>$good_receipt->id_gr,
                        'no_draft' => $good_receipt->id_vendor,
                        'date_draft' => $good_receipt->GR_Date,
                        'po_number' => $good_receipt->no_po,
                        'material' => $good_receipt->Material_Number,
                        'status_draft' => 'Not Yet Verified - Draft',
                    ]);
                }   
                if($draft){
                    //redirect dengan pesan sukses
                    return redirect('vendor/draft')->with('success','Data Telah berhasil Di Create Menjadi Draft Ba.');
                    }
                    else{
                    //redirect dengan pesan error
                    return redirect('vendor/draft')->with(['error' => 'Data Gagal Di Create Draft Ba!']);
                  }

                break;
    }
    }
    public function editba(Request $request){
        $recordIds = $request->get('ids');
        
        
        $bas = [];
        $total_dpp = 0;
        foreach($recordIds as $record) {
            $ba = BA_Reconcile::find($record);
            $total_dpp += $ba->amount_vendor * $ba->qty;
            array_push($bas, $ba);
        }
        // dd($total_dpp);
        $total_ppn = $total_dpp * 0.02;
        $total_harga = $total_dpp + $total_ppn;
        return view('vendor.po.editba', compact('bas', 'total_dpp', 'total_ppn', 'total_harga'));
    }

     public function update(Request $request)
     {
     
         foreach($request->id as $id) {
             $good_receipt = good_receipt::find($id);
             $good_receipt->update([
                 'Status' => 'Dispute',
                 'alasan_disp' => $request->alasan_disp
             ]);
             $good_receipt->save();
         }
        if($good_receipt){
        //redirect dengan pesan sukses
        return redirect('vendor/purchaseorder')->with('success','Data Telah berhasil Didisputed.');
        }
        else{
        //redirect dengan pesan error
        return redirect('vendor/purchaseorder')->with(['error' => 'Data Gagal Didisputed!']);
      }
     }
    
    public function store(Request $request){
        $from = "GR"; 
        $request->validate([
        'posting_date'  => 'required',
        'vendor_invoice_number'  => 'required',
        'faktur_pajak_number'  => 'required',
        'total_harga_gross' => 'required',
        'del_costs' => 'required',
        'data_from' => '',
        'id_vendor' => '',
    ]);

    $Invoice = Invoice::create($request->all());

    foreach($request->id as $id) {
        $good_receipt = good_receipt::find($id);
        $good_receipt->update([
            'id_inv' => $Invoice->id_inv
        ]);
        $good_receipt->save();
    }

        if($good_receipt){
            //redirect dengan pesan sukses
            return redirect('vendor/invoice')->with('success','Invoice Proposal Telah Berhasil Disimpan.');
        }else{
            //redirect dengan pesan error
            return redirect('vendor/purchaseorder')->with(['error' => 'Data Gagal Disimpan!']);
            }
    }

    public function storeba(Request $request){
        $from = "BA"; 
        $request->validate([
        'posting_date'  => 'required',
        'vendor_invoice_number'  => 'required',
        'faktur_pajak_number'  => 'required',
        'total_harga_gross' => 'required',
        'del_costs' => 'required',
        'data_from' => '',
    ]);

    $Invoice = Invoice::create($request->all());
    
    //  dd($Invoice);
    foreach($request->id as $id) {
        $ba = BA_Reconcile::find($id);
        $ba->update([
            'id_inv' => $Invoice->id_inv
        ]);
        $ba->save();
    }

        if($ba){
            //redirect dengan pesan sukses
            return redirect('vendor/invoiceba')->with('success','Invoice Proposal Telah Berhasil Disimpan.');
        }else{
            //redirect dengan pesan error
            return redirect('vendor/ba')->with(['error' => 'Data Gagal Disimpan!']);
            }
            }
    
    
    public function draft()
        {
        $draft = Draft_BA::all();
        return view('Vendor.ba.draft',compact('draft'));
        }

    public function ba()
    {
        $ba = BA_Reconcile::all();
        
        return view('Vendor.ba.upload',compact('ba'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-vendor-ba');
        Excel::import(new Draft_BAImport, $file);
        
        return back()->with('success', 'BA Imported Successfully');
    }
    
    public function invoice()
    {
        $user_vendor = Auth::User()->id_vendor;
        // dd($user_vendor);
        $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();

         return view('vendor.invoice.index',compact('invoice'))
                 ->with('i',(request()->input('page', 1) -1) *5);
        
    }
    public function detailinvoice(Request $request, $id){
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

        return view('vendor.invoice.detail', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function cetak_pdf($id)
    {
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
                    "goods_receipt.currency",
                    "invoice.id_inv", 
                    "invoice.posting_date", 
                    "invoice.baselinedate",
                    "invoice.vendor_invoice_number",
                    "invoice.faktur_pajak_number",
                    "invoice.total_harga_everify",
                    "invoice.ppn",
                    "invoice.total_harga_gross",
                    "invoice.created_at"
                    )
                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                    ->where("invoice.id_inv", "=", "$detail->id_inv")
                    ->get();
                    
                    $pdf = PDF::loadView('vendor.invoice.print',compact('invoices'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
                    $pdf->save(storage_path().'invoice.pdf');
                    return $pdf->stream();
    }   

    public function invoiceba()
    {
         $invoice = Invoice::latest()->orWhere("data_from", "BA")->get();
         return view('vendor.invoice.indexba',compact('invoice'))
                 ->with('i',(request()->input('page', 1) -1) *5);
        
    }
    public function detailinvoiceba(Request $request, $id){
        $detail = Invoice::find($id);
        // dd($detail->id_inv);
        $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
                                    "ba_reconcile.no_ba",
                                    "ba_reconcile.po_number",
                                    "ba_reconcile.po_mkp",
                                    "ba_reconcile.gr_date",
                                    "ba_reconcile.material_bp",
                                    "ba_reconcile.status_ba",
                                    "invoice.id_inv", 
                                    "invoice.posting_date", 
                                    "invoice.baselinedate",
                                    "invoice.vendor_invoice_number",
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

        return view('vendor.invoice.detailba', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function cetak_pdf_ba($id)
    {
        $detail = Invoice::find($id);
        $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
        "ba_reconcile.no_ba",
        "ba_reconcile.po_number",
        "ba_reconcile.po_mkp",
        "ba_reconcile.gr_date",
        "ba_reconcile.material_bp",
        "ba_reconcile.status_ba",
        "invoice.id_inv", 
        "invoice.posting_date", 
        "invoice.baselinedate",
        "invoice.vendor_invoice_number",
        "invoice.faktur_pajak_number",
        "invoice.total_harga_everify",
        "invoice.ppn",
        "invoice.DEL_COSTS",
        "invoice.total_harga_gross",
        "invoice.created_at"
        )
        ->JOIN("invoice", "ba_reconcile.id_inv", "=", "invoice.id_inv")
        ->where("invoice.id_inv", "=", "$detail->id_inv")
        ->get();
                    
                    $pdf = PDF::loadView('vendor.invoice.printba',compact('invoices'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
                    $pdf->save(storage_path().'invoice.pdf');
                    return $pdf->stream();
    }   

    public function disputed()
    {
        $good_receipts = good_receipt::where("Status", "Dispute")->get();
        return view('vendor.dispute.index',compact('good_receipts'))
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function showing($id){
        $user = \App\User::find($id);
        return view('vendor.user.profile',compact('user'));  
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

        return view('vendor.user.password',compact('user'));  
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