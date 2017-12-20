<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientScanExamination extends Model
{
    protected $table = 'patient_scan';

    public function scanexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientScanExaminationItems', 'patient_scan_id');
    }
}
