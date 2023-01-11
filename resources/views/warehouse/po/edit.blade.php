@extends('warehouse.layouts.sidebar')
@section('content')

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
    .table td,
    .table th,
    label{
        font-size: 11px;
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
                            <li><a href="#">Edit Good Receipt</a></li>
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
                        <strong class="card-header">Edit Good Receipt</strong>
                    </div>
                    @if($message = Session::get('destroy'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-body">
                        <form autocomplete="off" action="{{ route('update-datagr') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($good_receipts as $good)
                            <input type="hidden" name="id[]" value="{{$good->id_gr}}">
                            @endforeach
                            
                            <label class="form-control-label" for="status">Status  <span style="color: red">*</span></label><br>
                            <div class="row col mb-3">
                            <input type="radio" id="chk" name="status" value="Verified" {{ $good->status == "Verified" ? 'selected' : '' }} onclick="show()">&nbsp; Verified &nbsp;&nbsp;
                            <input type="radio" id="chk" name="status" value="Rejected" {{ $good->status == "Rejected" ? 'selected' : '' }} onclick="show1()">&nbsp; Rejected
                            </div>

                            {{-- TODO: Remember this must can upload multiple file and save to db with format (fileone, filetwo, filethree) include the paht  --}}
                            <div class="form-group" id="hidden" style="display: none">
                                <label class="form-control-label" for="lampiran">Upload SPB</label><strong style=" font-size: 10px;"> *.pdf max = 5MB</strong>
                                <input type="file" name="lampiran[]" class="form-control" id="lampiran" multiple>
                            </div>

                            <div class="form-group" id="hidden1" style="display: none">
                                <label class="form-control-label" for="alasan_disp">Reject Identification</label>
                                <textarea name="alasan_reject" class="form-control"
                                    placeholder="Please enter the reason for the reject data GR" id="" cols="20"
                                    rows="5"></textarea>
                                @error('alasan_disp')<span
                                    class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                            </div>

                            <button type="submit" name="action" value="edit" class="btn btn-success"
                                id="simpan" onclick="return confirm('Are you sure?')">Save</button>
                            <a href="{{url('warehouse/po')}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Return</a>
                        </form>
                        <br>
                        <strong class="card-header">Good Receipt Data to be Edit</strong>
                        <table id="list" class="table table-stats order-table ov-h">
                            <thead>
                                <tr>
                                    <th>Sts. Gr.</th>
                                    <th>GR Number</th>
                                    <th>PO</th>
                                    <th>GR Date</th>
                                    <th>Part Number</th>
                                    <th>Mat. Desc.</th>
                                    <th>Tax Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($good_receipts as $good_receipt)
                                <tr>
                                    <td>Not Verified</td>
                                    <td><span class="name">{{$good_receipt->gr_number}}</span> </td>
                                    <td> <span class="">{{$good_receipt->no_po}} /{{$good_receipt->po_item}}</span> </td>
                                    <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span></td>
                                    <td> <span class="">{{$good_receipt->material_number}} /{{$good_receipt->vendor_part_number}}</span></td>
                                    <td> <span class="">{{$good_receipt->mat_desc}} ({{$good_receipt->valuation_type}})</span> </td>
                                    <td> <span class="">{{$good_receipt->tax_code}}</span> </td>
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
function hide() {
  document.getElementById('hidden').style.display ='none';
}
function show() {
  document.getElementById('hidden').style.display = 'block';
  document.getElementById('hidden1').style.display ='none';
 }
function show1() {
  document.getElementById('hidden1').style.display = 'block';
  document.getElementById('hidden').style.display ='none';
 }

function validateForm() {
  var checked = false;
  var elements = document.getElementsByName("tick");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].checked) {
      checked = true;
    }
  }
  if (!checked) {
    alert('You must select why you are attending!');
  }
  return checked;
}
</script>
@endsection