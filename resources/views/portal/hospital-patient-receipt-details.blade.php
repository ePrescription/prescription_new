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
                                    <?php /* ?>
                                    <div style="float:right;display:none">
                                        <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <?php */ ?>

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

                                        <div class="col-lg-12" style="width:100%;float:left;">


                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">PID</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->pid}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->name}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">Number</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->telephone}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">E-Mail</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">Age</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->age}}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">Gender</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-3 control-label" style="width:30%;float:left;">Relationship</label>
                                                <div class="col-sm-9" style="width:70%;float:left;">
                                                    {{$patientDetails[0]->relationship}}
                                                </div>
                                            </div>
                                            <div class="hidden form-group col-md-4" style="width:33%;float:left;">
                                                <label class="col-sm-6 control-label" style="width:30%;float:left;">Relation Name</label>
                                                <div class="col-sm-6" style="width:70%;float:left;">
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
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>TEST NAME</th>
                                                                                    <th>TEST DATE</th>
                                                                                    <th>TEST AMOUNT</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($patientBloodTests as $patientBloodTestValue)
                                                                                    <tr>
                                                                                        <td>{{$patientBloodTestValue->examination_name}}</td>
                                                                                        <td>{{$patientBloodTestValue->examination_date}} </td>
                                                                                        <td>
                                                                                            <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][id]" value="{{$patientBloodTestValue->id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[bloodTests][{{$i}}][fees]" value="0" required="required" />
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif

                                                                    <?php $patientUrineTests=$labTestDetails['urineTests']; ?>
                                                                    @if(count($patientUrineTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Urine Test</h4>
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>TEST NAME</th>
                                                                                        <th>TEST DATE</th>
                                                                                        <th>TEST AMOUNT</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($patientUrineTests as $patientUrineTestValue)
                                                                                        <tr>
                                                                                            <td>{{$patientUrineTestValue->examination_name}}</td>
                                                                                            <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                            <td>
                                                                                                <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][id]" value="{{$patientUrineTestValue->id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[urineTests][{{$i}}][fees]" value="0" required="required" />
                                                                                            </td>
                                                                                        </tr>

                                                                                        <?php $i++; ?>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>


                                                                    @endif

                                                                    <?php $patientMotionTests=$labTestDetails['motionTests']; ?>
                                                                    @if(count($patientMotionTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Motion Test</h4>
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>TEST NAME</th>
                                                                                        <th>TEST DATE</th>
                                                                                        <th>TEST AMOUNT</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($patientMotionTests as $patientMotionTestValue)
                                                                                        <tr>
                                                                                            <td>{{$patientMotionTestValue->examination_name}}</td>
                                                                                            <td>{{$patientMotionTestValue->examination_date}} </td>
                                                                                            <td>
                                                                                                <input type="hidden" class="form-control" name="labTests[motionTests][{{$i}}][id]" value="{{$patientMotionTestValue->id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[motionTests][{{$i}}][fees]" value="0" required="required" />
                                                                                            </td>
                                                                                        </tr>

                                                                                        <?php $i++; ?>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>


                                                                    @endif

                                                                    <?php $patientScanTests=$labTestDetails['scanTests']; ?>
                                                                    @if(count($patientScanTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Scan Test</h4>
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>SCAN NAME</th>
                                                                                        <th>SCAN DATE</th>
                                                                                        <th>SCAN AMOUNT</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($patientScanTests as $patientScanTestValue)
                                                                                        <tr>
                                                                                            <td>{{$patientScanTestValue->scan_name}}</td>
                                                                                            <td>{{$patientScanTestValue->scan_date}} </td>
                                                                                            <td>
                                                                                                <input type="hidden" class="form-control" name="labTests[scanTests][{{$i}}][id]" value="{{$patientScanTestValue->id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[scanTests][{{$i}}][fees]" value="0" required="required" />
                                                                                            </td>
                                                                                        </tr>

                                                                                        <?php $i++; ?>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                    @endif

                                                                    <?php $patientUltraTests=$labTestDetails['ultraSoundTests']; ?>
                                                                    @if(count($patientUltraTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Ultra Sound Test</h4>
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>TEST NAME</th>
                                                                                        <th>TEST DATE</th>
                                                                                        <th>TEST AMOUNT</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($patientUltraTests as $patientUltraTestValue)
                                                                                        <tr>
                                                                                            <td>{{$patientUltraTestValue->examination_name}}</td>
                                                                                            <td>{{$patientUltraTestValue->examination_date}} </td>
                                                                                            <td>
                                                                                                <input type="hidden" class="form-control" name="labTests[ultraSoundTests][{{$i}}][id]" value="{{$patientUltraTestValue->id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[ultraSoundTests][{{$i}}][fees]" value="0" required="required" />
                                                                                            </td>
                                                                                        </tr>

                                                                                        <?php $i++; ?>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                    @endif
                                                                    <div class="form-group">
                                                                        <h4 class="m-t-0 m-b-30">Total Fee</h4>
                                                                        <div class="col-sm-4">Total Fee</div>
                                                                        <div class="col-sm-6">
                                                                            <input type="number" name="totalFees" class="form-control totalprice" value="0" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4"></div>
                                                                        <div class="col-sm-6">
                                                                            <input type="hidden" class="form-control" name="patientId" value="{{$labTestDetails['patientDetails']->patient_id}}" required="required" />
                                                                            <input type="hidden" class="form-control" name="hospitalId" value="{{$labTestDetails['hospitalDetails']->hospital_id}}" required="required" />
                                                                            <input style="float:left;" type="submit" name="addreceipt" value="Save Receipt" class="btn btn-success" onclickX="javascript:window.print();"/>


                                                                            <div style="float:left;margin:0px 20px;">
                                                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details">
                                                                                    <button type="button" class="btn btn-warning waves-effect waves-light">Cancel</button>
                                                                                </a>
                                                                            </div>
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