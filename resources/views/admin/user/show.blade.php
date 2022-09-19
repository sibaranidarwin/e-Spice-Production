@extends('admin.layouts.app')
@section('content')

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
                                    <li><a href="#">Profile</a></li>
                                    <li class="active">Admin</li>
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
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block" width="100px" src="{{asset('upload/'.$user->foto)}}" alt="Card image cap">
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
