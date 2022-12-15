<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

@extends('vendor.layouts.sidebar')
@section('content')
<script src="{{asset('assets/ckeditor/adapters/jquery.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/upload.css')}}">

<form method="post" action="{{route('upload')}}" enctype="multipart/form-data" class="form-horizontal" role="form">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="preview-zone hidden">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <div class="card-header">
                                    <strong class="card-title">Upload File</strong>
                                </div>
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

                <div class="col-md-12">
                    <label>Result:</label>

                    @if(Session::has('text'))
                    {{Session::get('text')}}
                    @endif

                </div>
            </div>
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