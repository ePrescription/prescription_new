@extends('layout.master-doctor-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
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

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Add Patient General Examination</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add General Examination</h4>


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

                                            <form action="{{URL::to('/')}}/doctor/generalexamination" role="form" method="POST" class="form-horizontal ">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Height (in Cm)</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[0][generalExaminationId]" value="1" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[0][generalExaminationValue]" value="0" required="required" id="height_value" />
                                                        <input type="hidden" class="form-control" name="generalExamination[0][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[0][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[0][isValueSet]" value="1" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Weight (in Kg)</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[1][generalExaminationId]" value="2" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[1][generalExaminationValue]" value="0" required="required" id="weight_value" onchange="javascript:getbmi();" />
                                                        <input type="hidden" class="form-control" name="generalExamination[1][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[1][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[1][isValueSet]" value="1" required="required" />                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BMI</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[2][generalExaminationId]" value="3" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[2][generalExaminationValue]" value="0" required="required" id="bmi_value" readonly />
                                                        <input type="hidden" class="form-control" name="generalExamination[2][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[2][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[2][isValueSet]" value="1" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Pallor</label>
                                                    <div class="col-sm-6">

                                                        <input type="hidden" class="form-control" name="generalExamination[3][generalExaminationId]" value="4" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[3][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[3][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[3][isValueSet]" value="1" required="required" />

                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue41" value="Yes" name="generalExamination[3][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue41"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue42" value="No" name="generalExamination[3][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue42"> No </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Cyanosis</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[4][generalExaminationId]" value="5" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[4][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[4][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[4][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue51" value="Yes" name="generalExamination[4][generalExaminationValue]"required="required" />
                                                            <label for="generalExaminationValue51"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue52" value="No" name="generalExamination[4][generalExaminationValue]" checked="checked"required="required" />
                                                            <label for="generalExaminationValue52"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Clubbing of Fingers / Toes</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[5][generalExaminationId]" value="6" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[5][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[5][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[5][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue61" value="Yes" name="generalExamination[5][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue61"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue62" value="No" name="generalExamination[5][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue62"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Lymphadenopathy</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[6][generalExaminationId]" value="7" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[6][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[6][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[6][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue71" value="Yes" name="generalExamination[6][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue71"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue72" value="No" name="generalExamination[6][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue72"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Oedema In Feet</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[7][generalExaminationId]" value="8" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[7][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[7][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[7][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue81" value="Yes" name="generalExamination[7][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue81"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue82" value="No" name="generalExamination[7][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue82"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Malnutrition</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[8][generalExaminationId]" value="9" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[8][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[8][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[8][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue91" value="Yes" name="generalExamination[8][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue91"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue92" value="No" name="generalExamination[8][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue92"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Dehydration</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[9][generalExaminationId]" value="10" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[9][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[9][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[9][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="generalExaminationValue101" value="Yes" name="generalExamination[9][generalExaminationValue]" required="required" />
                                                            <label for="generalExaminationValue101"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="generalExaminationValue102" value="No" name="generalExamination[9][generalExaminationValue]" checked="checked" required="required" />
                                                            <label for="generalExaminationValue102"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Temperature (C/F)</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[10][generalExaminationId]" value="11" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[10][generalExaminationValue]" value="0" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[10][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[10][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[10][isValueSet]" value="1" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Pulse rate per minute</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[11][generalExaminationId]" value="12" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[11][generalExaminationValue]" value="0" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[11][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[11][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[11][isValueSet]" value="1" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Respiration (count for a full minute) rate</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="generalExamination[12][generalExaminationId]" value="13" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[12][generalExaminationValue]" value="0" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[12][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[12][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[12][isValueSet]" value="1" required="required" />
                                                        <!--
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BP Lt.Arm mm/Hg</label>
                                                    <div class="col-sm-6">

                                                        <input type="hidden" class="form-control" name="generalExamination[13][generalExaminationId]" value="14" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[13][generalExaminationValue]" value="0" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[13][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[13][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[13][isValueSet]" value="1" required="required" />

                                                        <!--
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BP Rt.Arm mm/Hg</label>
                                                    <div class="col-sm-6">

                                                        <input type="hidden" class="form-control" name="generalExamination[14][generalExaminationId]" value="15" required="required" />
                                                        <input type="text" class="form-control" name="generalExamination[14][generalExaminationValue]" value="0" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[14][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[14][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="generalExamination[14][isValueSet]" value="1" required="required" />

                                                        <!--
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        -->
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="doctorId" value="{{$doctorId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="hospitalId" value="{{$hospitalId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />
                                                        <input type="submit" name="addgeneral" value="Save" class="btn btn-success"/>

                                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="margin:0px 16px;"><button type="button" class="btn btn-success">Cancel</button></a>
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

            @include('portal.doctor-footer')

        </div>
        <!-- End Right content here -->


@endsection

@section('scripts')
<script>
    function getbmi()
    {
    var hv=$("#height_value").val();
    var wv=$("#weight_value").val();
    var bmi=parseInt(wv)/((parseInt(hv)/100)*(parseInt(hv)/100));
    //$("#bmi_value").val(Math.round(bmi));
        $("#bmi_value").val(parseFloat(bmi).toFixed(2));
    }
</script>

@stop

