<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientUrineExaminationItems extends Model
{
    protected $table = 'patient_urine_examination_item';

    public function urineexamination()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientUrineExamination', 'patient_urine_examination_id');
    }
}
