<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

@extends('accounting.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">

@if ($month != null )
<p style="text-align: center; background-color: #11CDEF; color: white;"><strong class="card-title">Vendor Name: {{ ($vendor_name1) }} || Month : {{ ($month) }} || Year : {{ ($yer) }}</strong></p>
@endif
<div style="float: right;">
    <form action="{{ route('accounting-filterdash') }}" class="form-inline" method="GET">
            <select class="form-control form-control-sm form-select col-4" name="vendor">
                <option selected>Choose Vendor Name</option>
                    @foreach ($vendor_name as $vendor_name)
                        <option value="{{ $vendor_name['vendor_name'] }}">{{ $vendor_name['vendor_name'] }}</option>
                    @endforeach
            </select> &nbsp;
    <select class="form-control form-control-sm col-5-half" name="month">
        <option value="">Choose Month</option>
                <option value='1'>January</option>
                <option value="2">February</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">December</option>
    </select>
    &nbsp;
    <select class="form-control form-control-sm col-4-half" name="yer">
        <option value="">Choose Year</option>
        <option value='2018'>2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
        <option value="2027">2027</option>
        <option value="2028">2028</option>
        <option value="2029">2029</option>       
    </select>
    &nbsp;
    <button class="btn btn-light btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-search"></i></button>
    </form>
    </div>
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
                                            <div class="stat-text"><h5>Total Value: {{ number_format($totalgr, 0,",",".") }}</h5></div>
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
                                            <div class="stat-text"><h5>Total Value: {{ number_format($totalinv, 0,",",".") }}</h5></div>
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
                                            <div class="stat-text"><h5>Total Value: {{ number_format($totalinvba, 0,",",".") }}</h5></div>
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
                </div>
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                        <div id="jumlah"></div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                        <div id="onetime"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script>
   Highcharts.setOptions({
        lang: {
          thousandsSep: ' '
        },
        colors: [ '#779bd9','#2750a8']
      })
      Highcharts.chart('jumlah', {
          chart: {
              type: 'column',
              zoomType: 'y',
        },
          title: {
              text: 'Proposal Invoice by PT United Tractors'
          },
          xAxis: {
              categories: [
                  'January',
                  'February',
                  'Maret',
                  'April',
                  'May',
                  'June',
                  'July',
                  'Agustus',
                  'September',
                  'Oktober',
                  'November',
                  'December'
              ],
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Total Value Invoice Proposal'
              }
          },
          tooltip: {
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
              },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0,
                  dataLabels: {
                                enabled: true,
                                format: '{point.y:,.0f}'
                            }
              }
          },
          series: [{
              name: 'Invoice From GR',
              data: [{!!json_encode($invgr)!!}],
      
          }, {
              name: 'Invoice From BA',
              data: [{!!json_encode($invba)!!}]
      
          }]
      });
    </script>
    <script>
      Highcharts.chart('onetime', {
          chart: {
              type: 'column',
              zoomType: 'y',
              //backgroundColor:"#FBFAE4"
          },
          title: {
              text: 'Proposal Invoice by Vendor One Time'
          },
          xAxis: {
              categories: [
                  'January',
                  'February',
                  'Maret',
                  'April',
                  'May',
                  'June',
                  'July',
                  'Agustus',
                  'September',
                  'Oktober',
                  'November',
                  'December'
              ],
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Total Value Invoice Proposal'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y}</b></td></tr>' + 'Count: <b>{point.count:,.1f}</b><br/>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0,
                  dataLabels: {
                                enabled: true,
                                format: '{point.y:,.0f}'
                            }
              }
          },
          series: [{
              name: 'Invoice From GR',
              data: [],
      
          }, {
              name: 'Invoice From BA',
              data: []
      
          }]
      });
      </script>
      <script>
          $(".form-select").select2();
        </script>
@endsection