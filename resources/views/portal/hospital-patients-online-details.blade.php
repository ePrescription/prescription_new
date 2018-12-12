@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')
@section('styles')
    <!-- DataTables -->
    {!!  Html::style(asset('theme/assets/plugins/datatables/jquery.dataTables.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/buttons.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/fixedHeader.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/responsive.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/dataTables.bootstrap.min.css')) !!}
    {!!  Html::style(asset('theme/assets/plugins/datatables/scroller.bootstrap.min.css')) !!}

    <style>
        /* Style the tab */
        .tab_container .tab-content p,
        .tab_container .tab-content h3 {
            -webkit-animation: fadeInScale 0.7s ease-in-out;
            -moz-animation: fadeInScale 0.7s ease-in-out;
            animation: fadeInScale 0.7s ease-in-out;
        }
        .tab_container .tab-content h3  {
            text-align: center;
        }

        .tab_container [id^="tab"]:checked + label {
            background: #1f319f;
            box-shadow: inset 0 3px #1f319f;
            color:#fff;
        }

        .tab_container [id^="tab"]:checked + label .fa {
            color: #fff;
        }

        label .fa {
            font-size: 1.3em;
            margin: 0 0.4em 0 0;
        }

        /*Media query*/
        @media only screen and (max-width: 930px) {
            label span {
                font-size: 14px;
            }
            label .fa {
                font-size: 14px;
            }
        }

        @media only screen and (max-width: 768px) {
            label span {
                display: none;
            }

            label .fa {
                font-size: 16px;
            }

            .tab_container {
                width: 98%;
            }
        }

        /*Content Animation*/
        @keyframes fadeInScale {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        div.tab {
            overflow: hidden;
            border: 1px solid #060064;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        div.tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        div.tab button:hover {
            background-color: #060064;
            color:white;
        }

        /* Create an active/current tablink class */
        div.tab button.active {
            background-color: #060064;
            color:white;
        }

        .th{
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
            font-size: 14px;
            background: #1f319f;
            color:#fff;
        }

        table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 13px;
        }
    </style>
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

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="page-content-wrapper ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab tab_container">
                                    <button class="tablinks" onclick="openCity(event, 'Opinion')"><label for="tab3"><i class="fa fa-medkit" data-toggle="tooltip" title="Second Opinion"></i><span>Second Opinion </span></label>
                                    </button>
                                    <button class="tablinks" onclick="openCity(event, 'askquestion')"><label for="tab4"><i class="fa fa-question" data-toggle="tooltip" title="Answered Questions"></i><span>Answered Questions</span></label>
                                    </button>
                                    <button class="tablinks" onclick="openCity(event, 'online')"><label for="tab4"><i class="fa fa-stethoscope" data-toggle="tooltip" title="Answered Questions"></i><span>Online Appointments</span></label>
                                    </button>
                                </div>

                                <div id="Opinion" class="tabcontent">
                                    <div class="container">
                                        <h4> Second Opinion</h4>
                                        @if(count($secondOpinion)>0)
                                            <table class="table table-bordred table-striped" id="datatable">
                                                <thead>
                                                <th>PID</th>
                                                <th>Patient Name</th>
                                                <th>Mobile No</th>
                                                <th>Doctor Name</th>
                                                <th>Specialty</th>
                                                <th>Appointment Date </th>
                                                <th>Subject </th>
                                                <th>Description</th>
                                                <th class="hidden">Records</th>
                                                </thead>
                                                @foreach ($secondOpinion as $opinion)
                                                    <tr>
                                                        <td>{{ $opinion->pid }} </td>
                                                        <td>{{ $opinion->patient_name }}</td>
                                                        <td>{{ $opinion->telephone }}</td>
                                                        <td>{{ $opinion->name }} </td>
                                                        <td>{{ $opinion->specialty }}</td>
                                                        <td>{{ $opinion->appointment_date }}</td>
                                                        <td>{{ $opinion->subject }}</td>
                                                        <td>{{ $opinion->brief_history }}</td>
                                                        <td class="hidden">
                                                            @if($opinion->reports !="")
                                                                <?php $paths = explode("@@", $opinion->reports); ?>
                                                                @foreach($paths as $path)
                                                                        @if($path!= "")
                                                                        <a href="public/askquestion/{{$path}}" target="_blank">
                                                                            <img src="public/askquestion/{{$path}}" with="200" height="200px">
                                                                        </a>
                                                                    @endif
                                                                    @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </div>
                                </div>

                                <div id="askquestion" class="tabcontent" style="display: none;">
                                    <div class="container">
                                        <h4> Ask a Question</h4>
                                        @if(count($askquestions)>0)
                                            <table class="table table-bordred table-striped" id="datatable">
                                                <thead>
                                                <th>PID</th>
                                                <th>Patient Name</th>
                                                <th>Mobile No</th>
                                                <th>Doctor Name</th>
                                                <th>Specialty</th>
                                                <th>Appointment Date </th>
                                                <th>Subject </th>
                                                <th>Description</th>
                                                <th class="hidden">Records</th>
                                                </thead>
                                                @foreach ($askquestions as $question)
                                                    <tr>
                                                        <td>{{ $question->pid }} </td>
                                                        <td>{{ $question->patient_name }}</td>
                                                        <td>{{ $question->telephone }}</td>
                                                        <td>{{ $question->name }} </td>
                                                        <td>{{ $question->specialty }}</td>
                                                        <td>{{ $question->appointment_date }}</td>
                                                        <td>{{ $question->subject }}</td>
                                                        <td>{{ $question->brief_history }}</td>
                                                        <td class="hidden">
                                                            @if($question->reports !="")
                                                                <?php $paths = explode("@@", $question->reports); ?>
                                                                @foreach($paths as $path)
                                                                    @if($path!= "")
                                                                        <a href="public/askquestion/{{$path}}" target="_blank">
                                                                            <img src="public/askquestion/{{$path}}" with="200" height="200px">
                                                                        </a>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </div>
                                </div>


                                <div id="online" class="tabcontent" style="display: none;">
                                    <div class="container">
                                        <h4>Online Appointments</h4>
                                        @if(count($patients)>0)
                                            <table class="table table-bordred table-striped" id="datatable">
                                                <thead>
                                                <th>PID</th>
                                                <th>Patient Name</th>
                                                <th>Mobile No</th>
                                                <th>Doctor Name</th>
                                                <th>Appointment Date&Time </th>
                                                <th>Appointment Status </th>
                                                <th>Appointment Category </th>
                                                <th>Token Id </th>
                                                <th class="hidden">Records</th>
                                                </thead>
                                                @foreach ($patients as $patient)
                                                    <tr>
                                                        <td>{{ $patient->pid }} </td>
                                                        <td>{{ $patient->name }}</td>
                                                        <td>{{ $patient->telephone }}</td>
                                                        <td>{{ $patient->dname }} </td>
                                                        <td>{{ $patient->appointment_date }}&nbsp; {{ $patient->appointment_time }}</td>
                                                        <td>{{ $patient->appointment_name }}</td>
                                                        <td>{{ $patient->appointment_category }}</td>
                                                        <td>{{ $patient->token_id }}</td>

                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

        @section('scripts')
            <script>
                function openCity(evt, cityName) {
                    // Declare all variables
                    var i, tabcontent, tablinks;
                    // Get all elements with class="tabcontent" and hide them
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }

                    // Get all elements with class="tablinks" and remove the class "active"
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }

                    // Show the current tab, and add an "active" class to the button that opened the tab
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                }
            </script>
            <!-- Datatables-->
            {!!  Html::script(asset('theme/assets/plugins/datatables/jquery.dataTables.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.bootstrap.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.buttons.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.bootstrap.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/jszip.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/pdfmake.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/vfs_fonts.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.html5.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/buttons.print.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.fixedHeader.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.keyTable.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.responsive.min.js')) !!}
            {!!  Html::script(asset('theme/assets/plugins/datatables/responsive.bootstrap.min.js')) !!}


            {!!  Html::script(asset('theme/assets/plugins/datatables/dataTables.scroller.min.js')) !!}

            <!-- Datatable init js -->
            {!!  Html::script(asset('theme/assets/pages/datatables.init.js')) !!}

            {!!  Html::script(asset('theme/assets/js/app.js')) !!}

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


            <style>
                /* The Modal (background) */
                .modal {
                    display: none; /* Hidden by default */
                    position: fixed; /* Stay in place */
                    z-index: 1; /* Sit on top */
                    left: 0;
                    top: 0;
                    width: 100%; /* Full width */
                    height: 100%; /* Full height */
                    overflow: auto; /* Enable scroll if needed */
                    background-color: rgb(0,0,0); /* Fallback color */
                    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                }

                /* Modal Content/Box */
                .modal-content {
                    background-color: #fefefe;
                    margin: 15% auto; /* 15% from the top and centered */
                    padding: 20px;
                    border: 1px solid #888;
                    width: 50%; /* Could be more or less, depending on screen size */
                    height: 200px;
                }

                /* The Close Button */
                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
            </style>
            <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];
                console.log(span);
                // When the user clicks on the button, open the modal
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                function Modalclose() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }


                function OpenTransferFrom(pid,aid)
                {
                    alert(pid+'::'+aid);
                }

                function OpenBox(pid,aid,did,hid,date,time)
                {

                    document.getElementById("appointmentId").value=aid;
                    document.getElementById("hospitalId").value=hid;
                    document.getElementById("appoinmentDate").value=date;
                    document.getElementById("appoinmentTime").value=time;

                    modal.style.display = "block";

                }
                function DoctorAvailabilityCheck(){
                    var hid=document.getElementById("hospitalId").value;
                    var date=document.getElementById("appoinmentDate").value;
                    var time=document.getElementById("appoinmentTime").value;

                    var BASEURL = "{{ URL::to('/') }}/";
                    var did=$("#doctorId").val();
                    var callurl = BASEURL + 'fronthospital/rest/api/hospital/'+hid+'/doctor/' + did + '/date/'+date+'/time/'+time+'/availabilityCheck';
                    //alert(callurl);
                    $.ajax({
                        url: callurl,
                        type: "get",
                        data: {"status":1},
                        success: function (data) {

                            if(data==0){
                                alert("Doctor Is Not Available .Please Choose Another Doctor");
                                var did=$("#doctorId").val("");
                            }else if(data==2){
                                alert("Appointment Time Over,Can't Transfer!!");
                                var did=$("#doctorId").val("");
                            }
                        }
                    });
                }
            </script>


@stop
