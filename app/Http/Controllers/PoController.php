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
    
    public function update(Request $request)
     {
         foreach($request->id as $id) {
             $good_receipt = good_receipt::find($id);
             $good_receipt->update([
                 'Status' => $request->Status,
             ]);
             $good_receipt->save();
         }
        if($good_receipt){
        //redirect dengan pesan sukses
        return redirect('warehouse/po')->with('success','Data Telah berhasil Diupdate.');
        }
        else{
        //redirect dengan pesan error
        return redirect('warehouse/po')->with(['error' => 'Data Gagal Diupdate!']);
      }
     }

    public function disputed()
    {
        return view('admin.po.disputed');
    }
}