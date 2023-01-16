<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>e-Spice - Vendor</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('admin/images/favicon.ico')}}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('admin/assets/css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="{{asset('admin/assets/ckeditor/ckeditor.js')}}"></script>


    <style>
    .menu_utama {
        display: inline-block;
        vertical-align: top;
        text-align: center;
        color: white;
        border: none;
        cursor: pointer;
    }

    .menu_sub {
        display: none;
        list-style-type: none;
    }

    .menu_sub a {
        display: block;

        color: white;
        text-decoration: none;
    }

    #menu_dropdown .menu_utama:hover>.menu_sub {
        display: block;
    }

    #weatherWidget .currentDesc {
        color: #ffffff !important;
    }

    .traffic-chart {
        min-height: 335px;
    }

    #flotPie1 {
        height: 150px;
    }

    #flotPie1 td {
        padding: 3px;
    }

    #flotPie1 table {
        top: 20px !important;
        right: -10px !important;
    }

    .chart-container {
        display: table;
        min-width: 270px;
        text-align: left;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    #flotLine5 {
        height: 105px;
    }

    #flotBarChart {
        height: 150px;
    }

    #cellPaiChart {
        height: 160px;
    }
    </style>

</head>

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="menu-title">DASHBOARD</li><!-- /.menu-title -->
                <li class="active">
                    <a href="{{url('vendor/dashboard')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                </li>

                <li class="menu-title">DATA GOOD RECEIPT</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Good Receipt</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-check"></i><a href="{{url('vendor/purchaseorder')}}">Verified</a></li>
                        <li><i class="fa fa-close"></i><a href="{{url('vendor/puchaseorderreject')}}">Rejected</a></li>
                </li>
            </ul>
            </li>


            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="menu-icon fa fa-newspaper-o"></i>BA Reconcile
                </a>

                <ul class="sub-menu children dropdown-menu" id="menu_dropdown">
                    <li class="menu-item-has-children dropdown menu_utama">
                        <a class="accordion-heading" data-toggle="collapse" data-target="#submenu2"><span class=""><i
                                    class="fa fa-newspaper-o"></i> Draft BA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ></span></a>
                        <ul class="nav nav-list collapse sub-menu children menu_sub" id="submenu2">
                            <li><a href="{{url('vendor/draft')}}" title="Title"><i class="fa fa-table"></i>Active</a>
                            </li>
                            <li><a href="{{url('vendor/historydraft')}}" title="Title"><i
                                        class="fa fa-history"></i>History</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown menu_utama">
                        <a class="accordion-heading" data-toggle="collapse" data-target="#submenu3"><span class=""><i
                                    class="fa fa-newspaper-o"></i>BA
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                ></span></a>
                        <ul class="nav nav-list collapse sub-menu children menu_sub" id="submenu3">
                            <li><a href="{{url('vendor/detailba')}}" title="Title"><i
                                        class="fa fa-table "></i>Active</a></li>
                            <li><a href="{{url('vendor/historyba')}}" title="Title"><i
                                        class="fa fa-history "></i>History</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="menu-icon fa fa-warning"></i>Disputed Invoice</a>
                <ul class="sub-menu children dropdown-menu ">
                    <li><i class="fa fa-table "></i><a href="{{url('vendor/disputed')}}">Show</a></li>
                </ul>
            </li>

            <li class="menu-title">DATA Invoice</li><!-- /.menu-title -->
            <li class="menu-item-has-children dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="menu-icon fa fa-file-pdf-o"></i>Invoice Proposal</a>
                <ul class="sub-menu children dropdown-menu ">
                    <li><i class="fa fa-table "></i><a href="{{url('vendor/invoice')}}">Invoice GR</a></li>
                    <li><i class="fa fa-table "></i><a href="{{url('vendor/invoiceba')}}">Invoice BA</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="menu-icon fa fa-file"></i>Invoice Document</a>
                <ul class="sub-menu children dropdown-menu ">
                    <li><i class="fa fa-upload"></i><a href="{{url('vendor/uploadinv')}}">Upload Invoice</a></li>
                    <li><i class="fa fa-upload"></i><a href="{{url('vendor/uploadtax')}}">Upload Tax Invoice</a></li>
                </ul>
            </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{url('vendor/dashboard')}}"><img style="width: 45%;"
                        src="{{asset('admin/images/logo.png')}}" alt="Logo"></a>

                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">

                <div class="user-area  float-right">
                    <a href="#" id="button_id" class="dropdown-toggle" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-bell"><span id="hide_me" class="count">{{($notif)}}</span></i></a>
                </div>

                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Launch demo modal
                  </button> --}}

                <div class="user-area dropdown float-right">

                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img class="user-avatar rounded-circle" src="{{asset('upload/'.auth()->user()->foto)}}"
                            alt="User Avatar">
                        &nbsp; {{ auth()->user()->name}}&nbsp;<i class="fa fa-caret-down"></i>
                    </a>
                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="{{route('vendor-user.show',auth()->user()->id)}}"><i
                                class="fa fa- user"></i>Profile</a>

                        <a class="nav-link" href="{{route('vendor-user.showing',auth()->user()->id)}}"><i
                                class="fa fa -cog"></i>Settings</a>

                        <a class="nav-link" href="{{ route('logout') }}" onclick="if (!confirm('Are you sure?')){return false;}else{event.preventDefault();
                                 document.getElementById('logout-form').submit();}">
                            <i class="fa "></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </header>
    <main class="py-2">
        @yield('content')
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;">Notifications!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>{{($notif)}} data disputed invoice today by vendor.</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="{{asset('admin/assets/js/init/weather-init.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="assets/js/init/fullcalendar-init.js"></script>
    <script>
    document.getElementById("button_id").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("hide_me").style.display = "none";
    });
    </script>
    </body>

</html>