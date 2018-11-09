@extends('layout.master-doctor-inner')

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
                                                <th>Hospital Name</th>
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
                                                        <td>{{ $opinion->hospital_name }} </td>
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
                                                <th>Hospital Name</th>
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
                                                        <td>{{ $question->hospital_name }} </td>
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


@stop
