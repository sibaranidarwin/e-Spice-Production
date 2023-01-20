<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

@extends('warehouse.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">

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
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header">
                        <strong class="card-title"><i class="fa fa-list"></i> Rejected List</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            @if ($start_date != null || $end_date != null || $vendor != null)
                            <p style="text-align: center; background-color: #11CDEF; color: white;"><strong class="card-title">GR Date:{{ Carbon\Carbon::parse($start_date)->format('d F Y') }} To: {{ Carbon\Carbon::parse($end_date)->format('d F Y') }}&nbsp; || &nbsp; Vendor Name: {{ ($vendor) }}</strong></p>
                            @endif
                            <form action="{{ route('warehouse-filterreject') }}" class="form-inline" method="GET">
                                <div class="form-group col-md-2">

                                </div>
                                <div class="form-group ">
                                  <label for="" >GR Date: &nbsp;</label>
                                  <input type="date" class="form-control form-control-sm" name="start_date">
                                </div>
                                <div class="form-group mx-sm-2">
                                  <label for="inputPassword2">To: &nbsp;</label>
                                  <input type="date" class="form-control form-control-sm" name="end_date">
                                </div>
                                <div class="form-group col-md-2-half">
                                    <select class="form-control form-control-sm form-select" name="vendor">
                                        <option value="" >-- Choose Vendor Name -- </option>
                                            @foreach ($vendor_name as $vendor_name)
                                                <option value="{{ $vendor_name['vendor_name'] }}">{{ $vendor_name['vendor_name'] }}</option>
                                            @endforeach
                                    </select>
                                </div> &nbsp;&nbsp;
                                <div hidden class="form-group col-md-2-half">
                                    <select class="form-control form-control-sm status_invoice" name="status">
                                        <option value="">-- Choose Sts. Inv. Props. -- </option>
                                        <option value="Verified">Verified</option>
                                        <option value="Not Yet Verified - Draft BA">Not Yet Verified - Draft BA</option>
                                    </select>
                                </div> &nbsp;&nbsp;
                                <button class="btn btn-primary" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <form action="{{ route('update-datagr/{id}') }}" method="POST">
                                @csrf
                                <table id="list" class="table table-striped" style="font-size: 10px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Sts. GR</th>
                                            <th style="text-align: center;">Sts. Inv. Props.</th>
                                            <th style="text-align: center;">Vendor</th>
                                            <th style="text-align: center;">PO</th>
                                            <th style="text-align: center;">GR Number</th>
                                            <th style="text-align: center;">GR Date</th>
                                            <th style="text-align: center;">Part Number</th>
                                            <th style="text-align: center;">Mat. Desc.</th>
                                            <th style="text-align: center;">QTY UOM</th>
                                            <th style="text-align: center;">Reference</th>
                                            <th style="text-align: center;">Del. Note</th>
                                            <th style="text-align: center;">Tax Code</th>
                                            <th style="text-align: center;">Updated By</th>
                                            <th style="text-align: center;">Reason</th>  
                                            <th style="text-align: center;">Action</th>  
                                        </tr>
                                        </thead>
                                        <tbody style="font-size: 11px;">
                                            @foreach($good_receipts as $good_receipt)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td >{{ $good_receipt->status }}</td>
                                                <td >{{ $good_receipt->status_invoice }}</td>
                                                <td >{{ $good_receipt->id_vendor }} /{{ $good_receipt->vendor_name}}</td>
                                                <td ><span>{{$good_receipt->no_po}} /{{$good_receipt->po_item}}</span></td>
                                                <td ><span>{{$good_receipt->gr_number}}</span></td>
                                                <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span></td>
                                                <td> <span>{{$good_receipt->material_number}}/<br> {{$good_receipt->vendor_part_number}}</span></td>
                                                <td> <span>{{$good_receipt->mat_desc}}</span> <br>({{$good_receipt->valuation_type}})</td>
                                                <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->uom}}</span> </td>
                                                <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                                <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                                <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                                <td> <span>Warehouse</span> </td>
                                                <td><span>{{$good_receipt->alasan_reject}}</span></td>
                                                <td class="text-center"><span>
                                                    <a data-toggle="tooltip" data-placement="bottom" href="/warehouse/cancelreject/{{ $good_receipt->id_gr}}" class="btn btn-danger btn-sm fa fa-times" title="Cancel Rejected"
                                                        onclick="return confirm('Are you sure?')"></a>
                                            </span></td>
                                            </tr>
                                        @endforeach
                                        </select>
                                    </tbody>
                                </table>
                                <div class="row mt-2">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="card bg-light card-outline-danger text-cen">
                                            <span class="pull-right clickable close-icon text-right" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                                            <div class="card-block text-white">
                                              <blockquote class="card-blockquote text-white">
                                                <p style="font-size: 14px;"><strong>&nbsp; Good receipt status description: </strong></p>
                                                <p style="font-size: 13px;"><strong>&nbsp; Rejected: good receipt data that is no longer used because it has certain problems</strong></p>
                                            </blockquote>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                {{-- &nbsp;&nbsp;<button type="submit" value="Update" name="action" --}}
                                {{-- class="btn btn-success">Update Data</button> --}}
                            </form>
                        </div> <!-- /.table-stats -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

<footer class="site-footer">
    <div class="footer-inner bg-white">
        <div class="row">
            <div class="col-sm-6">
                <!-- Copyright &copy; 2018 Ela Admin -->
            </div>
            <div class="col-sm-6 text-right">
                Designed by <a href="https://colorlib.com">Colorlib</a>
            </div>
        </div>
    </div>
</footer>

</div><!-- /#right-panel -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
var minDate, maxDate;

// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[5]);

        if (
            (min === null && max === null) ||
            (min === null && date <= max) ||
            (min <= date && max === null) ||
            (min <= date && date <= max)
        ) {
            return true;
        }
        return false;
    }
);

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });

    // DataTables initialisation
    var table = $('#list').DataTable({
        lengthMenu: [[10, 25, 50, -1],[10, 25, 50, 'All'],],
        dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-6'i><'col-md-6'p>>",
        columnDefs: [
            {
                targets: 1,
                className: 'noVis'
            }
        ],
        buttons: [
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            }
        ],
        rowReorder: true,
        columnDefs: [{
                orderable: true,
                className: 'reorder',
                targets: 0
            },
            {
                orderable: true,
                className: 'reorder',
                targets: 4
            },
            {
                orderable: true,
                className: 'reorder',
                targets: 5
            },
            {
                orderable: false,
                targets: '_all'
            }
        ],
            
    });

    // Refilter the table
    $('#min, #max').on('change', function() {
        table.draw();
    });


});

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
$(".form-select").select2();
</script>
@endsection