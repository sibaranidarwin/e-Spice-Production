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
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">

<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
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
                            <li><a href="#">Invoice Proposal GR</a></li>
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
                        <strong class="card-title"><i class="fa fa-list"></i> Invoice Proposal GR List </strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            @if ($start_date != null || $end_date != null)
                            <p class="title" style="text-align: center; background-color: #11CDEF; color: white;"><strong class="card-title"></i>Invoice Date:{{ Carbon\Carbon::parse($start_date)->format('d F Y') }} To: {{ Carbon\Carbon::parse($end_date)->format('d F Y') }}</i></strong></p>
                            @endif
                            <form action="{{ route('vendor-filterinv') }}" class="form-inline" method="GET">
                                <div class="form-group col-md-3">
                                </div>
                                <div class="form-group ">
                                  <label for="" >Invoice Date: &nbsp;</label>
                                  <input type="date" class="form-control form-control-sm" name="start_date">
                                </div>
                                <div class="form-group mx-sm-3 ">
                                  <label for="inputPassword2">To: &nbsp;</label>
                                  <input type="date" class="form-control form-control-sm" name="end_date">
                                </div>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                              </form>
                            <form action="{{ route('update-datagr-vendor/{id_gr}') }}" method="POST">
                                @csrf
                                <table id="list" class="table table-striped" style="font-size: 10px;">
                                    <thead>
                                        <tr>
                                            <th class="serial">No</th>
                                            <th>Sts. Upload SAP</th>
                                            <th>Sts. Inv. Props.</th>
                                            <th>Invoice Proposal No</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Number Proposal</th>
                                            <th>VAT NO</th>
                                            <th>Curr</th>
                                            <th>Total PPN</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice as $item)
                                        <tr>
                                            <td class="serial">{{++$i}}</td>
                                            <td>{{$item['status']}}</td>
                                            <td>{{$item['status_invoice_proposal'] }}</td>
                                            <td>{{$item['no_invoice_proposal'] }}</td>
                                            <td><span>{{ Carbon\Carbon::parse($item['posting_date'])->format('d F Y') }}</span></td>
                                            <td>{{$item['vendor_invoice_number'] }}</td>
                                            <td>{{$item['faktur_pajak_number'] }}</td>
                                            <td>{{$item['currency'] }}</td>
                                            <td>{{$item['ppn']}}</td>
                                            <td>{{ number_format($item['total_harga_everify']) }}</td>
                                            <td>
                                                <a href="/vendor/detail-invoice/{{$item->id_inv}}"
                                                    class="btn btn-info btn-sm">Det.</a>
                                                <a href="/vendor/cetak_pdf/{{$item->id_inv}}"
                                                    class="btn btn-secondary btn-sm">Print</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                &nbsp;&nbsp;&nbsp;<a href="" class="btn btn-success mb-2">Upload SAP</a>
                                {{-- <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="col-md-1 mb-2"><a href=""
                                    class="btn btn-primary">Upload SAP</a></div>
                        </div> --}}
                            </form>
                        </div>
                    </div>
                </div> <!-- /.table-stats -->
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
            var date = new Date(data[4]);
    
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
            // {
            //     dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
            //         "<'row'<'col-md-12'tr>>" +
            //         "<'row'<'col-md-6'i><'col-md-6'p>>",
            //     buttons: [{
            //         extend: 'excelHtml5',
            //         autoFilter: true,
            //         sheetName: 'Exported data'
            //     }]
            // }
            rowReorder: true,
             columnDefs: [
            { orderable: true, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
                    ],
            lengthMenu: [[10, 25, 50, -1],[10, 25, 50, 'All'],],

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

function showHide(sID) {
    var el = document.getElementById(sID);
    if (el) {
        el.style.display = (el.style.display === '') ? 'none' : '';
    }
}
</script>
@endsection