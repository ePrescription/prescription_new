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
 
                         @if(count($scanDetails)>0)
                             <h4 class="m-t-0 m-b-30">Scan Test Details</h4>
                             @foreach($scanDetails as $recentTest)
                                 <?php $displaySet=0; ?>
                                 <div class="form-group">
                                     @foreach($recentTest as $recentTestDate)
                                         @if($displaySet==0)
                                             <label class="col-sm-12 control-label">{{$recentTestDate->scanDate}} - {{$recentTestDate->examination_time}} </label>
                                             <?php $displaySet=1; ?>
                                         @endif
                                     @endforeach
                                 </div>
                                 <div class="form-group col-sm-12">
                                     @foreach($recentTest as $recentTestValue)
                                         @if($recentTestValue->isValueSet==1)
                                             <div class="col-sm-6" style="width:50%;float:left;">
                                                 {{$recentTestValue->scanName}}
                                             </div>
                                         @endif
                                     @endforeach
                                 </div>
                             @endforeach
                         @endif



                    <?php /* ?>
                     <?php $i=0; ?>
                        @foreach($scanDetails as $scanDetailsValue)
                            @if($scanDetailsValue->isValueSet==1)
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-12 control-label">{{$scanDetailsValue->scanName}}</label>
                                </div>
                                <?php $i++; ?>
                            @endif
                        @endforeach
                    <?php */ ?>
                    </form>


                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

</div><!-- container -->

