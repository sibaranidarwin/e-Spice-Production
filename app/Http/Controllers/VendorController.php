<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use App\Profile;
use App\good_receipt;
use App\Invoice;


use Auth;
use Illuminate\Support\Facades\Hash;
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
       
        return view('vendor.dashboard');
    }
    public function po()
    {   
        $good_receipts = good_receipt::where("Status", "Verified")->get();
        return view('vendor.po.index',compact('good_receipts'))
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
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                }
                return view('vendor.po.edit', compact('good_receipts'));
                break;
        }
     }
    
    public function store(Request $request){
        
        $arrLen = count($request->id);

        for($i = 0; $i < $arrLen; $i++) {
            $good_receipt = good_receipt::find($request->id[$i]);

            $good_receipt->update([
                'GR_Number' => $request->GR_Number[$i],
                'no_po' => $request->no_po[$i],
                'po_item' => $request->po_item[$i],
                'GR_Date' => $request->GR_Date[$i],
                'Material_Number' => $request->Material_Number[$i],
                'Status' => $request->status[$i]
            ]);
            $good_receipt->save();
        }

       if($good_receipt){
        //redirect dengan pesan sukses
        return redirect('vendor/purchaseorder')->with('success','Data Telah di ubah.');
      }else{
        //redirect dengan pesan error
        return redirect('vendor/purchaseorder')->with(['error' => 'Data Gagal Disimpan!']);
      }
    }

    // public function dispute(Request $request){

    //     $recordIds = $request->get('ids');
    //     dd($recordIds);
    //     $newStatus = $request->get('Status');

    //     $good_receipts = [];
    //     // foreach($recordIds as $record) {
    //     //     $good_receipt = good_receipt::find($record);
    //     //     array_push($good_receipts, $good_receipt);
    //     // }
    //     return view('vendor.po.dispute', compact('good_receipts'));
    // }
    public function invoice(){
         $invoice = Invoice::latest()->get();
         return view('vendor.invoice.index',compact('invoice'))
                 ->with('i',(request()->input('page', 1) -1) *5);
        
    }

    public function detailinvoice(Request $request, $id){
        $invoice = Invoice::where('id', $id)->get();
        
        // $recordIds = $request->get('ids');
        // $newStatus = $request->get('Status');

        // $good_receipts = [];
        // foreach($recordIds as $record) {
        //     $good_receipt = good_receipt::find($record);
        //     array_push($good_receipts, $good_receipt);
        // }
        return view('vendor.invoice.detail', compact('invoice'))->with('i',(request()->input('page', 1) -1) *5);
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
       return redirect ('vendor/masyarakat')->with('success','Data Has Been Update');
    }

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
