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
                        <h4 class="page-title">Patient Receipts List</h4>

                    </div>
                </div>

                <div class="page-content-wrapper ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">


                                <div class="dropdown">
                                    <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                    <div class="dropdown-content">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>
                                        <!-- By Ramana 12-01-2018-->
                                        &nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientId}}/print" title="Print Medical Profile"><i class="fa fa-print"></i>Print Medical Profile </a>
                                    </div>
                                </div>

                                <div style="float:right;margin: 10px;">
                                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                                        <button class="btn btn-info waves-effect waves-light">Back to Patients List</button>
                                    </a>
                                </div>
                                      <h4 class="m-b-30 m-t-0">Patient Receipts List</h4>

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
                                                <th>Fee Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Due Amount</th>
                                                <th>Receipt Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($labReceipts as $labReceipt)
                                                <tr>
                                                    <td>{{$labReceipt->receiptId}}</td>
                                                    <td>{{$labReceipt->pid}}</td>
                                                    <td>{{$labReceipt->name}}</td>
                                                    <td>{{$labReceipt->total_fees}}</td>
                                                    <td>{{$labReceipt->paid_amount}}</td>
                                                    <td><?php echo abs($labReceipt->total_fees-$labReceipt->paid_amount); ?></td>
                                                    <td>{{$labReceipt->lab_receipt_date}}</td>
                                                    <td>

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$labReceipt->patient_id}}/receiptdetails?feereceipt={{$labReceipt->receiptId}}" title="Lab Profile"><i class="fa fa-eye"></i> </a>

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
@stop
