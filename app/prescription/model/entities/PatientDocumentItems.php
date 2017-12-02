<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientDocumentItems extends Model
{
    protected $table = 'patient_document_items';

    public function patientdocument()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientDocuments', 'patient_document_id');
    }
}
