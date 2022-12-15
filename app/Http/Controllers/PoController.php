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
  
    public function edit(Request $request) {
        switch ($request->input('action')) {
            case 'Upload':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
                $dispute = good_receipt::all()->where("Status", "Dispute")->count();

                
                $good_receipts = [];
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                }
                return view('warehouse.po.upload', compact('good_receipts', 'dispute'));
                break;
    
            case 'Update':
                $recordIds = $request->get('ids');
                $newStatus = $request->get('Status');
                $dispute = good_receipt::all()->where("Status", "Dispute")->count();

                $good_receipts = [];
                foreach($recordIds as $record) {
                    $good_receipt = good_receipt::find($record);
                    array_push($good_receipts, $good_receipt);
                }
                return view('warehouse.po.edit', compact('good_receipts','dispute'));
                break;
        }
     }
    public function update(Request $request)
     {
        $arrName = [];
        if ($request->hasFile("lampiran")) {

            $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
            $files = $request->file('lampiran');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, $allowedfileExtension)) {
                    $str = rand();
                    $result = md5($str);
                    $filename = pathinfo($extension, PATHINFO_FILENAME);
                    $name = time() . "-" . $result . '.' . $extension;
                    $file->move(public_path() . '/lampiran/spb/', $name);
                    array_push($arrName, '/lampiran/spb/' . $name);
                }
            }
        }
        $fileName = join("#", $arrName);

         foreach($request->id as $id) {
             $good_receipt = good_receipt::find($id);
             $good_receipt->update([
                 'status' => $request->status,
                 'lampiran' => $fileName
             ]);
             $good_receipt->save();
         }
        if($good_receipt){
        //redirect dengan pesan sukses
        return redirect('warehouse/po')->with('success','Data has been successfully updated!');
        }
        else{
        //redirect dengan pesan error
        return redirect('warehouse/po')->with(['error' => 'Data Update Failed!']);
      }
     }

    public function disputed()
    {
        return view('admin.po.dispsuted');
    }

}