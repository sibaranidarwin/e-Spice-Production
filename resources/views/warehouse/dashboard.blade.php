@extends('warehouse.layouts.sidebar')
{{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> --}}
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@section('content')
<style>
    .close-icon {
  cursor: pointer;
}
</style>
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/> --}}

        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row mt-4">
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
                                    <div class="stat-icon dib flat-color-3">
                                        <i class='fa fa-file-pdf-o'></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-heading"><strong> Invoice From GR</strong></div>
                                            <div class="stat-text"><strong class="count">{{ $invoice}}</strong></div>
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
                                    <div class="stat-icon dib flat-color-6">
                                        <i class='fa fa-users'></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-heading"><strong> Vendor</strong></div>
                                            <div class="stat-text"><strong class="count">{{ $vendor}}</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                    <div class="card bg-light card-outline-danger text">
                        <span class="pull-right clickable close-icon text-right" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                        <div class="card-block text-white">
                          <blockquote class="card-blockquote text-white">
                            <p style="font-size: 14px;"><strong>&nbsp; Description: </strong></p>
                            <p style="font-size: 13px;"><strong>&nbsp; There are {{$not_ver}} document GR data that must be updated (this data can be verified/rejected) </strong></p>
                          </blockquote>
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


<script type="text/javascript">
  $('.close-icon').on('click',function() {
  $(this).closest('.card').fadeOut();
})

    </script>

@endsection