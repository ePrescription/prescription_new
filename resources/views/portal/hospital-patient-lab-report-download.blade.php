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
                    <h4 class="page-title">Patient Lab Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">



                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="dropdown">
                                    <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                    <div class="dropdown-content">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>
                                        <!-- By Ramana 12-01-2018-->
                                        &nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>

                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                        &nbsp;&nbsp;
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i>Print Medical Profile </a>
                                    </div>
                                </div>

                                    <div style="float:right;">

                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back to Patients List</button>
                                        </a>
                                    </div>

                                    <div style="float:right;display:none;">
                                    <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <div style="float:right; display:none;">
                                        <a style="margin: 0px 10px;" href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labtestreceipts?hospitalId={{Auth::user()->id}}">
                                            <button class="btn btn-error waves-effect waves-light">Generate Receipt</button>
                                        </a>
                                    </div>
                                    <h4 class="m-t-0 m-b-30">Patient Lab Details</h4>


                                    @if (session()->has('message'))
                                        <div class="col_full login-title">
                                            <span style="color:red;">
                                                <p class="text-danger">{{session('message')}}</p>
                                            </span>
                                        </div>
                                    @endif

                                    @if (session()->has('success'))
                                        <div class="col_full login-title">
                                            <span style="color:green;">
                                                <p class="text-success">{{session('success')}}</p>
                                            </span>
                                        </div>
                                    @endif


                                    <div class="row">

                                        <div class="col-lg-2">
                                            @if($patientDetails[0]->patient_photo=="")

                                                <img src="{{URL::to('/')}}/uploads/patient_photo/noimage.png"  />

                                            @else

                                                <img src="{{URL::to('/')}}/{{$patientDetails[0]->patient_photo}}"  style="width:100px;" />

                                            @endif
                                        </div>
                                        <div class="col-lg-10">


                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">PID</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Number</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">E-Mail</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Age</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-3 control-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-6 control-label">Relation Name</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->spouseName}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <?php /* ?>
                                            <?php $displaySet=0; ?>
                                            <div class="form-group">
                                                @foreach($recentTest as $recentTestDate)
                                                    @if($displaySet==0)
                                                        <label class="col-sm-12 control-label">{{$recentTestDate->examinationDate}} - {{$recentTestDate->examination_time}} </label>
                                                        <?php $displaySet=1; ?>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <?php */ ?>

                                            @if(count($labReports)>0)
                                                <h4 class="m-t-0 m-b-30">Test Reports</h4>
                                                    <div class="form-group col-sm-4">
                                                        <strong>Document Name</strong>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <strong>Document Type</strong>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <strong>Document Download</strong>
                                                    </div>
                                                @foreach($labReports as $labReport)

                                                    <div class="form-group col-sm-4">
                                                        {{$labReport->document_name}} - {{$labReport->document_upload_date}}
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        {{$labReport->test_category_name}}
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <?php /* ?>{{$labReport->document_path}}<?php */ ?>
                                                        <a href="{{URL::to('/')}}/lab/rest/labreports/{{$labReport->document_item_id}}/report"> <i class="fa fa-download"></i> Download </a>
                                                    </div>

                                                @endforeach
                                            @endif

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



@section('scripts')


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>

        $(document).ready(function(){
            $( "input#TestTime" ).timepicker({
                timeFormat: 'HH:mm:ss',
                interval: 60,
                minTime: '10',
                maxTime: '6:00pm',
                defaultTime: '11',
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });


        function printDiv()
        {
            var divToPrint=document.getElementById('DivIdToPrint');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        }

        function UpdateTestDates(dateValue) {

            for (var i = 0; i < $('input#TestDates').length; i++) {
                $('input#TestDates').val(dateValue);
            }

        }

        function UpdateTestTimes(timeValue) {

            for (var i = 0; i < $('input#TestTimes').length; i++) {
                $('input#TestTimes').val(timeValue);
            }

        }

    </script>




    <script>
        /*
         $( function() {
         $( "#TestDate" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
         } );
         */
    </script>


    <script>

        $(document).ready(function() {
            symptomIndex = 0;
            $('#symptom-form')
                    .on('click', '.addButton', function() {
                        symptomIndex++;
                        var $template = $('#symptomTemplate'),
                                $clone    = $template.clone().removeClass('hide').removeAttr('id').attr('data-book-index', symptomIndex).insertBefore($template);

                        $clone
                                .find('[name="report_type"]').attr('name', 'lab_documents[' + symptomIndex + '][test_category_name]').end()
                                .find('[name="report_name"]').attr('name', 'lab_documents[' + symptomIndex + '][document_name]').end()
                                .find('[name="report_document"]').attr('name', 'lab_documents[' + symptomIndex + '][document_upload_path]').end();

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