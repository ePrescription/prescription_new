@extends('layout.master-doctor-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <!-- DataTables -->
    {!!  Html::style(asset('theme/assets/plugins/datatables/jquery.dataTables.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/buttons.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/fixedHeader.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/responsive.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/dataTables.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/scroller.bootstrap.min.css')) !!}
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
$prescription_menu="0";
$lab_menu="0";
$profile_menu="0";
?>
@section('content')
<div class="wrapper">
    @include('portal.doctor-header')
    <!-- Left side column. contains the logo and sidebar -->
    <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.doctor-sidebar')
    <!-- /.sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Appointment Patients List</h4>

                </div>
            </div>

            <div class="page-content-wrapper ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">


<!--
                            <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addpatientwithappointment" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Appointment</b></button></a>
                           <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addpatient" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Create New Patient</b></button></a>
-->
                            <div class="panel panel-primary">
                                <div class="panel-body">

                                    <h4 class="m-b-30 m-t-0">Appointment Patients List</h4>

                                    @if (session()->has('message'))
                                        <div class="col_full login-title">
                                        <span style="color:red;">
                                            <b>{{session('message')}}</b>
                                        </span>
                                        </div>
                                    @endif

                                    @if (session()->has('success'))
                                        <div class="col_full login-title">
                                        <span style="color:green;">
                                            <b>{{session('success')}}</b>
                                        </span>
                                        </div>
                                    @endif
                                    <div>
                                        PID ( Patient Identification)
                                    </div>
                                    <div class="table-responsive">
                                    <table id="datatable" class="table table-responsive table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="display: none;">ID</th>
                                            <th>AppointmentID with Token Number</th>
                                            <th>Patient ID</th>
                                            <th>Patient Name</th>
                                            <th>Mobile No</th>
                                            <th>Appointment Date</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($patients as $patient)
                                            <tr>
                                                <td style="display: none;">{{$patient->id}}</td>
                                                <td>
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/details" title="View Profile"> {{$patient->appointment_id}}--{{$patient->token_id}} </a>
                                                </td>
                                                <td>{{$patient->pid}}</td>
                                                <td>{{$patient->name}}</td>
                                                <td>{{$patient->telephone}}</td>
                                                <td>{{$patient->appointment_date}} - {{$patient->appointment_time}}</td>
                                                <td>{{$patient->appointment_category}}</td>
                                                <td>


                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patient->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i> </a>



                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->


                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.content-wrapper -->

        </div><!-- ./content -->
    </div><!-- ./content-page -->
    @include('portal.doctor-footer')

</div><!-- ./wrapper -->


@endsection
@section('scripts')
    <!-- Datatables-->
    {!!  Html::script(asset('theme/assets/plugins/datatables/jquery.dataTables.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.bootstrap.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.buttons.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.bootstrap.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/jszip.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/pdfmake.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/vfs_fonts.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.html5.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.print.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.fixedHeader.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.keyTable.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.responsive.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/responsive.bootstrap.min.js')) !!}
    {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.scroller.min.js')) !!}

    <!-- Datatable init js -->
    {!!  Html::script(asset('theme/assets/pages/datatables.init.js')) !!}

    {!!  Html::script(asset('theme/assets/js/app.js')) !!}
@stop
