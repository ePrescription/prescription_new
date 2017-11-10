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

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Add Patient Examination Finding</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Examination Finding</h4>


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
                                                    <!-- form start -->


                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/investigations" role="form" method="POST" class="form-horizontal ">
                                            <br/>
                                                    <!--
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Diagnosis Date</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="diagnosisDate" value="" required="required" />
                                                        </div>
                                                    </div>
                                                    -->
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Investigations</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="investigations" value="" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Examination Findings</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="examinationFindings" value="" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Provisional Diagnosis</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="provisionalDiagnosis" value="" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Final Diagnosis</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="finalDiagnosis" value="" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Treatment Type</label>
                                                        <div class="col-sm-6">
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="treatmentType1" value="1" name="treatmentType" />
                                                                <label for="treatmentType1"> Inpatient </label>
                                                            </div>
                                                            <div class="radio radio-inline">
                                                                <input type="radio" id="treatmentType2" value="2" name="treatmentType" checked="checked" />
                                                                <label for="treatmentType2"> Outpatient </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Treatment Notes</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="treatmentPlanNotes" value="" required="required" />
                                                        </div>
                                                    </div>



                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />
                                                        <input type="hidden" class="form-control" name="diagnosisDate" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="examinationTime" value="{{date('h:i:s')}}" required="required" />


                                                        <input type="submit" name="addfinding" value="Save" class="btn btn-success"/>
                                                    </div>
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


@endsection