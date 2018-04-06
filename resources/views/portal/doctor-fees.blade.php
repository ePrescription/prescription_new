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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="hidden">
                    <div class="page-header-title">
                        <h4 class="page-title">Hospital Doctor Fees</h4>

                    </div>
                </div>

                <div class="page-content-wrapper ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                            <!--    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/addfeereceipt" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Create New Bill</b></button></a>-->

                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h4 class="m-b-30 m-t-0">Hospital Doctor Fees List</h4>

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

                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name in Full</th>
                                                <th>Doctor Name in Full</th>
                                                <th>Appointment Date</th>
                                                <th>Payment Date</th>
                                                <th>Doctor Fee</th>
                                                <th>Payment Status</th>
                                                <th>View</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($feeReceipts as $fee)
                                                <tr>
                                                    <td>{{$fee->receiptId}}</td>
                                                    <td>{{$fee->PID}}</td>
                                                    <td>{{$fee->patientName}}</td>
                                                    <td>{{$fee->doctorName}}</td>
                                                    <td>{{$fee->created_at}}</td>
                                                    @if($fee->payment_status==0)
                                                        <td>-:-</td>
                                                    @else
                                                        <td>{{$fee->updated_at}}</td>
                                                    @endif
                                                    <td>{{$fee->fee}}</td>
                                                    @if($fee->payment_status==0)

                                                        <td>UN PAID
                                                            &nbsp;
                                                          <!--  <input style="float:left;" type="button"
                                                                   name="addreceipt" value="Pay"
                                                                   class="btn btn-success"
                                                                   onclick="javascript:feeUpdate('{{Auth::user()->id}}','{{$fee->doctor_id}}','{{$fee->patientId}}','{{$fee->receiptId}}')"/>
                                                       -->
                                                        </td>


                                                    @else
                                                        <td>PAID</td>
                                                    @endif
                                                    <td>
                                                        <a href="{{URL::to('/')}}/doctor/rest/api/receipt/{{$fee->receiptId}}/details" style="float:rightx;">View Details</a>
                                                        <br/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->


                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.content-wrapper -->

            </div><!-- ./content -->
        </div><!-- ./content-page -->
        @include('portal.doctor-footer')

    </div><!-- ./wrapper -->

@endsection
@section('scripts')
    <script>
        function feeUpdate(hospital_id,doctor_id,patient_id,rid) {

            var hid=hospital_id;
            var did=doctor_id;
            var pid=patient_id;
            var rid=rid;
            //alert(hid+"--"+did+"--"+pid+"--"+rid);

            var ask=window.confirm('Do you Want to Pay..?')
            if(ask){
                var BASEURL = "{{ URL::to('/') }}/";
                var status = 1;
                var callurl = BASEURL + 'fronthospital/rest/api/hospital/' + hid + '/doctor/' + did + '/patient/'+pid+'/receipt/'+rid+'/updatepatientpaymentstatus';
                $.ajax({
                    url: callurl,
                    type: "Post",
                    data: {},
                    success: function (data) {
                        alert(data);

                        location.reload();


                        //var result=data.split("separate");
                        // $("#patientblooddiv1").html(result[1]);
                        //$("#DivIdToPrint").html(data);



                    }
                });

            }
        }


    </script>





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
@stop
