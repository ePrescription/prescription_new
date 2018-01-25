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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Appointment Patients List</h4>

                </div>
            </div>

            <div class="page-content-wrapper ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">


                            <!-- The Modal -->
                            <div id="myModal" class="modal">

                                <!-- Modal content -->
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <!-- form start -->
                                    <form action="{{URL::to('/')}}/fronthospital/rest/api/transferappointment" role="form" id="appointmentDoctor" method="GET">
                                        <div class="col-md-12">
                                            <style>.control-label{line-height:32px;}</style>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Doctor</label>
                                                <div class="col-sm-9">
                                                    <select name="doctorId" id="doctorId" class="form-control" required="required" >
                                                        <option value="">--CHOOSE--</option>
                                                        @foreach($doctors as $doctor)
                                                            <option value="{{$doctor->doctorId}}">{{$doctor->doctorName.' '.$doctor->doctorUniqueId}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="box-footer">
                                            <input type="hidden" name="appointmentId" id="appointmentId" value="0" />
                                            <button type="submit" class="btn btn-success" style="float:right;">Transfer Appointment</button>
                                        </div>

                                    </form>

                                </div>

                            </div>



                            <!--
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addpatientwithappointment" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Appointment</b></button></a>
                                                       <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addpatient" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Create New Patient</b></button></a>
                            -->
                            <div class="panel panel-primary">
                                <div class="panel-body">

                                    <h4 class="m-b-30 m-t-0">Appointment Patients List</h4>

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
                                    <div>
                                        PID ( Patient Identification)
                                    </div>
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient ID</th>
                                            <th>Name in Full</th>
                                            <th>Mobile No</th>
                                            <th>Appointment</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($patients as $patient)
                                             <tr>
                                                <td>{{$patient->id}}</td>
                                                <td>
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/details" title="View Profile"> {{$patient->pid}} </a>
                                                </td>
                                                <td>{{$patient->name}}</td>
                                                <td>{{$patient->telephone}}</td>
                                                <td>{{$patient->appointment_date}} - {{$patient->appointment_time}}</td>
                                                <td>{{$patient->appointment_category}}</td>
                                                <td>

                                                    <a href="{{URL::to('/')}}/fronthospital/patients/appointments/{{$patient->appointment_id}}/details" title="View Appointment"><i class="fa fa-eye"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="#" data-data="{{URL::to('/')}}/fronthospital/patients/appointments/{{$patient->appointment_id}}/transferappointment?appointmentId={{$patient->appointment_id}}" title="Transfer Appointment" onclick="OpenBox('{{$patient->patient_id}}','{{$patient->appointment_id}}')"> <i class="fa fa-exchange"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/patients/appointments/{{$patient->appointment_id}}/cancelappointment?appointmentId={{$patient->appointment_id}}" title="Cancel Appointment" onclick="return confirm('Are you sure ?')"><i class="fa fa-times"></i> </a>
                                                    &nbsp;

                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/patient/{{$patient->patient_id}}/receipt/{{$patient->id}}/appointmentlabel" title="View Patient Appointment Label"><i class="fa fa-print"></i> </a>

                                                <!--


                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i> </a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i> </a>
                                                    -->
                                                    <!--
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/edit" title="Edit Profile"><i class="fa fa-edit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addpatientwithappointment?patientId={{$patient->patient_id}}" title="Book Appointment"><i class="fa fa-stethoscope"></i> </a>
                                                    -->
                                                    <!--
                                                    &nbsp;&nbsp;
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i> </a>
                                                    -->


                                                <?php /* ?>
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/details" style="float:rightx;">View Profile</a>
                                                    <br/>
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/medical-details" style="float:rightx;">View Medical</a>
                                                    <br/>
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/edit" style="float:rightx;">Edit Profile</a>
                                                    <br/>
                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patient->patient_id}}/addappointment" style="float:rightx;">Book Appointment</a>
                                                    <!--
                                                    <a href="#doctorview.html"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>
                                                    -->
                                                    <?php */ ?>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->


                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.content-wrapper -->

        </div><!-- ./content -->
    </div><!-- ./content-page -->
    @include('portal.doctor-footer')

</div><!-- ./wrapper -->


@endsection
@section('scripts')
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
        span.onclick = function() {
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

        function OpenBox(pid,aid)
        {
            document.getElementById("appointmentId").value=aid;
            modal.style.display = "block";
        }
    </script>


@stop
