@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
$profile_menu="0";
?>
<?php
$time_array=array(
        '00:00:00'=>'12:00 AM','00:15:00'=>'12:15 AM','00:30:00'=>'12:30 AM','00:45:00'=>'12:45 AM',
        '01:00:00'=>'01:00 AM','01:15:00'=>'01:15 AM','01:30:00'=>'01:30 AM','01:45:00'=>'01:45 AM',
        '02:00:00'=>'02:00 AM','02:15:00'=>'02:15 AM','02:30:00'=>'02:30 AM','02:45:00'=>'02:45 AM',
        '03:00:00'=>'03:00 AM','03:15:00'=>'03:15 AM','03:30:00'=>'03:30 AM','03:45:00'=>'03:45 AM',
        '04:00:00'=>'04:00 AM','04:15:00'=>'04:15 AM','04:30:00'=>'04:30 AM','04:45:00'=>'04:45 AM',
        '05:00:00'=>'05:00 AM','05:15:00'=>'05:15 AM','05:30:00'=>'05:30 AM','05:45:00'=>'05:45 AM',
        '06:00:00'=>'06:00 AM','06:15:00'=>'06:15 AM','06:30:00'=>'06:30 AM','06:45:00'=>'06:45 AM',
        '07:00:00'=>'07:00 AM','07:15:00'=>'07:15 AM','07:30:00'=>'07:30 AM','07:45:00'=>'07:45 AM',
        '08:00:00'=>'08:00 AM','08:15:00'=>'08:15 AM','08:30:00'=>'08:30 AM','08:45:00'=>'08:45 AM',
        '09:00:00'=>'09:00 AM','09:15:00'=>'09:15 AM','09:30:00'=>'09:30 AM','09:45:00'=>'09:45 AM',
        '10:00:00'=>'10:00 AM','10:15:00'=>'10:15 AM','10:30:00'=>'10:30 AM','10:45:00'=>'10:45 AM',
        '11:00:00'=>'11:00 AM','11:15:00'=>'11:15 AM','11:30:00'=>'11:30 AM','11:45:00'=>'11:45 AM',
        '12:00:00'=>'12:00 PM','12:15:00'=>'12:15 PM','12:30:00'=>'12:30 PM','12:45:00'=>'12:45 PM',
        '13:00:00'=>'01:00 PM','13:15:00'=>'01:15 PM','13:30:00'=>'01:30 PM','13:45:00'=>'01:45 PM',
        '14:00:00'=>'02:00 PM','14:15:00'=>'02:15 PM','14:30:00'=>'02:30 PM','14:45:00'=>'02:45 PM',
        '15:00:00'=>'03:00 PM','15:15:00'=>'03:15 PM','15:30:00'=>'03:30 PM','15:45:00'=>'03:45 PM',
        '16:00:00'=>'04:00 PM','16:15:00'=>'04:15 PM','16:30:00'=>'04:30 PM','16:45:00'=>'04:45 PM',
        '17:00:00'=>'05:00 PM','17:15:00'=>'05:15 PM','17:30:00'=>'05:30 PM','17:45:00'=>'05:45 PM',
        '18:00:00'=>'06:00 PM','18:15:00'=>'06:15 PM','18:30:00'=>'06:30 PM','18:45:00'=>'06:45 PM',
        '19:00:00'=>'07:00 PM','19:15:00'=>'07:15 PM','19:30:00'=>'07:30 PM','19:45:00'=>'07:45 PM',
        '20:00:00'=>'08:00 PM','20:15:00'=>'08:15 PM','20:30:00'=>'08:30 PM','20:45:00'=>'08:45 PM',
        '21:00:00'=>'09:00 PM','21:15:00'=>'09:15 PM','21:30:00'=>'09:30 PM','21:45:00'=>'09:45 PM',
        '22:00:00'=>'10:00 PM','22:15:00'=>'10:15 PM','22:30:00'=>'10:30 PM','22:45:00'=>'10:45 PM',
        '23:00:00'=>'11:00 PM','23:15:00'=>'11:15 PM','23:30:00'=>'11:30 PM','23:45:00'=>'11:45 PM',
);
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
                    <h4 class="page-title">New Patient Appointment</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0 m-b-30">New Patient Appointment</h4>


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
                                        <form action="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/savepatientwithappointment" role="form" method="POST">
                                            <input type="hidden" name="hospitalId" value="{{Auth::user()->id}}" required="required" />
                                            <input type="hidden" name="patientId" id="patientId" value="0" required="required" />
                                            <div class="col-md-12">
                                                <style>.control-label{line-height:32px;}</style>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Patient Visiting</label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" name="visiting" value="1" required="required" checked onclick="javascript:visitPatient(1);" />&nbsp;&nbsp;First time
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" name="visiting" value="2" required="required" onclick="javascript:visitPatient(2);" />&nbsp;&nbsp;Followup
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12" id="searchPatientBox" style="display:none;">
                                                    <label class="col-sm-3 control-label">Search Patient</label>
                                                    <div class="col-sm-9">
                                                        <!--
                                                        <input type="text" class="form-control" name="searchPatient" value="" id="autocomplete-ajax" />
                                                        -->

                                                        <select name="searchPatient" id="searchPatient" class="form-control patientUpdate" onchange="javascript:getPatient(this.value);">title="Select for a state" search><option></option></select>
                                                        <!--
                                                        <select name="searchPatient" id="searchPatient" class="form-control patientUpdate" onchange="javascript:getPatient(this.value);">
                                                            <option value="">--CHOOSE PATIENT--</option>
                                                            @foreach($patients as $patient)
                                                                <option value="{{$patient->patient_id}}" >{{$patient->pid}} - {{$patient->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>

                                                <h4 class="m-t-0 m-b-30">Patient Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="name" name="name" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="email" name="email" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="telephone" name="telephone" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Age</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="age" name="age" value="" required="required" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Gender</label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" id="gender1" name="gender" value="1" required="required" />&nbsp;&nbsp;Male
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" id="gender2" name="gender" value="2" required="required" />&nbsp;&nbsp;Female
                                                    </div>
                                                </div>


                                                <h4 class="m-t-0 m-b-30">Appointment Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Type</label>
                                                    <div class="col-sm-9">
                                                        <select name="appointmentCategory" class="form-control" required="required" >
                                                            <option value="">--CHOOSE--</option>
                                                            <option value="Normal">Normal</option>
                                                            <option value="Special">Special</option>
                                                            <option value="Pregnancy">Pregnancy</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor Name</label>
                                                    <div class="col-sm-9">

                                                        <select name="doctorId" class="form-control" required="required" >
                                                            <option value="">--CHOOSE--</option>
                                                            @foreach($doctors as $doctor)
                                                                <option value="{{$doctor->doctorId}}">{{$doctor->doctorName.' '.$doctor->doctorUniqueId}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" data-date-format="YYYY-MM-DD" min="{{date('Y-m-d')}}" class="form-control" name="appointmentDate" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Time</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="appointmentTime" required="required">

                                                            <option value=""> --:-- -- </option>
                                                            @foreach($time_array as $time_value)
                                                                <?php $key=array_keys($time_array,$time_value); ?>
                                                                <option value="{{$key[0]}}"> {{$time_value}} </option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Brief History</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="briefHistory" required="required"></textarea>
                                                    </div>
                                                </div>


                                                <h4 class="m-t-0 m-b-30">Referral Info</h4>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Referral Type</label>
                                                    <div class="col-sm-9">

                                                        <div class="col-sm-9">
                                                            <input type="radio" class="form-controlx" name="referralType" value="1" required="required" checked onclick="javascript:referralTypePatient(1);" />&nbsp;&nbsp;Internal
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" class="form-controlx" name="referralType" value="2" required="required" onclick="javascript:referralTypePatient(2);" />&nbsp;&nbsp;External
                                                        </div>

                                                    </div>
                                                </div>

                                                <div id="referralTypeInfo" style="display:none;">
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor Specialization</label>
                                                    <div class="col-sm-9">

                                                        <select name="referralSpecialty" id="referralSpecialty" class="form-control"  onchange="javascript:getDoctors(this.value);">
                                                            <option value="">--CHOOSE--</option>
                                                            @foreach($specialties as $specialty)
                                                                <option value="{{$specialty->id}}">{{$specialty->specialty_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Referred By</label>
                                                    <div class="col-sm-9">


                                                        <select name="referralDoctor" id="referralDoctor" class="form-control" onchange="javascript:getDoctorInfo();">
                                                            <option value="">--CHOOSE--</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Hospital Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="referralHospital" id="referralHospital" value="" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Hospital Location</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="hospitalLocation" id="hospitalLocation" value="" readonly />
                                                    </div>
                                                </div>
                                                </div>

                                                <h4 class="m-t-0 m-b-30">Payment Info</h4>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Payment Type</label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" id="payment" name="paymentType" value="Cash" required="required" />&nbsp;&nbsp;Cash
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" id="payment" name="paymentType" value="Card" required="required" />&nbsp;&nbsp;Card
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="fee" value="" required="required" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Notes</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-success" style="float:right;">Save & Book Appointment</button>
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


</div><!-- ./wrapper -->

@endsection



@section('scripts')


    {!!  Html::script(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.jquery.min.js')) !!}
    {!!  Html::script(asset('plugins/ajax-chosen/lib/ajax-chosen.js')) !!}

    {!!  Html::style(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.css')) !!}
    <style type="text/css">
        select#searchPatient { width: 300px; display: block; }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("select#searchPatient").ajaxChosen({
                type: 'GET',
                //url: '/vistara/ajax-chosen-master/data.json',
                ///url: '/treatin-web-app/public/ajaxGetCountry',
                url: '{{ URL::to('/') }}/fronthospital/rest/api/{{Auth::user()->id}}/patientnames',
                dataType: 'json'
            }, function (data) {
                var terms = {};
                console.log(data.result);
                $.each(data.result, function (i, val) {
                    terms[val.patientId] = val.name;
                });

                return terms;
            });
        });
    </script>

    <?php /* ?>
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/jquery.mockjax.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/src/jquery.autocomplete.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/countries.js')) !!}
    {!!  Html::script(asset('plugins/jQuery-Autocomplete/scripts/demo.js')) !!}
    <script>
        $('#autocomplete').autocomplete({
            serviceUrl: '{{ URL::to('/') }}/fronthospital/rest/api/{{Auth::user()->id}}/patientnames',
            onSelect: function (suggestion) {
                alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
            }
        });

    </script>
<?php */ ?>
    <script>
        function visitPatient(id)
        {
            if(id==1)
            {
                $("#searchPatientBox").hide();

                $('input#name').attr('readonly', false);
                $('input#email').attr('readonly', false);
                $('input#telephone').attr('readonly', false);
                $('input#age').attr('readonly', false);
                $('input#gender1').attr('disabled', false);
                $('input#gender2').attr('disabled', false);

            }
            else
            {
                $("#searchPatientBox").show();

                $('input#name').attr('readonly', true);
                $('input#email').attr('readonly', true);
                $('input#telephone').attr('readonly', true);
                $('input#age').attr('readonly', true);
                $('input#gender1').attr('disabled', true);
                $('input#gender2').attr('disabled', true);
            }
        }

        function getPatient(pid) {

            $("input#patientId").val(pid);
            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + pid + '/details';


            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": pid, "status": status},
                success: function (data) {
                    //alert(data.result[0].id);
                    console.log(data);
                    //$("#patienturinediv").html(data);
                    $("input#name").val(data.result[0].name);
                    $("input#email").val(data.result[0].email);
                    $("input#telephone").val(data.result[0].telephone);
                    $("input#age").val(data.result[0].age);
                    if(data.result[0].gender==1)
                    {
                        $("input#gender1").attr('checked', 'checked');
                    }
                    if(data.result[0].gender==2)
                    {
                        $("input#gender2").attr('checked', 'checked');
                    }

                }
            });


        }


        function referralTypePatient(id)
        {
            if(id==1)
            {
                $("#referralTypeInfo").hide();

                $('select#referralSpecialty').attr('required', false);
                $('select#referralDoctor').attr('required', false);
                $('input#referralHospital').attr('required', false);
                $('input#hospitalLocation').attr('required', false);


            }
            else
            {
                $("#referralTypeInfo").show();

                $('select#referralSpecialty').attr('required', true);
                $('select#referralDoctor').attr('required', true);
                $('input#referralHospital').attr('required', true);
                $('input#hospitalLocation').attr('required', true);

            }
        }

        function getDoctors(sid) {

            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + sid + '/referraldoctors';

            $.ajax({
                url: callurl,
                type: "get",
                data: {"id": sid, "status": status},
                success: function (data) {
                    var terms = '<option value="" data-doctor="" data-hospital="" data-location="">--Choose Doctor--</option>';
                    $.each(data.result, function (i, val) {
                        terms += '<option value="'+val.id+'" data-doctor="'+val.doctor_name+'" data-hospital="'+val.hospital_name+'" data-location="'+val.location+'">'+val.doctor_name+'</option>';
                    });
                    $("#referralDoctor").html(terms);

                }
            });


        }

        function getDoctorInfo()
        {
            var doctorName = $("#referralDoctor").find(':selected').attr('data-doctor');
            var hospitalName = $("#referralDoctor").find(':selected').attr('data-hospital');
            var locationName = $("#referralDoctor").find(':selected').attr('data-location');


            $('input#referralHospital').val(hospitalName);
            $('input#hospitalLocation').val(locationName);

        }


    </script>

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

    </script>
@stop
