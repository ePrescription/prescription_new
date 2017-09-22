@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane { min-height: 300px; }</style>
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
                    <h4 class="page-title">Patient Lab Receipt Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div style="float:right;display:none">
                                        <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <div style="float:right;">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back</button>
                                        </a>
                                    </div>
                                    <div id='DivIdToPrint' style="display:block;">
                                    <h4 class="m-t-0 m-b-30">Patient Lab Receipt Details</h4>


                                @if (session()->has('message'))
                                        <div class="col_full login-title">
                                            <span style="color:red;">
                                                <p class="text-danger">{{session('message')}}</p>
                                            </span>
                                        </div>
                                    @endif

                                    @if (session()->has('success'))
                                        <div class="col_full login-title">
                                            <span style="color:green;">
                                                <p class="text-success">{{session('success')}}</p>
                                            </span>
                                        </div>
                                    @endif



                                    <div class="row">

                                        <div class="col-lg-12">


                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">PID</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Number</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">E-Mail</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Age</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-3 control-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4">
                                                <label class="col-sm-6 control-label">Relation Name</label>
                                                <div class="col-sm-6">
                                                    {{$patientDetails[0]->spouseName}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-body">
                                                        <h4 class="m-t-0 m-b-30">Receipt for Lab Tests</h4>

                                                            <!-- form start -->

                                                                <form action="{{URL::to('/')}}/fronthospital/rest/api/savelabreceipts" role="form" method="POST" class="form-horizontal ">

                                                                <?php $fi=0; ?>

                                                                    <?php $patientBloodTests=$labTestDetails['bloodTests']; ?>
                                                                    @if(count($patientBloodTests)>0)
                                                                    <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Blood Test</h4>
                                                                    @foreach($patientBloodTests as $patientBloodTestValue)
                                                                        <div class="form-group">
                                                                            <label class="col-sm-4 control-label">{{$patientBloodTestValue->examination_name}} </label>
                                                                            <div class="col-sm-6">
                                                                                <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][id]" value="{{$patientBloodTestValue->id}}" required="required" />
                                                                                <div class="radio radio-info radio-inline">

                                                                                    <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[bloodTests][{{$i}}][fees]" value="0" required="required" />

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php $i++; ?>
                                                                    @endforeach
                                                                    @endif

                                                                    <?php $patientUrineTests=$labTestDetails['urineTests']; ?>
                                                                    @if(count($patientUrineTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Urine Test</h4>
                                                                        @foreach($patientUrineTests as $patientUrineTestValue)
                                                                            <div class="form-group">
                                                                                <label class="col-sm-4 control-label">{{$patientUrineTestValue->examination_name}} </label>
                                                                                <div class="col-sm-6">
                                                                                    <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][id]" value="{{$patientUrineTestValue->id}}" required="required" />
                                                                                    <div class="radio radio-info radio-inline">

                                                                                        <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[urineTests][{{$i}}][fees]" value="0" required="required" />

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $i++; ?>
                                                                        @endforeach
                                                                    @endif

                                                                    <?php $patientMotionTests=$labTestDetails['motionTests']; ?>
                                                                    @if(count($patientMotionTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Motion Test</h4>
                                                                        @foreach($patientMotionTests as $patientMotionTestValue)
                                                                            <div class="form-group">
                                                                                <label class="col-sm-4 control-label">{{$patientMotionTestValue->examination_name}} </label>
                                                                                <div class="col-sm-6">
                                                                                    <input type="hidden" class="form-control" name="labTests[motionTests][{{$i}}][id]" value="{{$patientMotionTestValue->id}}" required="required" />
                                                                                    <div class="radio radio-info radio-inline">

                                                                                        <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[motionTests][{{$i}}][fees]" value="0" required="required" />

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $i++; ?>
                                                                        @endforeach
                                                                    @endif

                                                                    <?php $patientScanTests=$labTestDetails['scanTests']; ?>
                                                                    @if(count($patientScanTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Scan Test</h4>
                                                                        @foreach($patientScanTests as $patientScanTestValue)
                                                                            <div class="form-group">
                                                                                <label class="col-sm-4 control-label">{{$patientScanTestValue->scan_name}} </label>
                                                                                <div class="col-sm-6">
                                                                                    <input type="hidden" class="form-control" name="labTests[scanTests][{{$i}}][id]" value="{{$patientScanTestValue->id}}" required="required" />
                                                                                    <div class="radio radio-info radio-inline">

                                                                                        <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[scanTests][{{$i}}][fees]" value="0" required="required" />

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $i++; ?>
                                                                        @endforeach
                                                                    @endif

                                                                    <?php $patientUltraTests=$labTestDetails['ultraSoundTests']; ?>
                                                                    @if(count($patientUltraTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Ultra Sound Test</h4>
                                                                        @foreach($patientUltraTests as $patientUltraTestValue)
                                                                            <div class="form-group">
                                                                                <label class="col-sm-4 control-label">{{$patientUltraTestValue->examination_name}} </label>
                                                                                <div class="col-sm-6">
                                                                                    <input type="hidden" class="form-control" name="labTests[ultraSoundTests][{{$i}}][id]" value="{{$patientUltraTestValue->id}}" required="required" />
                                                                                    <div class="radio radio-info radio-inline">

                                                                                        <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[ultraSoundTests][{{$i}}][fees]" value="0" required="required" />

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php $i++; ?>
                                                                        @endforeach
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <h4 class="m-t-0 m-b-30">Total Fee</h4>
                                                                        <div class="col-sm-4">Total Fee</div>
                                                                        <div class="col-sm-6">
                                                                            <input type="number" name="sum" class="form-control totalprice" value="0" disabled />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4"></div>
                                                                        <div class="col-sm-6">
                                                                            <input type="hidden" class="form-control" name="patientId" value="{{$labTestDetails['patientDetails']->patient_id}}" required="required" />
                                                                            <input type="hidden" class="form-control" name="hospitalId" value="{{$labTestDetails['hospitalDetails']->hospital_id}}" required="required" />
                                                                            <input type="submit" name="addreceipt" value="Save Receipt" class="btn btn-success" onclick="javascript:printDivXYZ();"/>
                                                                        </div>
                                                                    </div>
                                                                </form>


                                                    </div> <!-- panel-body -->
                                                </div> <!-- panel -->
                                            </div> <!-- col -->
                                        </div> <!-- End row -->

                                    </div><!-- container -->

                                    </div>

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


</div><!-- ./wrapper -->

@endsection



@section('scripts')

    <script>


        $('input#fee').each(function () {
            var sum = 0;
            $(this).change(function () {
                var sum = 0;
                $('.testprice').each(function(){
                    sum += parseFloat(this.value);
                });
                $('input.totalprice').val(sum);
            });
        });

        function printDiv()
        {
            var divToPrint=document.getElementById('DivIdToPrint');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        }

    </script>
@stop