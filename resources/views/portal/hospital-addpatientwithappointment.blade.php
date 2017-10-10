@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
$profile_menu="0";
?>
<?php
        /*
$time_array=array(
        '00:00:00'=>'12:00 AM','00:15:00'=>'12:15 AM','00:30:00'=>'12:30 AM','00:45:00'=>'12:45 AM',
        '01:00:00'=>'01:00 AM','01:15:00'=>'01:15 AM','01:30:00'=>'01:30 AM','01:45:00'=>'01:45 AM',
        '02:00:00'=>'02:00 AM','02:15:00'=>'02:15 AM','02:30:00'=>'02:30 AM','02:45:00'=>'02:45 AM',
        '03:00:00'=>'03:00 AM','03:15:00'=>'03:15 AM','03:30:00'=>'03:30 AM','03:45:00'=>'03:45 AM',
        '04:00:00'=>'04:00 AM','04:15:00'=>'04:15 AM','04:30:00'=>'04:30 AM','04:45:00'=>'04:45 AM',
        '05:00:00'=>'05:00 AM','05:15:00'=>'05:15 AM','05:30:00'=>'05:30 AM','05:45:00'=>'05:45 AM',
        '06:00:00'=>'06:00 AM','06:15:00'=>'06:15 AM','06:30:00'=>'06:30 AM','06:45:00'=>'06:45 AM',
        '07:00:00'=>'07:00 AM','07:15:00'=>'07:15 AM','07:30:00'=>'07:30 AM','07:45:00'=>'07:45 AM',
        '08:00:00'=>'08:00 AM','08:15:00'=>'08:15 AM','08:30:00'=>'08:30 AM','08:45:00'=>'08:45 AM',
        '09:00:00'=>'09:00 AM','09:15:00'=>'09:15 AM','09:30:00'=>'09:30 AM','09:45:00'=>'09:45 AM',
        '10:00:00'=>'10:00 AM','10:15:00'=>'10:15 AM','10:30:00'=>'10:30 AM','10:45:00'=>'10:45 AM',
        '11:00:00'=>'11:00 AM','11:15:00'=>'11:15 AM','11:30:00'=>'11:30 AM','11:45:00'=>'11:45 AM',
        '12:00:00'=>'12:00 PM','12:15:00'=>'12:15 PM','12:30:00'=>'12:30 PM','12:45:00'=>'12:45 PM',
        '13:00:00'=>'01:00 PM','13:15:00'=>'01:15 PM','13:30:00'=>'01:30 PM','13:45:00'=>'01:45 PM',
        '14:00:00'=>'02:00 PM','14:15:00'=>'02:15 PM','14:30:00'=>'02:30 PM','14:45:00'=>'02:45 PM',
        '15:00:00'=>'03:00 PM','15:15:00'=>'03:15 PM','15:30:00'=>'03:30 PM','15:45:00'=>'03:45 PM',
        '16:00:00'=>'04:00 PM','16:15:00'=>'04:15 PM','16:30:00'=>'04:30 PM','16:45:00'=>'04:45 PM',
        '17:00:00'=>'05:00 PM','17:15:00'=>'05:15 PM','17:30:00'=>'05:30 PM','17:45:00'=>'05:45 PM',
        '18:00:00'=>'06:00 PM','18:15:00'=>'06:15 PM','18:30:00'=>'06:30 PM','18:45:00'=>'06:45 PM',
        '19:00:00'=>'07:00 PM','19:15:00'=>'07:15 PM','19:30:00'=>'07:30 PM','19:45:00'=>'07:45 PM',
        '20:00:00'=>'08:00 PM','20:15:00'=>'08:15 PM','20:30:00'=>'08:30 PM','20:45:00'=>'08:45 PM',
        '21:00:00'=>'09:00 PM','21:15:00'=>'09:15 PM','21:30:00'=>'09:30 PM','21:45:00'=>'09:45 PM',
        '22:00:00'=>'10:00 PM','22:15:00'=>'10:15 PM','22:30:00'=>'10:30 PM','22:45:00'=>'10:45 PM',
        '23:00:00'=>'11:00 PM','23:15:00'=>'11:15 PM','23:30:00'=>'11:30 PM','23:45:00'=>'11:45 PM',
);
        */
