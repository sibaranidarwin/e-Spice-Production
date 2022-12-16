@extends('vendor.layouts.sidebar')
@section('content')
<script src="{{asset('assets/ckeditor/adapters/jquery.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/upload.css')}}">
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                            <h1>Dashboard</h1>
                        <!-- <h1>Data Purchase Order</h1> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Invoice Proposal</a></li>
                            <li class="active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{route('upload')}}" enctype="multipart/form-data" class="form-horizontal" role="form">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="form-group">
                    <div class="preview-zone hidden">
                        <div class="box box-solid">
                            <div class=" with-border">
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body"></div>
                        </div>
                    </div>
                    <div class="dropzone-wrapper">
                        <div class="dropzone-desc">
                            <i class="fa fa-download"></i>
                            <p>Choose an image file or drag it here.</p>
                        </div>
                        <input type="file" name="image" class="dropzone">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">Upload</button>
            </div>
            <div style="margin-top:10px" class="form-group">
                <!-- Button -->

                {{-- <div class="col-md-12">
                    <label>Result:</label> --}}

                    {{-- @if(Session::has('text'))
                    {{Session::get('text')}}
                    @endif --}}

                {{-- </div> --}}
            </div>
        </div>
    </div>
    <div class="content">
        {{-- <div class="animated fadeIn"> --}}
            <div class="row">
                <div class="col">
                    <div class="card  shadow h-100">
                        <div class="card-header">
                            <strong class="card-header">Data Invoice Proposal</strong>
                        </div>
                        <div class="card-body">
                            <form autocomplete="off" action="{{ route('create-invoice') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label" for="total_harga_gross">Total DPP</label>
                                        <input type="text" class="form-control @error('total_harga_gross[]') is-invalid @enderror"
                                            name="total_harga_gross" 
                                            value=" @if(Session::has('text'))
                                            {{Session::get('text')}}
                                            @endif" readonly>
                                        @error('total_harga_gross[]')<span
                                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label" for="no_invoice_proposal">Invoice Number Proposal<span style="color: red">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('no_invoice_proposal') is-invalid @enderror"
                                            name="no_invoice_proposal"
                                            value="@if(Session::has('text'))
                                            {{Session::get('text')}}
                                            @endif" readonly>
                                        @error('no_invoice_proposal')<span
                                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label" for="tax_code">Tax Code</label>
                                        <input type="text" class="form-control @error('tax_code[]') is-invalid @enderror"
                                            name="tax_code"
                                            value="@if(Session::has('text'))
                                            {{Session::get('text')}}
                                            @endif" readonly>
                                        @error('tax_code[]')<span
                                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label" for="posting_date">Invoice Date <span style="color: red">*</span></label>
                                        <input  id="datefield" type='text' min='1899-01-01' max='2000-13-13'
                                            class="form-control @error('posting_date') is-invalid @enderror"
                                            name="posting_date"
                                            value="@if(Session::has('text'))
                                            {{Session::get('text')}}
                                            @endif" required readonly>
                                        @error('posting_date')<span
                                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label" for="ppn">Total PPN</label>
                                        <input type="text" class="form-control @error('ppn[]') is-invalid @enderror"
                                            name="ppn" value="@if(Session::has('text'))
                                            {{Session::get('text')}}
                                            @endif"
                                            readonly>
                                        @error('ppn[]')<span
                                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                    </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="vendor_invoice_number">Invoice Number<span style="color: red">*</span></label>
                                    <input type="text" 
                                        class="form-control @error('vendor_invoice_number') is-invalid @enderror"
                                        name="vendor_invoice_number" value="@if(Session::has('text'))
                                        {{Session::get('text')}}
                                        @endif" required readonly>
                                    @error('vendor_invoice_number')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                            <div class="form-group col-md-6">
                                <label class="form-control-label" for="faktur_pajak_number">VAT NO.<span style="color: red">*</span></label>
                                <input type="text" id="input_mask"
                                    class="form-control @error('faktur_pajak_number[]') is-invalid @enderror"
                                    name="faktur_pajak_number"
                                    value="@if(Session::has('text'))
                                    {{Session::get('text')}}
                                    @endif" required readonly>
                                @error('faktur_pajak_number[]')<span
                                    class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                            </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="del_costs">Price Difference</label> <br>
                                    <input type="text" id="id-3" class="form-control @error('del_costs[]') is-invalid @enderror"
                                        name="del_costs" value="@if(Session::has('text'))
                                        {{Session::get('text')}}
                                        @endif" readonly>
                                    @error('del_costs[]')<span
                                        class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                        </div>
                        <a href="javascript:history.back()" type="submit" class="btn btn-danger mb-2" id="simpan" onclick="return confirm('Are you sure?')">Return</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-success mb-2" id="simpan" onclick="return confirm('Are you sure?')">Submit</button>
                    </div>
                    </div>
        </form>
<script type="text/javascript">
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var htmlPreview =
                '<img width="200" src="' + e.target.result + '" />' +
                '<p>' + input.files[0].name + '</p>';
            var wrapperZone = $(input).parent();
            var previewZone = $(input).parent().parent().find('.preview-zone');
            var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

            wrapperZone.removeClass('dragover');
            previewZone.removeClass('hidden');
            boxZone.empty();
            boxZone.append(htmlPreview);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}
$(".dropzone").change(function() {
    readFile(this);
});
$('.dropzone-wrapper').on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
});
$('.dropzone-wrapper').on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
});
$('.remove-preview').on('click', function() {
    var boxZone = $(this).parents('.preview-zone').find('.box-body');
    var previewZone = $(this).parents('.preview-zone');
    var dropzone = $(this).parents('.form-group').find('.dropzone');
    boxZone.empty();
    previewZone.addClass('hidden');
    reset(dropzone);
});
</script>
@endsection