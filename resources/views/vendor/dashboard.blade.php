@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
    #jumlah {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#datatable {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

#datatable caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

#datatable th {
    font-weight: 600;
    padding: 0.5em;
}

#datatable td,
#datatable th,
#datatable caption {
    padding: 0.5em;
}

#datatable thead tr,
#datatable tr:nth-child(even) {
    background: #f8f8f8;
}

#datatable tr:hover {
    background: #f1f7ff;
}

</style>
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
                            <select class="form-control form-control-sm form-select col-4 right" name="vendor">
                                <option value="">-- Choose Years -- </option>
                                        <option value="">2023</option>
                            </select>
                        <div id="jumlah"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                     <div id="year"></div>
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
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
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
          //backgroundColor:"#FBFAE4"
      },
      title: {
          text: 'Proposal Invoice Statisctic by Monthly'
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
              text: 'Total Invoice Proposal'
          }
      },
        plotOptions: {
        series: {
        borderWidth: 0,
    
        dataLabels: {
            enabled: true
        }
        },
    },
      tooltip: {
          headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      series: [{
          name: 'Invoice From GR',
          data: [{!!json_encode($invgr)!!}, 2, 3, 0, 5]
  
      }, {
          name: 'Invoice From BA',
          data: [{!!json_encode($invba)!!}, 6, 9, 1, 4]
  
      }]
  });
  </script>

<script>
    Highcharts.setOptions({
        lang: {
          thousandsSep: ' '
        },
        colors: [ '#779bd9','#2750a8']
      })
      Highcharts.chart('year', {
          chart: {
              type: 'column',
              zoomType: 'y',
              //backgroundColor:"#FBFAE4"
          },
          title: {
              text: 'Proposal Invoice Statisctic by Year'
          },
          xAxis: {
              categories: [
                  '2019',
                  '2020',
                  '2021',
                  '2022',
                  '2023',
              ],
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Total Invoice Proposal'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y}</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
              name: 'Invoice From GR',
              data: [41661561, 34419934, 33158027, 31209230, 23632635]
      
          }, {
              name: 'Invoice From BA',
              data: [40514123, 32340016, 32224529, 29456321, 22807464]
      
          }]
      });
      </script>

<script>

$('#myModal').on('shown.bs.modal', function () {
$('#myInput').trigger('focus')
})
</script>
@endsection