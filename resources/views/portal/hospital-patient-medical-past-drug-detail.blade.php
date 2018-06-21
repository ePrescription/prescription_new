

<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Past Drug Details</h4>

<!-- form start -->
    <form role="form" method="POST" class="form-horizontal ">
    <div class="form-group">

        <div class="row">
            <div class="col-sm-4"><strong>Drug Name</strong></div>
            <div class="col-sm-4"><strong>Drug Dosage</strong></div>
            <div class="col-sm-4"><strong>Drug Timing</strong></div>
        </div>
        @foreach($drugSurgeryHistory['drugHistory'] as $drugHistory)
        <div class="row">
            <div class="col-sm-4">{{$drugHistory->drugName}}</div>
            <div class="col-sm-4">{{$drugHistory->dosage}}</div>
            <div class="col-sm-4">{{$drugHistory->timings}}</div>
        </div>
        @endforeach
    </div>

    </form>

    <h4 class="m-t-0 m-b-30">Past Surgery Details</h4>

    <!-- form start -->
    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6"><strong>Surgery Name</strong></div>
                <div class="col-sm-6"><strong>Surgery Date</strong></div>
            </div>
            @foreach($drugSurgeryHistory['surgeryHistory'] as $surgeryHistory)
                <div class="row">
                    <div class="col-sm-6">{{$surgeryHistory->patientSurgeries==" "?" ":$surgeryHistory->patientSurgeries}}</div>
                    <div class="col-sm-6"> {{$surgeryHistory->operationDate=="0000-00-00" ? " " :$surgeryHistory->operationDate}}</div>
                </div>
            @endforeach
        </div>
    </form>


<?php /* ?>
<form action="{{URL::to('/')}}/fronthospital/rest/api/drughistory" role="form" method="POST" class="form-horizontal ">
<div class="form-group">
<label class="col-sm-2 control-label">Drug Details</label>
<div class="col-sm-7">
Drug Name<br/>
<input type="text" class="form-control" name="drugHistory[0][drugName]" value="" required="required" />
Drug Dosage<br/>
<input type="text" class="form-control" name="drugHistory[0][dosage]" value="" required="required" />
Drug Timing<br/>
<input type="text" class="form-control" name="drugHistory[0][timings]" value="" required="required" />
<input type="hidden" class="form-control" name="drugHistory[0][drugHistoryDate]" value="{{date('Y-m-d')}}" required="required" />

</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Surgery Details</label>
<div class="col-sm-7">
Surgery Name<br/>
<input type="text" class="form-control" name="surgeryHistory[0][surgeryName]" value="" required="required" />
Operation Date (YYYY-MM-DD)<br/>
<input type="text" class="form-control" name="surgeryHistory[0][operationDate]" value="" required="required" />
<input type="hidden" class="form-control" name="surgeryHistory[0][surgeryInputDate]" value="{{date('Y-m-d')}}" required="required" />

</div>
</div>

<div class="form-group">
<div class="col-sm-4"></div>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />

<input type="submit" name="addpersonal" value="Save" class="btn btn-success">
</div>
</div>

</form>
<?php */ ?>



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
