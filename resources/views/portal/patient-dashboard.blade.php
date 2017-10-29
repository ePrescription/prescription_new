@extends('layout.master-patient-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="1";
$prescription_menu="0";
$lab_menu="0";
$patient_menu="0";
$profile_menu="0";
?>

@section('content')
<div class="wrapper">
    @include('portal.patient-header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('portal.patient-sidebar')
    <!-- /.sidebar -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="">
                <div class="page-header-title">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row hidden">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Total Subscription</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-warning font-light"><i class="mdi mdi-arrow-down-bold-circle-outline m-r-10"></i>89,52,125</h2>
                                    <p class=" m-b-0 m-t-20 text-muted"><b>48%</b> From Last 24 Hours</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Unique Visitors</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-success font-light"><i class="mdi mdi-arrow-up-bold-circle-outline m-r-10"></i>4,52,564</h2>
                                    <p class="text-muted m-b-0 m-t-20"><b>22%</b> From Last 24 Hours</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Order Status</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-purple font-light"><i class="mdi mdi-arrow-up-bold-circle-outline m-r-10"></i>65,21,542</h2>
                                    <p class="m-b-0 m-t-20 text-muted"><b>42%</b> Orders in Last 10 months</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Monthly Earnings</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-pink font-light"><i class="mdi mdi-arrow-down-bold-circle-outline m-r-10"></i>56,21,256</h2>
                                    <p class="text-muted m-b-0 m-t-20"><b>35%</b> From Last 1 Month</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden">

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Monthly Earnings</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3654</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>954</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>8462</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-donut-example" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Revenue</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>5248</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>321</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>964</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-bar-example" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Email Sent</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3652</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>5421</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>9652</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-area-example" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->



                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        @include('portal.patient-footer')

    </div>
    <!-- End Right content here -->


</div><!-- ./wrapper -->

@endsection
