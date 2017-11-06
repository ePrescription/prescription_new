<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Complaint Detail</h4>


    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">

            @foreach($complaintDetails as $complaintDetailValues)

                <div class="row">
                    <h4>{{$complaintDetailValues[0]->complaint_date}} - {{$complaintDetailValues[0]->examination_time}}</h4>
                    @foreach($complaintDetailValues as $complaintDetail)
                    <div class="col-sm-12"><i class="fa fa-square"></i> {{$complaintDetail->complaint_name}}</div>
                    @endforeach
                    <br/><br/><br/>
                    <div class="col-sm-12"><p><strong> Notes: </strong>{{$complaintDetailValues[0]->complaint_text}}</p></div>
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
