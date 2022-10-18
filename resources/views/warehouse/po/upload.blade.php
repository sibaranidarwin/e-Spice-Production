@extends('warehouse.layouts.sidebar')
@section('content')

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <!-- <h1>Data Purchase Order</h1> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Upload SPB Good Receipt</a></li>
                            <li class="active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col">
                <div class="card  shadow h-100">
                    <div class="card-header">
                        <strong class="card-header">Upload SPB Good Receipt</strong>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" action="{{ route('update-datagr') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($good_receipts as $good)
                            <input type="hidden" name="id[]" value="{{$good->id}}">
                            @endforeach
                            <div class="form-group">
                                <label class="form-control-label" for="Status">Upload File SPB</label><br>
                                <input type="file" value="spb" class="">
                            </div>
                            <hr>
                            <button type="submit" name="action" value="Upload SPB" class="btn btn-success"
                                id="simpan">Save</button>
                            <a href="{{url('warehouse/po')}}" class="btn btn-danger">Return</a>
                        </form>
                        <br>
                        <strong class="card-header">Good Receipt Data to be Upload SPB</strong>
                        <table id="list" class="table table-stats order-table ov-h">
                            <thead>
                                <tr>
                                    <th>GR Number</th>
                                    <th>No PO</th>
                                    <th>PO Item</th>
                                    <th>GR Slip Date</th>
                                    <th>Material Number</th>
                                    <!-- <th class="text-center">Reference</th> -->
                                    <!-- <th class="text-center">Vendor Part Number</th>
                                        <th class="text-center">Item Description</th>
                                        <th class="text-center">UoM</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center">Jumlah</th> -->
                                    <!-- <th class="text-center">Jumlah Harga</th> -->
                                    <th>Tax Code</th>
                                    <!-- <th class="text-center">Valuation Type</th> -->
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($good_receipts as $good_receipt)
                                <tr>
                                    <td><span class="name">{{$good_receipt->GR_Number}}</span> </td>
                                    <td> <span class="">{{$good_receipt->no_po}}</span> </td>
                                    <td> <span class="">{{$good_receipt->po_item}}</span> </td>
                                    <td> <span class="">{{$good_receipt->GR_Date}}</span> </td>
                                    <td> <span class="">{{$good_receipt->Material_Number}}</span>
                                    </td>
                                    <!-- <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td> -->
                                    <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                                    <!-- <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td> -->
                                    <td> <span class="">{{$good_receipt->Tax_Code}}</span> </td>
                                    <!-- <td class="text-center"> <span class=""></span> </td> -->
                                    <td>{{ $good_receipt->Status }}</td>
                                </tr>
                                @endforeach
                                </select>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

</div><!-- /#right-panel -->
@endsection