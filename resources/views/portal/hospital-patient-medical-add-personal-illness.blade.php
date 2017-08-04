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
                        <h4 class="page-title">Add Patient Personal Illness</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h4 class="m-t-0 m-b-30">Add Personal Illness</h4>


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

                                                    <label class="col-sm-4 control-label">Marital Status</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Single </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Married </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Appetite</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Normal </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Lost </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Diet</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Inline One </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Inline Two </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Bowels</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Veg </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Non Ved </label>
                                                        </div>

                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Eggetarian </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Nutrition</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                            <label for="inlineRadio1"> Regular </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Irregular </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                            <label for="inlineRadio2"> Constipation </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Known Allergies</label>
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

                                                    <label class="col-sm-4 control-label">Habits / Addictions</label>
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
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="submit" name="addpersonal" value="Save" class="btn btn-success">
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