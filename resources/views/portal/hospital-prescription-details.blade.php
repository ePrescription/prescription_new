@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
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
                    <h4 class="page-title">Prescriptions Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                    <h4>Invoice</h4>
                                </div> -->

                                <div class="dropdown">
                                    <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                    <div class="dropdown-content">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>
                                        <!-- By Ramana 12-01-2018-->
                                        &nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$prescriptionDetails['PatientProfile'][0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i>Print Medical Profile </a>
                                    </div>
                                </div>
                                <div style="float:right;margin:10px;"><button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back</button></div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-xs-12">

                                            <div class="invoice-title">
                                                <h4 class="pull-right">PRID # {{$prescriptionDetails['PrescriptionInfo'][0]->PRID}}</h4>
                                                <h3 class="m-t-0">Prescriptions Details</h3>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <address>
                                                        <strong>Patient Details:</strong>
                                                    </address>
                                                    <div class="col-md-12">
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Patient ID</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['PatientProfile'][0]->pid}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Patient Name</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['PatientProfile'][0]->name}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Phone Number</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['PatientProfile'][0]->telephone}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">E-Mail</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['PatientProfile'][0]->email}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <address>
                                                        <strong>Doctor Details:</strong>
                                                    </address>
                                                    <div class="col-md-12">
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Doctor ID</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['DoctorProfile'][0]->did}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Doctor Name</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['DoctorProfile'][0]->name}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">Phone Number</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['DoctorProfile'][0]->telephone}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-sm-6 control-label">E-Mail</label>
                                                            <div class="col-sm-6">
                                                                {{$prescriptionDetails['DoctorProfile'][0]->email}}
                                                            </div>
                                                        </div>




                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <address>
                                                        <strong>Current Illness:</strong><br>
                                                        @foreach($prescriptionDetails['PrescriptionInfo'] as $prescriptioninfo)
                                                            {{$prescriptioninfo->illness}}
                                                        @endforeach
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><strong>Drug Details</strong></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="example2" class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>TRADE</th>
                                                                <th>FORMULATION</th>
                                                                <th>DOSAGE</th>
                                                                <th>DAYS</th>
                                                                <th>INTAKE</th>
                                                                <th>Morning - Afternoon - Night</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($prescriptionDetails['PatientDrugDetails'] as $prescription)
                                                                <tr>
                                                                    <td>{{$prescription->trade_name}}</td>
                                                                    <td>{{$prescription->formulation_name}}</td>
                                                                    <td>{{$prescription->dosage}}</td>
                                                                    <td>{{$prescription->no_of_days}}</td>
                                                                    <td>{{$prescription->intake_form}}</td>
                                                                    <td>
                                                                        {{$prescription->morning}} - {{$prescription->afternoon}} - {{$prescription->night}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <address>
                                                            <strong>Notes:</strong><br>
                                                            @foreach($prescriptionDetails['PrescriptionInfo'] as $prescriptioninfo)
                                                                {{$prescriptioninfo->notes}}
                                                            @endforeach
                                                        </address>
                                                    </div>


                                                    <div class="hidden-print">
                                                        <div class="pull-right">
                                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                            <a href="#" class="btn btn-primary waves-effect waves-light hidden">Send</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div> <!-- end row -->
                                </div> <!-- panel body -->
                            </div> <!-- end panel -->

                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->


                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        @include('portal.hospital-footer')

    </div>
    <!-- End Right content here -->


</div><!-- ./wrapper -->


<script>
    function printDiv()
    {

        var divToPrint=document.getElementById('PagePrint');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    }
</script>
@endsection
