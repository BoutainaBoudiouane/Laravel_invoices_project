@extends('layouts.master')
@section('title')
    لوحة التحكم - برنامج الفواتير
@stop
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بكم في برنامج إدارة الفواتير</h2>
                <br>
                <p class="mg-b-0">هنا حيث يمكنكم ادارة جميع فواتيركم</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white" style="font-size:17px;">اجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::sum('Total'), 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7" style="font-size:16px">{{ \App\Models\invoices::count() }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                               
                                <span class="text-white op-7"  style="font-size:16px;font-weight:bold">100%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white" style="font-size:17px;" >الفواتير الغير مدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h3 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 2)->sum('Total'), 2) }}

                                </h3>
                                <p class="mb-0 tx-12 text-white op-7"  style="font-size:16px">{{ \App\Models\invoices::where('Value_Status', 2)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                           
                                <span class="text-white op-7" style="font-size:16px;font-weight:bold">%

                                    @php
                                    $count_all= \App\Models\invoices::count();
                                    $count_invoices2 = \App\Models\invoices::where('Value_Status', 2)->count();

                                    if($count_invoices2 == 0){
                                       echo $count_invoices2 = 0;
                                    }
                                    else{
                                       echo round($count_invoices2 = $count_invoices2 / $count_all *100) ;
                                    }
                                    @endphp

                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white"  style="font-size:17px;">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 1)->sum('Total'), 2) }}

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7"  style="font-size:16px">
                                    {{ \App\Models\invoices::where('Value_Status', 1)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                        
                                <span class="text-white op-7" style="font-size:16px;font-weight:bold">%
                                    @php
                                        $count_all= \App\Models\invoices::count();
                                        $count_invoices1 = \App\Models\invoices::where('Value_Status', 1)->count();

                                        if($count_invoices1 == 0){
                                           echo $count_invoices1 = 0;
                                        }
                                        else{
                                           echo round($count_invoices1 = $count_invoices1 / $count_all *100);
                                        }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white"  style="font-size:17px;">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white" style="font-size:16px;">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 3)->sum('Total'), 2) }}

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7"  style="font-size:16px">
                                    {{ \App\Models\invoices::where('Value_Status', 3)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                           
                                <span class="text-white op-7"style="font-size:16px;font-weight:bold">% 
                                    @php
                                        $count_all= \App\Models\invoices::count();
                                        $count_invoices1 = \App\Models\invoices::where('Value_Status', 1)->count();

                                        if($count_invoices1 == 0){
                                            echo $count_invoices1 = 0;
                                        }
                                        else{
                                          echo round($count_invoices1 = $count_invoices1 / $count_all *100);
                                        }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0"  style="font-size:17px;">نسبة احصائية الفواتير</h4>
                    </div>

                </div>
                <div class="card-body" style="width: 70%">
                    {!! $chartjs->render() !!}

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xl-5">
            <div class="card card-dashboard-map-one">
                <label class="main-content-label"  style="font-size:17px;">نسبة احصائية الفواتير</label>
                <div class="" style="width: 100%">
                    {!! $chartjs_2->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
