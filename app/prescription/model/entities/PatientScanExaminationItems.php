<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientScanExaminationItems extends Model
{
    protected $table = 'patient_scan_item';

    public function scan()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientScanExamination', 'patient_scan_id');
    }
}
