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
                            <li><a href="#">BA Reconcile</a></li>
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
                    <div class="card-header">
                        <strong class="card-title">Draft BA Reconcile List</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <form action="{{ route('exportdraftba') }}" method="POST">
                                @csrf
                                @foreach ($draft as $good)
                                <input type="hidden" name="id[]" value="{{$good->id_draft_ba}}">
                                @endforeach
                                <div class="row">
                                <div class="text-right mb-2 col-4">
                                    <a href="{{url('vendor/draft')}}" type="submit" style="text-align: right"
                                     class="btn btn-danger btn-s" id="simpan" onclick="return confirm('Are you sure?')"> Return</a> &nbsp;&nbsp;&nbsp;
                                     <button class="btn btn-success btn-s" onclick="return confirm('Are you sure?')"><i class="fa fa-cloud-download"></i> Export To excel</button>
                                    {{-- <a href="{{route('exportdraftba')}}" class="btn btn-success sm" onclick="return confirm('Are you sure?')"><i class="fa fa-cloud-download"></i>&nbsp; Export To Excel</a> --}}
                                </div>
                            </div>
                            <table id="list" class="table table-striped" style="width: 100%; font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onchange="checkAll(this)"></th>
                                        <th hidden></th>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Sts. Draft BA</th>
                                        <th style="text-align: center;">Sts. Inv. Props.</th>
                                        <th style="text-align: center;">No Draft BA</th>
                                        <th style="text-align: center;">Date</th>
                                        <th style="text-align: center;">PO</th>
                                        <th style="text-align: center;">Gr Number</th>
                                        <th style="text-align: center;">GR Date</th>
                                        <th style="text-align: center;">Part Number</th>
                                        <th style="text-align: center;">Mat. Desc.</th>
                                        <th style="text-align: center;">Qty UOM</th>
                                        <th style="text-align: center;">Header Text</th>
                                        <th style="text-align: center;">Curr</th>
                                        <th style="text-align: center;">Price</th>
                                        <th style="text-align: center;">Total Value</th>
                                        <th style="text-align: center;">Tax Code</th>
                                        <th style="text-align: center;">Ref.</th>
                                        <th style="text-align: center;">Del. Note</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                    @php $i = 1 @endphp
                                    @foreach($draft as $item)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{$item->id_draft_ba}}"></td>
                                        <td hidden><input type="text" name="no_draft" value="{{$item->no_draft}}"></td>
                                        <td>{{$i++}}</td>
                                        <td><span>Verified - Draft BA</span></td>
                                        <td><span>{{$item->status_invoice_proposal}}</span></td>
                                        <td><span>{{ $item->no_draft}}</span></td>
                                        <td><span>{{ Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span></td>
                                        <td><span>{{$item->po_number}} /{{$item->po_item}}</span></td>
                                        <td ><span>{{$item->gr_number}}</span></td>
                                        <td><span>{{ Carbon\Carbon::parse($item->gr_date)->format('d F Y') }}</span></td>
                                        <td><span>{{$item->material_number}} / {{$item->vendor_part_number}}</span></td>
                                        <td><span>{{$item->mat_desc}} <br>({{$item->valuation_type}})</span></td>
                                        <td><span>{{$item->doc_header_text}}</span></td>
                                        <td><span>{{$item->jumlah}}</span>&nbsp;<span>{{$item->uom}}</span></td>
                                        <td> <span>{{$item->currency}}</span> </td>
                                        <td style="text-align: right"><span>Rp{{ number_format($item->harga_satuan) }}</span></td>
                                        <td style="text-align: right"></span>Rp{{ number_format($item->jumlah_harga) }}<span></td>
                                        <td><span>{{$item->tax_code}}</td>
                                        <td> <span>{{$item->ref_doc_no}}</span> </td>
                                        <td><span>{{$item->delivery_note}}</span> </td>
                                    </tr>
                                    @endforeach
                                    </select>
                                </tbody>
                            </table>
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
<div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-lg">
      <form method="post" id="form-import" action="{{url('vendor/draft')}}" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Import Data Draft BA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{method_field('PUT')}}
          {{csrf_field()}}
          <div class="row">
            <div class="col-md-12">
              <p>Import data Draft BA sesuai format contoh berikut.<br/><a href="{{url('')}}/excel-karyawan.xlsx"><i class="fa fa-download"></i> File Contoh Draft BA</a></p>
            </div>
            <div class="col-md-12">
              <label>File Excel Draft BA</label>
              <input type="file" name="excel-draft" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
<script type="text/javascript">
var minDate, maxDate;

// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[2]);

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
        rowReorder: true,
             columnDefs: [
            { orderable: true, className: 'reorder', targets: 1 },
            { orderable: true, className: 'reorder', targets: 7 },
            { orderable: false, targets: '_all' }
                    ],
            lengthMenu: [[10, 25, 50, -1],[10, 25, 50, 'All'],],

    });

    // Refilter the table
    $('#min, #max').on('change', function() {
        table.draw();
    });


});

function checkAll(ele) {
      var checkboxes = document.getElementsByTagName('input');
      if (ele.checked) {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox' ) {
                  checkboxes[i].checked = true;
              }
          }
      } else {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = false;
              }
          }
      }
  }
</script>
@endsection 