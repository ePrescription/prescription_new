@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="1";
$patient_menu="0";
$profile_menu="0";
?>
@section('content')
    <div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')

    </div><!-- /.wrapper-page -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <input type='button' class="btn btn-success" value='Print' onclick="print('label')"/>

                <input type='button'  class="btn btn-info" value='Back' onclick="window.history.back();"/>


   <div class="bg">



    <div class="modal-body" id='label'>
        <center>
            <br>



            <table style='width:100%;height:180px;border-color:black;border-width:1px;' >
                <tr bgcolor='#063751' style='color:white;font-size:10px'> <th colspan='6' ><center>{{ $doctorappointments->hospital_name}}<span></span></center> </th></tr>
                <tr style='font-size:10px'> <td > Token ID</td><td> :</td><td style='width:25%;'><span >{{$doctorappointments->token_id}}</span></td><td style='width:10%;'> </td><td> </td><td><span ></span></td></tr>
                <tr style='font-size:10px'> <td > Patient ID</td><td> :</td><td style='width:25%;'><span >{{$doctorappointments->patient_id}}</span></td><td style='width:10%;'> Date</td><td> :</td><td><span >{{ date('d-m-Y',strtotime($doctorappointments->appointment_date))}} {{ $doctorappointments->time}}</span></td></tr>
                <tr style='font-size:10px'><td>Name </td><td>:</td><td colspan='3'> <span > {{$doctorappointments->patient_name}}</span></td></tr>
                <tr style='font-size:10px'><td>Address </td><td>:</td><td> <span> {{$doctorappointments->address}} </span></td><td>Gender </td><td>:</td><td>
                        @if($doctorappointments->gender==1)
                        <span>
                           <b>Male</b>
                        </span>@else
                            <span>
                           <b>Female</b>
                        </span>
                        @endif

                    </td></tr>
                <tr style='font-size:10px'><td>Mobile / Phone No </td><td>:</td><td colspan='3'> <span>{{$doctorappointments->telephone}}</span></td></tr>
                <tr style='font-size:10px'><td>Referred By </td><td>:</td><td colspan='5'> <span>{{ $doctorappointments->name }}({{ $doctorappointments->specialty}})</span></td></tr>
                <tr style='font-size:9px'><td colspan='5'> </td><td>Authorized Signatory </td></tr>
                <tr style='font-size:8px'><td colspan='5'> </td></tr>
                <tr > <th colspan='6' bgcolor='#063751' style='color:white;font-size:10px'><center>{{$doctorappointments->hsaddress}}<span> </span> </center> </th></tr>

            </table>
            <br>

            <table style='width:100%;height:180px;border-color:black;border-width:1px;' >
                <tr bgcolor='#063751' style='color:white;font-size:10px'> <th colspan='6' ><center>{{ $doctorappointments->hospital_name}}<span></span></center> </th></tr>
                <tr style='font-size:10px'> <td> Patient ID</td><td> :</td><td style='width:25%;'><span ></span></td><td style='width:10%;'> Date</td><td> :</td><td><span >{{ date('d-m-Y',strtotime($doctorappointments->appointment_date))}} {{ $doctorappointments->time}}</span></td></tr>
                <tr style='font-size:10px'><td>Name </td><td>:</td><td colspan='3'> <span > {{session('userID')}}</span></td></tr>
                <tr style='font-size:10px'> <td > Bed Name</td><td> :</td><td style='width:25%;'><span >{{session('patient_id')}}</span></td><td style='width:10%;'> Bed Name</td><td> :</td><td><span ></span></td></tr>
                <tr style='font-size:10px'><td>Attendant Name </td><td>:</td><td> <span></span></td></tr>

                <tr style='font-size:10px'><td>Age </td><td>:</td><td> <span> </span></td><td>Sex </td><td>:</td><td> <span> </span></td></tr>
                <tr style='font-size:10px'><td>Address </td><td>:</td><td> <span></span></td></tr>

                <tr style='font-size:10px'><td>Mobile / Phone No </td><td>:</td><td> <span></span></td></tr>

                <tr style='font-size:8px'><td colspan='5'> </td></tr>
                <tr style='font-size:9px'><td colspan='5'> </td><td>Authorized Signatory </td></tr>
                <tr > <th colspan='6' bgcolor='#063751' style='color:white;font-size:10px'><center>{{$doctorappointments->hsaddress}}<span> </span> </center> </th></tr>

            </table>

        </center>
    </div>


   </div>
            </div>
        </div>

  @include('portal.hospital-footer')

@endsection
@section('scripts')


    <script>
        function print(id) {

            var divToPrint = document.getElementById(id);

            var newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            // setTimeout(function(){newWin.close();},10);

        }
    </script>

    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="http://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script>
        $( function() {

            $( "#appointmentDate" ).daterangepicker({ dateFormat: 'yy-mm-dd',minDate: new Date() });
            $('#appointmentDate').on('apply.daterangepicker', function(ev, picker) {
                console.log(picker.startDate.format('YYYY-MM-DD'));
                console.log(picker.endDate.format('YYYY-MM-DD'));
                ajaxloadappointmentdetails('{{Auth::user()->id}}',picker.startDate.format('YYYY-MM-DD'),picker.endDate.format('YYYY-MM-DD'));
            });


        } );
    </script>
@stop