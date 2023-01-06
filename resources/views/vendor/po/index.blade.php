<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

<style>
.table td,
.table th,
label {
    font-size: 11px;
}

div.dt-button-collection {
    background-color: #0275d8;
}

.hover:hover {
    border-bottom: 3px solid white;
}
</style>
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

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
                            <li><a href="#">Good Receipt List</a></li>
                            <li class="active">Show</li>
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
            <div class="col-lg-12">
                <div class="card">
                    @if($message = Session::get('destroy'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif($message = Session::get('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="">
                        <div class="card-header">
                            <strong class="card-title"><i class="fa fa-list"></i> Verified List</i></strong>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                            href="#nav-home" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Verified</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                            href="#nav-profile" role="tab" aria-controls="nav-profile"
                                            aria-selected="false">Not Yet Verified - Draft BA</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                            href="#nav-contact" role="tab" aria-controls="nav-contact"
                                            aria-selected="false">Verified - BA</a>
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap ">
                                                @if ($start_date != null || $end_date != null)
                                                <p style="text-align: center; background-color: #11CDEF; color: white;">
                                                    <strong class="card-title"></i>GR
                                                        Date:{{ Carbon\Carbon::parse($start_date)->format('d F Y') }}
                                                        To:
                                                        {{ Carbon\Carbon::parse($end_date)->format('d F Y') }}</i></strong>
                                                </p>
                                                @endif
                                                <form action="{{ route('vendor-filter') }}" class="form-inline"
                                                    method="GET">
                                                    {{-- <div class="row"> --}}
                                                    <div class="form-group col-md-1">

                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">GR Date: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="start_date">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="end_date">
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">Plant Code: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="minpo">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="maxpo">
                                                    </div>
                                                    <button class="btn btn-primary"
                                                        onclick="return confirm('Are you sure?')" type="submit"><i
                                                            class="fa fa-search"></i></button>
                                                </form>
                                                {{-- <h1> GR_Date:{{ Carbon\Carbon::parse($start_date)->format('d F Y') }}
                                                To: {{ Carbon\Carbon::parse($end_date)->format('d F Y') }}</h1> --}}
                                                <form action="{{ route('update-datagr-vendor/{id_gr}') }}"
                                                    method="POST">
                                                    @csrf
                                                    <table class="table table-striped" id="TABEL_1"
                                                        style="width:100%; font-size: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" onchange="checkAll(this)">
                                                                </th>
                                                                <th style="text-align: center;">No</th>
                                                                <th style="text-align: center;">Sts. GR</th>
                                                                <th style="text-align: center;">Sts. Inv. Props.</th>
                                                                <th style="text-align: center;">Plant Code</th>
                                                                <th style="text-align: center;">PO</th>
                                                                <th style="text-align: center;">GR Number</th>
                                                                <th style="text-align: center;">GR Date</th>
                                                                <th style="text-align: center;">Part Number</th>
                                                                <th style="text-align: center;">Mat. Desc.</th>
                                                                <th style="text-align: center;">Qty UOM</th>
                                                                <th style="text-align: center;">Curr</th>
                                                                <th style="text-align: center;">Unit Price</th>
                                                                <th style="text-align: center;">Ref.</th>
                                                                <th style="text-align: center;">Del. Note</th>
                                                                <th style="text-align: center;">Tax Code</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 11px;">
                                                            @foreach($good_receipts as $good_receipt)
                                                            <tr>
                                                                @if ($good_receipt->status_invoice_proposal == 'Not Yet
                                                                Verified - Draft BA')
                                                                <td><input disabled type="hidden" name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @elseif ($good_receipt->status_invoice_proposal ==
                                                                'Verified - BA')
                                                                <td><input disabled type="hidden" name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @else
                                                                <td><input type="checkbox" name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @endif
                                                                <td>{{++$i}}</td>
                                                                <td>{{ $good_receipt->status }}</td>
                                                                <td>{{ $good_receipt->status_invoice_proposal }}</td>
                                                                <td>{{ $good_receipt->plant_code }}</td>
                                                                <td><span>{{$good_receipt->no_po}}
                                                                        /{{$good_receipt->po_item}}</span></td>
                                                                <td><span>{{$good_receipt->gr_number}}</span></td>
                                                                <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->material_number}}/<br>
                                                                        {{$good_receipt->vendor_part_number}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->mat_desc}}</span>
                                                                    <br>({{$good_receipt->valuation_type}})</td>
                                                                <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->uom}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->currency}}</span> </td>
                                                                <td style="text-align: right">
                                                                    <span>{{number_format($good_receipt->harga_satuan)}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                                                <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                                                <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                                            </tr>
                                                            @endforeach
                                                            </select>
                                                        </tbody>
                                                    </table>
                                                    &nbsp;&nbsp;<button type="submit" name="action" value="Dispute"
                                                        class="btn btn-warning btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Dispute</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="action"
                                                        value="Update" class="btn btn-success btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Create Invoice
                                                        Proposal</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="action"
                                                        value="ba" class="btn btn-primary btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Generate Draft
                                                        BA</button>
                                                    <div class="row">
                                                        <div class="col-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="card bg-light card-outline-danger text-cen">
                                                                <span class="pull-right clickable close-icon text-right"
                                                                    data-effect="fadeOut"><i
                                                                        class="fa fa-times"></i></span>
                                                                <div class="card-block text-white">
                                                                    <blockquote class="card-blockquote text-white">
                                                                        <p style="font-size: 14px;"><strong>&nbsp; Good
                                                                                receipt status description: </strong>
                                                                        </p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 1.
                                                                                Verified: good receipt data with this
                                                                                status means that this data comes from
                                                                                the <br> warehouse and has been verified
                                                                                by the warehouse.</strong></p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 2.
                                                                                Auto Verify: good receipt data with this
                                                                                status means the data from SAP is
                                                                                correct <br> and does not have certain
                                                                                conditions.</strong></p>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div> <!-- /.table-stats -->
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap ">
                                                <form action="{{ route('vendor-filter') }}" class="form-inline"
                                                    method="GET">
                                                    {{-- <div class="row"> --}}
                                                    <div class="form-group col-md-1">

                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">GR Date: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="start_date">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="end_date">
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">Plant Code: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="minpo">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="maxpo">
                                                    </div>
                                                    <button class="btn btn-primary"
                                                        onclick="return confirm('Are you sure?')" type="submit"><i
                                                            class="fa fa-search"></i></button>
                                                </form>
                                                <form action="{{ route('update-datagr-vendor/{id_gr}') }}"
                                                    method="POST">
                                                    @csrf
                                                    <table class="table table-striped" id="TABEL_2"
                                                        style="width:100%; font-size: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" disabled
                                                                        onchange="checkAll(this)"></th>
                                                                <th style="text-align: center;">Sts. GR</th>
                                                                <th style="text-align: center;">Sts. Inv. Props.</th>
                                                                <th style="text-align: center;">Plant Code</th>
                                                                <th style="text-align: center;">PO</th>
                                                                <th style="text-align: center;">GR Number</th>
                                                                <th style="text-align: center;">GR Date</th>
                                                                <th style="text-align: center;">Part Number</th>
                                                                <th style="text-align: center;">Mat. Desc.</th>
                                                                <th style="text-align: center;">Qty UOM</th>
                                                                <th style="text-align: center;">Curr</th>
                                                                <th style="text-align: center;">Unit Price</th>
                                                                <th style="text-align: center;">Ref.</th>
                                                                <th style="text-align: center;">Del. Note</th>
                                                                <th style="text-align: center;">Tax Code</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 11px;">
                                                            @foreach($not as $good_receipt)
                                                            <tr>
                                                                @if ($good_receipt->status_invoice_proposal == 'Not Yet
                                                                Verified - Draft BA')
                                                                <td><input type="checkbox" disabled name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @elseif ($good_receipt->status_invoice_proposal ==
                                                                'Verified - BA')
                                                                <td><input type="checkbox" disabled name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @else
                                                                <td><input type="checkbox" name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @endif
                                                                <td>{{ $good_receipt->status }}</td>
                                                                <td>{{ $good_receipt->status_invoice_proposal }}</td>
                                                                <td>{{ $good_receipt->plant_code }}</td>
                                                                <td><span>{{$good_receipt->no_po}}
                                                                        /{{$good_receipt->po_item}}</span></td>
                                                                <td><span>{{$good_receipt->gr_number}}</span></td>
                                                                <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->material_number}}/<br>
                                                                        {{$good_receipt->vendor_part_number}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->mat_desc}}</span>
                                                                    <br>({{$good_receipt->valuation_type}})</td>
                                                                <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->uom}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->currency}}</span> </td>
                                                                <td style="text-align: right">
                                                                    <span>{{number_format($good_receipt->harga_satuan)}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                                                <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                                                <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                                            </tr>
                                                            @endforeach
                                                            </select>
                                                        </tbody>
                                                    </table>
                                                    &nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="Dispute" class="btn btn-warning btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Dispute</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="Update" class="btn btn-success btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Create Invoice
                                                        Proposal</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="ba" class="btn btn-primary btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Generate Draft
                                                        BA</button>
                                                    <div class="row">
                                                        <div class="col-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="card bg-light card-outline-danger text-cen">
                                                                <span class="pull-right clickable close-icon text-right"
                                                                    data-effect="fadeOut"><i
                                                                        class="fa fa-times"></i></span>
                                                                <div class="card-block text-white">
                                                                    <blockquote class="card-blockquote text-white">
                                                                        <p style="font-size:l 14px;"><strong>&nbsp; Good
                                                                                receipt status description: </strong>
                                                                        </p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 1.
                                                                                Verified: good receipt data with this
                                                                                status means that this data comes from
                                                                                the <br> warehouse and has been verified
                                                                                by the warehouse.</strong></p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 2.
                                                                                Auto Verify: good receipt data with this
                                                                                status means the data from SAP is
                                                                                correct <br> and does not have certain
                                                                                conditions.</strong></p>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div> <!-- /.table-stats -->
                                        </div>


                                    </div>

                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap ">
                                                <form action="{{ route('vendor-filter') }}" class="form-inline"
                                                    method="GET">
                                                    {{-- <div class="row"> --}}
                                                    <div class="form-group col-md-1">

                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">GR Date: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="start_date">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="date" class="form-control form-control-sm" name="end_date">
                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="">Plant Code: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="minpo">
                                                    </div>
                                                    <div class="form-group mx-sm-4">
                                                        <label for="inputPassword2">To: &nbsp;</label>
                                                        <input type="text" class="form-control form-control-sm" name="maxpo">
                                                    </div>
                                                    <button class="btn btn-primary"
                                                        onclick="return confirm('Are you sure?')" type="submit"><i
                                                            class="fa fa-search"></i></button>
                                                </form>
                                                <form action="{{ route('update-datagr-vendor/{id_gr}') }}"
                                                    method="POST">
                                                    @csrf
                                                    <table class="table table-striped" id="TABEL_3"
                                                        style="width:100%; font-size: 10px;">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" disabled
                                                                        onchange="checkAll(this)"></th>
                                                                <th style="text-align: center;">Sts. GR</th>
                                                                <th style="text-align: center;">Sts. Inv. Props.</th>
                                                                <th style="text-align: center;">Plant Code</th>
                                                                <th style="text-align: center;">PO</th>
                                                                <th style="text-align: center;">GR Number</th>
                                                                <th style="text-align: center;">GR Date</th>
                                                                <th style="text-align: center;">Part Number</th>
                                                                <th style="text-align: center;">Mat. Desc.</th>
                                                                <th style="text-align: center;">Qty UOM</th>
                                                                <th style="text-align: center;">Curr</th>
                                                                <th style="text-align: center;">Unit Price</th>
                                                                <th style="text-align: center;">Ref.</th>
                                                                <th style="text-align: center;">Del. Note</th>
                                                                <th style="text-align: center;">Tax Code</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="font-size: 11px;">
                                                            @foreach($ver as $good_receipt)
                                                            <tr>
                                                                @if ($good_receipt->status_invoice_proposal == 'Not Yet
                                                                Verified - Draft BA')
                                                                <td><input type="checkbox" disabled name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @elseif ($good_receipt->status_invoice_proposal ==
                                                                'Verified - BA')
                                                                <td><input type="checkbox" disabled name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @else
                                                                <td><input type="checkbox" name="ids[]"
                                                                        value="{{$good_receipt->id_gr}}"></td>
                                                                @endif
                                                                <td>{{ $good_receipt->status }}</td>
                                                                <td>{{ $good_receipt->status_invoice_proposal }}</td>
                                                                <td>{{ $good_receipt->plant_code }}</td>
                                                                <td><span>{{$good_receipt->no_po}}
                                                                        /{{$good_receipt->po_item}}</span></td>
                                                                <td><span>{{$good_receipt->gr_number}}</span></td>
                                                                <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->material_number}}/<br>
                                                                        {{$good_receipt->vendor_part_number}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->mat_desc}}</span>
                                                                    <br>({{$good_receipt->valuation_type}})</td>
                                                                <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->uom}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->currency}}</span> </td>
                                                                <td style="text-align: right">
                                                                    <span>{{number_format($good_receipt->harga_satuan)}}</span>
                                                                </td>
                                                                <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                                                <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                                                <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                                            </tr>
                                                            @endforeach
                                                            </select>
                                                        </tbody>
                                                    </table>
                                                    &nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="Dispute" class="btn btn-warning btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Dispute</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="Update" class="btn btn-success btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Create Invoice
                                                        Proposal</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<button disabled type="submit" name="action"
                                                        value="ba" class="btn btn-primary btn-sm-3"
                                                        onclick="return confirm('Are you sure?')">Generate Draft
                                                        BA</button>
                                                    <div class="row">
                                                        <div class="col-6">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="card bg-light card-outline-danger text-cen">
                                                                <span class="pull-right clickable close-icon text-right"
                                                                    data-effect="fadeOut"><i
                                                                        class="fa fa-times"></i></span>
                                                                <div class="card-block text-white">
                                                                    <blockquote class="card-blockquote text-white">
                                                                        <p style="font-size:l 14px;"><strong>&nbsp; Good
                                                                                receipt status description: </strong>
                                                                        </p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 1.
                                                                                Verified: good receipt data with this
                                                                                status means that this data comes from
                                                                                the <br> warehouse and has been verified
                                                                                by the warehouse.</strong></p>
                                                                        <p style="font-size: 13px;"><strong>&nbsp; 2.
                                                                                Auto Verify: good receipt data with this
                                                                                status means the data from SAP is
                                                                                correct <br> and does not have certain
                                                                                conditions.</strong></p>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div> <!-- /.table-stats -->
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript" defer="defer">
                    $(document).ready(function() {
                        $("table[id^='TABEL']").DataTable({
                            dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
                                "<'row'<'col-md-12'tr>>" +
                                "<'row'<'col-md-6'i><'col-md-6'p>>",
                            columnDefs: [{
                                targets: 1,
                                className: 'noVis'
                            }],
                            buttons: [{
                                extend: 'colvis',
                                columns: ':not(.noVis)'
                            }],
                            rowReorder: true,
                            columnDefs: [{
                                    orderable: true,
                                    className: 'reorder',
                                    targets: 1
                                },
                                {
                                    orderable: true,
                                    className: 'reorder',
                                    targets: 5
                                },
                                {
                                    orderable: true,
                                    className: 'reorder',
                                    targets: 6
                                },
                                {
                                    orderable: false,
                                    targets: '_all'
                                }
                            ],
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All'],
                            ],
                        });
                    });

                    // $(document).ready(function() {
                    // $('#TABEL_1').DataTable({         
                    //         rowReorder: true,
                    //          columnDefs: [
                    //         { orderable: true, className: 'reorder', targets: 1 },
                    //         { orderable: true, className: 'reorder', targets: 5 },
                    //         { orderable: true, className: 'reorder', targets: 6 },
                    //         { orderable: false, targets: '_all' }
                    //                 ],
                    //         lengthMenu: [[10, 25, 50, -1],[10, 25, 50, 'All'],],
                    //     });

                    // });    
                    </script>

                    <script>
                    function checkAll(box) {
                        let checkboxes = document.getElementsByTagName('input');

                        if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
                            for (let i = 0; i < checkboxes.length; i++) {
                                if (checkboxes[i].type == 'checkbox') {
                                    checkboxes[i].checked = true;
                                }
                            }
                        } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
                            for (let i = 0; i < checkboxes.length; i++) {
                                if (checkboxes[i].type == 'checkbox') {
                                    checkboxes[i].checked = false;
                                }
                            }
                        }
                    }
                    </script>
                    @endsection