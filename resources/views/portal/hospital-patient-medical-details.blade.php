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
                                                    <a href="#pregnency" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Pregnency</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="general">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-general" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add General Examination </b></button></a>
                                                    </div>
                                                    <div>
                                                        GEID ( General Examination Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>GEID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="family">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-family" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Family Illness History </b></button></a>
                                                    </div>
                                                    <div>
                                                        FIHID ( Family Illness History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>FIHID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="past">

                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-past" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Past Illness History </b></button></a>
                                                    </div>
                                                    <div>
                                                        PIHID ( Past Illness History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>PIHID</th>
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
                                                <div class="tab-pane" id="personal">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-personal" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Personal Illness History </b></button></a>
                                                    </div>
                                                    <div>
                                                        PRIHID ( Personal Illness History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>PRIHID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="scan">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-scan" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Scan History </b></button></a>
                                                    </div>
                                                    <div>
                                                        SHID ( Scan History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>SHID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="drug">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-drug" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Past Drug History </b></button></a>
                                                    </div>
                                                    <div>
                                                        PDHID ( Past Drug History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>PHID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="pregnency">
                                                    <p>
                                                    <div>
                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/add-medical-pregnency" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Add Pregnency History </b></button></a>
                                                    </div>
                                                    <div>
                                                        PRGHID ( Pregnency History Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>PRGHID</th>
                                                            <th>PID</th>
                                                            <th>PATIENT</th>
                                                            <th>DATE</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

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
