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
$prescription_menu="0";
$lab_menu="0";
$profile_menu="0";
?>
@section('content')
    <div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')
    <!-- /.sidebar -->


        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Doctor Patients List</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="panel panel-primary">
                                    <div class="panel-body">

                                        <div class="form-group col-md-12" id="searchPatientBox" style="display:block;">
                                            <label class="col-sm-3 control-label">Select Doctor</label>
                                            <div class="col-sm-12">
                                                <!--
                                                <input type="text" class="form-control" name="searchPatient" value="" id="autocomplete-ajax" />



                                                <select name="searchPatient" id="searchPatient" class="form-control patientUpdate" onchange="javascript:getPatient(this.value);"  title="Select for a state"  search><option></option></select>
                                                -->
                                                <select width="50%" name="doctorId" id="doctorId" class="form-control patientUpdate" onchange="javascript:getDoctorsAvailabilities(this.value);">
                                                    <option value="">--CHOOSE DOCTOR--</option>
                                                    @foreach($doctorsList as $doctor)
                                                        <option value="{{$doctor->doctor_id}}" >{{$doctor->name}} - {{$doctor->specialty}}</option>
                                                    @endforeach
                                                </select>



                                            </div>
                                            <div id="doctorInfo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        @include('portal.hospital-footer')

                    </div>
                    <!-- End Right content here -->


                </div><!-- ./wrapper -->
            </div>
        </div>

        <script>
            function getDoctorsAvailabilities(did) {

                // $("input#doctorId").val(did);
                var BASEURL = "{{ URL::to('/') }}/";
                var status = 1;

                var callurl = BASEURL + 'fronthospital/rest/api/{{Auth::user()->id}}/doctorId/' + did + '/availability';


                $.ajax({
                    url: callurl,
                    type: "get",
                    data: {"id": did, "status": status},
                    success: function (data) {
                        //alert();
                        console.log(data);
                        $("#doctorInfo").html(data);


                    }

                });

            }
        </script>
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
    {!!  Html::script(asset('theme/assets/js/app.js')) !!}
@stop

