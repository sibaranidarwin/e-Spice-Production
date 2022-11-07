@extends('warehouse.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
.table td,
.table th,
label {
    font-size: 11.4px;
}
</style>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Edit invoice Receipt List</a></li>
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
                        <strong class="card-header">Data Invoice Proposal</strong>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" action="" method="post" enctype="multipart/form-data">
                            @foreach ($invoices as $invoice)
                            @csrf
                            <input type="hidden" name="id[]" value="{{$invoice->id_inv}}">
                            @endforeach
                            {{-- <b class="mb-4">
                                    {{ $invoice->id }}
                            </b> --}}
                            {{-- <div class="form-group">
                                        <label class="form-control-label" for="id">GR Number</label>
                                        <input type="number" class="form-control @error('id') is-invalid @enderror" name="id" placeholder="Masukkan Tanggal ..." value="{{ $invoice->id }}">
                            @error('id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div> --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="vendor_invoice_number[]">No Invoice Proposal</label>
                            <input type="text" class="form-control @error('vendor_invoice_number[]') is-invalid @enderror"
                                name="vendor_invoice_number[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->no_invoice_proposal }}" readonly>
                            @error('vendor_invoice_number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="posting_date[]">Posting Date</label>
                            <input type="date" class="form-control @error('posting_date[]') is-invalid @enderror"
                                name="posting_date[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->posting_date }}" readonly>
                            @error('posting_date[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="vendor_invoice_number[]">No Invoice</label>
                            <input type="text"
                                class="form-control @error('vendor_invoice_number[]') is-invalid @enderror"
                                name="vendor_invoice_number[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->vendor_invoice_number }}" readonly>
                            @error('vendor_invoice_number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="total_harga_everify[]">No Faktur Pajak</label>
                            <input type="number"
                                class="form-control @error('total_harga_everify[]') is-invalid @enderror"
                                name="total_harga_everify[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->faktur_pajak_number }}" readonly>
                            @error('total_harga_everify[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="Material_Number[]">Amount DDP</label>
                            <input type="text" class="form-control @error('Material_Number[]') is-invalid @enderror"
                                name="Material_Number[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->total_harga_gross }}" readonly>
                            @error('Material_Number[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="ppn[]">PPN</label>
                            <input type="text" class="form-control @error('ppn[]') is-invalid @enderror" name="ppn[]"
                                placeholder="Masukkan Tanggal ..." value="{{ $invoice->ppn }}" readonly>
                            @error('ppn[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="total_harga_gross[]">Amount Price</label> <br>
                            <input type="text" class="form-control @error('total_harga_gross[]') is-invalid @enderror"
                                name="total_harga_gross[]" placeholder="Masukkan Tanggal ..."
                                value="{{ $invoice->total_harga_everify }}" readonly>
                            @error('total_harga_gross[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="Status[]">Selisih Harga</label> <br>
                            <input type="text" class="form-control @error('Tax_Code[]') is-invalid @enderror"
                                name="Tax_Code[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->del_costs}}" readonly>
                            @error('Tax_Code[]')<span
                                class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    &nbsp;<a href="{{url('warehouse/invoiceba')}}" type="submit" class="btn btn-danger mb-2"
                        id="simpan">Return</a>
                    </form>
                    <table id="list" class="table table-stats order-table ov-h">
                        <thead>
                            <tr>
                                <th>BA Number</th>
                                <th>PO Number</th>
                                <th>PO MKP</th>
                                <th>GR Date</th>
                                <th>Material</th>
                                <!-- <th class="text-center">Reference</th> -->
                                <!-- <th class="text-center">Vendor Part Number</th>
                                        <th class="text-center">Item Description</th>
                                        <th class="text-center">UoM</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center">Jumlah</th> -->
                                <!-- <th class="text-center">Jumlah Harga</th> -->
                                {{-- <th>Tax Code</th> --}}
                                <!-- <th class="text-center">Valuation Type</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $ba)
                            <tr>
                                <td><span class="name">{{$ba->no_ba}}</span> </td>
                                <td> <span class="">{{$ba->po_number}}</span> </td>
                                <td> <span class="">{{$ba->po_mkp}}</span> </td>
                                <td> <span class="">{{$ba->gr_date}}</span> </td>
                                <td> <span class="">{{$ba->material_bp}}</span></td>
                                <td>{{ $ba->status_ba }}</td>
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