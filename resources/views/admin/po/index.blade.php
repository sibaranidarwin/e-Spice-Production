@extends('admin.layouts.app')
@section('content')

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
                                    <li><a href="#">Good Receipt</a></li>
                                    <li class="active">Tampilkan</li>
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
                                <strong class="card-title">Purchase Order List</strong>
                            </div>
                            <div class="table-stats order-table ov-h">
                                <table id="list" class="table">
                                    <thead>
                                        <tr>
                                            <th>Selection</th>
                                            <th class="serial">No</th>
                                            <th width="5px">GR Number</th>
                                            <th class="text-center">No PO</th>
                                            <th class="text-center">PO Item</th>
                                            <th class="text-center">GR Slip Date</th>
                                            <th class="text-center">Material Number</th>
                                            <th class="text-center">Reference</th>
                                            <!-- <th class="text-center">Vendor Part Number</th>
                                            <th class="text-center">Item Description</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center">Currency</th>
                                            <th class="text-center">Harga Satuan</th>
                                            <th class="text-center">Jumlah</th> -->
                                            <th class="text-center">Jumlah Harga</th>
                                            <th class="text-center">Tax Code</th>
                                            <th class="text-center">Valuation Type</th>
                                            <th width="501px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($good_receipts as $good_receipt)
                                        <tr>
                                            <td><input name="selector[]" type="checkbox" <?php echo $good_receipt ?> value="<?php echo $good_receipt['id']; ?>"></td>
                                            <td class="serial">{{++$i}}</td>
                                            <td><span class="name">{{$good_receipt->GR_Number}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->id_gr}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->po_item}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->GR_Date}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Material_Number}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td>
                                            <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                                            <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td>
                                            <td class="text-center"> <span class="">{{$good_receipt->Tax_Code}}</span> </td>
                                            <td class="text-center"> <span class=""></span> </td>
                                            <td class="text-center"><span >
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger fa fa-times" onclick="return confirm('Are you sure?')"></button>
                                                <a href="" class="btn fa fa-eye"></a>
                                                <a href=""  class="btn btn-primary fa fa-edit"></a>
                                            </form>
                                            </span></td>
                                        </tr>
                                        @endforeach  
                                    </tbody>
                                </table>
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
                Copyright &copy; 2018 Ela Admin
            </div>
            <div class="col-sm-6 text-right">
                Designed by <a href="https://colorlib.com">Colorlib</a>
            </div>
        </div>
    </div>
</footer>

</div><!-- /#right-panel -->

<script>
        $(document).ready(function() {
            $('#list').DataTable({
                "order": [
                    [1, "desc"]
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ Data Keluarga per halaman",
                    "zeroRecords": "Maaf, tidak dapat menemukan apapun",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada Keluarga yang dapat ditampilkan",
                    "infoFiltered": "(dari _MAX_ total keluarga)",
                    "search": "Cari :",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "",
                        "previous": ""
                    },
                }
            });
        });
    </script>
@endsection