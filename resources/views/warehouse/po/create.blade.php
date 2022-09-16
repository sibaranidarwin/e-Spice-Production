@extends('vendor.layouts.sidebar')
@section('content')

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
                                <li><a href="#">Purchase Order</a></li>
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
                <div class="col-lg-12">
                    <form action="{{route('po.store')}}" method="POST">
                        @csrf

                        <div class="card-header">
                            <strong class="card-title">Buat Purchase Order</strong>
                        </div><br>

                        <div class="row">
                            <div class="col">
                                <label for="">Nama Vendor</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Vendor"
                                    aria-label="First name">
                            </div>
                            <div class="col">
                                <label for="">Nomor Good Receipt</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nomor Good Receipt"
                                    aria-label="Last name">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <input type="text" name="nama" value="{{auth()->user()->name}}" hidden="">
                            <input type="text" name="level" value="{{auth()->user()->level}}" hidden="">

                            <button type="submit" class="btn btn-primary col-md-2 mt-4">Save</button>
                            <button type="Reset" class="btn btn-secondary col-md-2 mt-4">Reset</button>
                            <button type="button" class="btn btn-danger col-md-2 mt-4">Return</button>
                        </div>
                </div>
            </div>
            </form>
        </div>

    </div>
    </div>
    </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

    </div><!-- /#right-panel -->
    @endsection