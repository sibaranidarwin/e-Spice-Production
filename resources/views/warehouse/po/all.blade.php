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

@extends('warehouse.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

<style>
    .table td, .table th,label {
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
                        <strong class="card-title">Good Receipt All Status List</strong>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive text-nowrap">
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
                                    <th style="text-align: center;">Tax Code</th>
                                    <th style="text-align: center;">Reference</th>
                                    <th style="text-align: center;">Del. Note</th>
                                    
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
                                        <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                        <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                        <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                    </tr>
                                    @endforeach
                                    </select>
                                </tbody>
                            </table>
                           &nbsp;&nbsp;<button type="submit" value="Update" name="action"
                                class="btn btn-success" onclick="return confirm('Are you sure?')">Update Data</button>
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
            rowReorder: true,
             columnDefs: [
            { orderable: true, className: 'reorder', targets: 1 },
            { orderable: true, className: 'reorder', targets: 6 },
            { orderable: false, targets: '_all' }
                    ]
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
    </script>
@endsection