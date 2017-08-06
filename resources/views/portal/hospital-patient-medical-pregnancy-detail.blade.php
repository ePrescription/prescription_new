<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">

    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">
            <label class="col-sm-4 control-label">Uterus Height</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pregnancyDetails[0][pregnancyId]" value="1" required="required">
                <input type="text" class="form-control" name="pregnancyDetails[0][pregnancyValue]" value="{{$pregnancyDetails[0]->pregnancyValue}}" required="required" readonly>
                <input type="hidden" class="form-control" name="pregnancyDetails[0][pregnancyDate]" value="2017-08-07" required="required">
                <input type="hidden" class="form-control" name="pregnancyDetails[0][isValueSet]" value="1" required="required">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Presentation of the fetus</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pregnancyDetails[1][pregnancyId]" value="2" required="required">
                <input type="text" class="form-control" name="pregnancyDetails[1][pregnancyValue]" value="{{$pregnancyDetails[1]->pregnancyValue}}" required="required" readonly>
                <input type="hidden" class="form-control" name="pregnancyDetails[1][pregnancyDate]" value="2017-08-07" required="required">
                <input type="hidden" class="form-control" name="pregnancyDetails[1][isValueSet]" value="1" required="required">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Fetal heart sound</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pregnancyDetails[2][pregnancyId]" value="3" required="required">
                <input type="text" class="form-control" name="pregnancyDetails[2][pregnancyValue]" value="{{$pregnancyDetails[2]->pregnancyValue}}" required="required" readonly>
                <input type="hidden" class="form-control" name="pregnancyDetails[2][pregnancyDate]" value="2017-08-07" required="required">
                <input type="hidden" class="form-control" name="pregnancyDetails[2][isValueSet]" value="1" required="required">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Fetal movements</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pregnancyDetails[3][pregnancyId]" value="4" required="required">
                <input type="text" class="form-control" name="pregnancyDetails[3][pregnancyValue]" value="{{$pregnancyDetails[3]->pregnancyValue}}" required="required" readonly>
                <input type="hidden" class="form-control" name="pregnancyDetails[3][pregnancyDate]" value="2017-08-07" required="required">
                <input type="hidden" class="form-control" name="pregnancyDetails[3][isValueSet]" value="1" required="required">
            </div>
        </div>

    </form>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
