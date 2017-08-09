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
                        <h4 class="page-title">Add Patient Symptoms</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
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
<?php /*  * / ?>
                                            {{print_r($patientDetails)}}
                                            {{print_r($mainSymptoms)}}
                                            {{print_r($subSymptoms)}}
                                            {{print_r($symptomsForSubSymptoms)}}
<?php / * */ ?>
                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/symptomdetails" role="form" method="POST" class="form-horizontal ">
<style>
    .addButton, .removeButton { float:right; }
</style>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Symptom Details</label><br /><br />
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label"></label>
                                                    <div class="col-sm-10" id="symptom-form">
                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                               Main Symptom
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                               Sub Symptom
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                Symptom
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="mainsymptombox" class="form-control" name="symptomDetails[0][mainSymptomId]" required="required">
                                                                    <option value="0">Main Symptom</option>
                                                                    <?php foreach($mainSymptoms as $mainSymptomsValue) { ?>
                                                                    <option value="{{$mainSymptomsValue->id}}">{{$mainSymptomsValue->main_symptom_name}}</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="symptomDetails[0][mainSymptomId]" placeholder="Main Symptom" required="required" />
                                                                -->
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="subsymptombox" class="form-control" name="symptomDetails[0][subSymptomId]" required="required">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="symptomDetails[0][subSymptomId]" placeholder="Sub Symptom" required="required" />
                                                                -->
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="symptombox" class="form-control" name="symptomDetails[0][symptomId]" required="required" style="width:80%;float: left;">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="symptomDetails[0][symptomId]" placeholder="Symptom" required="required" style="width:80%;float: left;" />
                                                                -->
                                                                <input type="hidden" class="form-control" name="symptomDetails[0][symptomDate]" value="{{date('Y-m-d')}}" required="required" />
                                                                <input type="hidden" class="form-control" name="symptomDetails[0][isValueSet]" value="1" required="required" />
                                                                <div class="btn btn-primary addButton">+</div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group remove-doc-box hide" id="symptomTemplate">
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="mainsymptombox" class="form-control" name="main_symptom">
                                                                    <option value="0">Main Symptom</option>
                                                                    <?php foreach($mainSymptoms as $mainSymptomsValue) { ?>
                                                                    <option value="{{$mainSymptomsValue->id}}">{{$mainSymptomsValue->main_symptom_name}}</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="main_symptom" placeholder="Main Symptom" />
                                                                -->
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="subsymptombox" class="form-control" name="sub_symptom">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="sub_symptom" placeholder="Sub Symptom" />
                                                                -->
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                                <select id="symptombox" class="form-control" name="symptom" style="width:80%;float: left;">
                                                                </select>
                                                                <!--
                                                                <input type="text" class="form-control" name="symptom" placeholder="Symptom" style="width:80%;float: left;" />
                                                                -->
                                                                <input type="hidden" class="form-control" name="symptom_date" value="{{date('Y-m-d')}}" />
                                                                <input type="hidden" class="form-control" name="symptom_status" value="{{date('Y-m-d')}}" />
                                                                <div class="btn btn-default removeButton min-button" value="-">-</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />

                                                        <input type="submit" name="addsymptom" value="Save" class="btn btn-success">
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

    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function(){

            $('body').on("change","#mainsymptombox", function () {
                 //alert('HI');
                 var BASEURL = "{{ URL::to('/') }}/";
                 var categoryId = $(this).find('option:selected').val();
                 var status = 1;
                 var callurl = BASEURL + 'fronthospital/rest/api/getsubsymptom';
                 console.log(categoryId+' '+callurl);
                 $.ajax({
                 url: callurl,
                 type: "get",
                 data: {"categoryId": categoryId, "status": status},
                 success: function (data) {
                 console.log(data);
                 $("#subsymptombox").html(data);
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
                    data: {"categoryId": categoryId, "status": status},
                    success: function (data) {
                        console.log(data);
                        $("#symptombox").html(data);
                    }
                });
            });
        });
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
                                    .find('[name="main_symptom"]').attr('name', 'symptomDetails[' + symptomIndex + '][mainSymptomId]').end()
                                    .find('[name="sub_symptom"]').attr('name', 'symptomDetails[' + symptomIndex + '][subSymptomId]').end()
                                    .find('[name="symptom"]').attr('name', 'symptomDetails[' + symptomIndex + '][symptomId]').end()
                                    .find('[name="symptom_date"]').attr('name', 'symptomDetails[' + symptomIndex + '][symptomDate]').end()
                                    .find('[name="symptom_status"]').attr('name', 'symptomDetails[' + symptomIndex + '][isValueSet]').end();

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