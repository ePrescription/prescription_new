@extends('layout.master-doctor-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
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

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Add Patient Symptoms</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Symptoms</h4>


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

                                            <form action="{{URL::to('/')}}/doctor/complaints" role="form" method="POST" class="form-horizontal ">
<style>
    .addButton, .removeButton { float:right; }
</style>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Complaint Details</label><br /><br />
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label"></label>
                                                    <div class="col-sm-10" id="complaint-form">
                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                               Complaint Type
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                               Complaint
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <select id="complainttypebox" class="form-control" name="complaints[0][complaintTypeId]" required="required">
                                                                    <option value="0">Complaint Type</option>
                                                                    <?php foreach($ComplaintTypes as $ComplaintTypesValue) { ?>
                                                                    <option value="{{$ComplaintTypesValue->id}}">{{$ComplaintTypesValue->complaint_name}}</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <select id="complaintbox" class="form-control" name="complaints[0][complaintId]" required="required" style="width:80%;float: left;">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="complaints[0][complaintId]" placeholder="Sub Symptom" required="required" />
                                                                -->
                                                                <input type="hidden" class="form-control" name="complaints[0][complaintDate]" value="{{date('Y-m-d')}}" required="required" />
                                                                <input type="hidden" class="form-control" name="complaints[0][isValueSet]" value="1" required="required" />
                                                                <div class="btn btn-primary addButton">+</div>

                                                            </div>

                                                        </div>

                                                        <div class="form-group remove-doc-box hide" id="complaintTemplate">
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <select id="complainttypebox" class="form-control" name="complaint_type">
                                                                    <option value="0">Complaint Type</option>
                                                                    <?php foreach($ComplaintTypes as $ComplaintTypesValue) { ?>
                                                                    <option value="{{$ComplaintTypesValue->id}}">{{$ComplaintTypesValue->complaint_name}}</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="main_symptom" placeholder="Main Symptom" />
                                                                -->
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <select id="complaintbox" class="form-control" name="complaint_name" style="width:80%;float: left;">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="sub_symptom" placeholder="Sub Symptom" />
                                                                -->
                                                                <input type="hidden" class="form-control" name="complaint_date" value="{{date('Y-m-d')}}" />
                                                                <input type="hidden" class="form-control" name="complaint_status" value="1" />
                                                                <div class="btn btn-default removeButton min-button" value="-">-</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-2" style="text-align: right;">Notes</div>
                                                    <div class="col-sm-8">
                                                      <textarea name="complaintText" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">

                                                        <input type="hidden" class="form-control" name="doctorId" value="{{$doctorId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="hospitalId" value="{{$hospitalId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />

                                                        <input type="hidden" class="form-control" name="complaintDate" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="examinationTime" value="{{date('h:i:s')}}" required="required" />

                                                        <input type="submit" name="addcomplaint" value="Save" class="btn btn-success">
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

            @include('portal.doctor-footer')

        </div>
        <!-- End Right content here -->

    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function(){

            $("#complainttypebox").on("change", function () {
                 //alert('HI');
                 var BASEURL = "{{ URL::to('/') }}/";
                 var categoryId = $(this).find('option:selected').val();
                 var status = 1;
                 var callurl = BASEURL + 'fronthospital/rest/api/getcomplaint';
                 console.log(categoryId+' '+callurl);
                 $.ajax({
                 url: callurl,
                 type: "get",
                 data: {"categoryId": categoryId, "status": status},
                 success: function (data) {
                 console.log(data);
                 $("#complaintbox").html(data);
                 }
                 });
            });

            $('body').on("change","#complainttypebox", function () {
                //alert('HI');
                var BASEURL = "{{ URL::to('/') }}/";
                var categoryId = $(this).find('option:selected').val();
                var status = 1;
                var callurl = BASEURL + 'fronthospital/rest/api/getcomplaint';
                console.log(categoryId+' '+callurl);
                $.ajax({
                    url: callurl,
                    type: "get",
                    context: this,
                    data: {"categoryId": categoryId, "status": status},
                    success: function (data) {
                        console.log(data);
                        //$("#subsymptombox").html(data);
                        $(this).parents( "div.remove-doc-box" ).find("#complaintbox").html(data);
                    }
                });
            });


            /*

            $("#subsymptombox").on("change",function () {
                //alert('HI');
                var BASEURL = "{{ URL::to('/') }}/";
                var categoryId = $(this).find('option:selected').val();
                var status = 1;
                var callurl = BASEURL + 'fronthospital/rest/api/getsymptomname';
                console.log(categoryId+' '+callurl);
                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"categoryId": categoryId, "status": status},
                    success: function (data) {
                        console.log(data);
                        $("#symptombox").html(data);
                    }
                });
            });

            $('body').on("change", "#subsymptombox", function () {
                //alert('HI');
                var BASEURL = "{{ URL::to('/') }}/";
                var categoryId = $(this).find('option:selected').val();
                var status = 1;
                var callurl = BASEURL + 'fronthospital/rest/api/getsymptomname';
                console.log(categoryId+' '+callurl);
                $.ajax({
                    url: callurl,
                    type: "get",
                    context: this,
                    data: {"categoryId": categoryId, "status": status},
                    success: function (data) {
                        console.log(data);
                        $(this).parents( "div.remove-doc-box" ).find("#symptombox").html(data);
                    }
                });
            });
            */

        });
    </script>

        <script>

            $(document).ready(function() {
                complaintIndex = 0;
                $('#complaint-form')
                        .on('click', '.addButton', function() {
                            complaintIndex++;
                            var $template = $('#complaintTemplate'),
                                    $clone    = $template.clone().removeClass('hide').removeAttr('id').attr('data-book-index', complaintIndex).insertBefore($template);

                            $clone
                                    .find('[name="complaint_type"]').attr('name', 'complaints[' + complaintIndex + '][complaintTypeId]').end()
                                    .find('[name="complaint_name"]').attr('name', 'complaints[' + complaintIndex + '][complaintId]').end()
                                    .find('[name="complaint_date"]').attr('name', 'complaints[' + complaintIndex + '][complaintDate]').end()
                                    .find('[name="complaint_status"]').attr('name', 'complaints[' + complaintIndex + '][isValueSet]').end();

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