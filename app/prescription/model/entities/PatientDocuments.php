<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientDocuments extends Model
{
    protected $table = 'patient_document';

    public function patientdocumentitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientDocumentItems', 'patient_document_id');
    }
}
