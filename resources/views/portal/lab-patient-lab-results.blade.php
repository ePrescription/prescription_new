@extends('layout.master-lab-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane { min-height: 300px; }</style>
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
    @include('portal.lab-header')
    <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.lab-sidebar')
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

                                        <div class="dropdown">
                                            <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                            <div class="dropdown-content">
                                                <a href="{{URL::to('/')}}/lab/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile</a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/lab/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>

                                                <!-- By Ramana 19-01-2018-->
                                                &nbsp;
                                                <a href="{{URL::to('/')}}/lab/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>
                                                &nbsp;
                                                <a href="{{URL::to('/')}}/lab/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-upload" title="Lab Report Upload"><i class="fa fa-upload"></i>Lab Report Upload </a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/lab/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i> Lab Report Download</a>
                                            </div>
                                        </div>
                                        <div style="float:right;">
                                            <a href="{{URL::to('/')}}/lab/rest/api/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patients">
                                                <button class="btn btn-info waves-effect waves-light">Back to Patients List</button>
                                            </a>
                                        </div>

                                        <div style="float:right;display:block;">
                                            <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                        </div>


                                        <h4 class="m-t-0 m-b-30">Patient Lab Details</h4>

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

                                            <div id="ExaminationInfoPrint" class="form-group">




                                            </div>
                                        </div>
                                        <div class="row">

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

                                        <?php $dates=array(); ?>
                                        @foreach($patientExaminations['bloodTestDates'] as $generalExaminationDate)
                                            @if (!in_array($generalExaminationDate->examination_date, $dates))
                                                <?php $dates[count($dates)]=$generalExaminationDate->examination_date; ?>
                                            @endif
                                        @endforeach

                                        @foreach($patientExaminations['urineTestDates'] as $generalExaminationDate)
                                            @if (!in_array($generalExaminationDate->examination_date, $dates))
                                                <?php $dates[count($dates)]=$generalExaminationDate->examination_date; ?>
                                            @endif
                                        @endforeach

                                        @foreach($patientExaminations['motionTestDates'] as $generalExaminationDate)
                                            @if (!in_array($generalExaminationDate->examination_date, $dates))
                                                <?php $dates[count($dates)]=$generalExaminationDate->examination_date; ?>
                                            @endif
                                        @endforeach
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="blood">
                                                <p>
                                                <div class="col-md-12">
                                                    <label style="float: left;margin: 10px;">Choose Date</label>
                                                    <select class="form-control" id="selectgerenal"  style="width:200px;float:left;" onchange="javascript:ajaxloadreport({{Auth::user()->id}},{{Session::get('LoginUserHospital')}},{{$patientDetails[0]->patient_id}},this.value);">
                                                        <option value="0">NONE</option>
                                                        @foreach($dates as $date)
                                                            <option value="{{$date}}">{{$date}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <br/>
                                                <div style="width:100%;" id="patientblooddiv1"></div>
                                                </p>
                                            </div>
                                        </div> <!-- panel-body -->
                                    </div> <!-- panel -->
                                </div> <!-- col -->
                            </div> <!-- End row -->

                        </div><!-- container -->



                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                @include('portal.lab-footer')

            </div>
            <!-- End Right content here -->


        <!-- ./wrapper -->

        @endsection



        @section('scripts')


            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
            <script src="http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

            <script>

                $(document).ready(function(){
                    $( "input#TestTime" ).timepicker({
                        timeFormat: 'HH:mm:ss',
                        interval: 60,
                        minTime: '10',
                        maxTime: '6:00pm',
                        defaultTime: '11',
                        startTime: '10:00',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true
                    });
                });

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

                function ajaxloaddentaldetails(pid,date) {

                    $("#patientdentaldiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/dentaltests';

                    if(date!=0)
                    {
                        $.ajax({
                            url: callurl,
                            type: "get",
                            data: {"id": pid, "examinationDate": date, "status": status},
                            success: function (data) {
                                $("#patientdentaldiv").html(data);
                            }
                        });
                    }
                    else
                    {
                        $("#patientdentaldiv").html("");
                    }

                }

                function ajaxloadxraydetails(pid,date) {

                    $("#patientxraydiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/xraytests';

                    if(date!=0)
                    {
                        $.ajax({
                            url: callurl,
                            type: "get",
                            data: {"id": pid, "examinationDate": date, "status": status},
                            success: function (data) {
                                $("#patientxraydiv").html(data);
                            }
                        });
                    }
                    else
                    {
                        $("#patientxraydiv").html("");
                    }

                }


                function ajaxloadreport(did,hid,pid,date) {

                    $("#patientblooddiv1").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/hospital/' + hid + '/patient/' + pid + '/'+date+'/lab-reports';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status,"date":date},
                        success: function (data) {
                            // alert(data)
                            var result=data.split("separate");
                            $("#patientblooddiv1").html(result[1]);
                            $("#DivIdToPrint").html(result[0]+result[1]);



                        }
                    });
                }

                function ajaxloadbloodform(did,hid,pid) {
                    $("#patientblooddiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-bloodtests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientblooddiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloadmotionform(did,hid,pid) {
                    $("#patientmotiondiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-motiontests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientmotiondiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloadurineform(did,hid,pid) {
                    $("#patienturinediv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-urinetests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patienturinediv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloadultraform(did,hid,pid) {
                    $("#patientultradiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-ultrasoundtests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientultradiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloadscanform(did,hid,pid) {
                    $("#patientscandiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-scantests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientscandiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloaddentalform(did,hid,pid) {
                    $("#patientdentaldiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-dentaltests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientdentaldiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
                        }
                    });
                }

                function ajaxloadxrayform(did,hid,pid) {
                    $("#patientxraydiv").html("LOADING...");
                    var BASEURL = "{{ URL::to('/') }}/";
                    var status = 1;
                    var callurl = BASEURL + 'doctor/' + did + '/hospital/' + hid + '/patient/' + pid + '/add-lab-xraytests';
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"id": pid, "status": status},
                        success: function (data) {
                            $("#patientxraydiv").html(data);
                            $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                            $( "input#TestTime" ).timepicker({
                                timeFormat: 'HH:mm:ss',
                                interval: 60,
                                defaultTime: '{{date('H:i:s')}}',
                                startTime: '00:00',
                                dynamic: false,
                                dropdown: true,
                                scrollbar: true
                            });
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

                function UpdateTestDates(dateValue) {

                    for (var i = 0; i < $('input#TestDates').length; i++) {
                        $('input#TestDates').val(dateValue);
                    }

                }

                function UpdateTestTimes(timeValue) {

                    for (var i = 0; i < $('input#TestTimes').length; i++) {
                        $('input#TestTimes').val(timeValue);
                    }

                }

            </script>




            <script>
                /*
                 $( function() {
                 $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
                 } );
                 */
            </script>

@stop