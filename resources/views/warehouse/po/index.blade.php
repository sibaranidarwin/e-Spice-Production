<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

@extends('warehouse.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

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
                    <div class="table-responsive text-nowrap">
                        <form action="{{ route('update-datagr/{id}') }}" method="POST">
                            @csrf
                        <table id="list" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>No</th>
                                    <th>GR Number</th>
                                    <th>No PO</th>
                                    <th>PO Item</th>
                                    <th>GR Slip Date</th>
                                    <th>Material Number</th>
                                    <th>Reference</th>
                                    {{-- <th>Vendor Part Number</th>
                                    <th>Item Description</th>
                                    <th>UoM</th>
                                    <th>Currency</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th> 
                                    <th>Jumlah Harga</th> 
                                    <th>Tax Code</th>
                                    <th>Valuation Type</th>  --}}
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
                                <td> <span>{{$good_receipt->no_po}}</span> </td>
                                <td> <span>{{$good_receipt->po_item}}</span> </td>
                                <td> <span>{{$good_receipt->GR_Date}}</span> </td>
                                <td> <span>{{$good_receipt->Material_Number}}</span></td>
                                <td> <span>{{$good_receipt->Ref_Doc_No}}</span> </td>
                                {{-- <td> <span>{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                <td> <span>{{$good_receipt->Mat_Desc}}</span> </td>
                                <td> <span>{{$good_receipt->UOM}}</span> </td>
                                <td> <span>{{$good_receipt->Currency}}</span> </td>
                                <td> <span>{{$good_receipt->harga_satuan}}</span> </td>
                                <td> <span>{{$good_receipt->jumlah}}</span> </td> 
                                <td> <span>{{$good_receipt->jumlah_harga}}</span> </td>
                                <td> <span>{{$good_receipt->Tax_Code}}</span> </td>
                                <td> <span></span> </td> --}}
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
                        &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" value="Upadate Data" class="btn btn-success">Update Data</button>
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
$(document).ready(function() {
    $('#list').DataTable({
        buttons: ['copy', 'csv', 'excel', 'print'],
        dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-6'i><'col-md-6'p>>",
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]
    });

});

$("#btn-mail").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
$("#head-cb").on('click',function(){
    var isChecked = $("#head-cb").prop('checked')
    $(".cb-child").prop('checked',isChecked)
    $("#button-nonaktif-all,#button-export-terpilih").prop('disabled',!isChecked)
    $("#button-aktif-all,#button-export-terpilih").prop('disabled',!isChecked)
  })
  $("#table tbody").on('click','.cb-child',function(){
    if($(this).prop('checked')!=true){
      $("#head-cb").prop('checked',false)
    }

    let semua_checkbox = $("#table tbody .cb-child:checked")
    let button_non_aktif_status = (semua_checkbox.length>0)
    let button_export_terpilih_status = button_non_aktif_status;
    $("#button-nonaktif-all,#button-export-terpilih").prop('disabled',!button_non_aktif_status)
    $("#button-aktif-all,#button-export-terpilih").prop('disabled',!button_non_aktif_status)
  })
function exportKaryawanTerpilih() {
    let checkbox_terpilih = $("#table tbody .cb-child:checked")
    let semua_id = []
    $.each(checkbox_terpilih,function(index,elm){
      semua_id.push(elm.value)
    })
    let ids = semua_id.join(',')
    $("#button-export-terpilih").prop('disabled',true)
    $("#form-export-terpilih [name='ids']").val(ids)
    $("#form-export-terpilih").submit()
    // $.ajax({
    //   url:"{{url('')}}/karyawan/export_terpilih",
    //   method:'POST',
    //   data:{ids:semua_id},
    //   success:function(res){
    //     console.log(res)
    //     $("#button-export-terpilih").prop('disabled',false)
    //   }
    // })
  }
</script>
@endsection