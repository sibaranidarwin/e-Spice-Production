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
                            @foreach ($invoices as $invoice)
                            @csrf
                            <input type="hidden" name="id[]" value="{{$invoice->id}}">
                            {{-- <b class="mb-4">
                                    {{ $good->id }}
                            </b> --}}
                            {{-- <div class="form-group">
                                        <label class="form-control-label" for="id">GR Number</label>
                                        <input type="number" class="form-control @error('id') is-invalid @enderror" name="id" placeholder="Masukkan Tanggal ..." value="{{ $good->id }}">
                            @error('id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div> --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="posting_date[]">Posting Date</label>
                            <input type="date" class="form-control @error('posting_date[]') is-invalid @enderror"
                                name="posting_date[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->posting_date }}">
                            @error('posting_date[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="baselinedate[]">Baseline Date</label>
                            <input type="date" class="form-control @error('baselinedate[]') is-invalid @enderror" name="baselinedate[]"
                                placeholder="Masukkan Tanggal ..." value="{{ $invoice->baselinedate }}">
                            @error('baselinedate[]')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="vendor_invoice_number[]">No Invoice</label>
                            <input type="number" class="form-control @error('vendor_invoice_number[]') is-invalid @enderror"
                                name="vendor_invoice_number[]" placeholder="Masukkan Tanggal ...">
                            @error('vendor_invoice_number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="faktur_pajak_number[]">No Tax Invoice</label>
                            <input type="date" class="form-control @error('faktur_pajak_number[]') is-invalid @enderror"
                                name="faktur_pajak_number[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->faktur_pajak_number }}">
                            @error('faktur_pajak_number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="total_harga_everify[]">No Invoice Proposal</label>
                            <input type="number" class="form-control @error('total_harga_everify[]') is-invalid @enderror"
                                name="total_harga_everify[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->total_harga_everify }}">
                            @error('total_harga_everify[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="Material_Number[]">Amount DDP</label>
                            <input type="text" class="form-control @error('Material_Number[]') is-invalid @enderror"
                                name="Material_Number[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->Material_Number }}">
                            @error('Material_Number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="ppn[]">PPN</label>
                            <input type="text" class="form-control @error('ppn[]') is-invalid @enderror"
                                name="ppn[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->ppn }}">
                            @error('ppn[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="total_harga_gross[]">Amount Price</label> <br>
                            <input type="number" class="form-control @error('total_harga_gross[]') is-invalid @enderror"
                                name="total_harga_gross[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->total_harga_gross }}">
                            @error('total_harga_gross[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="Status[]">Invoice Difference</label> <br>
                            <input type="text" class="form-control @error('Tax_Code[]') is-invalid @enderror"
                                name="Tax_Code[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->Tax_Code }}">
                            @error('Tax_Code[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    &nbsp;&nbsp;&nbsp;<a href="{{url('warehouse/invoice')}}" type="submit" class="btn btn-danger mb-2" id="simpan">Return</a>
                    </form>
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
                            @foreach($invoices as $good_receipt)
                            <tr>
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