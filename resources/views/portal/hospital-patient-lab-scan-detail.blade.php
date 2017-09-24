
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-body">


                                <!-- form start -->


                    <form role="form" method="POST" class="form-horizontal ">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Brain Plain</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[0][scanId]" value="1" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[0][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[0]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails11" value="1" name="scanDetails[0][isValueSet]">
                                    <label for="scanDetails11"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails12" value="0" name="scanDetails[0][isValueSet]" checked="checked">
                                    <label for="scanDetails12"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Brain With Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[1][scanId]" value="2" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[1][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[1]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails21" value="1" name="scanDetails[1][isValueSet]">
                                    <label for="scanDetails21"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails22" value="0" name="scanDetails[1][isValueSet]" checked="checked">
                                    <label for="scanDetails22"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT PNS</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[2][scanId]" value="3" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[2][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[2]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails31" value="1" name="scanDetails[2][isValueSet]">
                                    <label for="scanDetails31"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails32" value="0" name="scanDetails[2][isValueSet]" checked="checked">
                                    <label for="scanDetails32"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT PNS with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[3][scanId]" value="4" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[3][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[3]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails41" value="1" name="scanDetails[3][isValueSet]">
                                    <label for="scanDetails41"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails42" value="0" name="scanDetails[3][isValueSet]" checked="checked">
                                    <label for="scanDetails42"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Temporal Bone</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[4][scanId]" value="5" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[4][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[4]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails51" value="1" name="scanDetails[4][isValueSet]">
                                    <label for="scanDetails51"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails52" value="0" name="scanDetails[4][isValueSet]" checked="checked">
                                    <label for="scanDetails52"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Orbits</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[5][scanId]" value="6" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[5][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[5]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails61" value="1" name="scanDetails[5][isValueSet]">
                                    <label for="scanDetails61"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails62" value="0" name="scanDetails[5][isValueSet]" checked="checked">
                                    <label for="scanDetails62"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Orbits with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[6][scanId]" value="7" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[6][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[6]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails71" value="1" name="scanDetails[6][isValueSet]">
                                    <label for="scanDetails71"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails72" value="0" name="scanDetails[6][isValueSet]" checked="checked">
                                    <label for="scanDetails72"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Neck with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[7][scanId]" value="8" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[7][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[7]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails81" value="1" name="scanDetails[7][isValueSet]">
                                    <label for="scanDetails81"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails82" value="0" name="scanDetails[7][isValueSet]" checked="checked">
                                    <label for="scanDetails82"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Spine</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[8][scanId]" value="9" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[8][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[8]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails91" value="1" name="scanDetails[8][isValueSet]">
                                    <label for="scanDetails91"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails92" value="0" name="scanDetails[8][isValueSet]" checked="checked">
                                    <label for="scanDetails92"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Chest Plain</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[9][scanId]" value="10" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[9][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[9]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails101" value="1" name="scanDetails[9][isValueSet]">
                                    <label for="scanDetails101"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails102" value="0" name="scanDetails[9][isValueSet]" checked="checked">
                                    <label for="scanDetails102"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Chest with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[10][scanId]" value="11" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[10][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[10]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails111" value="1" name="scanDetails[10][isValueSet]">
                                    <label for="scanDetails111"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails112" value="0" name="scanDetails[10][isValueSet]" checked="checked">
                                    <label for="scanDetails112"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">HRCT Chest</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[11][scanId]" value="12" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[11][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[11]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails121" value="1" name="scanDetails[11][isValueSet]">
                                    <label for="scanDetails121"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails122" value="0" name="scanDetails[11][isValueSet]" checked="checked">
                                    <label for="scanDetails122"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Upper Abdomen</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[12][scanId]" value="13" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[12][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[12]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails131" value="1" name="scanDetails[12][isValueSet]">
                                    <label for="scanDetails131"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails132" value="0" name="scanDetails[12][isValueSet]" checked="checked">
                                    <label for="scanDetails132"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Abdomen and Pelvis Plain</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[13][scanId]" value="14" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[13][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[13]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails141" value="1" name="scanDetails[13][isValueSet]">
                                    <label for="scanDetails141"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails142" value="0" name="scanDetails[13][isValueSet]" checked="checked">
                                    <label for="scanDetails142"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Abdomen and Pelvis with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[14][scanId]" value="15" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[14][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[14]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails151" value="1" name="scanDetails[14][isValueSet]">
                                    <label for="scanDetails151"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails152" value="0" name="scanDetails[14][isValueSet]" checked="checked">
                                    <label for="scanDetails152"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Lower Abdomen Plain</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[15][scanId]" value="16" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[15][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[15]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails161" value="1" name="scanDetails[15][isValueSet]">
                                    <label for="scanDetails161"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails162" value="0" name="scanDetails[15][isValueSet]" checked="checked">
                                    <label for="scanDetails162"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Lower Abdomen with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[16][scanId]" value="17" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[16][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[16]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails171" value="1" name="scanDetails[16][isValueSet]">
                                    <label for="scanDetails171"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails172" value="0" name="scanDetails[16][isValueSet]" checked="checked">
                                    <label for="scanDetails172"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">CT Chest and Abdomen with Contrast</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[17][scanId]" value="18" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[17][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[17]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails181" value="1" name="scanDetails[17][isValueSet]">
                                    <label for="scanDetails181"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails182" value="0" name="scanDetails[17][isValueSet]" checked="checked">
                                    <label for="scanDetails182"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cervical</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[18][scanId]" value="19" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[18][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[18]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails191" value="1" name="scanDetails[18][isValueSet]">
                                    <label for="scanDetails191"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails192" value="0" name="scanDetails[18][isValueSet]" checked="checked">
                                    <label for="scanDetails192"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Thoracic</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[19][scanId]" value="20" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[19][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[19]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails201" value="1" name="scanDetails[19][isValueSet]">
                                    <label for="scanDetails201"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails202" value="0" name="scanDetails[19][isValueSet]" checked="checked">
                                    <label for="scanDetails202"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Lumbar</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="scanDetails[20][scanId]" value="21" required="required">
                                <input type="hidden" class="form-control" name="scanDetails[20][scanDate]" value="2017-08-06" required="required">
                                @if($scanDetails[20]->isValueSet==1) Yes @else No @endif
                                <div class="hidden radio radio-info radio-inline">
                                    <input type="radio" id="scanDetails211" value="1" name="scanDetails[20][isValueSet]">
                                    <label for="scanDetails211"> Yes </label>
                                </div>
                                <div class="hidden radio radio-inline">
                                    <input type="radio" id="scanDetails212" value="0" name="scanDetails[20][isValueSet]" checked="checked">
                                    <label for="scanDetails212"> No </label>
                                </div>
                            </div>
                        </div>

                    </form>




                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

</div><!-- container -->

