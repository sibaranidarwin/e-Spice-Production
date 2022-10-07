<?php

namespace App\Http\Controllers;

use App\good_receipt;
use Illuminate\Http\Request;

class PoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {   
        $good_receipts = good_receipt::latest()->get();
        return view('admin.po.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }

 
    public function edit(Request $request) {
        $recordIds = $request->get('ids');
        $newStatus = $request->get('Status');

        $good_receipts = [];
        foreach($recordIds as $record) {
            $good_receipt = good_receipt::find($record);
            array_push($good_receipts, $good_receipt);
        }
        return view('warehouse.po.edit', compact('good_receipts'));
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
        return redirect('warehouse/po')->with('success','Data Telah di ubah.');
      }else{
        //redirect dengan pesan error
        return redirect('warehouse/po')->with(['error' => 'Data Gagal Disimpan!']);
      }
    }
    public function disputed()
    {
        return view('admin.po.disputed');
    }
}
