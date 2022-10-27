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
                            <li class="active">Semua Procumerent</li>
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
                    <div class="card-header">
                        <strong class="card-title">Semua Procumerent</strong>
                    </div>
                    <div class="table-stats order-table ov-h">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th class="">Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                @if($user->level == "procurement")
                                <tr>
                                    <td class="serial">{{++$i}}</td>
                                    <td class="">
                                        <div class="round-img">
                                            <a href="#"><img class="rounded-circle"
                                                    src="{{asset('upload/'.$user->foto)}}" alt=""></a>
                                        </div>
                                    </td>
                                    <td> <span class="name">{{$user->name}}</span> </td>
                                    <td class="text-lowercase">{{$user->email}} </td>
                                    <td class="text-center"> <span
                                            class="btn btn-warning font-weight-bold">Procumerent</span> </td>
                                    <td class="text-center"><span>
                                            <form action="{{route('user.destroy',$user->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger fa fa-times"
                                                    onclick="return confirm('Are you sure?')"></button>
                                                <a href="{{route('masyarakat.showing',$user->id)}}"
                                                    class="btn fa fa-eye"></a>
                                                <a href="{{route('masyarakat.edit',$user->id)}}"
                                                    class="btn btn-primary fa fa-edit"></a>
                                            </form>
                                        </span></td>
                                </tr>
                                @endif
                                @endforeach



                            </tbody>
                        </table>
                    </div> <!-- /.table-stats -->
                </div>
            </div>
        </div>
    </div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>


</div><!-- /#right-panel -->

@endsection