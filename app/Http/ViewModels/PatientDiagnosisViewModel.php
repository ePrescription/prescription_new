<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24/10/2017
 * Time: 3:34 PM
 */

namespace App\Http\ViewModels;


class PatientDiagnosisViewModel
{
    private $patientId;
    private $doctorId;
    private $hospitalId;
    private $diagnosisDate;
    private $examinationTime;
    private $investigations;
    private $examinationFindings;
    private $provisionalDiagnosis;
    private $finalDiagnosis;
    private $treatmentType;
    private $treatmentPlanNotes;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getPatientId()
    {
        return $this->patientId;
    }

    /**
     * @param mixed $patientId
     */
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;
    }

    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param mixed $doctorId
     */
    public function setDoctorId($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    /**
     * @return mixed
     */
    public function getHospitalId()
    {
        return $this->hospitalId;
    }

    /**
     * @param mixed $hospitalId
     */
    public function setHospitalId($hospitalId)
    {
        $this->hospitalId = $hospitalId;
    }

    /**
     * @return mixed
     */
    public function getDiagnosisDate()
    {
        return $this->diagnosisDate;
    }

    /**
     * @param mixed $complaintDate
     */
    public function setDiagnosisDate($diagnosisDate)
    {
        $this->diagnosisDate = $diagnosisDate;
    }

    /**
     * @return mixed
     */
    public function getExaminationTime()
    {
        return $this->examinationTime;
    }

    /**
     * @param mixed $examinationTime
     */
    public function setExaminationTime($examinationTime)
    {
        $this->examinationTime = $examinationTime;
    }

    /**
     * @return mixed
     */
    public function getInvestigations()
    {
        return $this->investigations;
    }

    /**
     * @param mixed $investigations
     */
    public function setInvestigations($investigations)
    {
        $this->investigations = $investigations;
    }

    /**
     * @return mixed
     */
    public function getExaminationFindings()
    {
        return $this->examinationFindings;
    }

    /**
     * @param mixed $examinationFindings
     */
    public function setExaminationFindings($examinationFindings)
    {
        $this->examinationFindings = $examinationFindings;
    }

    /**
     * @return mixed
     */
    public function getProvisionalDiagnosis()
    {
        return $this->provisionalDiagnosis;
    }

    /**
     * @param mixed $provisionalDiagnosis
     */
    public function setProvisionalDiagnosis($provisionalDiagnosis)
    {
        $this->provisionalDiagnosis = $provisionalDiagnosis;
    }

    /**
     * @return mixed
     */
    public function getFinalDiagnosis()
    {
        return $this->finalDiagnosis;
    }

    /**
     * @param mixed $finalDiagnosis
     */
    public function setFinalDiagnosis($finalDiagnosis)
    {
        $this->finalDiagnosis = $finalDiagnosis;
    }

    /**
     * @return mixed
     */
    public function getTreatmentType()
    {
        return $this->treatmentType;
    }

    /**
     * @param mixed $treatmentType
     */
    public function setTreatmentType($treatmentType)
    {
        $this->treatmentType = $treatmentType;
    }

    /**
     * @return mixed
     */
    public function getTreatmentPlanNotes()
    {
        return $this->treatmentPlanNotes;
    }

    /**
     * @param mixed $treatmentPlanNotes
     */
    public function setTreatmentPlanNotes($treatmentPlanNotes)
    {
        $this->treatmentPlanNotes = $treatmentPlanNotes;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}