<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Complaint Detail</h4>


    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">
            @foreach($complaintDetails as $complaintDetail)
                <div class="row">
                    <div class="col-sm-12">{{$complaintDetail->complaint_name}}</div>
                </div>
                <hr/>
            @endforeach
        </div>
    </form>


    <?php /* ?>
<!-- form start -->
    <form role="form" method="POST" class="form-horizontal ">
    <div class="form-group">

        <div class="row">
            <div class="col-sm-4"><strong>Main Symptom</strong></div>
            <div class="col-sm-4"><strong>Sub Symptom</strong></div>
            <div class="col-sm-4"><strong>Symptom</strong></div>
        </div>
        <hr/>
        @foreach($symptomDetails as $symptomDetail)
        <div class="row">
            <div class="col-sm-4">{{$symptomDetail->mainSymptomName}}</div>
            <div class="col-sm-4">{{$symptomDetail->subSymptomName}}</div>
            <div class="col-sm-4">{{$symptomDetail->symptomName}}</div>
        </div>
        <hr/>
        @endforeach
    </div>

    </form>
    <?php */ ?>



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
