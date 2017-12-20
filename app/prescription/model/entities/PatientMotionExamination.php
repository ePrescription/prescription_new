<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientMotionExamination extends Model
{
    protected $table = 'patient_motion_examination';

    public function motionexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientMotionExaminationItems', 'patient_motion_examination_id');
    }
}
