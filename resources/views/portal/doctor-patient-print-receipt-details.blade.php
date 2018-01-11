@extends('layout.master-doctor-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane { min-height: 300px; }</style>
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


        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Patient Lab Receipt Details1</h4>
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
                                            <h4 class="m-t-0 m-b-30">Patient Lab Receipt Details1</h4>


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
                                                        @if($patientDetails[0]->patient_photo!="" || $patientDetails[0]->patient_photo!=null )
                                                            <center><img
                                                                        src="/uploads/patient_photo/{{$patientDetails[0]->patient_photo}}"
                                                                        width="150px" height="150px"></center>
                                                        @else
                                                            <center><img
                                                                        src="/uploads/patient_photo/patient_default_photo.png"
                                                                        width="150px" height="150px"></center>

                                                        @endif
                                                    </div>
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

                                                                    <?php $patientBloodTests=$labReceiptDetails['bloodTests']; ?>
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
                                                                                <?php $parentname="";?>
                                                                                @foreach($patientBloodTests as $patientBloodTestValue)

                                                                                    <tr>
                                                                                        @if($patientBloodTestValue->examination_name==$patientBloodTestValue->parent_examination_name)
                                                                                            <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>

                                                                                            <td>{{$patientBloodTestValue->parent_examination_name}}</td>
                                                                                            <td>{{$patientBloodTestValue->examination_date}} </td>
                                                                                            <td>{{$patientBloodTestValue->fees}}</td>


                                                                                        @else
                                                                                            @if($parentname=="" || $parentname!=$patientBloodTestValue->parent_examination_name)
                                                                                                <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>
                                                                                                <td>{{$patientBloodTestValue->parent_examination_name}}</td>
                                                                                                <td>{{$patientBloodTestValue->examination_date}} </td>
                                                                                                <td>{{$patientBloodTestValue->fees}}</td>


                                                                                            @endif

                                                                                        @endif

                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @endif


                                                                    <?php $patientUrineTests=$labReceiptDetails['urineTests']; ?>
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
                                                                                    <!--   <tr>
                                                                                            <td>{{$patientUrineTestValue->examination_name}}</td>
                                                                                            <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                            <td>{{$patientUrineTestValue->fees}}</td>
                                                                                        </tr>-->


                                                                                    <tr>
                                                                                        @if($patientUrineTestValue->examination_name==$patientUrineTestValue->parent_examination_name)
                                                                                            <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>

                                                                                            <td>{{$patientUrineTestValue->parent_examination_name}}</td>
                                                                                            <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                            <td>{{$patientUrineTestValue->fees}}</td>


                                                                                        @else
                                                                                            @if($parentname=="" || $parentname!=$patientUrineTestValue->parent_examination_name)
                                                                                                <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>
                                                                                                <td>{{$patientUrineTestValue->parent_examination_name}}</td>
                                                                                                <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                                <td>{{$patientUrineTestValue->fees}}</td>


                                                                                            @endif

                                                                                        @endif

                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>


                                                                    @endif

                                                                    <?php $patientMotionTests=$labReceiptDetails['motionTests']; ?>
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
                                                                                        <td>{{$patientMotionTestValue->fees}}</td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>


                                                                    @endif

                                                                    <?php $patientUltraTests=$labReceiptDetails['ultraSoundTests']; ?>
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
                                                                                        <td>{{$patientUltraTestValue->fees}}</td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif


                                                                    <?php $patientScanTests=$labReceiptDetails['scanTests']; ?>
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
                                                                                        <td>{{$patientScanTestValue->fees}}</td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @endif



                                                                    <?php $patientDentalTests=$labReceiptDetails['dentalTests']; ?>
                                                                    @if(count($patientDentalTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">Dental Test</h4>
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
                                                                                @foreach($patientDentalTests as $patientDentalTestValue)
                                                                                    <tr>
                                                                                        <td>{{$patientDentalTestValue->examination_name}}</td>
                                                                                        <td>{{$patientDentalTestValue->examination_date}} </td>
                                                                                        <td>{{$patientDentalTestValue->fees}}</td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif


                                                                    <?php $patientXrayTests=$labReceiptDetails['xrayTests']; ?>
                                                                    @if(count($patientXrayTests)>0)
                                                                        <?php $i=0; ?>
                                                                        <h4 class="m-t-0 m-b-30">X-Ray Test</h4>
                                                                        <div class="table-responsive">
                                                                            <table class="table" style="width: 50%;">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>TEST NAME</th>
                                                                                    <th>TEST DATE</th>
                                                                                    <th>TEST AMOUNT</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($patientXrayTests as $patientXrayTestValue)
                                                                                    <tr>
                                                                                        <td>{{$patientXrayTestValue->examination_name}}</td>
                                                                                        <td>{{$patientXrayTestValue->examination_date}} </td>
                                                                                        <td>{{$patientXrayTestValue->fees}}</td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif




                                                                    <?php $labTotalFees=$labReceiptDetails['labTotalFees']; ?>
                                                                    <div class="form-group">
                                                                        <h4 class="m-t-0 m-b-30">Total Fee</h4>
                                                                        <div class="col-sm-4">Total Fee</div>
                                                                        <div class="col-sm-6">
                                                                            {{$labTotalFees[0]->total_fees}}
                                                                        </div>
                                                                        <div class="col-sm-4">Paid Amount</div>
                                                                        <div class="col-sm-6">
                                                                            {{$labTotalFees[0]->paid_amount}}
                                                                        </div>
                                                                    </div>
                                                                </form>


                                                            </div> <!-- panel-body -->
                                                        </div> <!-- panel -->
                                                    </div> <!-- col -->
                                                </div> <!-- End row -->

                                            </div><!-- container -->

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-4"></div>
                                            <div class="col-sm-6">
                                                <input style="float:left;" type="submit" name="addreceipt" value="Print Receipt" class="btn btn-success"  onclick="javascript:printDiv();"/>


                                                <div style="float:left;margin:0px 20px;">
                                                    <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts">
                                                        <button type="button" class="btn btn-warning waves-effect waves-light">Cancel</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- panel-body -->
                                </div> <!-- panel -->
                            </div> <!-- col -->
                        </div> <!-- End row -->

                    </div><!-- container -->


                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            @include('portal.doctor-footer')

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