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
    table.one {border-collapse:collapse;}
    table.two {border-collapse:separate;}
    td.a {
        border-style:dotted;
        border-width:3px;
        border-color:#000000;
        padding: 10px;
    }
    tr.b {
        border-bottom: dotted 1px #000;

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

            <table   style='border-collapse: collapse;width:400px;height:180px;border-color:black;' >
                <tr bgcolor='#063751' style='color:white;font-size:10px; border-bottom: dotted 1px #000;'>
                    <th colspan='7'><center>Patient Lable<span></span></center> </th>
                </tr>

                <tr class="b" style='font-size:10px;  border-bottom: dotted 1px #000''>
                    <td colspan='1'>Patient ID:</td>
                    <td colspan='2'><span><b>{{$doctorappointments->pid}}</b></span></td>
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

                    <td colspan='1'>Phone No:</td>
                    <td colspan='5'><span ><b>{{$doctorappointments->telephone}}</b></span></td>
                </tr>

                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                    <td colspan='1'>Ref Dr:</td>
                    <td colspan='5'><span ><b>{{$doctorappointments->name }}</b></span></td>
                </tr>
                <tr style='font-size:10px'>
                    <td colspan='5'> </td><td colspan="1">Authorized Signatory </td>
                </tr>
                <tr >
                    <th colspan='6' bgcolor='#063751' style='color:white;font-size:10px'>
                        <center>{{ $doctorappointments->hospital_name}}&nbsp;&nbsp;{{$doctorappointments->hsaddress}}<span> </span>
                        </center> </th>
                </tr>
            </table>
            <br>
           <div id="Hide">
            <table   style='border-collapse: collapse;width:400px;height:180px;border-color:black;' >
                <tr bgcolor='#063751' style='color:white;font-size:10px'>
                    <th colspan='7' >
                        <center>Attendant Lable<span></span></center>
                    </th>
                </tr>
                <tr style='font-size:10px; border-bottom: dotted 1px #000'>
                  <td colspan='1'>Patient ID:</td>
                  <td colspan='2'><span ><b>{{$doctorappointments->pid}}</b></span></td>
                  <td colspan='1'>Date:</td>
                  <td colspan='2'><span ><b>{{ date('d-m-Y',strtotime($doctorappointments->appointment_date))}} {{ $doctorappointments->time}}</b></span></td>
                </tr>
                <tr style='font-size:10px;border-bottom: dotted 1px #000'>
                    <td colspan='1'>Name:</td>
                    <td colspan='5'>
                        <span ><b>{{$doctorappointments->patient_name}}</b></span>
                    </td>
                </tr>
                <tr style='font-size:10px;border-bottom: dotted 1px #000'>
                    <td colspan='1'> Bed No:</td>
                    <td colspan='2'>
                        <span ><b></b></span>
                    </td>
                    <td colspan='1'> Ward Type:</td>
                    <td colspan='2'>
                        <span ><b></b></span>
                    </td>
                </tr>
                <tr style='font-size:10px;border-bottom: dotted 1px #000'>
                    <td colspan='1'>Attendant Name:</td>
                    <td colspan='5'>
                        <span><b></b></span>
                    </td>
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
                <tr style='font-size:10px;border-bottom: dotted 1px #000'>
                    <td colspan='1'>Address:</td>
                    <td colspan='5'> <span><b>{{$doctorappointments->address}}</b></span></td>
                </tr>

                <tr style='font-size:10px;border-bottom: dotted 1px #000'>
                    <td colspan='1'>Phone No:</td>
                    <td colspan='5'> <span><b>{{$doctorappointments->telephone}}</b></span></td>
                </tr>

               <!-- <tr style='font-size:10px;'>
                    <td colspan='5'></td>
                </tr>-->
                <tr style='font-size:10px'>
                    <td colspan='5'> </td><td>Authorized Signatory </td>
                </tr>
                <tr >
                    <th colspan='6' bgcolor='#063751' style='color:white;font-size:10px'><center>{{ $doctorappointments->hospital_name}}&nbsp;&nbsp;{{$doctorappointments->hsaddress}}<span> </span> </center> </th>
                </tr>

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