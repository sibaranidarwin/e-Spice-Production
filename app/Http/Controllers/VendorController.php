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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use PDF; //library pdf
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use thiagoalessio\TesseractOCR\TesseractOCR;
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
        
        $good_receipt = good_receipt::where('id_vendor', $user_vendor)->where(function($query) {
			$query->where('status','Verified')
            ->orWhereNull('status');})->count();
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


        $good_receipts = good_receipt::where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
			$query->where('status','Verified')
						->orWhereNull('status');})->orderBy('updated_at', 'ASC')->get();


        return view('vendor.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
public function puchaseorderreject()
    {   
        $user_vendor = Auth::User()->id_vendor;
        $good_receipts = good_receipt::Where("id_vendor", $user_vendor)->where("Status", "Rejected")->get();
        return view('vendor.po.reject',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }

    function filter(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $good_receipts = good_receipt::whereBetween('gr_date',[$start_date,$end_date])->where('id_vendor', $user_vendor)->where('id_inv',0)->where(function($query) {
                $query->where('status','Verified')
                            ->orWhereNull('status');})->orderBy('updated_at', 'ASC')->get();
        } else {
            $good_receipts = good_receipt::latest()->get();
        }
        
        return view('vendor.po.index', compact('good_receipts'))->with('i',(request()->input('page', 1) -1) *5);
    }

    function filterinv(){
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $user_vendor = Auth::User()->id_vendor;
            $invoice = Invoice::whereBetween('posting_date',[$start_date,$end_date])->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();
        } else {
            $invoice = Invoice::latest()->get();
        }
        
        return view('vendor.invoice.index', compact('invoice'))->with('i',(request()->input('page', 1) -1) *5);
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
                
                // dd($recordIds);
                //buat kode otomatis
                $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));
                $kd="";
                if($q->count()>0)
                {
                    foreach($q->get() as $k)
                    {
                        $tmp = ((int)$k->kode)+1;
                        $kd = sprintf("%04s", $tmp);
                    }
                }
                else
                {
                    $kd = "0001";
                }
                $array_bln    = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
                $bln      = $array_bln[date('n')];

                // $tax = good_receipt::where('tax_code', 'M2')->get();
                //  dd($tax);
                $good_receipts = [];
                $total_dpp = 0;
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    $total_dpp += $good_receipt->jumlah_harga * $good_receipt->jumlah;
                    array_push($good_receipts, $good_receipt);
                }
                
                if (good_receipt::where('tax_code', 'M1')){
                $total_ppn = $total_dpp * 0.01;
                }
                elseif (good_receipt::where('tax_code', 'M2')){
                $total_ppn = $total_dpp * 0.02;
                }
                elseif (good_receipt::where('tax_code', 'M3')){
                $total_ppn = $total_dpp * 0.03;
                }
                elseif (good_receipt::where('tax_code', 'M4')){
                $total_ppn = $total_dpp * 0.04;
                }
                elseif (good_receipt::where('tax_code', 'M5')){
                $total_ppn = $total_dpp * 0.05;
                }
                elseif (good_receipt::where('tax_code', 'M6')){
                    $total_ppn = $total_dpp * 0.06;
                    }
                else{
                $tota_ppn = $total_dpp * 0.07;
                }

                // kondisi TAX code ma = 11%
                $total_harga = $total_dpp + $total_ppn;
                return view('vendor.po.edit', compact('good_receipts', 'total_dpp', 'total_ppn', 'total_harga','kd','bln'));
                break;

                case 'ba':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
                
                
                $good_receipts = [];
                $q = DB::table('draft_ba')->select(DB::raw('MAX(RIGHT(no_draft, 4)) as kode'))->get();
                $last_draft = $q[0]->kode;

                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);

                        $kd="";
                        $tmp = ((int)$last_draft)+1;
                        $kd = sprintf("%04s", $tmp);

                    $array_bln    = array(1=>"I","II","III", "IV" , "V","VI","VII","VIII","IX","X", "XI","XII");
                    $bln      = $array_bln[date('n')];
                   
                    $draft = Draft_BA::create([
                        'id_gr' =>$good_receipt->id_gr, 
                        'id_vendor' => $good_receipt->id_vendor,
                        'no_draft' => date('Y')."-".$bln."-MKP-Draft BA-".$kd,                         
                        'date_draft' => $good_receipt->gr_date,
                        'po_number' => $good_receipt->no_po,
                        'gr_number' => $good_receipt->gr_number,
                        'po_item' => $good_receipt->po_item,
                        'mat_desc' => $good_receipt->mat_desc,
                        'material_number' => $good_receipt->material_number,
                        'ref_doc_no' => $good_receipt->ref_doc_no,
                        'vendor_part_number' => $good_receipt->vendor_part_number,
                        'valuation_type' =>$good_receipt->valuation_type,
                        'doc_header_text' => $good_receipt->doc_header_text,
                        'jumlah' => $good_receipt->jumlah,
                        'uom' => $good_receipt->uom,
                        'currency' => $good_receipt->currency,
                        'gr_date' => $good_receipt->gr_date,
                        'tax_code' =>  $good_receipt->tax_code,
                        'delivery_note' =>  $good_receipt->delivery_note,
                        'harga_satuan' => $good_receipt->harga_satuan,
                        'jumlah_harga' => $good_receipt->total_harga,
                        'status_invoice_proposal' => 'Not Yet Verified - Draft BA',
                    ]);

                    $good_receipts = [];
                    foreach($recordIds as $record) {
                        $good_receipt = good_receipt::find($record);
                        $good_receipt->update([
                            'status_invoice' => $draft->status_invoice_proposal
                        ]);
                        $good_receipt->save();
                    }
                   }
                
                   if($good_receipt){
                    //redirect dengan pesan sukses
                    return redirect('vendor/draft')->with('success','Data Has Been Successfully Created Into Draft Ba!');
                    }
                    else{
                    //redirect dengan pesan error
                    return redirect('vendor/draft')->with(['error' => 'Data Failed to Create Draft Ba!']);
                  }
                break;
                 }
                }

    public function editba(Request $request){
        $recordIds = $request->get('ids');
        // dd($recordIds);
        //buat kode otomatis
        $q = DB::table('invoice')->select(DB::raw('MAX(RIGHT(no_invoice_proposal, 4)) as kode'));

                
        $kd="";
        if($q->count()>0)
                {
                    foreach($q->get() as $k)
                    {
                        $tmp = ((int)$k->kode)+1;
                        $kd = sprintf("%04s", $tmp);
                    }
                }
                else
                {
                    $kd = "0001";
                }

                $array_bln    = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
                $bln      = $array_bln[date('n')];

        $bas = [];
        $total_dpp = 0;
        foreach($recordIds as $record ) {
            $ba = BA_Reconcile::find($record);
            $ba->update([
                'status_invoice_proposal' => 'Verified - BA',
            ]);
            $ba->save();


            $total_dpp += $ba->harga_satuan * $ba->qty;
            array_push($bas, $ba);
        }
        // dd($ba->id_vendor);
        // dd($total_dpp);
        $total_ppn = $total_dpp * 0.02;
        $total_harga = $total_dpp + $total_ppn;

        return view('vendor.po.editba', compact('bas', 'total_dpp', 'total_ppn', 'total_harga', 'kd', 'bln'));
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
        return redirect('vendor/purchaseorder')->with('success','Data has been successfully Disputed!');
        }
        else{
        //redirect dengan pesan error
        return redirect('vendor/purchaseorder')->with(['error' => 'Data Failed to Disputed!']);
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
            return redirect('vendor/invoice')->with('success','Proposal Invoice Has Been Saved Successfully!');
        }else{
            //redirect dengan pesan error
            return redirect('vendor/purchaseorder')->with(['error' => 'Data Failed to Save!']);
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
            return redirect('vendor/invoiceba')->with('success','Proposal Invoice Has Been Saved Successfully!');
        }else{
            //redirect dengan pesan error
            return redirect('vendor/ba')->with(['error' => 'Data Failed to Save!']);
            }
            }
    
    
    public function draft()
        {
        $user_vendor = Auth::User()->id_vendor;
        $duration = 10;
        $now = date('Y-m-d H:i:s', strtotime("+$duration sec"));
        // dd($now);
        //   $ba = BA::select('no_ba','status_ba','status_invoice_proposal')->distinct()->where("id_vendor", $user_vendor)->get(); 
        // dd($user_vendor);
        $draft = Draft_BA::select('no_draft','status_invoice_proposal')->distinct()->where("id_vendor", $user_vendor)->where("status_invoice_proposal", "Not Yet Verified - Draft BA")->get();
        // $total_price= Draft_BA::all()->jumlah_harga->get();
        //  dd($total_price);
        // $total = $total_price * 2;
        // $total = Draft_BA::all()->select('sum(jumlah_harga*jumlah) as total');
        // dd($total);
        return view('Vendor.ba.draft',compact('draft'));
        }

    public function detaildraft($no_draft)
        {
        $user_vendor = Auth::User()->id_vendor;

        $draft = Draft_BA::where("no_draft", $no_draft)->get();
        // dd($draft);
        return view('Vendor.ba.detaildraft',compact('draft'));
        }

    public function historydraft()
        {
        $now = date('Y-m-d');
        // dd($now);
        $user_vendor = Auth::User()->id_vendor;
        // dd($user_vendor);
        $draft = Draft_BA::all()->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - Draft BA');
        // dd($draft);
        return view('Vendor.ba.historydraft',compact('draft'));
        }

    public function detailba()
        {
            $user_vendor = Auth::User()->id_vendor;
            //   $ba = BA::select('no_ba','status_ba','status_invoice_proposal')->distinct()->where("id_vendor", $user_vendor)->get(); 

             $BA = Ba::select("ba.no_ba",
             "ba.status_ba",
             "ba_reconcile.status_invoice_proposal",
             )
             ->distinct()
             ->JOIN("ba_reconcile","ba.no_ba", "=", "ba_reconcile.no_ba")
             ->where("ba.id_vendor", "=", $user_vendor)
             ->where("ba_reconcile.status_invoice_proposal", "=", "Not Yet Verified - BA")
             ->get();
            //  dd($BA);

            return view('Vendor.ba.detail',compact('BA'));
        }

    public function ba($no_ba)
    {
        $user_vendor = Auth::User()->id_vendor;
        $ba = BA_Reconcile::where("no_ba", $no_ba)->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Not Yet Verified - BA')->get();
        
        return view('Vendor.ba.upload',compact('ba'));
    }
    public function historyba()
    {
        $user_vendor = Auth::User()->id_vendor;

        $ba = BA_Reconcile::all()->where("id_vendor", $user_vendor)->where('status_invoice_proposal', 'Verified - BA');
        
        return view('Vendor.ba.historyba',compact('ba'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-vendor-ba');
        Excel::import(new Draft_BAImport, $file);
        
        return back()->with('success', 'BA Imported Successfully');
    }

    public function draftbaexport(Request $request){
        $recordIds = $request->get('ids');
        // dd($recordIds);
        foreach($recordIds as $id) {
            $drafts = Draft_BA::find($id);
            $drafts->update([
                'status_invoice_proposal' => 'Verified - Draft BA',
                // 'status_draft' => 'Verified - Draft BA'
            ]);
            }
            
            $drafts->save();

            $user_vendor = Auth::User()->id_vendor;

            $draft = Draft_BA::all()->where("id_vendor", $user_vendor);
            //  dd($draft);
        // return view('vendor.ba.export', compact('draft'));
        return Excel::download(new DraftbaExport,'ba.xlsx');
        return view('vendor.ba.detaildraft', compact('draft'));
        // return Excel::download(new DraftbaExport,'ba.xlsx');
    }
    
    public function export(){

        return Excel::download(new DraftbaExport,'ba.xlsx');
   }

   public function uploadinv()
   {
       $user_vendor = Auth::User()->id_vendor;
       // dd($user_vendor);
       $invoice = Invoice::latest()->Where("id_vendor", $user_vendor)->Where("data_from", "GR")->get();

        return view('vendor.ocr.uploadinv',compact('invoice'))
                ->with('i',(request()->input('page', 1) -1) *5);
       
   }

   public function upload(Request $request){

    $image = $request->file('image');
    $filename= date('YmdHi').$image->getClientOriginalName();
    $image-> move(public_path('images'), $filename);
    
    $ocr = new TesseractOCR(public_path("images/$filename"));
    $ocr->lang('eng');
    $text = $ocr->run();

    return redirect()->back()->with('text',$text);
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
                                    "goods_receipt.uom",
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
                    "goods_receipt.mat_desc",
                    "goods_receipt.valuation_type",
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
                                    "ba_reconcile.gr_number",
                                    "ba_reconcile.material_number",
                                    "ba_reconcile.vendor_part_number",
                                    "ba_reconcile.item",
                                    "ba_reconcile.gr_date",
                                    "ba_reconcile.harga_satuan",
                                    "ba_reconcile.qty",
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
        "ba_reconcile.item",
        "ba_reconcile.gr_date",
        "ba_reconcile.tax_code",
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
        $good_receipts = good_receipt::where("status", "Disputed")->Where("id_vendor", $user_vendor)->get();

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
                 
                return redirect()->back()->with("success","Password Changed Successfully!");
        
        }
        
        else{
            // The passwords matches
        return redirect()->back()->with("error","The entered password does not match. Try again!");

        }
    }
}