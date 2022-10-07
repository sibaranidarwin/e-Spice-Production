@extends('accounting.layouts.sidebar')
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
                            <li><a href="#">Data Invoice Proposal</a></li>
                            <li class="active">List</li>
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
                        <strong class="card-header">Data Invoice Proposal</strong>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" action="" method="post"
                            enctype="multipart/form-data">
                            @foreach ($invoice as $good)
                            @csrf
                            <input type="hidden" name="id[]" value="{{$good->id}}">
                            {{-- <b class="mb-4">
                                    {{ $good->id }}
                            </b> --}}
                            {{-- <div class="form-group">
                                        <label class="form-control-label" for="id">GR Number</label>
                                        <input type="number" class="form-control @error('id') is-invalid @enderror" name="id" placeholder="Masukkan Tanggal ..." value="{{ $good->id }}">
                            @error('id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div> --}}
                    <div class="form-group">
                        <label class="form-control-label" for="vendor_name[]">Posting Date</label>
                        <input type="date" class="form-control @error('vendor_name[]') is-invalid @enderror"
                            name="vendor_name[]" placeholder="Masukkan Tanggal ..." value="{{ $good->posting_date }}">
                        @error('vendor_name[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="no_po[]">Baseline Date</label>
                        <input type="date" class="form-control @error('no_po[]') is-invalid @enderror" name="no_po[]"
                            placeholder="Masukkan Tanggal ..." value="{{ $good->baselinedate }}">
                        @error('no_po[]')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="po_item[]">No Invoice</label>
                        <input type="text" class="form-control @error('po_item[]') is-invalid @enderror"
                            name="po_item[]" placeholder="Masukkan Tanggal ..." value="{{ $good->vendor_invoice_number }}">
                        @error('po_item[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="GR_Date[]">No Tax Invoice</label>
                        <input type="text" class="form-control @error('GR_Date[]') is-invalid @enderror"
                            name="GR_Date[]" placeholder="Masukkan Tanggal ..." value="{{ $good->faktur_pajak_number }}">
                        @error('GR_Date[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="faktur_pajak_number[]">No Invoice Proposal</label>
                        <input type="text" class="form-control @error('faktur_pajak_number[]') is-invalid @enderror"
                            name="faktur_pajak_number[]" placeholder="Masukkan Tanggal ..." value="{{ $good->vendor_invoice_number }}">
                        @error('faktur_pajak_number[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Material_Number[]">Amount DDP</label>
                        <input type="text" class="form-control @error('Material_Number[]') is-invalid @enderror"
                            name="Material_Number[]" placeholder="Masukkan Tanggal ..."
                            value="{{ $good->total_harga_everify }}">
                        @error('Material_Number[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="ppn[]">PPN</label>
                        <input type="number" class="form-control @error('ppn[]') is-invalid @enderror"
                            name="ppn[]" placeholder="Masukkan Tanggal ..." value="{{ $good->ppn }}">
                        @error('ppn[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Status[]">Amount Price</label> <br>
                        <input type="text" class="form-control @error('Tax_Code[]') is-invalid @enderror"
                            name="Tax_Code[]" placeholder="Masukkan Tanggal ..." value="{{ $good->Tax_Code }}">
                        @error('Tax_Code[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Status[]">Invoice Difference</label> <br>
                        <input type="text" class="form-control @error('Tax_Code[]') is-invalid @enderror"
                            name="Tax_Code[]" placeholder="Masukkan Tanggal ..." value="{{ $good->Tax_Code }}">
                        @error('Tax_Code[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <hr>
                    @endforeach
                    &nbsp;&nbsp;&nbsp;<a href="{{url('accounting/invoice')}}" type="submit" class="btn btn-danger mb-2" id="simpan">Return</a>
                    </form>

                    <table id="list" class="table">
                        <thead>
                            <tr>
                                <th></th>
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
                            @foreach($invoice as $good_receipt)
                            <tr>
                            <td><input type="hidden" name="ids[]" value="{{$good_receipt->id}}"></td>      
                            
                            <td><span class="name">{{$good_receipt->id}}</span> </td>
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