<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12/09/2017
 * Time: 3:31 PM
 */

namespace App\Http\ViewModels;


class DoctorReferralsViewModel
{
    private $doctorName;
    private $hospitalName;
    private $location;
    private $specialtyId;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getDoctorName()
    {
        return $this->doctorName;
    }

    /**
     * @param mixed $doctorName
     */
    public function setDoctorName($doctorName)
    {
        $this->doctorName = $doctorName;
    }

    /**
     * @return mixed
     */
    public function getHospitalName()
    {
        return $this->hospitalName;
    }

    /**
     * @param mixed $hospitalName
     */
    public function setHospitalName($hospitalName)
    {
        $this->hospitalName = $hospitalName;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getSpecialtyId()
    {
        return $this->specialtyId;
    }

    /**
     * @param mixed $specialtyId
     */
    public function setSpecialtyId($specialtyId)
    {
        $this->specialtyId = $specialtyId;
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