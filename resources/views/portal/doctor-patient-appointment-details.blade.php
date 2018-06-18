@extends('layout.master-doctor-inner')

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
                    <h4 class="page-title">Patient All Details</h4>
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
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle">View Profile</i> </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit">Medical Profile</i></a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o">Medical Prescription</i> </a>
                                            &nbsp;&nbsp;

                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask">Lab Profile</i> </a>
                                            &nbsp;

                                            <!--ADDED BY RAMANA --->
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/lab-details-results" title="Print Patient lab Tests"><i class="fa fa-folder-o">Print Patient lab Tests</i> </a>
                                            &nbsp;&nbsp;

                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download">Lab Report Download</i> </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money">Lab Receipts</i> </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print">Print Medical Profile</i> </a>

                                        </div>
                                    </div>
                                    <div style="float:right;">

                                       <!-- <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$appointmentDetails['patientProfile'][0]->id}}/details#appointment">
                                            <button class="btn btn-info waves-effect waves-light">Back to Profile</button>
                                        </a>-->
                                           <button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back to Profile</button>


                                    </div>

                                    <div style="float:right;">
                                        <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <h4 class="m-t-0 m-b-30">Patient Appointment Details</h4>


                                    <div id='DivIdToPrint' style="display:block;">


                                        <div id="PatientInfoPrint" class="" style="height: 150px;">
                                            <div class="row">

                                                <div class="col-lg-12"  style="width:100%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Patient Details</h4>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">PID</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['patientProfile'][0]->pid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['patientProfile'][0]->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Number</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['patientProfile'][0]->telephone}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">E-Mail</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['patientProfile'][0]->email}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="DoctorInfoPrint" class="" style="height: 150px;">
                                            <div class="row">

                                                <div class="col-lg-12" style="width:100%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Doctor Details</h4>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">DID</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['doctorProfile'][0]->did}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['doctorProfile'][0]->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Email</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['doctorProfile'][0]->email}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Phone</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['doctorProfile'][0]->telephone}}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div id="HospitalInfoPrint" class="" style="height: 150px;">
                                            <div class="row">

                                                <div class="col-lg-12" style="width:100%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Hospital Details</h4>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">HID</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['hospitalProfile'][0]->hid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['hospitalProfile'][0]->hospital_name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Email</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['hospitalProfile'][0]->email}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Phone</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['hospitalProfile'][0]->telephone}}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>



                                        <div id="AppointmentInfoPrint" class="" style="height: 300px;">
                                            <div class="row">

                                                <div class="col-lg-12" style="width:100%;float:left;">
                                                    <h4 class="m-t-0 m-b-30">Appointment Details</h4>


                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Category</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->appointment_category}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Notes</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->notes}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Date</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->appointment_date}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Time</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->appointment_time}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Fee</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->fee}}
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">

                                                    </div>

                                                @if($appointmentDetails['appointmentDetails'][0]->referral_type == "External")
                                                    <h4 class="m-t-0 m-b-30">Referral Details</h4>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Referral Type</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->referral_type}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Referral Doctor</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->referral_doctor}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Referral Hospital</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->referral_hospital}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-3 control-label" style="width:30%;float:left;">Referral Hospital Location</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$appointmentDetails['appointmentDetails'][0]->referral_hospital_location}}
                                                        </div>
                                                    </div>
                                                @endif


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

        @include('portal.doctor-footer')

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