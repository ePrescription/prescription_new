<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientUltrasoundExaminationItems extends Model
{
    //patient_ultra_sound_id
    protected $table = 'patient_ultra_sound_item';

    public function ultrasound()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientUltrasoundExamination', 'patient_ultra_sound_id');
    }

}
