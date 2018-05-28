@extends('layout.master-doctor-inner')

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
    @include('portal.doctor-header')
    <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.doctor-sidebar')
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
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">

                                        <h4 class="m-b-30 m-t-0">Doctor Patients Questions List</h4>


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

                                    <!-- Modal -->
                                        <div id="myModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Modal Header</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{URL::to('/')}}/doctor/rest/api/{{Session::get('LoginUserHospital')}}/{{ Auth::user()->id }}/saveanswers" role="form" id="referraldoctor" method="POST">
                                                            <div class="col-md-12">

                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">PatientId</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="hidden" class="form-control" id="Id" name="Id"  required="required" />

                                                                        <input type="hidden" class="form-control" id="hospitalId" name="hospitalId" value="{{Session::get('LoginUserHospital')}}" required="required" />

                                                                        <input type="hidden" class="form-control" id="doctorId" name="doctorId" value="{{ Auth::user()->id }}" required="required" />

                                                                        <input type="text" class="form-control" id="patientId" name="patientId" value="" readonly required="required" />

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">Message</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="message" name="message" value="" readonly required="required" />

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">Age</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="age" name="age" value="" readonly required="required" />

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">Gender</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="gender" name="gender" value="" readonly required="required" />

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">File</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="filepath" name="filepath" value="" readonly required="required" />

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-sm-3 control-label">Answer</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control" id="answer" name="answer" style="width: 411px;height: 171px;" value="" required="required" ></textarea>
                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-success" style="float:right;">Save Profile</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                            </div>

                                                        </form>                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                        <!-- Trigger the modal with a button -->


                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table id="datatable" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>patientId</th>
                                                        <th>Message</th>
                                                        <th>Priority Level</th>
                                                        <th>Gender</th>
                                                        <th>age</th>
                                                        <th>Image</th>
                                                        <th>Answer</th>
                                                    </tr>
                                                    </thead>

                                                    <?php $gender=null; ?>
                                                    <tbody>
                                                    @foreach($patientQuestions as $patient)
                                                        <tr>

                                                            <td>{{$patient->name}}</td>
                                                            <td>{{$patient->message}}</td>
                                                            <td>{{$patient->priority}}</td>
                                                            <td>@if($patient->gender==1) <?php $gender="Male"; ?> Male @else Female <?php $gender="FeMale"; ?> @endif</td>
                                                            <td>{{$patient->age}}</td>
                                                            <td>{{$patient->filepath}}</td>
                                                            <td><button onclick="updateQuestion('{{$patient->id}}','{{$patient->patient_id}}','{{$patient->message}}','{{$patient->filepath}}','{{$patient->age}}','{{$gender}}')"  class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Answer</button></td>
                                                        <?php $gender=null; ?>
                                                         @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- End Row -->



                    </div><!-- container -->


                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            @include('portal.doctor-footer')

        </div>
        <!-- End Right content here -->


    </div><!-- ./wrapper -->
@endsection
<script>
    function updateQuestion(id,pid,message,filepath,age,gender) {

        document.getElementById("Id").value=id;
        document.getElementById("patientId").value=pid;
        document.getElementById("message").value=message;
        document.getElementById("filepath").value=filepath;
        document.getElementById("gender").value=gender;
        document.getElementById("age").value=age;

        var modal = document.getElementById('myModal');

        modal.style.display = "block";

        
    }

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

