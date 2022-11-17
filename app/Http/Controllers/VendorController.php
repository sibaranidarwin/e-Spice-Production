<?php

namespace App\Http\Controllers;

use App\BA_Reconcile;
use App\Draft_BA;
use App\Exports\DraftbaExport;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use PDF; //library pdf
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Drawing;

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
        
        $good_receipt = good_receipt::Where("status", "Verified")->Where("id_vendor", $user_vendor)->count();
        $invoicegr = Invoice::all()->where("data_from", "GR")->Where("id_vendor", $user_vendor)->count();
        $invoiceba = Invoice::all()->where("data_from", "BA")->Where("id_vendor", $user_vendor)->count();
        $dispute = good_receipt::all()->where("status", "Dispute")->Where("id_vendor", $user_vendor)->count();
        $vendor = User::all()->where("level", "vendor")->count();
        $draft = Draft_BA::all()->Where("id_vendor", $user_vendor)->count();
        $ba = BA_Reconcile::all()->Where("id_vendor", $user_vendor)->count();

        return view('vendor.dashboard',['good_receipt'=>$good_receipt,'draft'=>$draft, 'ba'=>$ba , 'invoicegr'=>$invoicegr, 'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
    }
    public function po()
    {   
        $user_vendor = Auth::User()->id_vendor;
        //  dd($user_vendodelr);
        $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->WhereNOTNULL("status")->orWhereNULL("status")->orWhere("status", "Verified")->WhereNULL("id_inv")->get();
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
                
                //buat kode otomatis
                $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));
                $kd="";
                if($q->count()>0)
                {
                    foreach($q->get() as $k)
                    {
                        $tmp = ((int)$k->kode)+1;
                        $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
                    }
                }
                else
                {
                    $kd = date('d-m-Y').'-'."0001";
                }

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
                return view('vendor.po.edit', compact('good_receipts', 'total_dpp', 'total_ppn', 'total_harga','kd'));
                break;

                case 'ba':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
        
                $good_receipts = [];
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                    
                    //buat kode otomatis
                    $q = DB::table('draft_ba')->select(DB::raw('MAX(RIGHT(no_draft, 4)) as kode'));
                    $kd="";
                    if($q->count()>0)
                    {
                        foreach($q->get() as $k)
                        {
                            $tmp = ((int)$k->kode)+1;
                            $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
                        }
                    }
                    else
                    {
                        $kd = date('d-m-Y').'-'."0001";
                    }
                    $draft = Draft_BA::create([
                        'id_gr' =>$good_receipt->id_gr,
                        'id_vendor' => $good_receipt->id_vendor,
                        'no_draft' => "MKP-Draft-". $kd,                        
                        'date_draft' => $good_receipt->gr_date,
                        'po_number' => $good_receipt->no_po,
                        'mat_desc' => $good_receipt->mat_desc,
                        'vendor_part_number' => $good_receipt->vendor_part_number,
                        'doc_header_text' => $good_receipt->doc_header_text,
                        'po_item' => $good_receipt->po_item,
                        'jumlah' => $good_receipt->jumlah,
                        'gr_date' => $good_receipt->gr_date,
                        'jumlah_harga' => $good_receipt->jumlah_harga,
                        'status_draft' => 'Verified',
                        'status_invoice_proposal' => 'Not Yet Verified-Draft',
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
        
        //buat kode otomatis
        $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));

                
        $kd="";
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kode)+1;
                $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = date('d-m-Y').'-'."0001";
        }

        $bas = [];
        $total_dpp = 0;
        foreach($recordIds as $record ) {
            $ba = BA_Reconcile::find($record);
            $ba->update([
                'status_invoice_proposal' => 'Verified',
            ]);
            $ba->save();

            $total_dpp += $ba->amount_mkp * $ba->qty;
            array_push($bas, $ba);
        }
        // dd($ba->id_vendor);
        // dd($total_dpp);
        $total_ppn = $total_dpp * 0.02;
        $total_harga = $total_dpp + $total_ppn;

        return view('vendor.po.editba', compact('bas', 'total_dpp', 'total_ppn', 'total_harga', 'kd'));
    }

     public function update(Request $request)
     {
     
         foreach($request->id as $id) {
             $good_receipt = good_receipt::find($id);
             $good_receipt->update([
                 'status' => 'Dispute',
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
        //buat kode otomatis
        $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));

        $kd="";
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kode)+1;
                $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = date('d-m-Y').'-'."0001";
        }

        $request->validate([
        'posting_date'  => 'required','date','before:now',
        'vendor_invoice_number'  => 'required',
        'no_invoice_proposal' => "required",
        'faktur_pajak_number'  => 'required',
        'total_harga_gross' => 'required',
        'del_costs' => '',
        'data_from' => '',
        'id_vendor' => '',
        'status_invoice_proposal' =>'',
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

        $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));

        $kd="";
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kode)+1;
                $kd = date('d-m-Y').'-'.sprintf("%04s", $tmp);
            }
        }
        else
        {
            $kd = date('d-m-Y').'-'."0001";
        }

        $request->validate([
        'posting_date'  => 'required','date','before:now',
        'vendor_invoice_number'  => 'required',
        'no_invoice_proposal' => "required",
        'faktur_pajak_number'  => 'required',
        'total_harga_gross' => '',
        'del_costs' => '',
        'data_from' => '',
        'id_vendor' => '',
        'status_invoice_proposal' =>'',
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
        $user_vendor = Auth::User()->id_vendor;
        // dd($user_vendor);
        $draft = Draft_BA::all()->where("id_vendor", $user_vendor);
        return view('Vendor.ba.draft',compact('draft'));
        }
    public function historydraft()
        {
        $user_vendor = Auth::User()->id_vendor;
        // dd($user_vendor);
        $draft = Draft_BA::all()->where("id_vendor", $user_vendor);
        return view('Vendor.ba.historydraft',compact('draft'));
        }

    public function ba()
    {
        $user_vendor = Auth::User()->id_vendor;

        $ba = BA_Reconcile::all()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - BA");
        
        return view('Vendor.ba.upload',compact('ba'));
    }
    public function historyba()
    {
        $user_vendor = Auth::User()->id_vendor;

        $ba = BA_Reconcile::all()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Verified");
        
        return view('Vendor.ba.historyba',compact('ba'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-vendor-ba');
        Excel::import(new Draft_BAImport, $file);
        
        return back()->with('success', 'BA Imported Successfully');
    }
    
    public function draftbaexport(){
        return Excel::download(new DraftbaExport,'ba.xlsx');
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
        $user_vendor = Auth::User()->id_vendor;
        // dd($user_vendor);
        $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "BA")->get();
         
        return view('vendor.invoice.indexba',compact('invoice'))
                 ->with('i',(request()->input('page', 1) -1) *5);
        
    }
    public function detailinvoiceba(Request $request, $id){
        $detail = Invoice::find($id);
        // dd($detail->id_inv);
       $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
                                    "ba_reconcile.no_ba",
                                    "ba_reconcile.po_number",
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

        return view('vendor.invoice.detailba', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function cetak_pdf_ba($id)
    {
        $detail = Invoice::find($id);
        $invoices = BA_Reconcile::select("ba_reconcile.id_ba",
        "ba_reconcile.no_ba",
        "ba_reconcile.po_number",
        "ba_reconcile.gr_date",
        "ba_reconcile.material_description",
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
                    
                    $pdf = PDF::loadView('vendor.invoice.printba',compact('invoices'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
                    $pdf->save(storage_path().'invoice.pdf');
                    return $pdf->stream();
    }   

    public function disputed()
    {
        $user_vendor = Auth::User()->id_vendor;
        $good_receipts = good_receipt::where("status", "Dispute")->Where("id_vendor", $user_vendor)->get();

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
        $passwordlama = $request->current_password;
        
    
        $user = User::where("id", $id)->first();
        // dd($user);
        if (password_verify($passwordlama, $user->password)) {
            
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