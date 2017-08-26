@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="0";
$doctor_menu="1";
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

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Fees Details</h4>
                </div>
            </div>


            <div style="width:100%;float: right;padding:1px;margin:1px;">

                <div id="modalemail" class="modal modalemail">
                    <div class="modal-dialog animated" style=" width: 50%; top: 100px;">
                        <div class="modal-content">
                            <form action="{{URL::to('/')}}/fronthospital/receipt/{{$receiptId}}/mail/{{$feeReceiptDetails['patientDetails']->email}}" class="form-horizontal" method="get">
                                <div class="modal-header">
                                    <strong>Enter Email Address</strong>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="dummyText" class="control-label col-xs-4">Email</label>
                                        <div class="input-group col-xs-7">
                                            <input type="email" name="email" id="email" class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-default" type="button" onclick="modalemail.close();">Cancel</button>
                                    <button class="btn btn-primary" type="submit" onclick="modal.close();">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modalsms" class="modal modalsms">
                    <div class="modal-dialog animated" style=" width: 50%; top: 100px;">
                        <div class="modal-content">
                            <form action="{{URL::to('/')}}/fronthospital/receipt/{{$receiptId}}/sms/{{$feeReceiptDetails['patientDetails']->telephone}}" class="form-horizontal" method="get">
                                <div class="modal-header">
                                    <strong>Enter Mobile Number</strong>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="dummyText" class="control-label col-xs-4">Mobile</label>
                                        <div class="input-group col-xs-7">
                                            <input type="number" name="mobile" id="mobile" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-default" type="button" onclick="modalsms.close();">Cancel</button>
                                    <button class="btn btn-primary" type="submit" onclick="modal.close();">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" style="float: right;margin: 10px;">

                    <div class="row">
                        <div class="col-lg-12">

                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>

                            <a href="javascript:void(0);" id="showModalSMS" class="btn btn-success waves-effect waves-light"><i class="fa fa-mobile"></i></a>

                            <a href="javascript:void(0);" id="showModalEMAIL" class="btn btn-success waves-effect waves-light"><i class="fa fa-envelope-o"></i></a>

                        </div>
                    </div>
                </div>

            </div>



            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h4>Fee Details</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="invoice-title">
                                                <h4 class="pull-right">Bill ID # 12345</h4>
                                                <h3 class="m-t-0">Fees Details</h3>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <address>
                                                        <strong>Hospital Details:</strong><br>
                                                    </address>
                                                        <div class="box-body">
                                                                <?php if(!empty($feeReceiptDetails['hospitalDetails']->hospital_logo)) { ?>
                                                                    <div class="col-md-12 col-sm-12">
                                                                    {{$feeReceiptDetails['hospitalDetails']->hospital_logo}}
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <label class="col-sm-4 control-label">Name</label>
                                                                        <div class="col-sm-8">
                                                                            {{$feeReceiptDetails['hospitalDetails']->hospital_name}}
                                                                            ( {{$feeReceiptDetails['hospitalDetails']->hid}} )
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <label class="col-sm-4 control-label">Address</label>
                                                                        <div class="col-sm-8">
                                                                            {{$feeReceiptDetails['hospitalDetails']->address}}, <br/>
                                                                            {{$feeReceiptDetails['hospitalDetails']->cityName}}, {{$feeReceiptDetails['hospitalDetails']->country}}
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="col-sm-12">
                                                                        <label class="col-sm-4 control-label">Name</label>
                                                                        <div class="col-sm-8">
                                                                            {{$feeReceiptDetails['hospitalDetails']->hospital_name}}
                                                                            ( {{$feeReceiptDetails['hospitalDetails']->hid}} )
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <label class="col-sm-4 control-label">Address</label>
                                                                        <div class="col-sm-8">
                                                                            {{$feeReceiptDetails['hospitalDetails']->address}}, <br/>
                                                                            {{$feeReceiptDetails['hospitalDetails']->cityName}}, {{$feeReceiptDetails['hospitalDetails']->country}}
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                        </div><!-- /.box-body -->

                                                </div>

                                                <div class="col-xs-4">
                                                    <address>
                                                        <strong>Doctor Details:</strong><br>
                                                    </address>
                                                    <div class="box-body">
                                                        <div class="col-md-12">
                                                                <label class="col-sm-6 control-label">Doctor ID</label>
                                                                <div class="col-sm-6">
                                                                    {{$feeReceiptDetails['doctorDetails']->did}}
                                                                </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                                <label class="col-sm-6 control-label">Name</label>
                                                                <div class="col-sm-6">
                                                                    {{$feeReceiptDetails['doctorDetails']->name}}
                                                                </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                                <label class="col-sm-6 control-label">Designation</label>
                                                                <div class="col-sm-6">
                                                                    {{$feeReceiptDetails['doctorDetails']->designation}}
                                                                </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                                <label class="col-sm-6 control-label">Department</label>
                                                                <div class="col-sm-6">
                                                                    {{$feeReceiptDetails['doctorDetails']->department}}
                                                                </div>
                                                        </div>
                                                    </div><!-- /.box-body -->
                                                </div>

                                                <div class="col-xs-4">
                                                    <address>
                                                        <strong>Patient Details:</strong><br>
                                                    </address>

                                                    <div class="box-body">
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Patient ID</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->pid}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Name</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->name}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Number</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->telephone}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Address</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->address}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Relationship</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->relationship}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="col-sm-6 control-label">Relation Name</label>
                                                            <div class="col-sm-6">
                                                                {{$feeReceiptDetails['patientDetails']->spouseName}}
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><strong>Fees Details</strong></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <div class="box">
                                                            <div class="box-body">

                                                                <div class="col-md-12">
                                                                    <div class="form-group col-md-12">
                                                                        Received Rs: {{$feeReceiptDetails['feeDetails']['fee']}} ( In Words {{$feeReceiptDetails['feeDetails']['inWords']}} ) with thanks towards doctor consultation charges
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1"></div>

                                                            </div><!-- /.box-body -->
                                                        </div><!-- /.box -->
                                                    </div>

                                                    <div class="hidden-print hidden">
                                                        <div class="pull-right">
                                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>

                                                            <a href="javascript:void(0);" id="showModalSMS" class="btn btn-success waves-effect waves-light"><i class="fa fa-mobile"></i></a>

                                                            <a href="javascript:void(0);" id="showModalEMAIL" class="btn btn-success waves-effect waves-light"><i class="fa fa-envelope-o"></i></a>

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




