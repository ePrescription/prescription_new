<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Complaint Detail</h4>


    <form role="form" method="POST" class="form-horizontal ">
        @foreach($complaintDetails as $complaintDetailValues)<h4>{{$complaintDetailValues[0]->complaint_date}} - {{$complaintDetailValues[0]->examination_time}}</h4>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6"><strong>Complaint Type</strong></div>
                <div class="col-sm-6"><strong>Complaint Name</strong></div>

            </div>
            <hr/>
            @foreach($complaintDetailValues as $complaintDetail)
                <div class="row">
                    <div class="col-sm-6">{{$complaintDetail->complaint_type_name}}</div>
                    <div class="col-sm-6">{{$complaintDetail->complaint_name}}</div>
                </div>
                <hr/>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-12"><strong>Complaint Notes:</strong> {{$complaintDetailValues[0]->complaint_text}}</div>
        </div>

        @endforeach

    </form>



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
