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
                                    <div style="float:right;"><button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back</button></div>
                                    <h4 class="m-t-0 m-b-30">Patient Lab Details</h4>

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
                                                            @foreach($patientExaminations['generalExaminationDates'] as $generalExaminationDate)
                                                                <option value="{{$generalExaminationDate->general_examination_date}}">{{$generalExaminationDate->general_examination_date}}</option>
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
                                                        <select class="form-control" id="selectfamily" onchange="javascript:ajaxloadmationdetails({{$patientDetails[0]->patient_id}},this.value);" style="width:200px;float:left;">
                                                            <option value="0">NONE</option>
                                                            @foreach($patientExaminations['familyIllnessDates'] as $familyIllnessDates)
                                                                <option value="{{$familyIllnessDates->family_illness_date}}">{{$familyIllnessDates->family_illness_date}}</option>
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
                                                            @foreach($patientExaminations['pastIllnessDates'] as $pastIllnessDates)
                                                                <option value="{{$pastIllnessDates->past_illness_date}}">{{$pastIllnessDates->past_illness_date}}</option>
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
                                                            @foreach($patientExaminations['personalHistoryDates'] as $personalHistoryDates)
                                                                <option value="{{$personalHistoryDates->personal_history_date}}">{{$personalHistoryDates->personal_history_date}}</option>
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
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/bloodhistory';

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
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/motionhistory';

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
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/urinehistory';

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
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/ultrahistory';

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
            var callurl = BASEURL + 'fronthospital/rest/api/' + hid + '/patient/' + pid + '/add-lab-ultratests';
            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    $("#patientultradiv").html(data);
                }
            });
        }

    </script>
@stop