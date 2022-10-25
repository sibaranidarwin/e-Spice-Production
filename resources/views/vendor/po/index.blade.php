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

@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

<style>
    .table td, .table th,  label{
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
                        <strong class="card-title">Good Receipt Reject List</strong>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <div class="row">
                            <div class="col-4 bg-white mb-3">
                                <label for="">GR Date From : </label>
                                <input type="text" id="min" name="min"> 
                            </div> 
                            <div class="col-2 bg-white mb-4">
                                <label for="">To : </label>
                                <input type="text" id="max" name="max">
                            </div>
                            <div class="col-4">
                                <label for=""> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 bg-white mb-3">
                                <label for="">No PO From :  &nbsp;&nbsp;</label>
                                <input type="text" id="minpo" name="minpo"> 
                            </div> 
                            <div class="col-2 bg-white mb-4">
                                <label for="">To : </label>
                                <input type="text" id="maxpo" name="maxpo">
                            </div>
                            <div class="col-4">
                                <label for=""> </label>
                            </div>
                        </div>
                        <form action="{{ route('update-datagr-vendor/{id_gr}') }}" method="POST">
                            @csrf
                            <table id="list" class="table table-striped" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="checkAll(this)"></th>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>GR Number</th>
                                        <th>No PO</th>
                                        <th>PO Item</th>
                                        <th>GR Date</th>
                                        <th>Part Number</th>
                                        <th>Reference</th>
                                        <th>Material Description</th>
                                        <th>QTY UOM</th>
                                        <th>Curr</th>
                                        <th>Unit Price</th>
                                        <th>Tax Code</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                    @foreach($good_receipts as $good_receipt)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{$good_receipt->id_gr}}"></td>
                                        <td>{{++$i}}</td>
                                        <td >{{ $good_receipt->Status }}</td>
                                        <td ><span>{{$good_receipt->GR_Number}}</span></td>
                                        <td ><span>{{$good_receipt->no_po}}</span></td>
                                        <td><span>{{$good_receipt->po_item}}</span></td>
                                        <td><span>{{$good_receipt->GR_Date}}</span></td>
                                        <td> <span>{{$good_receipt->Material_Number}}</span></td>
                                        <td> <span>{{$good_receipt->Ref_Doc_No}}</span> </td>
                                        <td> <span>{{$good_receipt->Mat_Desc}}</span> </td>
                                        <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->UOM}}</span> </td>
                                        <td> <span>{{$good_receipt->Currency}}</span> </td>
                                        <td> <span>{{$good_receipt->harga_satuan}}</span> </td>
                                        <td> <span>{{$good_receipt->Tax_Code}}</span> </td>
                                    </tr>
                                    @endforeach
                                    </select>
                                </tbody>
                            </table>
                            &nbsp;&nbsp;<button type="submit" name="action" value="Dispute"
                            class="btn btn-warning btn-sm-3">Dispute</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="action" value="Update"
                            class="btn btn-success btn-sm-3">Create Invoice</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="action" value="ba"
                            class="btn btn-info btn-sm-3">Generate Draft BA</button>
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
    var minpo, maxpo;
    
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[6]);
    
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

    // $.fn.dataTable.ext.search.push(
    //     function(settings, data, dataIndex) {
    //         var minpo = minpo.val();
    //         var maxpo = maxpo.val();
    //         var date = new Date(data[5]);
    
    //         if (
    //             (minpo === null && maxpo === null) ||
    //             (minpo === null && date <= maxpo) ||
    //             (minpo <= date && max === null) ||
    //             (minpo <= date && date <= maxpo)
    //         ) {
    //             return true;
    //         }
    //         return false;
    //     }
    // );
    
    $(document).ready(function() {
    
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'DD MM YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'DD MM YYYY'
        });
        // DataTables initialisation
        var table = $('#list').DataTable({
            dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data'
            }]
        });
    
        // Refilter the table
        $('#min, #max, #minpo, #maxpo').on('change', function() {
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