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
.table th,
label {
    font-size: 11.7px;
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
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header">
                        <strong class="card-title">BA Reconcile List</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <div class="row">
                                <div class="form-group col-3 bg-white mb-2">
                                    <label for="">BA Date:</label>
                                    <input class="form-group" type="text" id="min" name="min">
                                </div>To:
                                <div class=" form-group col-3 bg-white mb-2">
                                    <label for=""></label>
                                    <input class="form-group" type="text" id="max" name="max">
                                </div>
                                <div class="col-3 mb-2">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-import"><i class="fa fa-plus"></i> Import Data BA</button>
                                </div>
                            </div>
                            <form action="{{ route('update-ba-vendor/{id_gr}') }}" method="POST">
                                @csrf
                                <table id="list" class="table table-striped" style="font-size: 10px;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" onchange="checkAll(this)"></th>
                                            <th>No</th>
                                            <th>No BA</th>
                                            <th>Date</th>
                                            <th>No PO</th>
                                            <th>PO MKP</th>
                                            <th>Material</th>
                                            <th>Status BA</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 11px;">
                                        @php $i = 1 @endphp
                                        @foreach($ba as $item)
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="{{$item->id_ba}}"></td>
                                            <td>{{$i++}}</td>
                                            <td>{{ $item->no_ba}}</td>
                                            <td><span>{{$item->gr_date}}</span></td>
                                            <td><span>{{$item->po_number}}</span></td>
                                            <td><span>{{$item->po_mkp}}</span></td>
                                            <td><span>{{$item->material_bp}}</span></td>
                                            <td><span>{{$item->status_ba}}</span></td>
                                        </tr>
                                        @endforeach
                                        </select>
                                    </tbody>
                                </table>
                                {{-- &nbsp;&nbsp;<button type="submit" name="action" value="Dispute"
                                    class="btn btn-warning btn-sm-3">Dispute</button> --}}
                                    &nbsp;&nbsp;<button type="submit" name="action" value="Update"
                                    class="btn btn-success btn-sm-3" onclick="return confirm('Are you sure?')">Create Invoice</button>
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
          <h4 class="modal-title">Import Data BA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{method_field('PUT')}}
          {{csrf_field()}}
          <div class="row">
            <div class="col-md-12">
              <p>Import data BA sesuai format contoh berikut.<br/><a href="{{url('')}}/vendor-ba.xlsx"><i class="fa fa-download"></i> File Contoh BA</a></p>
            </div>
            <div class="col-md-12">
              <label>File Excel BA</label>
              <input type="file" name="excel-vendor-ba" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="return confirm('Are you sure?')">Tutup</button>
          <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Simpan</button>
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
        var date = new Date(data[3]);

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
    var table = $('#list').DataTable();

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