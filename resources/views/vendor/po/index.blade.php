<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

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
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header">
                        <strong class="card-title">Good Receipt List</strong>
                    </div>
                    <div class="table-stats order-table ov-h">
                        <div class="">
                            <div class="col-4 bg-white">
                                <label for="">Minimum date: </label>
                                <input type="text" id="min" name="min">
                            </div>
                            <div class="col-4 bg-white">
                                <label for="">Maximum date: </label>
                                <input type="text" id="max" name="max">
                            </div>
                            <div class="col-4">
                                <label for=""> </label>
                            </div>
                        </div>
                        <form action="{{ route('update-datagr-vendor/{id}') }}" method="POST">
                            @csrf
                        <table id="list" class="">
                            <thead>
                                <tr>
                                    <th>
                                       Select
                                    </th>
                                    <th class="serial">No</th>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($good_receipts as $good_receipt)
                                <tr>
                                <td><input type="checkbox" name="ids[]" value="{{$good_receipt->id}}"></td>      
                                <td class="serial">{{++$i}}</td>
                                <td><span class="name">{{$good_receipt->id}}</span> </td>
                                <td> <span class="">{{$good_receipt->no_po}}</span> </td>
                                <td> <span class="">{{$good_receipt->po_item}}</span> </td>
                                <td> <span class="">{{$good_receipt->GR_Date}}</span> </td>
                                <td> <span class="">{{$good_receipt->Material_Number}}</span>
                                </td>
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td> -->
                                <td> <span class="">{{$good_receipt->Tax_Code}}</span> </td>
                                <!-- <td class="text-center"> <span class=""></span> </td> -->
                                <td>{{ $good_receipt->Status }}</td>
                                <td><span>
                                            <button class="btn btn-light" onclick="showHide('section_1')"><i class="fa fa-eye"></i></button></td>
                                
                                            <!-- <a href=""  class="btn btn-primary fa fa-edit"></a> -->

                                    </span></td>
                                </tr>
                                @endforeach
                            </select>
                            </tbody>
                        </table>
                        {{-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('dispute-datagr-vendor/{id}') }}" class="btn btn-warning">Dispute</a>
                        <a href="" class="col-md-9 mb-2"></a> --}}
                        <button type="submit" name="action" value="Dispute"  class="btn btn-warning">Dispute</button>                      
                        <button type="submit" name="action" value="Update" class="btn btn-success">Update</button>
                    </form>
                       
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
         function( settings, data, dataIndex ) {
             var min = minDate.val();
             var max = maxDate.val();
             var date = new Date( data[5] );
      
             if (
                 ( min === null && max === null ) ||
                 ( min === null && date <= max ) ||
                 ( min <= date   && max === null ) ||
                 ( min <= date   && date <= max )
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
         var table = $('#list').DataTable();
      
         // Refilter the table
         $('#min, #max').on('change', function () {
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