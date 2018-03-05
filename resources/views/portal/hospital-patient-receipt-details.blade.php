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

                                                <div class="col-lg-2" style="margin-bottom:12px">
                                                    @if($patientDetails[0]->patient_photo=="")

                                                        <img src="{{URL::to('/')}}/uploads/patient_photo/noimage.png"  />

                                                    @else

                                                        <img src="{{URL::to('/')}}/{{$patientDetails[0]->patient_photo}}"  style="width:100px;" />

                                                    @endif
                                                </div>

                                                <div class="col-lg-10">


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
                                                                <?php $totalprice=0;$labtestcheck="no"; ?>
                                                                <form action="{{URL::to('/')}}/fronthospital/rest/api/savelabreceipts" role="form" method="POST" class="form-horizontal " id="myform">

                                                                    <?php $fi=0; ?>

                                                                    <?php $patientBloodTests=$labTestDetails['bloodTests']; ?>
                                                                    @if(count($patientBloodTests)>0)
                                                                        <?php $i=0;$labtestcheck="yes"; ?>
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
                                                                                <?php $parentname=""; ?>
                                                                                @foreach($patientBloodTests as $patientBloodTestValue)


                                                                                    @if($patientBloodTestValue->examination_name==$patientBloodTestValue->parent_examination_name)
                                                                                        <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>
                                                                                        <tr>
                                                                                            <td>{{$patientBloodTestValue->examination_name}}</td>


                                                                                            <td>{{$patientBloodTestValue->examination_date}} </td>
                                                                                            <td>
                                                                                                <?php $totalprice += $patientBloodTestValue->fees;?>
                                                                                                <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][id]" value="{{$patientBloodTestValue->id}}" required="required" />
                                                                                                <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][item_id]" value="{{$patientBloodTestValue->examination_item_id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[bloodTests][{{$i}}][fees]" value="{{$patientBloodTestValue->fees}}" required="required" />
                                                                                            </td>
                                                                                        </tr>
                                                                                    @else
                                                                                        @if($parentname=="" || $parentname!=$patientBloodTestValue->parent_examination_name)
                                                                                            <tr>
                                                                                                <td>{{$patientBloodTestValue->parent_examination_name}}</td>

                                                                                                <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>
                                                                                                <td>{{$patientBloodTestValue->examination_date}} </td>
                                                                                                <td>
                                                                                                    <?php $totalprice += $patientBloodTestValue->fees;?>
                                                                                                    <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][id]" value="{{$patientBloodTestValue->id}}" required="required" />
                                                                                                    <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][item_id]" value="{{$patientBloodTestValue->examination_item_id}}" required="required" />
                                                                                                    <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[bloodTests][{{$i}}][fees]" value="{{$patientBloodTestValue->fees}}" required="required" />
                                                                                                </td>
                                                                                            </tr>
                                                                                        @elseif($parentname==$patientBloodTestValue->parent_examination_name)


                                                                                            <?php $parentname=$patientBloodTestValue->parent_examination_name; ?>



                                                                                            <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][id]" value="{{$patientBloodTestValue->id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[bloodTests][{{$i}}][item_id]" value="{{$patientBloodTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="hidden" min="0" class="form-control testprice1" name="labTests[bloodTests][{{$i}}][fees]" value="1" required="required" />

                                                                                        @endif

                                                                                    @endif




                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif
                                                                    <?php $parentname=""; ?>
                                                                    <?php $patientUrineTests=$labTestDetails['urineTests']; ?>
                                                                    @if(count($patientUrineTests)>0)
                                                                        <?php $i=0; $labtestcheck="yes";?>
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



                                                                                    @if($patientUrineTestValue->examination_name==$patientUrineTestValue->parent_examination_name)
                                                                                        <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>
                                                                                        <tr>
                                                                                            <td>{{$patientUrineTestValue->examination_name}}</td>


                                                                                            <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                            <td>
                                                                                                <?php $totalprice += $patientUrineTestValue->fees;?>
                                                                                                <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][id]" value="{{$patientUrineTestValue->id}}" required="required" />
                                                                                                <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][item_id]" value="{{$patientUrineTestValue->examination_item_id}}" required="required" />
                                                                                                <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[urineTests][{{$i}}][fees]" value="{{$patientUrineTestValue->fees}}" required="required" />
                                                                                            </td>
                                                                                        </tr>
                                                                                    @else
                                                                                        @if($parentname=="" || $parentname!=$patientUrineTestValue->parent_examination_name)
                                                                                            <tr>
                                                                                                <td>{{$patientUrineTestValue->parent_examination_name}}</td>

                                                                                                <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>
                                                                                                <td>{{$patientUrineTestValue->examination_date}} </td>
                                                                                                <td>
                                                                                                    <?php $totalprice += $patientUrineTestValue->fees;?>
                                                                                                    <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][id]" value="{{$patientUrineTestValue->id}}" required="required" />
                                                                                                    <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][item_id]" value="{{$patientUrineTestValue->examination_item_id}}" required="required" />
                                                                                                    <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[urineTests][{{$i}}][fees]" value="{{$patientUrineTestValue->fees}}" required="required" />
                                                                                                </td>
                                                                                            </tr>
                                                                                        @elseif($parentname==$patientUrineTestValue->parent_examination_name)


                                                                                            <?php $parentname=$patientUrineTestValue->parent_examination_name; ?>



                                                                                            <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][id]" value="{{$patientUrineTestValue->id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[urineTests][{{$i}}][item_id]" value="{{$patientUrineTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="hidden" min="0" class="form-control testprice1" name="labTests[urineTests][{{$i}}][fees]" value="1" required="required" />

                                                                                        @endif

                                                                                    @endif

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>


                                                                    @endif

                                                                    <?php $patientMotionTests=$labTestDetails['motionTests']; ?>
                                                                    @if(count($patientMotionTests)>0)
                                                                        <?php $i=0; $labtestcheck="yes";?>
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
                                                                                            <?php $totalprice += $patientMotionTestValue->fees;?>
                                                                                            <input type="hidden" class="form-control" name="labTests[motionTests][{{$i}}][id]" value="{{$patientMotionTestValue->id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[motionTests][{{$i}}][item_id]" value="{{$patientMotionTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[motionTests][{{$i}}][fees]" value="{{$patientMotionTestValue->fees}}" required="required" />
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
                                                                        <?php $i=0;$labtestcheck="yes"; ?>
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
                                                                                            <?php $totalprice += $patientScanTestValue->fees;?>
                                                                                            <input type="hidden" class="form-control" name="labTests[scanTests][{{$i}}][id]" value="{{$patientScanTestValue->id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[scanTests][{{$i}}][item_id]" value="{{$patientScanTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[scanTests][{{$i}}][fees]" value="{{$patientScanTestValue->fees}}" required="required" />
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
                                                                        <?php $i=0; $labtestcheck="yes";?>
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
                                                                                            <?php $totalprice += $patientUltraTestValue->fees;?>
                                                                                            <input type="hidden" class="form-control" name="labTests[ultraSoundTests][{{$i}}][id]" value="{{$patientUltraTestValue->id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[ultraSoundTests][{{$i}}][item_id]" value="{{$patientUltraTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[ultraSoundTests][{{$i}}][fees]" value="{{$patientUltraTestValue->fees}}" required="required" />
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif

                                                                    <?php $patientDentalTests=$labTestDetails['dentalTests']; ?>
                                                                    @if(count($patientDentalTests)>0)
                                                                        <?php $i=0;$labtestcheck="yes"; ?>
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
                                                                                        <td>
                                                                                            <?php $totalprice += $patientDentalTestValue->fees;?>
                                                                                            <input type="hidden" class="form-control" name="labTests[dentalTests][{{$i}}][id]" value="{{$patientDentalTestValue->examination_id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[dentalTests][{{$i}}][item_id]" value="{{$patientDentalTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[dentalTests][{{$i}}][fees]" value="{{$patientDentalTestValue->fees}}" required="required" />
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif


                                                                    <?php $patientXrayTests=$labTestDetails['xrayTests']; ?>
                                                                    @if(count($patientXrayTests)>0)
                                                                        <?php $i=0;$labtestcheck="yes"; ?>
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
                                                                                        <td>{{$patientXrayTestValue->examination_name}}</td>
                                                                                        <td>{{$patientXrayTestValue->examination_date}} </td>
                                                                                        <td>
                                                                                            <?php $totalprice += $patientXrayTestValue->fees;?>
                                                                                            <input type="hidden" class="form-control" name="labTests[xrayTests][{{$i}}][id]" value="{{$patientXrayTestValue->examination_id}}" required="required" />
                                                                                            <input type="hidden" class="form-control" name="labTests[xrayTests][{{$i}}][item_id]" value="{{$patientXrayTestValue->examination_item_id}}" required="required" />
                                                                                            <input id="fee" type="number" min="0" class="form-control testprice" name="labTests[xrayTests][{{$i}}][fees]" value="{{$patientXrayTestValue->fees}}" required="required" />
                                                                                        </td>
                                                                                    </tr>

                                                                                    <?php $i++; ?>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    @endif
                                                                    @if($labtestcheck=="yes")
                                                                        <div class="form-group">
                                                                            <h4 class="m-t-0 m-b-30">Total Fee</h4>
                                                                            <div class="col-sm-4">Total Fee</div>
                                                                            <div class="col-sm-6">
                                                                                <input id="totalprice" type="number" name="totalFees" class="form-control totalprice" value="{{$totalprice}}" readonly />
                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <div class="col-sm-4">Paid Amount</div>
                                                                            <div class="col-sm-6">
                                                                                <input id="paidamount" type="number" name="paidamount" class="form-control totalprice" value="{{$totalprice}}"  />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-4">Payment Type</div>
                                                                            <div class="col-sm-6">
                                                                                <select class="form-controlx" id="paymenttype" name="paymenttype" required="required">
                                                                                    <option value="cash">CASH</option>
                                                                                    <option value="cheque">CHEQUE</option>
                                                                                    <option value="card">CARD</option>
                                                                                </select>
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
                                                                    @endif
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
    <?php /* ?>
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        // just for the demos, avoids form submit
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        $( "#myform" ).validate({
            rules: {
                totalFees: {
                    required: true,
                    min: 1
                }
            }
        });
    </script>
    <?php */ ?>



    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

    <script>
        // Wait for the DOM to be ready
        $(function() {

            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z\s]+$/i.test(value);
            });

            jQuery.validator.addMethod('minStrict', function (value, el, param) {
                return value > param;
            });

            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form#myform").validate({
                // Specify validation rules
                rules: {
                    role: "required",
                    totalFees: {
                        required: true,
                        minStrict: 0,
                        number: true
                    }
                },
                // Specify validation error messages
                messages: {
                    role: "provide a valid Amount",
                    totalFees: "Please provide a valid Amount",
                    minStrict:"Please provide a valid Amount"
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@stop