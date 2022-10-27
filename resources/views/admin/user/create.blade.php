@extends('admin.layouts.app')
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
                                <form class="form-horizontal" method="POST" action="{{ route('create-user') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block" id="profile-img-tag" width="80px"
                                            height="80px" src="{{asset('upload/'. auth()->user()->foto)}}"
                                            alt="Harus Persegi">
                                        <div class="mx-auto text-center">
                                            {{--  <label for="profile-img" class="mx-auto d-block"><i class="btn fa fa-camera"></i></label> --}}
                                        </div>

                                        <h5 class="text-sm-center mt-2 mb-1 font-weight-bold">Username</h5>
                                        <h5 class="text-sm-center mt-2 mb-1">email@email.com</h5>
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
                                    <label for="">Name <span style="color: red">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="off"
                                        required="" class="form-control">
                                    <input type="text" name="foto" value="avatar.png" hidden="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="id_vendor">Vendor ID </label>
                                    <select name="id_vendor" id="id_vendor" class="form-control">
                                        <option disabled selected>Pilih Nomor Vendor</option>
                                        @foreach ($vendor as $id_vendor)
                                            <option value="{{ $id_vendor['id_vendor'] }}">{{ $id_vendor['id_vendor'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_vendor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Email <span style="color: red">*</span></label>
                                    <input type="text" id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Password <span style="color: red">*</span></label>
                                    <input type="password" required=""
                                        class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Password Confirmation <span style="color: red">*</span></label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Level <span style="color: red">*</span></label>
                                    <select name="level" required="" id="" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="warehouse">Warehouse</option>
                                        <option value="accounting">Accounting</option>
                                        <option value="procument">Procument</option>
                                        <option value="vendor">Vendor</option>

                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" onclick="return confirm('Are You Sure?')"
                                        class="btn btn-primary">
                                        {{ __('Register') }}
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
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>
</div><!-- /#right-panel -->

@endsection