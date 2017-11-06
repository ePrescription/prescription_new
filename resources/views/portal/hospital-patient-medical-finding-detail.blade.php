<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Finding Detail</h4>



    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">

            @foreach($investigationDetails as $investigationDetailValues)

                <div class="row">

                    <h4>{{$investigationDetailValues[0]->diagnosis_date}} - {{$investigationDetailValues[0]->examination_time}}</h4>
                    @foreach($investigationDetailValues as $investigationDetail)
                    <div class="col-sm-3">Investigations </div><div class="col-sm-9"> {{$investigationDetail->investigations}}</div>
                    <div class="col-sm-3">Examination Findings </div><div class="col-sm-9"> {{$investigationDetail->examination_findings}}</div>
                    <div class="col-sm-3">Provisional Diagnosis </div><div class="col-sm-9"> {{$investigationDetail->provisional_diagnosis}}</div>
                    <div class="col-sm-3">Final Diagnosis </div><div class="col-sm-9"> {{$investigationDetail->final_diagnosis}}</div>
                    <div class="col-sm-3">Treatment Type </div><div class="col-sm-9"> {{$investigationDetail->treatment_type}}</div>
                    @endforeach
                </div>
                <hr/>
            @endforeach

        </div>
    </form>



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
