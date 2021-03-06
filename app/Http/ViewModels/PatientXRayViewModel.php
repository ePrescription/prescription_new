<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02/10/2017
 * Time: 2:52 PM
 */

namespace App\Http\ViewModels;


class PatientXRayViewModel
{
    private $patientId;
    private $doctorId;
    private $hospitalId;
    private $labId;

    private $examinationDate;
    private $examinationTime;
    private $patientXRayTests;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->patientXRayTests = array();
    }

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
    public function getLabId()
    {
        return $this->labId;
    }

    /**
     * @param mixed $labId
     */
    public function setLabId($labId)
    {
        $this->labId = $labId;
    }

    /**
     * @return mixed
     */
    public function getExaminationDate()
    {
        return $this->examinationDate;
    }

    /**
     * @param mixed $examinationDate
     */
    public function setExaminationDate($examinationDate)
    {
        $this->examinationDate = $examinationDate;
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
    public function getPatientXRayTests()
    {
        return $this->patientXRayTests;
    }

    /**
     * @param mixed $patientXRayTests
     */
    public function setPatientXRayTests($patientXRayTests)
    {
        array_push($this->patientXRayTests, (object) $patientXRayTests);
        //$this->patientXRayTests = $patientXRayTests;
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