@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="1";
$patient_menu="0";
$profile_menu="0";
?>
@section('content')
<div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')
    <!-- /.sidebar -->

    <!-- Start right Content here -->

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

                    <div class="row">


                        @foreach($dashboardDetails['appointmentCategory'] as $appointmentCategory)
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <a href="{{URL::to('/')}}/fronthospital/rest/{{Auth::user()->id}}/patients/appointments?appointmentCategory={{$appointmentCategory->appointment_category}}">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-purple m-t-10 font-light">{{$appointmentCategory->appointment_category}} Appointments</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-warning font-light">
                                        <i class="fa fa-stethoscope"></i>
                                        {{$appointmentCategory->noAppointments}}
                                    </h2>
                                </div>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div class="row">


                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Total Amount</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>{{$dashboardDetails['totalAmountCollected'][0]->totalAmount}}</b></h4>
                                            <p class="text-muted m-b-0">INR</p>
                                        </li>

                                    </ul>

                                    <div id="morris-donut-example" style="height: 300px;display:none;"><svg height="300" version="1.1" width="303" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#dcdcdc" d="M151.5,243.33333333333331A93.33333333333333,93.33333333333333,0,0,0,239.72775519497708,180.44625304313007" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#dcdcdc" stroke="#ffffff" d="M151.5,246.33333333333331A96.33333333333333,96.33333333333333,0,0,0,242.56364732624417,181.4248826052307L279.1151459070204,194.03833029452744A135,135,0,0,1,151.5,285Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#7578f9" d="M239.72775519497708,180.44625304313007A93.33333333333333,93.33333333333333,0,0,0,67.78484627831412,108.73398312817662" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#7578f9" stroke="#ffffff" d="M242.56364732624417,181.4248826052307A96.33333333333333,96.33333333333333,0,0,0,65.09400205154564,107.40757544301087L25.927269417471166,88.10097469226493A140,140,0,0,1,283.8416327924656,195.6693795646951Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#5cb45b" d="M67.78484627831412,108.73398312817662A93.33333333333333,93.33333333333333,0,0,0,151.47067846904883,243.333328727518" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#5cb45b" stroke="#ffffff" d="M65.09400205154564,107.40757544301087A96.33333333333333,96.33333333333333,0,0,0,151.46973599126827,246.3333285794739L151.4575884998742,284.9999933380171A135,135,0,0,1,30.412009795418626,90.31165416754118Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="151.5" y="140" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="15px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;" font-weight="800" transform="matrix(1.4579,0,0,1.4579,-69.368,-69.1426)" stroke-width="0.6859188988095237"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales</tspan></text><text x="151.5" y="160" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="14px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;" transform="matrix(1.9444,0,0,1.9444,-143.1719,-143.5556)" stroke-width="0.5142857142857143"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan></text></svg></div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- end row -->


                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div><!-- /.content -->
    @include('portal.hospital-footer')
    </div><!-- /.content-page -->

</div><!-- ./wrapper -->

</body>
</html>
