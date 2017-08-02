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
$patient_menu="0";
$prescription_menu="1";
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

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Doctor Prescriptions List</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                        <div class="panel panel-primary">
                            <div class="panel-body">
                            <h4 class="m-b-30 m-t-0">Doctor Prescriptions Details List</h4>
                                <form action="{{URL::to('/')}}/doctor/rest/api/prescription" method="get" style="line-height:30px;width:500px;float:left;display:none;">
                                    <div class="col-xs-3">
                                        Search By PRID
                                    </div>
                                    <div class="col-xs-5">
                                        <input name="prid" id="prid" class="form-control" type="text" value="" />
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block btn-flat">SEARCH</button>
                                    </div>
                                </form>
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
                            <div>
                                PRID ( Prescription Identification) - PID ( Patient Identification)
                            </div>
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>PRID</th>
                                    <th>PID</th>
                                    <th>PATIENT</th>
                                    <th>DATE</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prescriptions as $prescription)
                                <tr>
                                    <td>{{$prescription->prid}}</td>
                                    <td>{{$prescription->pid}}</td>
                                    <td>{{$prescription->name}}</td>
                                    <td>{{$prescription->prescription_date}}</td>
                                    <td>

                                        <a href="{{URL::to('/')}}/doctor/rest/api/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                    </td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div><!-- /.box-body -->
                        </div>


                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        </div>

        </div><!-- /.content -->

        @include('portal.doctor-footer')

    </div><!-- /.content-page -->

</div><!-- ./wrapper -->

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
