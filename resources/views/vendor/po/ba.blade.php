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
    .table td,
    .table th {
        font-size: 11.4px;
    }
    </style>
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
                            <li><a href="#">Ba</a></li>
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
                        <strong class="card-header">Generate Draft BA From Data Good Receipt</strong>
                    </div>
                    <div class="card-body">
                        <table id="list" class="table table-striped" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th></th>
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
                                    <th hidden>Status Invoice Proposal</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 11px;">
                                @php $i = 1 @endphp
                                @foreach($good_receipts as $good_receipt)
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="{{$good_receipt->id_gr}}">
                                    </td>
                                    <td>{{$i++}}</td>
                                    <td>{{ $good_receipt->Status }}</td>
                                    <td><span>{{$good_receipt->GR_Number}}</span></td>
                                    <td><span>{{$good_receipt->no_po}}</span></td>
                                    <td><span>{{$good_receipt->po_item}}</span></td>
                                    <td><span>{{$good_receipt->GR_Date}}</span></td>
                                    <td> <span>{{$good_receipt->Material_Number}}</span></td>
                                    <td> <span>{{$good_receipt->Ref_Doc_No}}</span> </td>
                                    <td> <span>{{$good_receipt->Mat_Desc}}</span> </td>
                                    <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->UOM}}</span>
                                    </td>
                                    <td> <span>{{$good_receipt->Currency}}</span> </td>
                                    <td> <span>{{$good_receipt->harga_satuan}}</span> </td>
                                    <td> <span>{{$good_receipt->Tax_Code}}</span> </td>
                                    <td hidden><span>{{$good_receipt->status_invoice}}</span></td>
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
    var minDate, maxDate;
    
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
        $('#min, #max').on('change', function() {
            table.draw();
        });
    
    
    });
    
    </script>
@endsection