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

    <form action="#" role="form" method="POST" class="form-horizontal ">
        <?php $i=0; ?>
        @foreach($dentalTests as $dentalTestsValue)
            <div class="form-group col-sm-6">

                <label class="col-sm-12 control-label" style="text-align: left;">{{$dentalTestsValue->examinationName}}</label>
                <?php /* ?>
                <div class="col-sm-6 control-label">
                    @if($ultraSoundValue->isValueSet==1) Yes @else No @endif
                </div>
                <?php */ ?>
            </div>
            <?php $i++; ?>
        @endforeach
    </form>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
