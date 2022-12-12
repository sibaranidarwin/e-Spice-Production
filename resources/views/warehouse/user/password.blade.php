@extends('warehouse.layouts.sidebar')
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
                            <li class="active">Edit Password</li>
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
                    <div class="col-md-6 offset-3"><br>
                        <div class="card">
                            <div class="card-header" style="text-align: center;">
                                <i class="fa fa-user"></i><strong class="card-title pl-3">Setting Password</strong>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('update-vendor', $user->id) }}"
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
                                <form style="align-content: center;" method="POST"
                                    action="{{ route('update-pass-vendor', $user->id) }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                        <label for="" class="col-md-1 control-label"></label>
                                        <label for="new_password" class="col-md-4 control-label">Old Password</label>
                                        <div class="row">
                                        <div class="col-md-1">
                                            
                                        </div>
                                        <div class="col-md-10">
                                            <input id="current_password" type="password" class="form-control"
                                                name="current_password" placeholder="Enter Old Password" required>

                                            @if ($errors->has('current_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('current_password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        <label for="" class="col-md-1 control-label"></label>
                                        <label for="new_password" class="col-md-4 control-label">New password</label>
                                        <div class="row">
                                            <div class="col-md-1">
                                                
                                            </div>
                                        <div class="col-md-10">
                                            <input id="new_password" type="password" class="form-control"
                                                name="new_password" placeholder="Enter New Password" required>

                                            @if ($errors->has('new_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-md-1 control-label"></label>
                                        <label for="new_password_confirm" class="col-md-6 control-label">Confirm New Password</label>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    
                                                </div>
                                        <div class="col-md-10">
                                            <input id="new_password_confirm" type="password" class="form-control"
                                                name="new_password_confirmation" placeholder="Enter New Password"
                                                required>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                        <div class="col-md-5 col-md-offset-4">

                                        </div>
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-primary">
                                                SAVE
                                            </button>
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

    @endsection