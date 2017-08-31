<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">

    <form action="#" role="form" method="POST" class="form-horizontal ">
        <?php $i=0; ?>
        @foreach($urineTests as $urineTestsValue)
            <div class="form-group">

                <label class="col-sm-4 control-label">{{$urineTestsValue->examinationName}}</label>
                <div class="col-sm-6">
                    @if($urineTestsValue->isValueSet==1) Yes @else No @endif
                </div>
            </div>
            <?php $i++; ?>
        @endforeach
    </form>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
