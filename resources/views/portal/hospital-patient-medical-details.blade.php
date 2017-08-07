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
                                    <h4 class="m-t-0 m-b-30">Patient Medical Details</h4>

                                    <div class="row">

                                        <div class="col-lg-12">


                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient ID</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient Name</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">Phone Number</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">E-Mail</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient Age</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient Gender</label>
                                                <div class="col-sm-6">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient Relationship</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-6 control-label">Patient Relation Name</label>
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
                                                        <span class="hidden-xs">Personal Illness</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#scan" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Scan</span>
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
                                            </ul>
                                            <?php /* ?>{{print_r($patientExaminations)}}<?php */ ?>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="general">
                                                    <p>
                                                    <div class="col-md-12">
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
                                                        <select class="form-control" id="selectpersonal" onchange="javascript:ajaxloadpersonaldetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['personalHistoryDates'] as $personalHistoryDates)
                                                                <option value="{{$personalHistoryDates->personal_history_date}}">{{$personalHistoryDates->personal_history_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-personal" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Personal Illness History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientpersonaldiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="scan">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <select class="form-control" id="selectscan" onchange="javascript:ajaxloadscandetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['scanDates'] as $scanDates)
                                                                <option value="{{$scanDates->scan_date}}">{{$scanDates->scan_date}}</option>
                                                            @endforeach
                                                        </select>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-scan" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Scan History </b></button></a>
                                                    </div>
                                                    <br/>
                                                    <div style="width:100%;" id="patientscandiv"></div>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="drug">
                                                    <p>
                                                    <div class="col-md-12">
                                                        <select class="form-control" id="selectdrug" onchange="javascript:ajaxloaddrugdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['scanDates'] as $scanDates)
                                                                <option value="{{$scanDates->scan_date}}">{{$scanDates->scan_date}}</option>
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
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/pregnancydetails';

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
    </script>
@stop