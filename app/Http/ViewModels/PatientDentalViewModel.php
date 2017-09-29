<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/09/2017
 * Time: 2:36 PM
 */

namespace App\Http\ViewModels;


class PatientDentalViewModel
{
    private $patientId;
    private $doctorId;
    private $hospitalId;
    private $examinationDate;
    private $patientDentalTests;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->patientDentalTests = array();
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
    public function getPatientDentalTests()
    {
        return $this->patientDentalTests;
    }

    /**
     * @param mixed $patientDentalTests
     */
    public function setPatientDentalTests($patientDentalTests)
    {
        array_push($this->patientDentalTests, (object) $patientDentalTests);
        //$this->patientDentalTests = $patientDentalTests;
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