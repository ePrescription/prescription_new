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

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Patient Prescription Details</h4>
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
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/details" title="View Profile"><i class="fa fa-user-circle"></i>View Profile </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" title="Medical Profile"><i class="fa fa-medkit"></i>Medical Profile</a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/prescription-details" title="Medical Prescription"><i class="fa fa-file-text-o"></i>Medical Prescription </a>
                                            &nbsp;&nbsp;

                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-details" title="Lab Profile"><i class="fa fa-flask"></i> Lab Profile</a>
                                            &nbsp;

                                            <!--ADDED BY RAMANA --->
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-details-results" title="Print Patient lab Tests"><i class="fa fa-folder-o"></i>Print Patient lab Tests </a>
                                            &nbsp;&nbsp;

                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/lab-report-download" title="Lab Report Download"><i class="fa fa-download"></i>Lab Report Download </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/labreceipts" title="Lab Receipts"><i class="fa fa-money"></i>Lab Receipts </a>
                                            &nbsp;&nbsp;
                                            <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/print" title="Print Medical Profile"><i class="fa fa-print"></i> Print Medical Profile</a>

                                        </div>
                                    </div>
                                    <div style="float:right;">
                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patients">
                                            <button class="btn btn-info waves-effect waves-light">Back to Patient List</button>
                                        </a>
                                    </div>

                                    <h4 class="m-t-0 m-b-30">Patient Prescription Details</h4>



                                    @if (session()->has('success'))
                                        <div class="col_full login-title">
                                     <span style="color:green;">
                                        <b>{{session('success')}}</b>
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
                                                <label class="col-sm-3 control-label">Relation Name</label>
                                                <div class="col-sm-9">
                                                    {{$patientDetails[0]->spouseName}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs navtab-bg">

                                                <li  class="">
                                                    <a href="#messages" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                                        <span class="hidden-xs">View Prescription</span>
                                                    </a>
                                                </li>
                                                <li  class="active">
                                                    <a href="#prescription" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                                        <span class="hidden-xs">Add Prescription</span>
                                                    </a>
                                                </li>
                                                <li  class="">
                                                    <a href="#addfile" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                                        <span class="hidden-xs">Add Attachment</span>
                                                    </a>
                                                </li>
                                                <?php /* ?>
                                                <li class="">
                                                    <a href="#home" data-toggle="tab" aria-expanded="true">
                                                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                                                        <span class="hidden-xs">Info</span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#profile" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                                                        <span class="hidden-xs">Appointment</span>
                                                    </a>
                                                </li>


                                                <li class="">
                                                    <a href="#settings" data-toggle="tab" aria-expanded="false">
                                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                                        <span class="hidden-xs">Lab Tests</span>
                                                    </a>
                                                </li>
                                                <?php */ ?>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane" id="addfile">
                                                    <form action="#">
                                                    <h5>Add Attachment</h5><input type="file" class="form-control" id="prescriptionFile" name="prescriptionFile"/>
                                                     <br>
                                                        <button type="button" class="btn btn-success">Save</button>
                                                    </form>
                                                </div>


                                                <div class="tab-pane" id="messages">
                                                    <p>
                                                    <div>
                                                        PRID ( Prescription Identification) - PID ( Patient Identification)
                                                    </div>
                                                    <table id="example2" class="table table-bordered table-hover">
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
                                                        @foreach($patientPrescriptions as $prescription)
                                                            <tr>
                                                                <td>{{$prescription->unique_id}}</td>
                                                                <td>{{$prescription->pid}}</td>
                                                                <td>{{$prescription->name}}</td>
                                                                <td>{{$prescription->prescription_date}}</td>
                                                                <td>

                                                                    <a href="{{URL::to('/')}}/doctor/prescription/{{$prescription->prescription_id}}"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</button></a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>

                                                    </p>
                                                </div>
                                                <style>
                                                    .addButton, .removeButton { float:right; }
                                                </style>

                                                <div class="tab-pane active" id="prescription">
                                                    <div class="panel-body" style="padding: 0px;">
                                                        <div class="table-responsive">
                                                            <div id="POItablediv" >
                                                                <form action="{{URL::to('/')}}/doctor/rest/api/patient/prescription" method="GET" id="form1" onsubmit="return validateForm('form1')" style="line-height:10px; padding: 0px;">


                                                                    <h4>Current Illness:</h4>  <textarea class="form-control" style="width: 750px; height: 50px; resize: none;" name="drugHistory" value="" id="drugHistory" ></textarea>

                                                                    <br><br><br>
                                                                    <input type="radio" class="form-controlx" onclick="change(1)"  id="bytradeName"  name="status" checked/><b>By Trade Name</b>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" class="form-controlx" onclick="change(2)"   id="byformulationName" name="status"/><b>BY Formulation Name</b>

<br><br><br><br>



                                                                    <table class="table" id="POITable">
                                                                <thead>
                                                                <tr>
                                                                    <th>TRADE</th>
                                                                    <th>FORMULATION</th>
                                                                    <th>TYPE</th>
                                                                    <th>DOSAGE</th>
                                                                    <th>DAYS</th>
                                                                    <th>FREQUENCY</th>
                                                                    <th>Notes</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <tr>

                                                                      <td style="width:20%;">

                                                                          <input type="text" class="form-control tradeName" onselect="changeValues(this,0);" onchange="changeValues(this,0);" name=""  list="result"   id="trade0" onkeyup="load(this)" required="required" style="width:100%;" />

                                                                          <datalist style="display: none" id="result" data-size="1" ></datalist>
                                                                    <!--     <td style="width:20%;">

                                                                            <select id="trade0" name="trade0" class="form-control " onkeyup="load(this)" style="display: block;">
                                                                                <option value="">--CHOOSE PATIENT--</option>
                                                                            </select>-->
                                                                        </td>
                                                                        <td style="width:20%;"> <input type="text" class="form-control formulation" name="drugs[0][fomulationId]" list="result" id="formulation0" onselect="changeValues(this,0)" onchange="changeValues(this,0)"   onkeyup="load(this)" required="required" readonly="readonly" style="width:100%; text-transform: uppercase;" /></td>
                                                                        <datalist style="display: none" id="result" data-size="1" ></datalist>

                                                                        <td style="width:10%;"><input type="text"  value="WEB" name="drugs[0][intakeForm]" id="type0"  readonly style="width:100%;" ></td>
                                                                        <td style="width:10%;"><input type="text"  name="drugs[0][dosage]" id="dosage0" style="width:100%;" ></td>
                                                                        <td style="width:10%;"><input type="number"  name="drugs[0][noOfDays]" id="days0" style="width:100%;"  min="0" required></td>
                                                                        <td style="width:20%;"><input type="checkbox" class="form-controlx"  id="morningId0" name="drugs[0][morning]" value="1"   />M

                                                                            <input type="checkbox" class="form-controlx"  id="afternoonId0" name="drugs[0][afternoon]" value="1" />A

                                                                            <input type="checkbox" class="form-controlx"  id="nightId0" name="drugs[0][night]" value="1"  />N

                                                                            <input type="hidden" id="drug0" class="form-control" name="drugs[0][drugId]" value=""  />

                                                                            <input type="hidden" id="brand0" class="form-control" name="drugs[0][brandId]" value=""  />

                                                                         <input type="hidden" name="doctorId" id="doctorId" value="{{Auth::user()->id}}">
                                                                         <input type="hidden" name="hospitalId" id="hospitalId" value="{{Session::get('LoginUserHospital')}}">
                                                                         <input type="hidden" name="patientId" id="patientId" value="{{$patientDetails[0]->patient_id}}">

                                                                        </td>
                                                                         <td style="width:10%;">
                                                                            <div class="btn btn-primary addButton">+</div>
                                                                        </td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                                    <div id="symptomTemplate1"></div>

                                                                    <h4>Description:</h4><textarea  style="width: 750px; height: 50px; resize: none;"  name="notes" id="notes"></textarea>

                                                                    <input type="submit" value="save" class="btn btn-success" style="float: right;padding-left: 30px;padding-right: 30px; padding-top: 10px;padding-bottom: 10px;">

                                                                </form>


                                                                <div class="form-group remove-doc-box hide" id="symptomTemplate">

                                                                    <table class="table" id="POITable"  class="table table-boderless">

                                                                        <tbody>

                                                                        <tr>
                                                                            <td style="width:20%;" ><input type="text" onselect="changeValues(this,0)" onchange="changeValues(this,0)" class="form-control tradeName" name="trade" style="width:100%;" list="result" required="required"  id="trade"  onkeyup="load(this)" />

                                                                            </td>
                                                                            <td style="width:20%;"><input type="text" class="form-control formulation" name="formulation" onselect="changeValues(this,0)" onchange="changeValues(this,0)"  list="result"  style="width:100%;" id="formulation" onkeyup="load(this)"   required="required"/></td>
                                                                            <td style="width:10%;"><input type="text"  value="" name="type" id="type" style="width:100%;" readonly ></td>
                                                                            <td style="width:10%;"><input type="text"  name="dosage" id="dosage" style="width:100%;" ></td>
                                                                            <td style="width:10%;"><input type="number" id="days"  name="days" style="width:100%;"  min="0" required></td>
                                                                            <td style="width:20%;">
                                                                                <input type="checkbox" class="form-controlx"  id="morningId" name="morning" value="1"  />M
                                                                                <input type="checkbox" class="form-controlx" id="afternoonId" name="afternoon" value="1"   />A
                                                                                <input type="checkbox" class="form-controlx"  id="nightId" name="night" value="1" />N

                                                                                <input type="hidden" id="drug" class="form-control" name="drug" value=""  />
                                                                                <input type="hidden" class="form-control" id="brand" name="brand" value=""  />
                                                                            </td>
                                                                            <td style="width:10%;">
                                                                                <div class="btn btn-default removeButton min-button" value="-">-</div>

                                                                            </td>

                                                                        </tr>

                                                                        </tbody>
                                                                    </table>

                                                                </div>

                                                            </div>



                                                        </div>
                                                </div>



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
</div>
@endsection
@section('scripts')
{!!  Html::script(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.jquery.min.js')) !!}
{!!  Html::script(asset('plugins/ajax-chosen/lib/ajax-chosen.js')) !!}

{!!  Html::style(asset('plugins/ajax-chosen/dist/chosen/chosen/chosen.css')) !!}



<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

<script type="text/javascript">
    function change(id){
        if(id==1){
            $('#formulation'+prescriptionIndex).attr('readonly', true);
            $('#trade'+prescriptionIndex).attr('readonly', false);
        }else{
            $('#formulation'+prescriptionIndex).attr('readonly', false);
            $('#trade'+prescriptionIndex).attr('readonly', true);
        }

    }
</script>

<script type="text/javascript">
           function load(key) {

               //To Detect
               // Opera 8.0+
               var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

               // Firefox 1.0+
               var isFirefox = typeof InstallTrigger !== 'undefined';

               // if(key.value.length<2){
               //    return false;
               //}
               // Safari 3.0+ "[object HTMLElementConstructor]"
               var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) {
                   return p.toString() === "[object SafariRemoteNotification]";
               })(!window['safari'] || safari.pushNotification);

               // Internet Explorer 6-11
               var isIE = /*@cc_on!@*/false || !!document.documentMode;

               // Edge 20+
               var isEdge = !isIE && !!window.StyleMedia;

               // Chrome 1+
               var isChrome = !!window.chrome && !!window.chrome.webstore;

               // Blink engine detection
               var isBlink = (isChrome || isOpera) && !!window.CSS;

               if (isChrome) {
                   // alert(key.value.length);
                   if (key.value.length < 2) {
                       return false;
                   }
               }
               var dataList = document.getElementById('result');




               var traStatus = $("#bytradeName").is(':checked');
               var forStatus = $("#byformulationName").is(':checked');

               //if By Trade Name
               if (traStatus) {
                   $.ajax({
                       type: 'GET',
                       //url: '/vistara/ajax-chosen-master/data.json',
                       ///url: '/treatin-web-app/public/ajaxGetCountry',
                       url: '{{ URL::to('/') }}/hospital/rest/api/brands',
                       dataType: 'json',
                       data: {brands: key.value},

                       success: function (data) {
                           $.each(data, function (i, val) {
                               var terms = {};
                              // dataList.innerText="";
                               if (i == "result") {

                                   val.forEach(function (element) {
                                         var option = document.createElement('option');
                                       // Set the value using the item in the JSON array.
                                     //  option.value = element['tradeName'];
                                       option.text = element['tradeName'];
                                       option.brandId = element['tradeId'];
                                       option.drugId = element['drug_id'];
                                       option.dispensing_form = element['dispensing_form'];
                                       option.dosage_amount = element['dosage_amount'] + " " + element['quantity'];
                                       option.formulationName = element['formulationName'];
                                       dataList.append(option);
                                   });
                                   // key.placeholder =dataList;
                               }
                               //return terms;
                           });
                       }
                   });
               }
               else {
                   //alert()
                   $.ajax({
                       type: 'GET',
                       //url: '/vistara/ajax-chosen-master/data.json',
                       ///url: '/treatin-web-app/public/ajaxGetCountry',
                       url: '{{ URL::to('/') }}/hospital/rest/api/formulations',
                       dataType: 'json',
                       data: {formulations: key.value},

                       success: function (data) {
                           $.each(data, function (i, val) {
                               var terms = {};
                            //   dataList.innerText="";
                               if (i == "result") {

                                   val.forEach(function (element) {
                                       //alert(element['tradeName']);
                                          var option = document.createElement('option');
                                       // Set the value using the item in the JSON array.
                                       //option.value = element['tradeId'];
                                       option.text = element['tradeName'];
                                       option.brandId = element['tradeId'];
                                       option.drugId = element['drug_id'];
                                       option.dispensing_form = element['dispensing_form'];
                                       option.dosage_amount = element['dosage_amount'] + " " + element['quantity'];
                                       option.formulationName = element['formulationName'];


                                       dataList.append(option);
                                   });
                                   // key.placeholder =dataList;

                               }
                               //return terms;
                           });
                       }
                   });
               }
           }








           function changeValues(key,indx){

               var options = $('datalist')[0].options;
               for (var i=0;i<options.length;i++){
                   if (options[i].value == key.value)
                   {
                       // alert($(key).val()+"  "+options[i].formulationName);
                       $("#trade"+indx).val(options[i].text);
                       $("#drug"+indx).val(options[i].drugId);
                       $("#formulation"+indx).val(options[i].formulationName);
                       $("#type"+indx).val(options[i].dispensing_form);
                       $("#dosage"+indx).val(options[i].dosage_amount);
                       $("#brand"+indx).val(options[i].brandId);

                     //  break;
                       //key.value=0;
                   }
               }
           }
          /* $(function () {
               $(document).on('click', '#browser', function () {
                   var options = $('datalist')[0].options;
                   alert("RAM");
                   for (var i = 0; i < options.length++; i++) {
                       if (options[i].value == $(this).val()) {
                           alert($(this).val());
                           break;
                       }
                   }
               })

           })
*/

</script>

           <script>

           $(document).ready(function() {
               prescriptionIndex = 0;
               $('#POItablediv')
                   .on('click', '.addButton', function() {

                       var trade = $("#trade" + prescriptionIndex).val();
                       var formulation = $("#formulation" + prescriptionIndex).val();
                       var days = $("#days" + prescriptionIndex).val();
                       var morning = $("#morningId" + prescriptionIndex).is(':checked');
                       var afternoon = $("#afternoonId" + prescriptionIndex).is(':checked');
                       var night = $("#nightId" + prescriptionIndex).is(':checked');



                       //  alert(trade + "--" + formulation + "--" + days + "--" + morning + "--" + afternoon + "--" + night);

                       if (trade != "" && formulation != "" && days != "" && (morning || afternoon || night)) {




                           prescriptionIndex++;
                           var $template1 = $('#symptomTemplate1')
                           var $template = $('#symptomTemplate'),
                               $clone = $template.clone().removeClass('hide').removeAttr('id').attr('data-book-index', prescriptionIndex).insertBefore($template1);
                           // alert(prescriptionIndex);
                           $clone
                               .find('[name="trade"]').attr('name', '').end()
                               .find('[name="formulation"]').attr('name', 'drugs[' + prescriptionIndex + '][formulationId]').end()
                               .find('[name="type"]').attr('name', 'drugs[' + prescriptionIndex + '][intakeForm]').end()
                               .find('[name="dosage"]').attr('name', 'drugs[' + prescriptionIndex + '][dosage]').end()
                               .find('[name="days"]').attr('name', 'drugs[' + prescriptionIndex + '][noOfDays]').end()
                               .find('[name="morning"]').attr('name', 'drugs[' + prescriptionIndex + '][morning]').end()
                               .find('[name="afternoon"]').attr('name', 'drugs[' + prescriptionIndex + '][afternoon]').end()
                               .find('[name="night"]').attr('name', 'drugs[' + prescriptionIndex + '][night]').end()
                               .find('[name="brand"]').attr('name', 'drugs[' + prescriptionIndex + '][brandId]').end()
                               .find('[name="drug"]').attr('name', 'drugs[' + prescriptionIndex + '][drugId]').end()

                               .find('[id="trade"]').attr('id', 'trade' + prescriptionIndex).end()

                               .find('[id="formulation"]').attr('id', 'formulation' + prescriptionIndex).end()
                               .find('[id="type"]').attr('id', 'type' + prescriptionIndex).end()
                               .find('[id="dosage"]').attr('id', 'dosage' + prescriptionIndex).end()
                               .find('[id="brand"]').attr('id', 'brand' + prescriptionIndex).end()
                               .find('[id="drug"]').attr('id', 'drug' + prescriptionIndex).end()

                               .find('[id="days"]').attr('id', 'days' + prescriptionIndex).end()
                               .find('[id="morningId"]').attr('id', 'morningId' + prescriptionIndex).end()
                               .find('[id="afternoonId"]').attr('id', 'afternoonId' + prescriptionIndex).end()
                               .find('[id="nightId"]').attr('id', 'nightId' + prescriptionIndex).end()


                               .find('[onselect="changeValues(this,0)"]').attr('onselect', 'changeValues(this,' + prescriptionIndex + ')').end()

                               .find('[onchange="changeValues(this,0)"]').attr('onchange', 'changeValues(this,' + prescriptionIndex + ')').end()
                           var traStatus = $("#bytradeName").is(':checked');
                           var forStatus = $("#byformulationName").is(':checked');
                       //    alert(traStatus+"---"+forStatus);

                           if(traStatus){
                               $("#formulation" + prescriptionIndex).attr('readonly', true);

                               $("#trade" + prescriptionIndex).attr('readonly', false);
                           }else{
                               $("#formulation" + prescriptionIndex).attr('readonly', false);

                               $("#trade" + prescriptionIndex).attr('readonly', true);
                           }

                       }else{
                           alert("Please Fill Mandatory Fields");
                       }

                   })


                   // Remove button click handler
                   .on('click', '.removeButton', function() {
                       if(window.confirm("Do you Want To Delete ..?")) {
                           //alert("Hi");
                           var $row = $(this).parents('.remove-doc-box'),

                               index = $row.attr('data-book-index');
                           //alert($row+"======"+index+"--"+prescriptionIndex);


                           if (index == prescriptionIndex) {

                               $row.remove();
                               prescriptionIndex--;
                           } else {
                               alert("First Remove Last Record");
                               return false;
                           }
                       }
                       //$row.remove();
                   });
           });

</script>
<script>


          /* $(document).on('change', '#trade', function(){
               var options = $('datalist')[0].options;
               for (var i=0;i<options.length;i++){
                   if (options[i].value != $(this).val())
                   {alert($(this).val());break;}
               }
           });*/

           function validateForm(formId) {

               //$("#POITable").val();

               var trade = $("#trade" + prescriptionIndex).val();
               var formulation = $("#formulation" + prescriptionIndex).val();
               var days = $("#days" + prescriptionIndex).val();
               var morning = $("#morningId" + prescriptionIndex).is(':checked');
               var afternoon = $("#afternoonId" + prescriptionIndex).is(':checked');
               var night = $("#nightId" + prescriptionIndex).is(':checked');

             //  alert(trade + "--" + formulation + "--" + days + "--" + morning + "--" + afternoon + "--" + night);

               if (trade != "" && formulation != "" && days != "" && (morning || afternoon || night)) {
               return true;
               }else{
                   return false;
               }



           }
    </script>
<style type="text/css">
    datalist#result { width: 30px; display: block;height: 10px }
</style>

@stop
