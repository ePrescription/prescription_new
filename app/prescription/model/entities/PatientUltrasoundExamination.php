<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientUltrasoundExamination extends Model
{
    protected $table = 'patient_ultra_sound';

    public function ultrasoundexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientUltrasoundExaminationItems', 'patient_ultra_sound_id');
    }
}