<link rel="stylesheet" href="{{ URL::to('/') }}/plugins/rmodal/dist/rmodal.css" type="text/css" />
<script type="text/javascript" src="{{ URL::to('/') }}/plugins/rmodal/dist/rmodal.js"></script>

<script type="text/javascript">
    /*
    window.onload = function() {
        var modalsms = new RModal(document.getElementById('modalsms'), {
            beforeOpen: function(next) {
                console.log('beforeOpen');
                next();
            }
            , afterOpen: function() {
                console.log('opened');
            }

            , beforeClose: function(next) {
                console.log('beforeClose');
                next();
            }
            , afterClose: function() {
                console.log('closed');
            }
        });

        document.addEventListener('keydown', function(ev) {
            modalsms.keydown(ev);
        }, false);

        document.getElementById('showModalSMS').addEventListener("click", function(ev) {
            ev.preventDefault();
            modalsms.open();
        }, false);

        window.modal = modalsms;
    }
    */
</script>
<script type="text/javascript">


    window.onload = function() {

        var modalsms = new RModal(document.getElementById('modalsms'), {
            beforeOpen: function(next1) {
                console.log('beforeOpen');
                next1();
            }
            , afterOpen: function() {
                console.log('opened');
            }

            , beforeClose: function(next1) {
                console.log('beforeClose');
                next1();
            }
            , afterClose: function() {
                console.log('closed');
            }
        });

        document.addEventListener('keydown', function(ev1) {
            modalsms.keydown(ev1);
        }, false);

        document.getElementById('showModalSMS').addEventListener("click", function(ev1) {
            ev1.preventDefault();
            modalsms.open();
        }, false);

        window.modalsms = modalsms;

        var modalemail = new RModal(document.getElementById('modalemail'), {
        beforeOpen: function(next2) {
            console.log('beforeOpen');
            next2();
        }
        , afterOpen: function() {
            console.log('opened');
        }

        , beforeClose: function(next2) {
            console.log('beforeClose');
            next2();
        }
        , afterClose: function() {
            console.log('closed');
        }
    });

    document.addEventListener('keydown', function(ev2) {
        modalemail.keydown(ev2);
    }, false);

    document.getElementById('showModalEMAIL').addEventListener("click", function(ev2) {
        ev2.preventDefault();
        modalemail.open();
    }, false);

    window.modalemail = modalemail;


    }
</script>
@endsection
