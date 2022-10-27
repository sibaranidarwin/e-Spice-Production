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
                                <i class="fa fa-user"></i><strong class="card-title pl-3">Edit Password</strong>
                            </div>
                            <div class="card-body">
                                <form style="align-content: center;" method="POST"
                                    action="{{ route('update-pass-vendor', $user->id) }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                        <label for="new_password" class="col-md-4 control-label">Kata Sandi Lama</label>

                                        <div class="col-md-8">
                                            <input id="current_password" type="password" class="form-control"
                                                name="current_password" required>

                                            @if ($errors->has('current_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('current_password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        <label for="new_password" class="col-md-6 control-label">Kata Sandi Baru</label>

                                        <div class="col-md-8">
                                            <input id="new_password" type="password" class="form-control"
                                                name="new_password" required>

                                            @if ($errors->has('new_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirm" class="col-md-6 control-label">Konfirmasi Kata
                                            Sandi
                                            Baru</label>

                                        <div class="col-md-8">
                                            <input id="new_password_confirm" type="password" class="form-control"
                                                name="new_password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-4 center">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-primary">
                                                SAVE
                                            </button>
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