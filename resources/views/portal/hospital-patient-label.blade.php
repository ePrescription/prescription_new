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
<style>
    .dot{
        border-bottom: 1px dotted black;
        width: 40px;
    }
    span{
        font-size:10px;
        font-weight: normal;
    }
</style>
   <!-- /.wrapper-page -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <input type='button' class="btn btn-success" value='Print' onclick="print('label')"/>

                <input type='button'  class="btn btn-info" value='Back' onclick="window.history.back();"/>





    <div class="modal-body" id='label'>
        <center>
            <br>

            <table style='width:400px;height:180px;border-color:black;' >
                <tr bgcolor='#063751' style='color:white;font-size:10px'>
                    <th colspan='7'><center>{{ $doctorappointments->hospital_name}}<span></span></center> </th>
                </tr>

                <tr style='font-size:10px; '>
                    <td colspan='1'> TOKEN ID:</td>
                    <td colspan='2'><span><b>{{$doctorappointments->token_id}}</b></span></td>
                    <td colspan='1'>DATE:</td>
                    <td colspan='2'><span ><b>{{ date('d-m-Y',strtotime($doctorappointments->appointment_date))}} {{ $doctorappointments->time}}</b></span></td>
                   <!-- <td> </td><td><span ></span></td>-->
                </tr>

                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1'  >NAME:</td>
                    <td colspan='5'><span><b>{{$doctorappointments->patient_name}}</b></span></td>
                  </tr>
                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1' >W/O:</td>
                    <td colspan='5'><span><b>{{$doctorappointments->relationship}}</b></span></td>
                </tr>

                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1'>AGE:</td>
                    <td colspan='2'><span><b>{{$doctorappointments->age}}</b></span></td>
                    <td colspan='1'>SEX:</td>
                    <td colspan='2'>@if($doctorappointments->gender==1)<span><b>Male</b></span>
                            @else
                                <span><b>Female</b> @endif</span></td>
                    <!-- <td> </td><td><span ></span></td>-->
                </tr>
                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1'>ADDRESS:</td>
                    <td colspan='5'><span ><b>{{$doctorappointments->address}}</b></span></td>

                </tr>
                <tr style='font-size:10px; border-bottom: dotted 1px #000'>

                    <td colspan='1'>CELL:</td>
                    <td colspan='5'><span ><b>{{$doctorappointments->telephone}}</b></span></td>
                </tr>

                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1'>REF Dr:</td>
                    <td colspan='5'><span >{{$doctorappointments->name }}</span></td>
                </tr>

            </table>
            <br>
           <div id="Hide" style="display: none">
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
</div>
        </center>
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