@extends('vendor.layouts.sidebar')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

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
                        <!-- <h1>Data Purchase Order</h1> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Invoice Proposal</a></li>
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
                        <form autocomplete="off" action="{{ route('create-invoice') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($good_receipts as $good)
                            <input type="hidden" name="id[]" value="{{$good->id_gr}}">
                            @endforeach
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
                                    name="vendor_invoice_number" required>
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
                            <div hidden class="form-group col-md-6">
                                <input type="text" class="form-control @error('data_from') is-invalid @enderror"
                                    name="data_from" value="GR" >
                                @error('data_from')<span
                                    class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                            </div>
                            <div hidden class="form-group col-md-6">
                                <input type="number" class="form-control @error('id_vendor') is-invalid @enderror"
                                    name="id_vendor" value="{{ $good->id_vendor }}" >
                                @error('id_vendor')<span
                                    class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                            </div>
                    </div>
                    <button type="submit" class="btn btn-success mb-2" id="simpan" onclick="return confirm('Are you sure?')">Submit</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('vendor/ba')}}" type="submit"
                        class="btn btn-danger mb-2" id="simpan" onclick="return confirm('Are you sure?')">Return</a>
                    </form>
                    <br>
                    <strong class="card-header">Data GR to be Invoice Proposal</strong>
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
                                <td><span class="name">{{$good_receipt->gr_number}}</span> </td>
                                <td> <span class="">{{$good_receipt->no_po}}</span> </td>
                                <td> <span class="">{{$good_receipt->po_item}}</span> </td>
                                <td> <span class="">{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span> </td>
                                <td> <span class="">{{$good_receipt->material_number}}</span>
                                </td>
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td> -->
                                <td> <span class="">{{$good_receipt->tax_code}}</span> </td>
                                <!-- <td class="text-center"> <span class=""></span> </td> -->
                                <td>{{ $good_receipt->status }}</td>
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
<script type="text/javascript">
        $('#input_mask').inputmask({
                mask: '***.***.**.********',
                definitions: {
                    A: {
                        validator: "[A-Za-z0-9 ]"
                    },
                },            
            });
        $('#input_mask1').inputmask({
                mask: '*********-**',
                definitions: {
                    A: {
                        validator: "[A-Za-z0-9 ]"
                    },
                },            
            });
        $("#input_mask_currency").inputmask({
            prefix : 'Rp ',
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric",
            autoGroup: true,
            digits: 0
        });
</script>
@endsection