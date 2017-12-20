<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientMotionExaminationItems extends Model
{
    protected $table = 'patient_motion_examination_item';

    public function motionexamination()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientMotionExamination', 'patient_motion_examination_id');
    }
}
