@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
    <style>.tab-pane {
            min-height: 300px;
        }</style>
@stop
<?php
$dashboard_menu = "0";
$patient_menu = "1";
$profile_menu = "0";
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

                                        <div class="dropdown">
                                            <button class="dropbtn"><img src="{{URL::to('/')}}/images/menu.png" width="20"/>Menu</button>
                                            <div class="dropdown-content">
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i>Lab Profile </a>
                                                <!-- By Ramana 12-01-2018-->
                                                &nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-details-results" title="Print Patient Lab Results"><i class="fa fa-folder-o"></i>Print Patient Lab Results </a>

                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>

                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                                &nbsp;&nbsp;
                                                <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i>Print Medical Profile </a>
                                            </div>
                                        </div>
                                        <?php /* ?>
                                    <div style="float:right;display:none">
                                        <button style="margin: 0px 10px;" type="button" id="btn" value="Print" class="btn btn-success waves-effect waves-light" onclick="javascript:printDiv();" ><i class="icon-print"></i> Print</button>
                                    </div>

                                    <?php */ ?>


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

                                        <div id='DivIdToPrint' style="display:block;">

                                            <div class="row">
                                                <div class="col-lg-2" style="margin-bottom:12px">
                                                    @if($patientDetails[0]->patient_photo=="")

                                                        <img src="{{URL::to('/')}}/uploads/patient_photo/noimage.png"  />

                                                    @else

                                                        <img src="{{URL::to('/')}}/{{$patientDetails[0]->patient_photo}}"  style="width:100px;" />

                                                    @endif
                                                </div>

                                                <div class="col-lg-10">



                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">PID</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->pid}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">Name</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->name}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">Number</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->telephone}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">E-Mail</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->email}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">Age</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->age}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">Gender</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            @if($patientDetails[0]->gender==1) Male @else Female @endif
                                                        </div>
                                                    </div>
                                                    <div class="hidden form-group col-md-4"
                                                         style="width:33%;float:left;">
                                                        <label class="col-sm-3 control-label"
                                                               style="width:30%;float:left;">Relationship</label>
                                                        <div class="col-sm-9" style="width:70%;float:left;">
                                                            {{$patientDetails[0]->relationship}}
                                                        </div>
                                                    </div>
                                                    <div class="hidden form-group col-md-4"
                                                         style="width:33%;float:left;">
                                                        <label class="col-sm-6 control-label"
                                                               style="width:30%;float:left;">Relation Name</label>
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


                                                                <form action="{{URL::to('/')}}/fronthospital/rest/api/savelabreceipts"
                                                                      role="form" method="POST"
                                                                      class="form-horizontal ">

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

                                                                                            <td  style="padding-left: 0px;">{{$patientBloodTestValue->parent_examination_name}}</td>
                                                                                            <td style="padding-left: 0px;">{{$patientBloodTestValue->examination_date}} </td>
                                                                                            <td style="padding-left: 0px;">{{$patientBloodTestValue->fees}}</td>


                                                                                        @else
                                                                                            @if($parentname=="" || $parentname!=$patientBloodTestValue->parent_examination_name)
                                                                                                <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>
                                                                                                <td style="padding-left: 0px;">{{$patientBloodTestValue->parent_examination_name}}</td>
                                                                                                <td style="padding-left: 0px;">{{$patientBloodTestValue->examination_date}} </td>
                                                                                                <td style="padding-left: 0px;">{{$patientBloodTestValue->fees}}</td>


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



                                                                                    <tr>
                                                                                        @if($patientUrineTestValue->examination_name==$patientUrineTestValue->parent_examination_name)
                                                                                            <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>

                                                                                            <td style="padding-left: 0px;">{{$patientUrineTestValue->parent_examination_name}}</td>
                                                                                            <td style="padding-left: 0px;">{{$patientUrineTestValue->examination_date}} </td>
                                                                                            <td style="padding-left: 0px;">{{$patientUrineTestValue->fees}}</td>


                                                                                        @else
                                                                                            @if($parentname=="" || $parentname!=$patientUrineTestValue->parent_examination_name)
                                                                                                <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>
                                                                                                <td style="padding-left: 0px;">{{$patientUrineTestValue->parent_examination_name}}</td>
                                                                                                <td style="padding-left: 0px;">{{$patientUrineTestValue->examination_date}} </td>
                                                                                                <td style="padding-left: 0px;">{{$patientUrineTestValue->fees}}</td>


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
                                                                                        <td style="padding-left: 0px;">{{$patientMotionTestValue->examination_name}}</td>
                                                                                        <td style="padding-left: 0px;">{{$patientMotionTestValue->examination_date}} </td>
                                                                                        <td style="padding-left: 0px;">{{$patientMotionTestValue->fees}}</td>
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
                                                                                        <td style="padding-left: 0px;">{{$patientUltraTestValue->examination_name}}</td>
                                                                                        <td  style="padding-left: 0px;">{{$patientUltraTestValue->examination_date}} </td>
                                                                                        <td  style="padding-left: 0px;">{{$patientUltraTestValue->fees}}</td>
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
                                                                                        <td  style="padding-left: 0px;">{{$patientScanTestValue->scan_name}}</td>
                                                                                        <td  style="padding-left: 0px;">{{$patientScanTestValue->scan_date}} </td>
                                                                                        <td style="padding-left: 0px;">{{$patientScanTestValue->fees}}</td>
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
                                                                                        <td  style="padding-left: 0px;">{{$patientDentalTestValue->examination_name}}</td>
                                                                                        <td  style="padding-left: 0px;">{{$patientDentalTestValue->examination_date}} </td>
                                                                                        <td  style="padding-left: 0px;">{{$patientDentalTestValue->fees}}</td>
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
                                                                            <table class="table">
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
                                                                                        <td  style="padding-left: 0px;">{{$patientXrayTestValue->examination_name}}</td>
                                                                                        <td style="padding-left: 0px;">{{$patientXrayTestValue->examination_date}} </td>
                                                                                        <td style="padding-left: 0px;">{{$patientXrayTestValue->fees}}</td>
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
                                                                        <table class="table">
                                                                            <tr><th>Total Fee</th><td></td><td> {{$labTotalFees[0]->total_fees}}</td></tr>
                                                                            <tr><th>Paid Amount</th><td></td><td>  {{$labTotalFees[0]->paid_amount}}</td></tr>
                                                                            @if($labTotalFees[0]->total_fees!=$labTotalFees[0]->paid_amount)
                                                                                <tr><th>Balance Amount</th><td></td><td><input id="balanceamount" type="number" style="width: 20%;"
                                                                                                                               name="balanceamount"
                                                                                                                               class="form-control totalprice"
                                                                                                                               value="{{$labTotalFees[0]->total_fees-$labTotalFees[0]->paid_amount}}"/></td></tr>
                                                                                <tr><th>Payment Type</th><td></td><td> <select class="form-controlx" id="paymenttype" name="paymenttype" required="required">
                                                                                            <option value="1">CASH</option>
                                                                                            <option value="2">CHEQUE</option>
                                                                                            <option value="3">CARD</option>
                                                                                        </select></td></tr>
                                                                                <tr><th></th><td></td><td> <input style="float:left;" type="button"
                                                                                                                  name="addreceipt" value="Pay"
                                                                                                                  class="btn btn-success"
                                                                                                                  onclick="javascript:feeUpdate()"/></td></tr>
                                                                            @endif

                                                                        </table>

                                                                    <!--  <div class="col-sm-4">Total Fee</div>
                                                                        <div class="col-sm-6">
                                                                            {{$labTotalFees[0]->total_fees}}
                                                                            </div>

                                                                            <div class="col-sm-4">Paid Amount</div>
                                                                            <div class="col-sm-6">
                                                        {{$labTotalFees[0]->paid_amount}}
                                                                            </div>
                                                                 @if($labTotalFees[0]->total_fees!=$labTotalFees[0]->paid_amount)
                                                                        <div class="col-sm-4">Balance Amount</div>
                                                                        <div class="col-sm-6">

                                                                            <input id="balanceamount" type="number" style="width: 20%;"
                                                                                   name="balanceamount"
                                                                                   class="form-control totalprice"
                                                                                   value="{{$labTotalFees[0]->total_fees-$labTotalFees[0]->paid_amount}}"/>
                                                                            </div>

                                                                                    <div class="col-sm-4">Payment Type</div>
                                                                                    <div class="col-sm-6">
                                                                                        <select class="form-controlx" id="paymenttype" name="paymenttype" required="required">
                                                                                            <option value="1">CASH</option>
                                                                                            <option value="2">CHEQUE</option>
                                                                                            <option value="3">CARD</option>
                                                                                        </select>
                                                                                    </div>
                                                                            <div class="col-sm-4"> </div>
                                                                            <div class="col-sm-6">
                                                                            <input style="float:left;" type="button"
                                                                                   name="addreceipt" value="Pay"
                                                                                   class="btn btn-success"
                                                                                   onclick="javascript:feeUpdate()"/>
                                                                          </div> @endif-->

                                                                    </div>



                                                            </form>



                                                            <div id="divprint" class="table-responsive" style="display: none">
                                                                <h4 class="m-t-0 m-b-30">Payment History</h4>
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Payment Type</th>

                                                                        <th>Payment Date</th>
                                                                        <th>Paid Amount</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($paymentHistory as $paymentHistorys)
                                                                        <tr>
                                                                            <td>{{$paymentHistorys->payment_type}}</td>

                                                                            <td>{{$paymentHistorys->created_at}}</td>
                                                                            <td>{{$paymentHistorys->paid_amount}} </td>
                                                                        </tr>


                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                                <div class="form-group">
                                                                    <div class="col-sm-4"></div>
                                                                    <div class="col-sm-6">
                                                                        <input style="float:left;" type="submit" name="addreceipt" value="Print Receipt"
                                                                               class="btn btn-success" onclick="javascript:printDiv();"/>


                                                                        <div style="float:left;margin:0px 20px;">
                                                                            <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts">
                                                                                <button type="button" class="btn btn-warning waves-effect waves-light">Cancel</button>
                                                                            </a>
                                                                        </div>
                                                                        <input type="button" id="payment" class="btn btn-warning" onclick="view()" value="View Payment History">

                                                                    </div>
                                                                </div>
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

            </div>
        </div>

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
                $('.testprice').each(function () {
                    sum += parseFloat(this.value);
                });
                $('input.totalprice').val(sum);
            });
        });
        var te=0;
        function view() {


            if(te==0){

                document.getElementById("payment").value="Hide Payment History";
                document.getElementById("divprint").style.display="block";
                te=1;
            }else{
                document.getElementById("payment").value="View Payment History";
                document.getElementById("divprint").style.display="none";

                te=0;
            }
        }

        function feeUpdate() {

            var pid = '{{$labTotalFees[0]->patient_id}}';
            var rid = '{{$labTotalFees[0]->id}}';
            var hid = '{{$labTotalFees[0]->hospital_id}}';
            var oldpaidamount = '{{$labTotalFees[0]->paid_amount}}';
            var paidamount=document.getElementById("balanceamount").value;
            var paymenttype=document.getElementById("paymenttype").value;
            var totalpaidamount=parseInt(paidamount)+parseInt(oldpaidamount);

            var BASEURL = "{{ URL::to('/') }}/";
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/hospital/' + hid + '/patient/' + pid + '/receiptid/'+rid+'/amount/'+totalpaidamount+'/'+paidamount+'/paymenttype/'+paymenttype+'/lab-fee-update';
            $.ajax({
                url: callurl,
                type: "Post",
                data: {},
                success: function (data) {

                    location.reload();

                    document.getElementById("balanceamount").value=parseInt({{$labTotalFees[0]->total_fees}})-totalpaidamount;

                    //var result=data.split("separate");
                    // $("#patientblooddiv1").html(result[1]);
                    //$("#DivIdToPrint").html(data);



                }
            });


        }

        function printDiv() {
            var divToPrint = document.getElementById('DivIdToPrint');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close();
            setTimeout(function () {
                newWin.close();
            }, 600);
        }

    </script>
@stop