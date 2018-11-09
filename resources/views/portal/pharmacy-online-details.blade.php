@extends('layout.master-pharmacy-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$prescription_menu="1";
$patient_menu="0";
$profile_menu="0";
?>
@section('content')
    <div class="wrapper">
        @include('portal.pharmacy-header')
        <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
        @include('portal.pharmacy-sidebar')
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Pharmacy Pickup List</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="Opinion" class="tabcontent">
                                    <div class="container">
                                        <h4> Pharmacy Pickup</h4>
                                        @if(count($pharmacypickup)>0)
                                            <table class="table table-bordred table-striped" id="datatable">
                                                <thead>
                                                <th>PID</th>
                                                <th>Patient Name</th>
                                                <th>Mobile No</th>
                                                <th>Hospital Name</th>
                                                <th>Appointment Date </th>
                                                <th>Description</th>
                                                <th class="hidden">Download</th>
                                                </thead>
                                                @foreach ($pharmacypickup as $pickup)
                                                    <tr>
                                                        <td>{{ $pickup->pid }} </td>
                                                        <td>{{ $pickup->patient_name }}</td>
                                                        <td>{{ $pickup->telephone }}</td>
                                                        <td>{{ $pickup->hospital_name }} </td>
                                                        <td>{{ $pickup->appointment_date }}</td>
                                                        <td>{{ $pickup->brief_history }}</td>
                                                        <td class="hidden">
                                                            @if($pickup->reports !="")
                                                                <?php $paths = explode("@@", $pickup->reports); ?>
                                                                @foreach($paths as $path)

                                                                    @if($path!= "")
                                                                        <a href="public/askquestion/{{$path}}" target="_blank">
                                                                            @if(($pickup->document_extension == 'jpg') || ($pickup->document_extension == 'jpeg') || ($pickup->document_extension == 'png') || ($pickup->document_extension == 'JPG') || ($pickup->document_extension == 'JPEG') || ($pickup->document_extension == 'PNG'))
                                                                                <img src="public/askquestion/{{$path}}" width="100px" height="100px">
                                                                            @else
                                                                                <i class="fa fa-download"></i>
                                                                            @endif
                                                                        </a>
                                                                    @endif

                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </div>
                                </div>


                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div>

            </div><!-- /.content -->

            @include('portal.pharmacy-footer')

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
