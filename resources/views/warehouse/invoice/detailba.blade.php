@extends('warehouse.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
.table td,
.table th,
label {
    font-size: 11px;
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
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="total_harga_gross">Currency</label>
                                    <input type="text"
                                        class="form-control @error('total_harga_gross[]') is-invalid @enderror"
                                        name="total_harga_gross" placeholder="Masukkan Total DDP ..."
                                        value="{{($invoice->currency) }}" readonly>
                                    @error('total_harga_gross[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="Material_Number[]">Total DPP</label>
                                    <input type="text"
                                        class="form-control @error('Material_Number[]') is-invalid @enderror"
                                        name="Material_Number[]" placeholder="Masukkan Tanggal ..."
                                        value="{{ $invoice->total_harga_gross }}" readonly>
                                    @error('Material_Number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="vendor_invoice_number[]">Invoice Number
                                        Proposal</label>
                                    <input type="text"
                                        class="form-control @error('vendor_invoice_number[]') is-invalid @enderror"
                                        name="vendor_invoice_number[]" placeholder="Masukkan Tanggal ..."
                                        value="{{ $invoice->no_invoice_proposal }}" readonly>
                                    @error('vendor_invoice_number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="Material_Number[]">Tax Code</label>
                                    <input type="text"
                                        class="form-control @error('Material_Number[]') is-invalid @enderror"
                                        name="Material_Number[]" value="{{ $invoice->tax_code }}" readonly>
                                    @error('Material_Number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="ppn[]">Total PPN</label>
                                    <input type="text" class="form-control @error('ppn[]') is-invalid @enderror"
                                        name="ppn[]" placeholder="Masukkan Tanggal ..." value="{{ $invoice->ppn }}"
                                        readonly>
                                    @error('ppn[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="posting_date[]">Invoice Date</label>
                                    <input type="date"
                                        class="form-control @error('posting_date[]') is-invalid @enderror"
                                        name="posting_date[]" placeholder="Masukkan Tanggal ..."
                                        value="{{ $invoice->posting_date }}" readonly>
                                    @error('posting_date[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="total_harga_everify">Total Price (calculate
                                        by system)</label> <br>
                                    <input type="text"
                                        class="form-control @error('total_harga_everify[]') is-invalid @enderror"
                                        name="" placeholder="Masukkan Total Price ..."
                                        value="{{ number_format($invoice->total_harga_everify) }}" readonly>
                                    @error('total_harga_everify[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="faktur_pajak_number">Total Price (acc. to doc
                                        invoice)<span style="color: red"></span></label>
                                    <input type="text" id="id-2"
                                        class="form-control @error('faktur_pajak_number[]') is-invalid @enderror"
                                        name="total_doc_invoice" placeholder="Fill in Total Price (acc. to doc invoice)"
                                        value="{{ number_format($invoice->total_doc_invoice) }}" readonly>
                                    @error('faktur_pajak_number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="vendor_invoice_number[]">Invoice
                                        Number</label>
                                    <input type="text"
                                        class="form-control @error('vendor_invoice_number[]') is-invalid @enderror"
                                        name="vendor_invoice_number[]" placeholder="Masukkan Tanggal ..."
                                        value="{{ $invoice->vendor_invoice_number }}" readonly>
                                    @error('vendor_invoice_number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="del_costs">Price Difference</label> <br>
                                    <input type="number" id="id-5"
                                        class="form-control @error('del_costs[]') is-invalid @enderror" name="del_costs"
                                        value="{{ number_format($invoice->del_costs) }}" readonly>
                                    @error('del_costs[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="form-control-label" for="faktur_pajak_number">Unplanned Cost<span
                                            style="color: red"></span></label>
                                    <input type="number" id="id-3" class="number-decimal form-control"
                                        name="unplan_cost" value="{{ number_format($invoice->unplan_cost) }}"
                                        autocomplete="off" readonly>
                                    @error('faktur_pajak_number[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="total_harga_everify[]">VAT NO.</label>
                                    <input type="text"
                                        class="form-control @error('total_harga_everify[]') is-invalid @enderror"
                                        name="total_harga_everify[]" placeholder="Masukkan Tanggal ..."
                                        value="{{ $invoice->faktur_pajak_number }}" readonly>
                                    @error('total_harga_everify[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            &nbsp;<a href="{{url('warehouse/invoiceba')}}" type="submit" class="btn btn-danger mb-2"
                                id="simpan">Return</a>
                        </form>
                        <table id="list" class="table table-stats order-table ov-h">
                            <thead>
                                <tr>
                                    <th>Sts. BA</th>
                                    <th>BA Number</th>
                                    <th>PO</th>
                                    <th>GR Number</th>
                                    <th>GR Date</th>
                                    <th>Part Number</th>
                                    <th>Mat. Desc.</th>
                                    <th>Qty UOM</th>
                                    <th>Price</th>
                                    <th>Curr</th>

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

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $ba)
                                <tr>
                                    <td>{{ $ba->status_ba }}</td>
                                    <td><span class="name">{{$ba->no_ba}}</span> </td>
                                    <td> <span class="">{{$ba->po_number}} /{{$ba->item}}</span> </td>
                                    <td> <span class="">{{$ba->gr_number}}</span> </td>
                                    <td><span>{{ Carbon\Carbon::parse($ba->gr_date)->format('d F Y') }}</span></td>
                                    <td> <span class="">{{$ba->material_number}} /{{$ba->vendor_part_number}} </span>
                                    </td>
                                    <td> <span class="">{{$ba->material_description}} ({{$ba->valuation_type}})</span>
                                    </td>
                                    <td> <span class="">{{$ba->jumlah}} {{$ba->uom}}</span></td>
                                    <td> <span class="">{{$ba->currency}}</span> </td>
                                    <td style="text-align: right"> <span>{{number_format($ba->harga_satuan)}}</span>
                                    </td>
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