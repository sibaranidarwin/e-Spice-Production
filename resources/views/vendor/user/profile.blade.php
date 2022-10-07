@extends('vendor.layouts.sidebar')
@section('content')
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
                            <li><a href="#">User</a></li>
                            <li class="active">Edit Profile</li>
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
                    <div class="col-md-6 offset-3"><br>
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Profile Card</strong>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('user.update', $user->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block" id="profile-img-tag" width="80px"
                                            height="80px" src="{{asset('upload/'. $user->foto)}}" alt="Harus Persegi">
                                        <div class="mx-auto text-center">
                                            <label for="profile-img" class="mx-auto d-block"><i
                                                    class="btn fa fa-camera"></i></label>
                                        </div>
                                        <input type="file" name="foto" id="profile-img" hidden="">
                                        <h5 class="text-sm-center mt-2 mb-1 font-weight-bold">{{$user->name}}</h5>
                                        <h5 class="text-sm-center mt-2 mb-1">{{$user->email}}</h5>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <a href="#"><i class="fa fa-facebook pr-1"></i></a>
                                        <a href="#"><i class="fa fa-twitter pr-1"></i></a>
                                        <a href="#"><i class="fa fa-linkedin pr-1"></i></a>
                                        <a href="#"><i class="fa fa-pinterest pr-1"></i></a>
                                    </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" autocomplete="off" value="{{$user->name}}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$user->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" value="{{$user->password}}" disabled="">
                                    <input type="hidden" name="fotoLama" value="{{$user->foto}}">

                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Are you sure?')">UPDATE</button>
                                </div>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
</div><!-- /#right-panel -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#profile-img-tag').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#profile-img").change(function() {
    readURL(this);
});
</script>
@endsection