?>
<?php
$time_array=array(
        '00:00:00'=>'12:00 AM','00:05:00'=>'12:05 AM','00:10:00'=>'12:10 AM','00:15:00'=>'12:15 AM','00:20:00'=>'12:20 AM','00:25:00'=>'12:25 AM','00:30:00'=>'12:30 AM','00:35:00'=>'12:35 AM','00:40:00'=>'12:40 AM','00:45:00'=>'12:45 AM','00:50:00'=>'12:50 AM','00:55:00'=>'12:55 AM',
        '01:00:00'=>'01:00 AM','01:05:00'=>'01:05 AM','01:10:00'=>'01:10 AM','01:15:00'=>'01:15 AM','01:20:00'=>'01:20 AM','01:25:00'=>'01:25 AM','01:30:00'=>'01:30 AM','01:35:00'=>'01:35 AM','01:40:00'=>'01:40 AM','01:45:00'=>'01:45 AM','01:50:00'=>'01:50 AM','01:55:00'=>'01:55 AM',
        '02:00:00'=>'02:00 AM','02:05:00'=>'02:05 AM','02:10:00'=>'02:10 AM','02:15:00'=>'02:15 AM','02:20:00'=>'02:20 AM','02:25:00'=>'02:25 AM','02:30:00'=>'02:30 AM','02:35:00'=>'02:35 AM','02:40:00'=>'02:40 AM','02:45:00'=>'02:45 AM','02:50:00'=>'02:50 AM','02:55:00'=>'02:55 AM',
        '03:00:00'=>'03:00 AM','03:05:00'=>'03:05 AM','03:10:00'=>'03:10 AM','03:15:00'=>'03:15 AM','03:20:00'=>'03:20 AM','03:25:00'=>'03:25 AM','03:30:00'=>'03:30 AM','03:35:00'=>'03:35 AM','03:40:00'=>'03:40 AM','03:45:00'=>'03:45 AM','03:50:00'=>'03:50 AM','03:55:00'=>'03:55 AM',
        '04:00:00'=>'04:00 AM','04:05:00'=>'04:05 AM','04:10:00'=>'04:10 AM','04:15:00'=>'04:15 AM','04:20:00'=>'04:20 AM','04:25:00'=>'04:25 AM','04:30:00'=>'04:30 AM','04:35:00'=>'04:35 AM','04:40:00'=>'04:40 AM','04:45:00'=>'04:45 AM','04:50:00'=>'04:50 AM','04:55:00'=>'04:55 AM',
        '05:00:00'=>'05:00 AM','05:05:00'=>'05:05 AM','05:10:00'=>'05:10 AM','05:15:00'=>'05:15 AM','05:20:00'=>'05:20 AM','05:25:00'=>'05:25 AM','05:30:00'=>'05:30 AM','05:35:00'=>'05:35 AM','05:40:00'=>'05:40 AM','05:45:00'=>'05:45 AM','05:50:00'=>'05:50 AM','05:55:00'=>'05:55 AM',
        '06:00:00'=>'06:00 AM','06:05:00'=>'06:05 AM','06:10:00'=>'06:10 AM','06:15:00'=>'06:15 AM','06:20:00'=>'06:20 AM','06:25:00'=>'06:25 AM','06:30:00'=>'06:30 AM','06:35:00'=>'06:35 AM','06:40:00'=>'06:40 AM','06:45:00'=>'06:45 AM','06:50:00'=>'06:50 AM','06:55:00'=>'06:55 AM',
        '07:00:00'=>'07:00 AM','07:05:00'=>'07:05 AM','07:10:00'=>'07:10 AM','07:15:00'=>'07:15 AM','07:20:00'=>'07:20 AM','07:25:00'=>'07:25 AM','07:30:00'=>'07:30 AM','07:35:00'=>'07:35 AM','07:40:00'=>'07:40 AM','07:45:00'=>'07:45 AM','07:50:00'=>'07:50 AM','07:55:00'=>'07:55 AM',
        '08:00:00'=>'08:00 AM','08:05:00'=>'08:05 AM','08:10:00'=>'08:10 AM','08:15:00'=>'08:15 AM','08:20:00'=>'08:20 AM','08:25:00'=>'08:25 AM','08:30:00'=>'08:30 AM','08:35:00'=>'08:35 AM','08:40:00'=>'08:40 AM','08:45:00'=>'08:45 AM','08:50:00'=>'08:50 AM','08:55:00'=>'08:55 AM',
        '09:00:00'=>'09:00 AM','09:05:00'=>'09:05 AM','09:10:00'=>'09:10 AM','09:15:00'=>'09:15 AM','09:20:00'=>'09:20 AM','09:25:00'=>'09:25 AM','09:30:00'=>'09:30 AM','09:35:00'=>'09:35 AM','09:40:00'=>'09:40 AM','09:45:00'=>'09:45 AM','09:50:00'=>'09:50 AM','09:55:00'=>'09:55 AM',
        '10:00:00'=>'10:00 AM','10:05:00'=>'10:05 AM','10:10:00'=>'10:10 AM','10:15:00'=>'10:15 AM','10:20:00'=>'10:20 AM','10:25:00'=>'10:25 AM','10:30:00'=>'10:30 AM','10:35:00'=>'10:35 AM','10:40:00'=>'10:40 AM','10:45:00'=>'10:45 AM','10:50:00'=>'10:50 AM','10:55:00'=>'10:55 AM',
        '11:00:00'=>'11:00 AM','11:05:00'=>'11:05 AM','11:10:00'=>'11:10 AM','11:15:00'=>'11:15 AM','11:20:00'=>'11:20 AM','11:25:00'=>'11:25 AM','11:30:00'=>'11:30 AM','11:35:00'=>'11:35 AM','11:40:00'=>'11:40 AM','11:45:00'=>'11:45 AM','11:50:00'=>'11:50 AM','11:55:00'=>'11:55 AM',
        '12:00:00'=>'12:00 PM','12:05:00'=>'12:05 PM','12:10:00'=>'12:10 PM','12:15:00'=>'12:15 PM','12:20:00'=>'12:20 PM','12:25:00'=>'12:25 PM','12:30:00'=>'12:30 PM','12:35:00'=>'12:35 PM','12:40:00'=>'12:40 PM','12:45:00'=>'12:45 PM','12:50:00'=>'12:50 AM','12:55:00'=>'12:55 AM',
        '13:00:00'=>'01:00 PM','13:05:00'=>'01:05 PM','13:10:00'=>'01:10 PM','13:15:00'=>'01:15 PM','13:20:00'=>'01:20 PM','13:25:00'=>'01:25 PM','13:30:00'=>'01:30 PM','13:35:00'=>'01:35 PM','13:40:00'=>'01:40 PM','13:45:00'=>'01:45 PM','13:50:00'=>'01:50 PM','13:55:00'=>'01:55 PM',
        '14:00:00'=>'02:00 PM','14:05:00'=>'02:05 PM','14:10:00'=>'02:10 PM','14:15:00'=>'02:15 PM','14:20:00'=>'02:20 PM','14:25:00'=>'02:25 PM','14:30:00'=>'02:30 PM','14:35:00'=>'02:35 PM','14:40:00'=>'02:40 PM','14:45:00'=>'02:45 PM','14:50:00'=>'02:50 PM','14:55:00'=>'02:55 PM',
        '15:00:00'=>'03:00 PM','15:05:00'=>'03:05 PM','15:10:00'=>'03:10 PM','15:15:00'=>'03:15 PM','15:20:00'=>'03:20 PM','15:25:00'=>'03:25 PM','15:30:00'=>'03:30 PM','15:35:00'=>'03:35 PM','15:40:00'=>'03:40 PM','15:45:00'=>'03:45 PM','15:50:00'=>'03:50 PM','15:55:00'=>'03:55 PM',
        '16:00:00'=>'04:00 PM','16:05:00'=>'04:05 PM','16:10:00'=>'04:10 PM','16:15:00'=>'04:15 PM','16:20:00'=>'04:20 PM','16:25:00'=>'04:25 PM','16:30:00'=>'04:30 PM','16:35:00'=>'04:35 PM','16:40:00'=>'04:40 PM','16:45:00'=>'04:45 PM','16:50:00'=>'04:50 PM','16:55:00'=>'04:55 PM',
        '17:00:00'=>'05:00 PM','17:05:00'=>'05:05 PM','17:10:00'=>'05:10 PM','17:15:00'=>'05:15 PM','17:20:00'=>'05:20 PM','17:25:00'=>'05:25 PM','17:30:00'=>'05:30 PM','17:35:00'=>'05:35 PM','17:40:00'=>'05:40 PM','17:45:00'=>'05:45 PM','17:50:00'=>'05:50 PM','17:55:00'=>'05:55 PM',
        '18:00:00'=>'06:00 PM','18:05:00'=>'06:05 PM','18:10:00'=>'06:10 PM','18:15:00'=>'06:15 PM','18:20:00'=>'06:20 PM','18:25:00'=>'06:25 PM','18:30:00'=>'06:30 PM','18:35:00'=>'06:35 PM','18:40:00'=>'06:40 PM','18:45:00'=>'06:45 PM','18:50:00'=>'06:50 PM','18:55:00'=>'06:55 PM',
        '19:00:00'=>'07:00 PM','19:05:00'=>'07:05 PM','19:10:00'=>'07:10 PM','19:15:00'=>'07:15 PM','19:20:00'=>'07:20 PM','19:25:00'=>'07:25 PM','19:30:00'=>'07:30 PM','19:35:00'=>'07:35 PM','19:40:00'=>'07:40 PM','19:45:00'=>'07:45 PM','19:50:00'=>'07:50 PM','19:55:00'=>'07:55 PM',
        '20:00:00'=>'08:00 PM','20:05:00'=>'08:05 PM','20:10:00'=>'08:10 PM','20:15:00'=>'08:15 PM','20:20:00'=>'08:20 PM','20:25:00'=>'08:25 PM','20:30:00'=>'08:30 PM','20:35:00'=>'08:35 PM','20:40:00'=>'08:40 PM','20:45:00'=>'08:45 PM','20:50:00'=>'08:50 PM','20:55:00'=>'08:55 PM',
        '21:00:00'=>'09:00 PM','21:05:00'=>'09:05 PM','21:10:00'=>'09:10 PM','21:15:00'=>'09:15 PM','21:20:00'=>'09:20 PM','21:25:00'=>'09:25 PM','21:30:00'=>'09:30 PM','21:35:00'=>'09:35 PM','21:40:00'=>'09:40 PM','21:45:00'=>'09:45 PM','21:50:00'=>'09:50 PM','21:55:00'=>'09:55 PM',
        '22:00:00'=>'10:00 PM','22:05:00'=>'10:05 PM','22:10:00'=>'10:10 PM','22:15:00'=>'10:15 PM','22:20:00'=>'10:20 PM','22:25:00'=>'10:25 PM','22:30:00'=>'10:30 PM','22:35:00'=>'10:35 PM','22:40:00'=>'10:40 PM','22:45:00'=>'10:45 PM','22:50:00'=>'10:50 PM','22:55:00'=>'10:55 PM',
        '23:00:00'=>'11:00 PM','23:05:00'=>'11:05 PM','23:10:00'=>'11:10 PM','23:15:00'=>'11:15 PM','23:20:00'=>'11:20 PM','23:25:00'=>'11:25 PM','23:30:00'=>'11:30 PM','23:35:00'=>'11:35 PM','23:40:00'=>'11:40 PM','23:45:00'=>'11:45 PM','23:50:00'=>'11:50 PM','23:55:00'=>'11:55 PM',

);
?>
<style>
    span.red {color:red;margin:0 10px;}
