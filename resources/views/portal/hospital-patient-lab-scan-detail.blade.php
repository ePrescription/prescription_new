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


                                <!-- form start -->
<style>
    form.display label.control-label{ text-align:left; }
</style>

                     <form role="form" method="POST" class="display form-horizontal">
                        <?php $i=0; ?>
                        @foreach($scanDetails as $scanDetailsValue)
                            @if($scanDetailsValue->isValueSet==1)
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-12 control-label">{{$scanDetailsValue->scanName}}</label>
                                </div>
                                <?php $i++; ?>
                            @endif
                        @endforeach
                    </form>


                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

</div><!-- container -->

