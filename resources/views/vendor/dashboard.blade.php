@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row mt-2">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="fa fa-file"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong> Good Receipt</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $good_receipt}}</strong></div>
                                    {{-- <div class="stat-heading">Good Receipt</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="fa fa-newspaper-o"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong>Draft BA</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $draft}}</strong></div>
                                    {{-- <div class="stat-heading">Good Receipt</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-5">
                                <i class="fa fa-newspaper-o"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong>BA Reconcile</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $ba}}</strong></div>
                                    {{-- <div class="stat-heading">Good Receipt</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class='fa fa-file-pdf-o'></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong> Invoice From GR</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $invoicegr}}</strong></div>
                                    {{-- <div class="stat-heading">Invoice</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class='fa fa-file-pdf-o'></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong> Invoice From BA</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $invoiceba}}</strong></div>
                                    {{-- <div class="stat-heading">Invoice</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-7">
                                <i class='fa fa-warning'></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong> Disputed</strong></div>
                                    <div class="stat-text"><strong class="count">{{ $dispute}}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div id="jumlah"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div id="gereja"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->
        <!--  Traffic  -->

        <!-- /#add-category -->
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>
<!-- Footer -->

<!-- /.site-footer -->
</div>
<!-- /#right-panel -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('jumlah', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Proposal Invoice Statisctic by Monthly'
    },
    series: [{
        data: [{
                name: 'January',
                y: {!!json_encode($good_receipts->where("status", "Verified")->count())!!}
            },
            {
                name: 'February',
                y: 40
            },
            {
                name: 'Maret',
                y: 40
            },
            {
                name: 'April',
                y: 40
            },
            {
                name: 'Mei',
                y: 40
            },
            {
                name: 'Juni',
                y: 40
            },
            {
                name: 'July',
                y: 40
            },
            {
                name: 'Agustus',
                y: 40
            },
            {
                name: 'September',
                y: 30
            }, {
                name: 'Oktober',
                y: 20
            }, {
                name: 'November',
                y: 5
            }, {
                name: 'Desember',
                y: 5
            }
        ]
    }]
});
</script>
<script>
Highcharts.chart('gereja', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Proposal Invoice Statisctic by Year'
    },
    series: [{
        data: [{
            name: '2020',
            y: 1777
        }, 
    ]
    }]
});
</script>

<script>

$('#myModal').on('shown.bs.modal', function () {
$('#myInput').trigger('focus')
})
</script>
@endsection