</style>
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
                    <h4 class="page-title">New Patient Appointment</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0 m-b-30">New Patient Appointment</h4>
                                    <div style="float:right;"><button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back</button></div>



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



                                        <!-- The Modal -->
                                        <div id="myModal" class="modal">

                                            <!-- Modal content -->
                                            <div class="modal-content">
                                                <span class="close">&times;</span>
                                                <!-- form start -->
                                                <form action="{{URL::to('/')}}/fronthospital/rest/api/referraldoctor" role="form" id="referraldoctor" method="POST">
                                                    <div class="col-md-12">
                                                        <style>.control-label{line-height:32px;}</style>

                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-3 control-label">Doctor specialty</label>
                                                            <div class="col-sm-9">
                                                                <select name="specialtyId" class="form-control" required="required">
                                                                    <option value="">--CHOOSE--</option>
                                                                    @foreach($specialties as $specialty)
                                                                        <option value="{{$specialty->id}}">{{$specialty->specialty_name}}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-3 control-label">Doctor Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="doctorName" value="" required="required" />

                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-3 control-label">Hospital Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="hospitalName" value="" required="required" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-3 control-label">Hospital Location</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="location" value="" required="required" />
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-success" style="float:right;">Save Profile</button>
                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                            <!-- form start -->
                                        <form action="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/savepatientwithappointment" id="appointment" role="form" method="POST">
                                            <input type="hidden" name="hospitalId" value="{{Auth::user()->id}}" required="required" />
                                            <input type="hidden" name="patientId" id="patientId" value="0" required="required" />
                                            <div class="col-md-12">
                                                <style>.control-label{line-height:32px;}</style>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Patient Visiting <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" name="visiting" value="1" required="required" checked onclick="javascript:visitPatient(1);" />&nbsp;&nbsp;First time
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" name="visiting" value="2" required="required" onclick="javascript:visitPatient(2);" />&nbsp;&nbsp;Followup
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12" id="searchPatientBox" style="display:none;">
                                                    <label class="col-sm-3 control-label">Search Patient</label>
                                                    <div class="col-sm-9">
                                                        <!--
                                                        <input type="text" class="form-control" name="searchPatient" value="" id="autocomplete-ajax" />
                                                        -->

                                                        <select name="searchPatient" id="searchPatient" class="form-control patientUpdate" onchange="javascript:getPatient(this.value);">title="Select for a state" search><option></option></select>
                                                        <!--
                                                        <select name="searchPatient" id="searchPatient" class="form-control patientUpdate" onchange="javascript:getPatient(this.value);">
                                                            <option value="">--CHOOSE PATIENT--</option>
                                                            @foreach($patients as $patient)
                                                                <option value="{{$patient->patient_id}}" >{{$patient->pid}} - {{$patient->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <h4 class="m-t-0 m-b-30">Patient Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Name <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" pattern="[a-zA-Z\s]+" title="Please Enter Characters Onlky" class="form-control" id="name" name="name" value="" required="required" />
                                                        @if ($errors->has('name'))<p class="error" style="">{!!$errors->first('name')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Email <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="email" name="email" value="" required="required" />
                                                        @if ($errors->has('email'))<p class="error" style="">{!!$errors->first('email')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Mobile <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="number" min="0" class="form-control" id="telephone" name="telephone" value="" required="required" maxlength="10"/>
                                                        @if ($errors->has('telephone'))<p class="error" style="">{!!$errors->first('telephone')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Age <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="number" min="0" class="form-control" id="age" name="age" value="" required="required" />
                                                        @if ($errors->has('age'))<p class="error" style="">{!!$errors->first('age')!!}</p>@endif
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Gender <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" id="gender1" name="gender" value="1" required="required" />&nbsp;&nbsp;Male
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" id="gender2" name="gender" value="2" required="required" />&nbsp;&nbsp;Female
                                                        @if ($errors->has('gender'))<p class="error" style="">{!!$errors->first('gender')!!}</p>@endif
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Relationship</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="relationship" id="relationship">
                                                            <option value="" selected></option>
                                                            <option value="Brother">Brother</option>
                                                            <option value="Sister">Sister</option>
                                                            <option value="Husband">Husband</option>
                                                            <option value="Wife">Wife</option>
                                                            <option value="Father">Father</option>
                                                            <option value="Mother">Mother</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                        @if ($errors->has('relationship'))<p class="error" style="">{!!$errors->first('relationship')!!}</p>@endif
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Relation Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" id="spouseName" value="" />
                                                        @if ($errors->has('spouseName'))<p class="error" style="">{!!$errors->first('spouseName')!!}</p>@endif
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Address</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" id="address" name="address"></textarea>
                                                        @if ($errors->has('address'))<p class="error" style="">{!!$errors->first('address')!!}</p>@endif
                                                    </div>
                                                </div>


                                                <h4 class="m-t-0 m-b-30">Appointment Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Type <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select name="appointmentCategory" id="appointmentCategory" class="form-control" required="required" >
                                                            <option value="">--CHOOSE--</option>
                                                            <option value="Normal">Normal</option>
                                                            <option value="Special">Special</option>
                                                            <option value="Pregnancy">Pregnancy</option>
                                                        </select>
                                                        @if ($errors->has('appointmentCategory'))<p class="error" style="">{!!$errors->first('appointmentCategory')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor Name <span class="red">*</span></label>
                                                    <div class="col-sm-9">

                                                        <select name="doctorId" id="doctorId" class="form-control" required="required" >
                                                            <option value="">--CHOOSE--</option>
                                                            @foreach($doctors as $doctor)
                                                                <option value="{{$doctor->doctorId}}">{{$doctor->doctorName.' '.$doctor->doctorUniqueId}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('doctorId'))<p class="error" style="">{!!$errors->first('doctorId')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Date <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="appointmentDate" id="appointmentDate" value="" required="required" onchange="javascript:appointmentTypePatient(this.value); " />
                                                        @if ($errors->has('appointmentDate'))<p class="error" style="">{!!$errors->first('appointmentDate')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Time <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="appointmentTime" id="appointmentTime" required="required">

                                                            <option value=""> --:-- -- </option>
                                                            @foreach($time_array as $time_value)
                                                                <?php $key=array_keys($time_array,$time_value); ?>
                                                                <option value="{{$key[0]}}"> {{$time_value}} </option>
                                                            @endforeach

                                                        </select>
                                                        @if ($errors->has('appointmentTime'))<p class="error" style="">{!!$errors->first('appointmentTime')!!}</p>@endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Brief History <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="briefHistory" required="required"></textarea>
                                                        @if ($errors->has('briefHistory'))<p class="error" style="">{!!$errors->first('briefHistory')!!}</p>@endif
                                                    </div>
                                                </div>


                                                <h4 class="m-t-0 m-b-30">Referral Info</h4>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Referral Type <span class="red">*</span></label>
                                                    <div class="col-sm-9">

                                                        <div class="col-sm-9">
                                                            <input type="radio" class="form-controlx" name="referralType" value="1" required="required" checked onclick="javascript:referralTypePatient(1);" />&nbsp;&nbsp;Internal
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" class="form-controlx" name="referralType" value="2" required="required" onclick="javascript:referralTypePatient(2);" />&nbsp;&nbsp;External
                                                        </div>

                                                    </div>
                                                </div>

                                                <div id="referralTypeInfo" style="display:none;">
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor Specialization <span class="red">*</span></label>
                                                    <div class="col-sm-6">

                                                        <select name="referralSpecialty" id="referralSpecialty" class="form-control"  onchange="javascript:getDoctors(this.value);">
                                                            <option value="">--CHOOSE--</option>
                                                            @foreach($specialties as $specialty)
                                                                <option value="{{$specialty->id}}">{{$specialty->specialty_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <!-- Trigger/Open The Modal -->
                                                        <button type="button" id="myBtn">Add Referred Doctor</button>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Referred By <span class="red">*</span></label>
                                                    <div class="col-sm-9">


                                                        <select name="referralDoctor" id="referralDoctor" class="form-control" onchange="javascript:getDoctorInfo();">
                                                            <option value="">--CHOOSE--</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Hospital Name </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="referralHospital" id="referralHospital" value="" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Hospital Location </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="hospitalLocation" id="hospitalLocation" value="" readonly />
                                                    </div>
                                                </div>
                                                </div>

                                                <div id="paymentTypeInfo" style="display:block;">
                                                <h4 class="m-t-0 m-b-30">Payment Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Payment Type <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" id="payment1" name="paymentType" value="Cash" required="required" />&nbsp;&nbsp;Cash
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" id="payment2" name="paymentType" value="Card" required="required" />&nbsp;&nbsp;Card
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Amount <span class="red">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="number" min="0" class="form-control" id="fee" name="fee" value="" required="required" />
                                                    </div>
                                                </div>
                                                </div>


                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="box-footer">
                                                <input type="hidden" class="form-control" name="prev_appointment_date" id="prev_appointment_date" value="" />
                                                <button type="submit" class="btn btn-success" style="float:right;">Save & Book Appointment</button>
                                            </div>

                                        </form>


                                </div> <!-- panel-body -->
                            </div> <!-- panel -->
                        </div> <!-- col -->
                    </div> <!-- End row -->

                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        @include('portal.hospital-footer')

    </div>
    <!-- End Right content here -->


</div><!-- ./wrapper -->

@endsection



@section('scripts')


    {!!  Html::script(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.jquery.min.js')) !!}
    {!!  Html::script(asset('plugins/ajax-chosen/lib/ajax-chosen.js')) !!}

    {!!  Html::style(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.css')) !!}
    <style type="text/css">
        select#searchPatient { width: 300px; display: block; }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("select#searchPatient").ajaxChosen({
                type: 'GET',
                //url: '/vistara/ajax-chosen-master/data.json',
                ///url: '/treatin-web-app/public/ajaxGetCountry',
                url: '{{ URL::to('/') }}/fronthospital/rest/api/{{Auth::user()->id}}/patientnames',
                dataType: 'json'
            }, function (data) {
                var terms = {};
                console.log(data.result);
                $.each(data.result, function (i, val) {
                    terms[val.patientId] = val.name;
                });

                return terms;
            });
        });
    </script>

    <?php /* ?>
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/jquery.mockjax.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/src/jquery.autocomplete.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/countries.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/demo.js')) !!}
    <script>
        $('#autocomplete').autocomplete({
            serviceUrl: '{{ URL::to('/') }}/fronthospital/rest/api/{{Auth::user()->id}}/patientnames',
            onSelect: function (suggestion) {
                alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
            }
        });

    </script>
<?php */ ?>
    <script>
        function visitPatient(id)
        {
            if(id==1)
            {
                $("#searchPatientBox").hide();

                $('input#name').attr('readonly', false);
                $('input#email').attr('readonly', false);
                $('input#telephone').attr('readonly', false);
                $('input#age').attr('readonly', false);
                $('input#gender1').attr('disabled', false);
                $('input#gender2').attr('disabled', false);
                $('select#relationship').attr('disabled', false);
                $('input#spouseName').attr('disabled', false);
                $('textarea#address').attr('disabled', false);

            }
            else
            {
                $("#searchPatientBox").show();

                $('input#name').attr('readonly', true);
                $('input#email').attr('readonly', true);
                $('input#telephone').attr('readonly', true);
                $('input#age').attr('readonly', true);
                $('input#gender1').attr('disabled', true);
                $('input#gender2').attr('disabled', true);
                $('select#relationship').attr('disabled', true);
                $('input#spouseName').attr('disabled', true);
                $('textarea#address').attr('disabled', true);
            }
        }

        function getPatient(pid) {

            $("input#patientId").val(pid);
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/details';


            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    //alert(data.result[0].id);
                    console.log(data);
                    //$("#patienturinediv").html(data);
                    $("input#name").val(data.result[0].name);
                    $("input#email").val(data.result[0].email);
                    $("input#telephone").val(data.result[0].telephone);
                    $("input#age").val(data.result[0].age);

                    if(data.result[0].gender==1)
                    {
                        $("input#gender1").attr('checked', 'checked');
                    }
                    if(data.result[0].gender==2)
                    {
                        $("input#gender2").attr('checked', 'checked');
                    }

                    $("select#relationship").val(data.result[0].relationship);
                    $("input#spouseName").val(data.result[0].spouseName);
                    $("textarea#address").val(data.result[0].address);

                    $("input#prev_appointment_date").val(data.result[0].appointment_date);
                }
            });


        }


        function referralTypePatient(id)
        {
            if(id==1)
            {
                $("#referralTypeInfo").hide();

                $('select#referralSpecialty').attr('required', false);
                $('select#referralDoctor').attr('required', false);
                $('input#referralHospital').attr('required', false);
                $('input#hospitalLocation').attr('required', false);


            }
            else
            {
                $("#referralTypeInfo").show();

                $('select#referralSpecialty').attr('required', true);
                $('select#referralDoctor').attr('required', true);
                $('input#referralHospital').attr('required', true);
                $('input#hospitalLocation').attr('required', true);

            }
        }

        function getDoctors(sid) {

            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + sid + '/referraldoctors';

            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": sid, "status": status},
                success: function (data) {
                    var terms = '<option value="" data-doctor="" data-hospital="" data-location="">--Choose Doctor--</option>';
                    $.each(data.result, function (i, val) {
                        terms += '<option value="'+val.id+'" data-doctor="'+val.doctor_name+'" data-hospital="'+val.hospital_name+'" data-location="'+val.location+'">'+val.doctor_name+'</option>';
                    });
                    $("#referralDoctor").html(terms);

                }
            });


        }

        function getDoctorInfo()
        {
            var doctorName = $("#referralDoctor").find(':selected').attr('data-doctor');
            var hospitalName = $("#referralDoctor").find(':selected').attr('data-hospital');
            var locationName = $("#referralDoctor").find(':selected').attr('data-location');


            $('input#referralHospital').val(hospitalName);
            $('input#hospitalLocation').val(locationName);

        }


        function appointmentTypePatient(dateValue)
        {
            var new_appointment_date = dateValue;
            var prev_appointment_date = $("input#prev_appointment_date").val();

            var date1 = new Date(new_appointment_date);
            var date2 = new Date(prev_appointment_date);
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            //alert(diffDays);


            if(diffDays<=15)
            {
                $("#paymentTypeInfo").hide();

                $('input#payment1').attr('required', false);
                $('input#payment2').attr('required', false);
                $('input#fee').attr('required', false);

            }
            else
            {
                $("#paymentTypeInfo").show();

                $('input#payment1').attr('required', true);
                $('input#payment2').attr('required', true);
                $('input#fee').attr('required', true);

            }


            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/appointmenttimes';


            var d = new Date();
            var h = (d.getHours()<10?'0':'') + d.getHours();
            var m = (d.getMinutes()<10?'0':'') + d.getMinutes();
            var s = (d.getSeconds()<10?'0':'') + d.getSeconds();
            var t = h+":"+m+":"+s;
            var timeValue = h+":"+m;

            $.ajax({
                url: callurl,
                type: "get",
                data: {"date": dateValue, "time": timeValue, "status": status},
                success: function (data) {
                    console.log(data);
                    var terms = '<option value="">--Choose Time--</option>';
                    $.each(data.result, function (index, value) {
                        terms += '<option value="'+index+'">'+value+'</option>';
                    });
                    $("#appointmentTime").html(terms);

                }
            });


        }
    </script>



    <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
            height: 400px;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

    <script>
        // Wait for the DOM to be ready
        $(function() {

            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z\s]+$/i.test(value);
            });

            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form#appointment").validate({
                // Specify validation rules
                rules: {
                    // The key name on the left side is the name attribute
                    // of an input field. Validation rules are defined
                    // on the right side
                    role: "required",
                    name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        // Specify that email should be validated
                        // by the built-in "email" rule
                        email: true
                    },
                    telephone: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 11
                    },
                    age: {
                        required: true,
                        number: true,
                        minlength: 1,
                        maxlength: 3
                    },
                    appointmentDate: {
                        required: true
                    },
                    fee: {
                        number: true
                    }
                },
                // Specify validation error messages
                messages: {
                    role: "Please choose role",
                    name: {
                        required: "Please enter your name",
                        lettersonly: "Your name must be characters"
                    },
                    email: "Please enter a valid email address",
                    telephone: {
                        required: "Please provide a valid mobile number",
                        minlength: "Your mobile number must be 10 characters long",
                        maxlength: "Your mobile number must be 11 characters long"
                    },
                    age: "Please provide a valid age",
                    appointmentDate: "Please provide a valid Date",
                    fee: "Please provide a valid Amounr"
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        $("#telephone1").keyup(function() {
            var a = $("#telephone").val();
            var filter = /^[7-9][0-9]{9}$/;

            if (filter.test(a)) {
                return true;
                //alert("valid");
            }
            else {
                alert(a+"Please enter the mobile number starting with 7 or 8 or 9");
            }
        });


    </script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $( function() {
            $( "#appointmentDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
        } );
    </script>



@stop
