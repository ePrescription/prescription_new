@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
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

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Patient Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <div class="dropdown">
                                    <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                    <div class="dropdown-content">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>
                                        <!-- By Ramana 12-01-2018-->
                                        &nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i>Print Medical Profile </a>
                                    </div>
                                </div>
                                <div style="float:right;"><button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back</button></div>
                                <h4 class="m-t-0 m-b-30">Patient Details</h4>


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


                                    <form action="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/update" role="form" method="POST">
                                        <input type="hidden" name="hospitalId" value="{{Auth::user()->id}}" required="required" />
                                        <input type="hidden" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />

                                        <div class="col-md-12">
                                            <style>.control-label{line-height:32px;}</style>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">PID</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->pid}}
                                                    <input type="hidden" class="form-control" name="patient_id" value="{{$patientDetails[0]->patient_id}}" required="required" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" value="{{$patientDetails[0]->name}}" required="required" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="email" value="{{$patientDetails[0]->email}}" required="required" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Mobile</label>
                                                <div class="col-sm-9">
                                                    <input type="number" min="0" class="form-control" name="telephone" value="{{$patientDetails[0]->telephone}}" required="required" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Age</label>
                                                <div class="col-sm-9">
                                                    <input type="number" min="0" class="form-control" name="age" value="{{$patientDetails[0]->age}}" required="required" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">

                                                    <input type="radio" class="form-controlx" name="gender" value="1" required="required" @if($patientDetails[0]->gender==1) checked @endif />Male
                                                    &nbsp;&nbsp;
                                                    <input type="radio" class="form-controlx" name="gender" value="2" required="required" @if($patientDetails[0]->gender==0) checked @endif />Female
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    <!--
                                                <input type="text" class="form-control" name="relationship" value="{{$patientDetails[0]->relationship}}" required="required" />
                                                -->
                                                    <select class="form-control" name="relationship" required="required">
                                                        <option selected>{{$patientDetails[0]->relationship}}</option>
                                                        <option>Brother</option>
                                                        <option>Sister</option>
                                                        <option>Husband</option>
                                                        <option>Wife</option>
                                                        <option>Father</option>
                                                        <option>Mother</option>
                                                        <option>Others</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Relation Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="spouseName" value="{{$patientDetails[0]->spouseName}}" required="required" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="address" value="{{$patientDetails[0]->address}}" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-success" style="float:right;">Save Profile</button>
                                        </div>

                                    </form>


                                </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->


                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        @include('portal.hospital-footer')

    </div>
    <!-- End Right content here -->

</div><!-- ./wrapper -->

@endsection
