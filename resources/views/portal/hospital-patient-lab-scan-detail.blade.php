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


                    <form role="form" method="POST" class="form-horizontal ">
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Brain Plain</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[0]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Brain With Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[1]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT PNS</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[2]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT PNS with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[3]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Temporal Bone</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[4]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Orbits</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[5]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Orbits with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[6]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Neck with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[7]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Spine</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[8]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Chest Plain</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[9]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Chest with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[10]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">HRCT Chest</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[11]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Upper Abdomen</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[12]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Abdomen and Pelvis Plain</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[13]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Abdomen and Pelvis with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[14]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Lower Abdomen Plain</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[15]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Lower Abdomen with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[16]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">CT Chest and Abdomen with Contrast</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[17]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">Cervical</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[18]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">Thoracic</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[19]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-sm-6 control-label">Lumbar</label>
                            <div class="col-sm-6 control-label">
                                @if($scanDetails[20]->isValueSet==1) Yes @else No @endif
                            </div>
                        </div>

                    </form>




                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

</div><!-- container -->

