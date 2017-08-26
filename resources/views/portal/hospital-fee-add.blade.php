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

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                    <h4>Invoice</h4>
                                </div> -->
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
                                <div class="panel-heading">
                                    <h4>Add Doctor Fee Details</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-xs-12">

                                            <!--
                                            <div class="invoice-title">
                                                <h4 class="pull-right">Order # 12345</h4>
                                                <h3 class="m-t-0">UPBOND</h3>
                                            </div>
                                            <hr>
                                            -->

                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/savefeereceipt" role="form" method="POST">

                                                <div class="col-xs-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Patient Details</strong></h3>
                                                        </div><!-- /.box-header -->
                                                        <div class="panel-body">

                                                            <div class="col-md-4">
                                                                <select name="patientId" id="patientId" class="form-control patientUpdate" onchange="patientUpdate();">
                                                                    <option value="">--CHOOSE PATIENT--</option>
                                                                    @foreach($patients as $patient)
                                                                        <option value="{{$patient->patient_id}}" >{{$patient->pid}} - {{$patient->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">

                                                                @foreach($patients as $patient)
                                                                    <div id="patientdisplay{{$patient->patient_id}}" class="patientdisplay" style="display: none;">
                                                                        Patient ID: {{$patient->pid}} <br/>
                                                                        Patient Name: {{$patient->name}}<br/>
                                                                        Patient Age: {{$patient->age}}<br/>
                                                                        Patient Gender: @if($patient->gender==1) Male @else Femaile @endif<br/>
                                                                        Patient Mobile: {{$patient->telephone}}<br/>
                                                                    </div>
                                                                @endforeach


                                                            </div>

                                                            <div class="col-md-1"></div>


                                                        </div><!-- /.box-body -->
                                                    </div><!-- /.box -->

                                                </div>


                                                <div class="col-xs-12">

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Doctor Details</strong></h3>
                                                        </div><!-- /.box-header -->
                                                        <div class="panel-body">

                                                            <div class="col-md-4">
                                                                <select name="doctorId" id="doctorId" class="form-control doctorUpdate" onchange="doctorUpdate();">
                                                                    <option value="">--CHOOSE DOCTOR--</option>
                                                                    @foreach($doctors as $doctor)
                                                                        <option value="{{$doctor->doctorId}}">{{$doctor->doctorUniqueId}} - {{$doctor->doctorName}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">

                                                                @foreach($doctors as $doctor)
                                                                    <div id="doctordisplay{{$doctor->doctorId}}" class="doctordisplay" style="display: none;">

                                                                        Doctor ID: {{$doctor->doctorUniqueId}}
                                                                        <br/>
                                                                        Doctor Name: {{$doctor->doctorName}}

                                                                    </div>
                                                                @endforeach

                                                            </div>

                                                            <div class="col-md-1"></div>


                                                        </div><!-- /.box-body -->
                                                    </div><!-- /.box -->

                                                </div>

                                                <div class="col-xs-12">

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Fee Details</strong></h3>
                                                        </div><!-- /.box-header -->
                                                        <div class="panel-body">

                                                            <div class="col-md-12">
                                                                <div class="form-group col-md-12">
                                                                    Received Rs: <input type="text" name="fees" value="" class="form-control" style="display: inline;width: 200px;" /> with thanks towards doctor consultation charges
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1"></div>


                                                        </div><!-- /.box-body -->
                                                        <div class="panel-body">

                                                            <div class="col-md-12">
                                                                <div class="form-group col-md-12">
                                                                    <input type="hidden" name="hospitalId" value="{{Auth::user()->id}}" class="form-control"/>
                                                                    <input type="submit" name="addfee" value="SUBMIT FEE" class="btn btn-success"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"></div>


                                                        </div><!-- /.box-body -->

                                                    </div><!-- /.box -->

                                                </div>

                                            </form>


                                    <div class="row hidden">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">

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


<script>
    function printDiv()
    {

        var divToPrint=document.getElementById('PagePrint');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    }

    function patientUpdate()
    {
        var patientIdValue=document.getElementById('patientId');
        var pVal=patientIdValue.value;

        var elements=document.getElementsByClassName("patientdisplay");
        var n = elements.length;
        for (var i = 0; i < n; i++) {
            var e = elements[i];

            if(e.style.display == 'block') {
                e.style.display = 'none';
            } else {
                //e.style.display = 'block';
            }
        }
        document.getElementById('patientdisplay'+pVal).style.display="block";

    }


    function doctorUpdate()
    {
        var doctorIdValue=document.getElementById('doctorId');
        var dVal=doctorIdValue.value;
        var elements=document.getElementsByClassName("doctordisplay");
        var n = elements.length;
        for (var i = 0; i < n; i++) {
            var e = elements[i];

            if(e.style.display == 'block') {
                e.style.display = 'none';
            } else {
                //e.style.display = 'block';
            }
        }
        document.getElementById('doctordisplay'+dVal).style.display="block";

    }
</script>
@endsection
