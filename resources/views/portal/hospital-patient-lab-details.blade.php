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
                    <h4 class="page-title">Patient Lab Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">



                            <div class="panel panel-primary">
                                <div class="panel-body">


                                    <div style="float:right;">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back to Patients List</button>
                                        </a>
                                    </div>

                                    <div style="float:right;">
                                    <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <div style="float:right;display:none;">
                                        <a style="margin: 0px 10px;" href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labtestreceipts?hospitalId={{Auth::user()->id}}">
                                            <button class="btn btn-error waves-effect waves-light">Generate Receipt</button>
                                        </a>
                                    </div>
                                    <h4 class="m-t-0 m-b-30">Patient Lab Details</h4>

                                    <div id='DivIdToPrint' style="display:none;">

                                        <div id="PatientInfoPrint" class="">
                                            <div class="row">

                                                <div class="col-lg-6" style="width:50%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Hospital Details</h4>

                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Name</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['hospitalDetails']->hospital_name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Address</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['hospitalDetails']->address}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">City</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['hospitalDetails']->city_name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Country</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['hospitalDetails']->name}}
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6"  style="width:50%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Patient Details</h4>

                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">PID</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['patientDetails']->pid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Name</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['patientDetails']->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Number</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['patientDetails']->telephone}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">E-Mail</label>
                                                        <div class="col-sm-9">
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


                                        @if(count($patientExaminations['recentBloodTests'])>0)
                                            <hr/>
                                            <div class="form-group">
                                            <label class="col-sm-12 control-label">Blood Test - {{$patientExaminations['recentBloodTests'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                            @foreach($patientExaminations['recentBloodTests'] as $recentTest)
                                                <div class="col-sm-4" style="width:33%;float:left;">

                                                    {{$recentTest->examination_name}}

                                                </div>
                                            @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentMotionExaminations'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Motion Test - {{$patientExaminations['recentMotionExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentMotionExaminations'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/>
                                        @endif



                                        @if(count($patientExaminations['recentUrineExaminations'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Urine Test - {{$patientExaminations['recentUrineExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentUrineExaminations'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>
                                            <br/><br/><br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentUltrasound'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Ultra Test - {{$patientExaminations['recentUltrasound'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentUltrasound'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

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

                                        @if(count($patientExaminations['recentGeneralTests'])>0)
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

                                                        {{$recentTest->personal_history_name}} - {{$recentTest->personal_history_item_name}}

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

                                        @if(count($patientExaminations['recentScans'])>0)
                                            <hr/>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">Scans - {{$patientExaminations['recentScans'][0]->scan_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                @foreach($patientExaminations['recentScans'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->scan_name}}

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
                                         <hr/>

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

                                        <div class="col-lg-12">


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



                                            <ul class="nav nav-tabs navtab-bg">
                                                <li class="active">
                                                    <a href="#blood" data-toggle="tab" aria-expanded="true">
                                                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                                                        <span class="hidden-xs">Blood</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#motion" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                                                        <span class="hidden-xs">Motion</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#urine" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                                        <span class="hidden-xs">Urine</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#ultra" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Ultra Sound</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="blood">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectgerenal" onchange="javascript:ajaxloadblooddetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['bloodTestDates'] as $generalExaminationDate)
                                                                <option value="{{$generalExaminationDate->examination_date}}">{{$generalExaminationDate->examination_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="#" data-href="#{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-lab-bloodtests" onclick="javascript:ajaxloadbloodform({{Auth::user()->id}},{{$patientDetails[0]->patient_id}});" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Blood Test </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientblooddiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="motion">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectfamily" onchange="javascript:ajaxloadmotiondetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['motionTestDates'] as $familyIllnessDates)
                                                                <option value="{{$familyIllnessDates->examination_date}}">{{$familyIllnessDates->examination_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="#" data-href="#{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-lab-motiontest" onclick="javascript:ajaxloadmotionform({{Auth::user()->id}},{{$patientDetails[0]->patient_id}});" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Motion Test </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientmotiondiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="urine">

                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectpast" onchange="javascript:ajaxloadurinedetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['urineTestDates'] as $pastIllnessDates)
                                                                <option value="{{$pastIllnessDates->examination_date}}">{{$pastIllnessDates->examination_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="#" data-href="#{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-lab-urine" onclick="javascript:ajaxloadurineform({{Auth::user()->id}},{{$patientDetails[0]->patient_id}});" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Urine Test </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patienturinediv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="ultra">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <label style="float: left;margin: 10px;">Choose Date</label>
                                                        <select class="form-control" id="selectpersonal" onchange="javascript:ajaxloadultradetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['ultraSoundDates'] as $personalHistoryDates)
                                                                <option value="{{$personalHistoryDates->examination_date}}">{{$personalHistoryDates->examination_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="#" data-href="#{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-lab-ultra" onclick="javascript:ajaxloadultraform({{Auth::user()->id}},{{$patientDetails[0]->patient_id}});" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Ultra Sound Test </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientultradiv"></div>
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
        function ajaxloadblooddetails(pid,date) {

            $("#patientblooddiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/bloodtests';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientblooddiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientblooddiv").html("");
            }

        }

        function ajaxloadmotiondetails(pid,date) {

            $("#patientmotiondiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/motiontests';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientmotiondiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientmotiondiv").html("");
            }

        }

        function ajaxloadurinedetails(pid,date) {

            $("#patienturinediv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/urinetests';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patienturinediv").html(data);
                    }
                });
            }
            else
            {
                $("#patienturinediv").html("");
            }

        }

        function ajaxloadultradetails(pid,date) {

            $("#patientultradiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/ultrasoundtests';

            if(date!=0)
            {
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "examinationDate": date, "status": status},
                    success: function (data) {
                        $("#patientultradiv").html(data);
                    }
                });
            }
            else
            {
                $("#patientultradiv").html("");
            }

        }

        function ajaxloadbloodform(hid,pid) {
            $("#patientblooddiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + hid + '/patient/' + pid + '/add-lab-bloodtests';
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": pid, "status": status},
                    success: function (data) {
                        $("#patientblooddiv").html(data);
                    }
                });
        }

        function ajaxloadmotionform(hid,pid) {
            $("#patientmotiondiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + hid + '/patient/' + pid + '/add-lab-motiontests';
            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    $("#patientmotiondiv").html(data);
                }
            });
        }

        function ajaxloadurineform(hid,pid) {
            $("#patienturinediv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + hid + '/patient/' + pid + '/add-lab-urinetests';
            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    $("#patienturinediv").html(data);
                }
            });
        }

        function ajaxloadultraform(hid,pid) {
            $("#patientultradiv").html("LOADING...");
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + hid + '/patient/' + pid + '/add-lab-ultrasoundtests';
            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    $("#patientultradiv").html(data);
                }
            });
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