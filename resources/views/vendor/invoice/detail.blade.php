@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
    .table td,
    .table th,
    label {
        font-size: 12.4px;
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
                        <form autocomplete="off" action="" method="post"
                            enctype="multipart/form-data">
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
                        <label class="form-control-label" for="total_harga_gross">Total DPP</label>
                        <input type="text" class="form-control @error('total_harga_gross[]') is-invalid @enderror"
                            name="total_harga_gross" placeholder="Masukkan Total DDP ..."
                            value="{{ number_format($total_dpp) }}" readonly>
                        @error('total_harga_gross[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-control-label" for="no_invoice_proposal">Nomor Invoice Proposal<span style="color: red">*</span></label>
                        <input type="text" 
                            class="form-control @error('no_invoice_proposal') is-invalid @enderror"
                            name="no_invoice_proposal" placeholder="Masukkan No Invoice ..."
                            value="{{ "MKP-INV-".$kd }}" readonly>
                        @error('no_invoice_proposal')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-control-label" for="tax_code">Tax Code</label>
                        <input type="text" class="form-control @error('tax_code[]') is-invalid @enderror"
                            name="tax_code" placeholder="Masukkan Total DDP ..."
                            value="{{ $good->tax_code }}" readonly>
                        @error('tax_code[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-control-label" for="posting_date">Invoice Date <span style="color: red">*</span></label>
                        <input type="date"
                            class="form-control @error('posting_date') is-invalid @enderror"
                            name="posting_date" placeholder="Fill in Invoice Date ..."
                            required>
                        @error('posting_date')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-control-label" for="ppn">Total PPN</label>
                        <input type="text" class="form-control @error('ppn[]') is-invalid @enderror"
                            name="ppn" placeholder="Masukkan Total PPN ..." value="{{ number_format($total_ppn) }}"
                            readonly>
                        @error('ppn[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                <div class="form-group col-md-6">
                    <label class="form-control-label" for="vendor_invoice_number">Invoice Number<span style="color: red">*</span></label>
                    <input type="text" id="input_mask1"
                        class="form-control @error('vendor_invoice_number') is-invalid @enderror"
                        name="vendor_invoice_number" placeholder="Fill in Invoice Number ..."
                        value="{{ $good->vendor_invoice_number }}"  required>
                    @error('vendor_invoice_number')<span
                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="form-control-label" for="total_harga_everify">Total Price</label> <br>
                    <input type="text"
                        class="form-control @error('total_harga_everify[]') is-invalid @enderror"
                        name="total_harga_everify" placeholder="Masukkan Total Price ..."
                        value="RP {{ number_format($total_harga) }}" readonly>
                    @error('total_harga_everify[]')<span
                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="form-control-label" for="faktur_pajak_number">VAT NO.<span style="color: red">*</span></label>
                    <input type="text" id="input_mask"
                        class="form-control @error('faktur_pajak_number[]') is-invalid @enderror"
                        name="faktur_pajak_number" placeholder="Fill in VAT NO ..."
                        value="{{ $good->faktur_pajak_number }}" required>
                    @error('faktur_pajak_number[]')<span
                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="form-control-label" for="del_costs">Invoice Difference</label> <br>
                    <input type="number" class="form-control @error('del_costs[]') is-invalid @enderror"
                        name="del_costs" placeholder="Fill in Invoice Difference ...">
                    @error('del_costs[]')<span
                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                </div>
                </div>
                    &nbsp;<a href="{{url('vendor/invoice')}}" type="submit" class="btn btn-danger mb-2" id="simpan">Return</a>
                    </form>
                    <table id="list" class="table table-stats order-table ov-h">
                        <thead>
                            <tr>
                                <th>GR Number</th>
                                <th>No PO</th>
                                <th>PO Item</th>
                                <th>GR Slip Date</th>
                                <th>Material Number</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Tax Code</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>   
                            <td> <span class="">{{$invoice->no_po}}</span> </td>
                            <td> <span class="">{{$invoice->gr_number}}</span> </td>
                            <td> <span class="">{{$invoice->po_item}}</span> </td>
                            <td> <span class="">{{$invoice->gr_date}}</span>
                            <td> <span class="">{{$invoice->material_number}}</span>
                            <td> <span class="">{{$invoice->harga_satuan}}</span>
                            <td> <span class="">{{$invoice->jumlah}}</span></td>
                            <td> <span class="">{{$invoice->tax_code}}</span></td>
                            <td> <span class="">{{ $invoice->status }}</span></td>
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