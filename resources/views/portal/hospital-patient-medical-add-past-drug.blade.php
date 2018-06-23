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
                        <h4 class="page-title">Add Patient Past Drug</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Past Drug</h4>


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


                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/drughistory" role="form" method="POST" class="form-horizontal ">
<style>
    .addButton, .removeButton { float:right; }
</style>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Drug Details</label><br /><br />
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label"></label>
                                                    <div class="col-sm-10" id="drug-form">
                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                               Drug Name
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                Drug Dosage
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                Drug Timing
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drugHistory[0][drugName]" placeholder="Drug Name" required="required" />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drugHistory[0][dosage]" placeholder="Drug Dosage" required="required" />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drugHistory[0][timings]" placeholder="Drug Timing" required="required" style="width:80%;float: left;" />
                                                                <input type="hidden" class="form-control" name="drugHistory[0][drugHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                                <div class="btn btn-primary addButton">+</div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group remove-doc-box hide" id="drugTemplate">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drug_name" placeholder="Drug Name" />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drug_dosage" placeholder="Drug Dosage" />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="drug_timing" placeholder="Drug Timing" style="width:80%;float: left;" />
                                                                <input type="hidden" class="form-control" name="drug_date" value="{{date('Y-m-d')}}" />
                                                                <div class="btn btn-default removeButton min-button" value="-">-</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Surgery Details</label><br /><br />
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label"></label>
                                                    <div class="col-sm-10" id="surgery-form">
                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                Surgery Name
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                Surgery Date
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="surgeryHistory[0][surgeryName]" placeholder="Surgery Name"  />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control datepicker" name="surgeryHistory[0][operationDate]" placeholder="Operation Date (YYYY-MM-DD)"  style="width:80%;float: left;" />
                                                                <input type="hidden" class="form-control" name="surgeryHistory[0][surgeryInputDate]" value="{{date('Y-m-d')}}" />
                                                                <div class="btn btn-primary addButton">+</div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group remove-doc-box hide" id="surgeryTemplate">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control" name="surgery_name" placeholder="Surgery Name" />
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <input type="text" class="form-control datepicker" name="operation_date" placeholder="Operation Date (YYYY-MM-DD)" style="width:80%;float: left;" />
                                                                <input type="hidden" class="form-control" name="surgery_date" value="{{date('Y-m-d')}}" />
                                                                <div class="btn btn-default removeButton min-button" value="-">-</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />

                                                        <input type="submit" name="addpersonal" value="Save" class="btn btn-success">

                                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="margin: 0px 16px;"><button type="button" class="btn btn-success"> Cancel </button></a>
                                                    </div>
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


@endsection

@section('scripts')

            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
/*
                $( function() {
                    $( ".datepicker" ).datepicker({ maxDate: new Date() });
                } );
*/

                $('body').on('focus', '.datepicker', function(){
                    $(this).datepicker({ dateFormat: 'yy-mm-dd',maxDate: new Date() } );
                }).on('click', '.datepicker', function(){
                    $(this).datepicker({ dateFormat: 'yy-mm-dd',maxDate: new Date() } );
                });
            </script>


        <script>

            $(document).ready(function() {
                drugIndex = 0;
                $('#drug-form')
                        .on('click', '.addButton', function() {
                            drugIndex++;
                            var $template = $('#drugTemplate'),
                                    $clone    = $template.clone().removeClass('hide').removeAttr('id').attr('data-book-index', drugIndex).insertBefore($template);

                            $clone
                                    .find('[name="drug_name"]').attr('name', 'drugHistory[' + drugIndex + '][drugName]').end()
                                    .find('[name="drug_dosage"]').attr('name', 'drugHistory[' + drugIndex + '][dosage]').end()
                                    .find('[name="drug_timing"]').attr('name', 'drugHistory[' + drugIndex + '][timings]').end()
                                    .find('[name="drug_date"]').attr('name', 'drugHistory[' + drugIndex + '][drugHistoryDate]').end();

// Add new fields

                        })

// Remove button click handler
                        .on('click', '.removeButton', function() {
//alert("Hi");
                            var $row  = $(this).parents('.remove-doc-box'),
                                    index = $row.attr('data-book-index');

//alert(attr('data-book-index'));
// Remove element containing the fields
                            $row.remove();
                        });
            });

        </script>

            <script>

                $(document).ready(function() {
                    surgeryIndex = 0;
                    $('#surgery-form')
                            .on('click', '.addButton', function() {
                                surgeryIndex++;
                                var $template = $('#surgeryTemplate'),
                                        $clone    = $template.clone().removeClass('hide').removeAttr('id').attr('data-book-index', surgeryIndex).insertBefore($template);

                                $clone
                                        .find('[name="surgery_name"]').attr('name', 'surgeryHistory[' + surgeryIndex + '][surgeryName]').end()
                                        .find('[name="operation_date"]').attr('name', 'surgeryHistory[' + surgeryIndex + '][operationDate]').end()
                                        .find('[name="surgery_date"]').attr('name', 'surgeryHistory[' + surgeryIndex + '][surgeryInputDate]').end();

// Add new fields

                            })

// Remove button click handler
                            .on('click', '.removeButton', function() {
//alert("Hi");
                                var $row  = $(this).parents('.remove-doc-box'),
                                        index = $row.attr('data-book-index');

//alert(attr('data-book-index'));
// Remove element containing the fields
                                $row.remove();
                            });
                });

            </script>

@stop