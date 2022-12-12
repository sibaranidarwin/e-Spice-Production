@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
    .table td, .table th {
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
                            <li><a href="#">Dispute Good Receipt List</a></li>
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
                        <strong class="card-header">Dispute Good Receipt</strong>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" action="{{ route('dispute_datagr') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($good_receipts as $good)
                            <input type="hidden" name="id[]" value="{{$good->id_gr}}">
                            @endforeach
                    <div class="form-group">
                        <label class="form-control-label" for="alasan_disp">Dispute Identification</label>
                        <textarea name="alasan_disp" class="form-control" placeholder="Please enter the reason for the dispute invoice" id="" cols="20" rows="5"></textarea>
                        @error('alasan_disp')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" name="action" value="Dispute" onclick="return confirm('Are you sure?')" class="btn btn-warning" id="simpan">Dispute</button>
                    <a href="{{url('vendor/purchaseorder')}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Return</a>
                    </form>
                    <br>
                    <strong class="card-header">Good Receipt Data to be Disputed</strong>
                    <table id="list" class="table table-stats order-table ov-h">
                        <thead>
                            <tr>
                                <th></th>
                                <th>PO</th>
                                <th>GR Number</th>
                                <th>GR Date</th>
                                <th>Part Number</th>
                                <th>Tax Code</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($good_receipts as $good_receipt)
                            <tr>
                            <td><input type="hidden" name="ids[]" value="{{$good_receipt->id}}"></td>      
                            <td> <span class="">{{$good_receipt->no_po}} /{{$good_receipt->po_item}}</span> </td>
                            <td><span class="name">{{$good_receipt->gr_number}}</span> </td>
                            <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span></td>
                            <td> <span class="">{{$good_receipt->material_number}} /{{$good_receipt->vendor_part_number}}</span>
                            <td> <span class="">{{$good_receipt->tax_code}}</span> </td>
                            <td>{{ $good_receipt->status }}</td>
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
@endsection