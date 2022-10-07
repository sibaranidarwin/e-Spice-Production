<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

@extends('admin.layouts.app')
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
                    <div class="table-stats order-table ov-h">
                        <table id="list" class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onchange="checkAll(this)"></th>
                                    <th class="serial">No</th>
                                    <th width="5px">GR Number</th>
                                    <th class="text-center">No PO</th>
                                    <th class="text-center">PO Item</th>
                                    <th class="text-center">GR Slip Date</th>
                                    <th class="text-center">Material Number</th>
                                    <!-- <th class="text-center">Reference</th> -->
                                    <!-- <th class="text-center">Vendor Part Number</th>
                                            <th class="text-center">Item Description</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center">Currency</th>
                                            <th class="text-center">Harga Satuan</th>
                                            <th class="text-center">Jumlah</th> -->
                                    <!-- <th class="text-center">Jumlah Harga</th> -->
                                    <th class="text-center">Tax Code</th>
                                    <!-- <th class="text-center">Valuation Type</th> -->
                                    <th width="501px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($good_receipts as $good_receipt)
                                <tr>
                                <td><input name="selector[]" type="checkbox" <?php echo $good_receipt ?>
                                        value="<?php echo $good_receipt['id']; ?>"></td>
                                        
                                <td class="serial">{{++$i}}</td>

                                <td><span class="name">{{$good_receipt->GR_Number}}</span> </td>
                                <td class="text-center"> <span class="">{{$good_receipt->id_gr}}</span> </td>
                                <td class="text-center"> <span class="">{{$good_receipt->po_item}}</span> </td>
                                <td class="text-center"> <span class="">{{$good_receipt->GR_Date}}</span> </td>
                                <td class="text-center"> <span class="">{{$good_receipt->Material_Number}}</span>
                                </td>
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                                <!-- <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td> -->
                                <td class="text-center"> <span class="">{{$good_receipt->Tax_Code}}</span> </td>
                                <!-- <td class="text-center"> <span class=""></span> </td> -->
                                <td class="text-center"><span>
                                            <button class="btn btn-light" onclick="showHide('section_1')"><i class="fa fa-eye"></i></button></td>
                                
                                            <!-- <a href=""  class="btn btn-primary fa fa-edit"></a> -->
                                        </form>
                                    </span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="col-md-1 mb-2"><a href=""
                                    class="btn btn-warning">Dispute</a></div>
                            <div class="col-md-9 mb-2"><a href="" class=""></a></div>
                            <div class="col-md-1 mb-2"><a href="" class="btn btn-success">Update</a></div>
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

function showHide(sID){
	var el = document.getElementById(sID);
	if(el) {
		el.style.display = (el.style.display === '') ? 'none' : '';
	}
}
</script>
@endsection