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
                    <h4 class="page-title">Patient All Details</h4>
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
                                    <h4 class="m-t-0 m-b-30">Patient All Details</h4>


                                    <div id='DivIdToPrint' style="display:block;">


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

                                        <h4 class="m-t-0 m-b-30">Lab Tests Details</h4>

                                        @if(count($patientExaminations['recentBloodTests'])>0)
                                            <hr style="width: 100%;"/>

                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Blood Test - {{$patientExaminations['recentBloodTests'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentBloodTests'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentMotionExaminations'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Motion Test - {{$patientExaminations['recentMotionExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentMotionExaminations'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif



                                        @if(count($patientExaminations['recentUrineExaminations'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Urine Test - {{$patientExaminations['recentUrineExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentUrineExaminations'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentUltrasound'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Ultra Sound Test - {{$patientExaminations['recentUltrasound'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentUltrasound'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentScans'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Scans - {{$patientExaminations['recentScans'][0]->scan_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentScans'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->scan_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['dentalExaminations'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Dental Examination - {{$patientExaminations['dentalExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['dentalExaminations'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->category_name}} - {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['xrayExaminations'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">X-Ray Examination - {{$patientExaminations['xrayExaminations'][0]->examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['xrayExaminations'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->examination_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif

                                        <h4 class="m-t-0 m-b-30">Medical Examination Details</h4>


                                        @if(count($patientExaminations['recentGeneralTests'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">General Test - {{$patientExaminations['recentGeneralTests'][0]->general_examination_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentGeneralTests'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->general_examination_name}} :: {{$recentTest->general_examination_value}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentPastIllness'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Past Illeness - {{$patientExaminations['recentPastIllness'][0]->past_illness_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentPastIllness'] as $recentTest)
                                                    <div class="col-sm-4" style="width:33%;float:left;">

                                                        {{$recentTest->past_illness_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentFamilyIllness'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Family Illeness - {{$patientExaminations['recentFamilyIllness'][0]->family_illness_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentFamilyIllness'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->family_illness_name}} - {{$recentTest->relation}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentPersonalHistory'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Personal Illeness - {{$patientExaminations['recentPersonalHistory'][0]->personal_history_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentPersonalHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->personal_history_name}} - {{$recentTest->personal_history_item_name}} @if(!empty($recentTest->personal_history_value)) - {{$recentTest->personal_history_value}} @endif

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentPregnancy'])>0)
                                            <hr style="width: 100%;" />
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Pregnancy - {{$patientExaminations['recentPregnancy'][0]->pregnancy_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentPregnancy'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->pregnancy_details}} - {{$recentTest->pregnancy_value}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentSymptoms'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Symptoms - {{$patientExaminations['recentSymptoms'][0]->patient_symptom_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentSymptoms'] as $recentTest)
                                                    <div class="col-sm-12" style="width:100%;float:left;">

                                                        {{$recentTest->main_symptom_name}} - {{$recentTest->sub_symptom_name}} - {{$recentTest->symptom_name}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif


                                        @if(count($patientExaminations['recentDrugHistory'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Drug History - {{$patientExaminations['recentDrugHistory'][0]->drug_history_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentDrugHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->drug_name}} - {{$recentTest->dosage}} - {{$recentTest->timings}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif

                                        @if(count($patientExaminations['recentSurgeryHistory'])>0)
                                            <hr style="width: 100%;"/>
                                            <div class="form-group" style="width: 100%;">
                                                <label class="col-sm-12 control-label" style="width: 100%;">Surgery History - {{$patientExaminations['recentSurgeryHistory'][0]->surgery_input_date}}</label>
                                            </div>
                                            <div class="form-group col-sm-12" style="width: 100%;">
                                                @foreach($patientExaminations['recentSurgeryHistory'] as $recentTest)
                                                    <div class="col-sm-6" style="width:50%;float:left;">

                                                        {{$recentTest->patient_surgeries}} - {{$recentTest->surgery_input_date}}

                                                    </div>
                                                @endforeach
                                            </div>

                                            <br/><br/>
                                        @endif



                                            <?php $latestPrescription=$patientExaminations['latestPrescription']; ?>
                                            @if(count($latestPrescription)>0)
                                                <?php $i=0; ?>
                                                <h4 class="m-t-0 m-b-30" style="width: 100%;">Prescription Details</h4>
                                                <div class="table-responsive" style="width: 100%;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>BRAND</th>
                                                            <th>MEDICINE</th>
                                                            <th>DOSAGE</th>
                                                            <th>DAYS</th>
                                                            <th>TIMING</th>
                                                            <th>INTAKE FORM</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($latestPrescription as $latestPrescriptionValue)
                                                            <tr>
                                                                <td>{{$latestPrescriptionValue->trade_name}}</td>
                                                                <td>{{$latestPrescriptionValue->formulation_name}} </td>
                                                                <td>{{$latestPrescriptionValue->dosage}}</td>
                                                                <td>{{$latestPrescriptionValue->no_of_days}}</td>
                                                                <td>
                                                                    @if($latestPrescriptionValue->morning==1) Morning @endif
                                                                    @if($latestPrescriptionValue->afternoon==1) After Noon @endif
                                                                    @if($latestPrescriptionValue->night==1) Night @endif
                                                                </td>
                                                                <td>{{$latestPrescriptionValue->intake_form}}</td>
                                                            </tr>

                                                            <?php $i++; ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            @endif

                                            <hr/>

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