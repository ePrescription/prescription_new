@extends('layout.master-lab-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane { min-height: 300px; }</style>
@stop
<?php
$dashboard_menu="1";
$lab_menu="0";
$patient_menu="0";
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

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Patient Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">

                                    <div style="float:right;">
                                        <a href="{{URL::to('/')}}/lab/rest/api/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back to Patients List</button>
                                        </a>
                                    </div>
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
                                    <h4 class="m-t-0 m-b-30">Patient Details</h4>

                                    <div class="row">

                                        <div class="col-lg-12">


                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">PID</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">Name</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">Number</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">E-Mail</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">Age</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-4 control-label">Gender</label>
                                                <div class="col-sm-8">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-4 control-label">Relationship</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-4 control-label">Relation Name</label>
                                                <div class="col-sm-8">
                                                    {{$patientDetails[0]->spouseName}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs navtab-bg">
                                                <li class="active">
                                                    <a href="#home" data-toggle="tab" aria-expanded="true">
                                                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                                                        <span class="hidden-xs">Info</span>
                                                    </a>
                                                </li>
                                                <?php /* ?>
                                                <li class="">
                                                    <a href="#settings" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Lab Tests</span>
                                                    </a>
                                                </li>
                                                <?php */ ?>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="home">
                                                    <p>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient ID</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->pid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Name</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Phone Number</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->telephone}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">E-Mail</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->email}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Age</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->age}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Gender</label>
                                                        <div class="col-sm-6">
                                                            @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Relationship</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->relationship}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Relation Name</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->spouseName}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="col-sm-6 control-label">Patient Address</label>
                                                        <div class="col-sm-6">
                                                            {{$patientDetails[0]->address}}
                                                        </div>
                                                    </div>
                                                    </p>
                                                </div>

                                                <?php /* ?>
                                                <div class="tab-pane" id="settings">
                                                    <p>
                                                    <div>
                                                        PLID ( Patient LabTest Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>PLID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($labTests as $labTest)
                                                            <tr>
                                                                <td>{{$labTest->unique_id}}</td>
                                                                <td>{{$labTest->pid}}</td>
                                                                <td>{{$labTest->name}}</td>
                                                                <td>{{$labTest->labtest_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/lab/{{$labTest->labtest_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                    </p>
                                                </div>
                                                <?php */ ?>
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

        @include('portal.lab-footer')

    </div>
    <!-- End Right content here -->


</div><!-- ./wrapper -->

@endsection
