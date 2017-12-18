<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientBloodExaminationItems extends Model
{
    protected $table = 'patient_blood_examination_item';

    public function bloodexamination()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientBloodExamination', 'patient_blood_examination_id');
    }
}
