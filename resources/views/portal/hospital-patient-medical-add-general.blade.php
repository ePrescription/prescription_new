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
                        <h4 class="page-title">Add Patient General Examination</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h4 class="m-t-0 m-b-30">Add General Examination</h4>


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

                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Height (in Cm)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Weight (in Kg)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BMI</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Pallor</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Cyanosis</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Clubbing of Fingers / Toes</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Lymphadenopathy</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Oedema In Feet</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Malnutrition</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Dehydration</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Temperature (C/F)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Pulse rate per minute</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Respiration (count for a full minute) rate</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BP Lt.Arm mm/Hg</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">BP Rt.Arm mm/Hg</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="submit" name="addgeneral" value="Save" class="btn btn-success"/>
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