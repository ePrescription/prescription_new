<style>
    div.control-label {
        text-align: left !important;
    }
</style>


<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">

    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Uterus Height</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[0]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Presentation of the fetus</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[1]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Fetal heart sound</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[2]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Fetal movements</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[3]->pregnancyValue}}
            </div>
        </div>

    </form>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
