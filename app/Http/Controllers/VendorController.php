<?php

namespace App\Http\Controllers;

use App\Draft_BA;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;
use Maatwebsite\Excel\Facades\Excel;

use PDF; //library pdf
use Auth;
use Illuminate\Http\Request;

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
        $good_receipt = good_receipt::count();
        $invoice = Invoice::count();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();
        $vendor = User::all()->where("level", "vendor")->count();

        return view('vendor.dashboard',['good_receipt'=>$good_receipt, 'invoice'=>$invoice, 'dispute'=>$dispute, 'vendor'=>$vendor]);
    }
    public function po()
    {   
        $good_receipts = good_receipt::where("Status", "Verified")->orWhere("Status", "")->get();
        return view('vendor.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function puchaseorderreject()
    {   
        $good_receipts = good_receipt::where("Status", "Reject")->get();
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
                        'no_draft' => $good_receipt->vendor_id,
                        'date_draft' => $good_receipt->GR_Date,
                        'po_number' => $good_receipt->no_po,
                        'material' => $good_receipt->Material_Number,
                        'status_draft' => 'Not Yet Verified -Draft',
                    ]);
                }

                return view('Vendor.po.ba',compact('draft'));
                break;
    }
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
        $request->validate([
        'posting_date'  => 'required',
        'vendor_invoice_number'  => 'required',
        'faktur_pajak_number'  => 'required',
        'total_harga_gross' => 'required',
        'DEL_COSTS' => 'required'
    ]);

    $Invoice = Invoice::create($request->all());
    // dd($Invoice);
    foreach($request->id as $id) {
        $good_receipt = good_receipt::find($id);
        $good_receipt->update([
            'id_inv' => $Invoice->id_inv
        ]);
        $good_receipt->save();
    }
    // $good_receipt = good_receipt::find($request->id_gr);
    // dd($good_receipt);
    // $good_receipt -> update($Invoice);

        if($good_receipt){
            //redirect dengan pesan sukses
            return redirect('vendor/invoice')->with('success','Invoice Proposal Telah Berhasil Disimpan.');
        }else{
            //redirect dengan pesan error
            return redirect('vendor/purchaseorder')->with(['error' => 'Data Gagal Disimpan!']);
            }
            }
    

    public function ba()
    {
        $draft = Draft_BA::all();
        
        return view('Vendor.ba.upload',compact('draft'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-draft');
        Excel::import(new Draft_BAImport, $file);
        

        return back()->with('success', 'Draft BA Imported Successfully');
    }
    public function invoice()
    {
         $invoice = Invoice::latest()->get();
         return view('vendor.invoice.index',compact('invoice'))
                 ->with('i',(request()->input('page', 1) -1) *5);
        
    }
    public function detailinvoice(Request $request, $id){
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
        return view('vendor.invoice.detail', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
    }

    public function cetak_pdf($id)
    {
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
                    "invoice.total_harga_gross"
                    )
                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                    ->get();
                    
                        $pdf = PDF::loadView('vendor.invoice.print',compact('invoices'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\good_receipt  $good_receipts
     * @return \Illuminate\Http\Response
     */
    public function delete(good_receipt $id_gr){
       
        $good_receipts->delete();
        return back()->with('destroy','PurchaseOrder Berhasil Di Hapus');
    }
    public function showing($id){
        $user = \App\User::find($id);
        return view('vendor.user.profile',compact('user'));  
    }
    
}