@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane { min-height: 300px; }</style>
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
                    <h4 class="page-title">Patient Medical Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div style="float:right;">
                                        <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <div style="float:right;">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back</button>
                                        </a>
                                    </div>
                                    <h4 class="m-t-0 m-b-30">Patient Medical Details</h4>

                                    <div id='DivIdToPrint' style="display:none;">


                                        <div id="PatientInfoPrint" class="" style="height: 250px;">
                                            <div class="row">

                                                <div class="col-lg-6" style="width:50%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Hospital Details</h4>

                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['hospitalDetails']->hospital_name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Address</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['hospitalDetails']->address}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">City</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['hospitalDetails']->city_name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Country</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['hospitalDetails']->name}}
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6"  style="width:50%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Patient Details</h4>



                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">PID</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['patientDetails']->pid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['patientDetails']->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Number</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['patientDetails']->telephone}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">E-Mail</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientExaminations['patientDetails']->email}}
                                                        </div>
                                                    </div>
                                                    <?php /* ?>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Age / Gender</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['patientDetails']->age}} / @if($patientExaminations['patientDetails']->gender==1) Male @else Female @endif
                                                        </div>
                                                    </div>
                                                    <?php */ ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="ExaminationInfoPrint" class="">

                                        @if(count($patientExaminations['recentComplaints'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Complaints - {{$patientExaminations['recentComplaints'][0]->complaint_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentComplaints'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->complaintType}} :: {{$recentTest->complaint_name}}
                                                        <br/>
                                                        <strong>Notes:</strong>{{$recentTest->complaint_text}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentGeneralTests'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">General Test - {{$patientExaminations['recentGeneralTests'][0]->general_examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentGeneralTests'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->general_examination_name}} :: {{$recentTest->general_examination_value}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentPastIllness'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Past Illeness - {{$patientExaminations['recentPastIllness'][0]->past_illness_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentPastIllness'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->past_illness_name}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentFamilyIllness'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Family Illeness - {{$patientExaminations['recentFamilyIllness'][0]->family_illness_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentFamilyIllness'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->family_illness_name}} - {{$recentTest->relation}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentPersonalHistory'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Personal Illeness - {{$patientExaminations['recentPersonalHistory'][0]->personal_history_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentPersonalHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->personal_history_name}} - {{$recentTest->personal_history_item_name}} @if(!empty($recentTest->personal_history_value)) - {{$recentTest->personal_history_value}} @endif

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentPregnancy'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Pregnancy - {{$patientExaminations['recentPregnancy'][0]->pregnancy_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentPregnancy'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->pregnancy_details}} - {{$recentTest->pregnancy_value}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentSymptoms'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Symptoms - {{$patientExaminations['recentSymptoms'][0]->patient_symptom_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentSymptoms'] as $recentTest)
                                                    <div class="col-sm-12" style="width:100%;float:left;">

                                                        {{$recentTest->main_symptom_name}} - {{$recentTest->sub_symptom_name}} - {{$recentTest->symptom_name}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif



                                        @if(count($patientExaminations['recentDrugHistory'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Drug History - {{$patientExaminations['recentDrugHistory'][0]->drug_history_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentDrugHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->drug_name}} - {{$recentTest->dosage}} - {{$recentTest->timings}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif



                                        @if(count($patientExaminations['recentSurgeryHistory'])>0)
                                            <hr/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label">Surgery History - {{$patientExaminations['recentSurgeryHistory'][0]->surgery_input_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentSurgeryHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">
                                                        {{$recentTest->patient_surgeries}} - {{$recentTest->operation_date}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr/>
                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['diagnosticExaminations'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Diagnostic Examinations - {{$patientExaminations['diagnosticExaminations'][0]->diagnosis_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['diagnosticExaminations'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        Investigations - {{$recentTest->investigations}} <br/>
                                                        Examination Findings - {{$recentTest->examination_findings}} <br/>
                                                        Provisional Diagnosis - {{$recentTest->provisional_diagnosis}} <br/>
                                                        Final Diagnosis - {{$recentTest->final_diagnosis}} <br/>
                                                        Treatment Type - {{$recentTest->treatment_type}} <br/>
                                                        Treatment Notes - {{$recentTest->treatment_code}} <br/>


                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                            <hr/>

                                        </div>
                                    </div>


                                @if (session()->has('message'))
                                        <div class="col_full login-title">
                                            <span style="color:red;">
                                                <p class="text-danger">{{session('message')}}</p>
                                            </span>
                                        </div>
                                    @endif

                                    @if (session()->has('success'))
                                        <div class="col_full login-title">
                                            <span style="color:green;">
                                                <p class="text-success">{{session('success')}}</p>
                                            </span>
                                        </div>
                                    @endif



                                    <div class="row">

                                        <div class="col-lg-2">
                                            @if($patientDetails[0]->patient_photo=="")

                                                <img src="{{URL::to('/')}}/uploads/patient_photo/noimage.png"  />

                                            @else

                                                <img src="{{URL::to('/')}}/{{$patientDetails[0]->patient_photo}}"  style="width:100px;" />

                                            @endif
                                        </div>
                                        <div class="col-lg-10">


                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">PID</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Number</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">E-Mail</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Age</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-3 control-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-6 control-label">Relation Name</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->spouseName}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <style>
                                            ul.nav-tabs span.hidden-xs {
                                                margin-left: -10px;
                                                margin-right: -10px;
                                            }
                                            </style>
                                            <ul class="nav nav-tabs navtab-bg">
                                                <li class="active">
                                                    <a href="#complaint" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Complaint</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#general" data-toggle="tab" aria-expanded="true">
                                                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                                                        <span class="hidden-xs">General</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#family" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                                                        <span class="hidden-xs">Family Illness</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#past" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                                        <span class="hidden-xs">Past Illness</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#personal" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Personal History</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#drug" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Past Drug</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#pregnancy" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Pregnancy</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#symptom" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Symptom</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#finding" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Finding</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <?php /* * / ?>{{print_r($patientExaminations)}}<?php / * */ ?>
                                            <div class="tab-content">

                                                <div class="tab-pane active" id="complaint">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectdrug" onchange="javascript:ajaxloadcomplaintdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['complaintDates'] as $complaintDates)
                                                                <option value="{{$complaintDates->complaint_date}}">{{$complaintDates->complaint_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-complaint" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Complaints </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientcomplaintdiv"></div>
                                                    </p>
                                                </div>

                                                <div class="tab-pane" id="general">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectgerenal" onchange="javascript:ajaxloadgeneraldetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['generalExaminationDates'] as $generalExaminationDate)
                                                                <option value="{{$generalExaminationDate->general_examination_date}}">{{$generalExaminationDate->general_examination_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-general" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add General Examination </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientgeneraldiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="family">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectfamily" onchange="javascript:ajaxloadfamilydetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['familyIllnessDates'] as $familyIllnessDates)
                                                                <option value="{{$familyIllnessDates->family_illness_date}}">{{$familyIllnessDates->family_illness_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-family" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Family Illness History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientfamilydiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="past">

                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectpast" onchange="javascript:ajaxloadpastdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['pastIllnessDates'] as $pastIllnessDates)
                                                                <option value="{{$pastIllnessDates->past_illness_date}}">{{$pastIllnessDates->past_illness_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-past" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Past Illness History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientpastdiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="personal">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectpersonal" onchange="javascript:ajaxloadpersonaldetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['personalHistoryDates'] as $personalHistoryDates)
                                                                <option value="{{$personalHistoryDates->personal_history_date}}">{{$personalHistoryDates->personal_history_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-personal" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Personal History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientpersonaldiv"></div>
                                                    </p>
                                                </div>

                                                <div class="tab-pane" id="drug">
                                                    <p>
                                                    <div class="col-md-12">

                                                         <label style="float: left;margin: 10px;">Choose Data</label>
                                                        <select class="form-control" id="selectdrug" onchange="javascript:ajaxloaddrugdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['drugTestDates'] as $drugTestDates)
                                                                <option value="{{$drugTestDates->drug_history_date}}">{{$drugTestDates->drug_history_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-drug" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Past Drug History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientdrugdiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="pregnancy">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>

                                                        <select class="form-control" id="selectpregnancy" onchange="javascript:ajaxloadpregnancydetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['pregnancyDates'] as $pregnancyDates)
                                                                <option value="{{$pregnancyDates->pregnancy_date}}">{{$pregnancyDates->pregnancy_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-pregnancy" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Pregnancy History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientpregnancydiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="symptom">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectdrug" onchange="javascript:ajaxloadsymptomdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['symptomDates'] as $symptomDates)
                                                                <option value="{{$symptomDates->patient_symptom_date}}">{{$symptomDates->patient_symptom_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-symptom" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Symptoms </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientsymptomdiv"></div>
                                                    </p>
                                                </div>

                                                <div class="tab-pane" id="finding">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectdrug" onchange="javascript:ajaxloadfindingdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['diagnosisDates'] as $diagnosticExaminations)
                                                                <option value="{{$diagnosticExaminations->diagnosis_date}}">{{$diagnosticExaminations->diagnosis_date}}</option>
                                                            @endforeach
                                                        </select>

                                                         <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-finding" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Finding </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientfindingdiv"></div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

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

    <script>
        function ajaxloadgeneraldetails(pid,date) {

            $("#patientgeneraldiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/generalexamination';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientgeneraldiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientgeneraldiv").html("");
            }

        }

        function ajaxloadfamilydetails(pid,date) {

            $("#patientfamilydiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/familyillness';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientfamilydiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientfamilydiv").html("");
            }

        }

        function ajaxloadpastdetails(pid,date) {

            $("#patientpastdiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/pastillness';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientpastdiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientpastdiv").html("");
            }

        }

        function ajaxloadpersonaldetails(pid,date) {

            $("#patientpersonaldiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/patienthistory';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientpersonaldiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientpersonaldiv").html("");
            }

        }

        function ajaxloadscandetails(pid,date) {

            $("#patientscandiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/scandetails';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientscandiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientscandiv").html("");
            }

        }

        function ajaxloaddrugdetails(pid,date) {

            $("#patientdrugdiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/drughistory';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientdrugdiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientdrugdiv").html("");
            }

        }

        function ajaxloadpregnancydetails(pid,date) {

            $("#patientpregnancydiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/pregnancydetails';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientpregnancydiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientpregnancydiv").html("");
            }

        }

        function ajaxloadsymptomdetails(pid,date) {

            $("#patientsymptomdiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/symptomdetails';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientsymptomdiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientsymptomdiv").html("");
            }

        }


        function ajaxloadcomplaintdetails(pid,date) {

            $("#patientcomplaintdiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/complaintdetails';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientcomplaintdiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientcomplaintdiv").html("");
            }

        }


        function ajaxloadfindingdetails(pid,date) {

            $("#patientfindingdiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/investigationdetails';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientfindingdiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientfindingdiv").html("");
            }

        }

        function printDiv()
        {
            var divToPrint=document.getElementById('DivIdToPrint');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        }

    </script>
@stop