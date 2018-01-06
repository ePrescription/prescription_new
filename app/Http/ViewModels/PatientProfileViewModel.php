<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/11/2016
 * Time: 7:45 PM
 */

namespace App\Http\ViewModels;


class PatientProfileViewModel
{
    private $patientId;
    private $name;
    private $address;
    private $occupation;
    private $careOf;
    private $city;
    private $country;
    private $pid;
    private $telephone;
    private $email;
    private $relationship;
    private $spouseName;
    private $patientPhoto;
    private $dob;
    private $age;
    private $placeOfBirth;
    private $nationality;
    private $gender;
    private $maritalStatus;
    private $hospitalId;
    private $doctorId;
    private $appointment;

    private $briefHistory;
    private $appointmentDate;
    private $appointmentTime;
    private $appointmentCategory;
    private $referralDoctor;
    private $referralHospital;
    private $hospitalLocation;
    private $amount;
    private $referralType;
    private $paymentType;
    private $paymentStatus;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->appointment = array();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param mixed $careOf
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    /**
     * @return mixed
     */
    public function getCareOf()
    {
        return $this->careOf;
    }

    /**
     * @param mixed $careOf
     */
    public function setCareOf($careOf)
    {
        $this->careOf = $careOf;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param mixed $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param mixed $relationship
     */
    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;
    }

    /**
     * @return mixed
     */
    public function getSpouseName()
    {
        return $this->spouseName;
    }

    /**
     * @param mixed $spouseName
     */
    public function setSpouseName($spouseName)
    {
        $this->spouseName = $spouseName;
    }

    /**
     * @return mixed
     */
    public function getPatientPhoto()
    {
        return $this->patientPhoto;
    }

    /**
     * @param mixed $patientPhoto
     */
    public function setPatientPhoto($patientPhoto)
    {
        $this->patientPhoto = $patientPhoto;
    }

    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }

    /**
     * @param mixed $placeOfBirth
     */
    public function setPlaceOfBirth($placeOfBirth)
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * @param mixed $maritalStatus
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
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
    public function getAppointment()
    {
        return $this->appointment;
    }

    /**
     * @param mixed $appointment
     */
    public function setAppointment($appointment)
    {
        //$this->appointment = $appointment;
        array_push($this->appointment, (object) $appointment);
    }

    /**
     * @return mixed
     */
    public function getBriefHistory()
    {
        return $this->briefHistory;
    }

    /**
     * @param mixed $briefHistory
     */
    public function setBriefHistory($briefHistory)
    {
        $this->briefHistory = $briefHistory;
    }

    /**
     * @return mixed
     */
    public function getAppointmentDate()
    {
        return $this->appointmentDate;
    }

    /**
     * @param mixed $appointmentDate
     */
    public function setAppointmentDate($appointmentDate)
    {
        $this->appointmentDate = $appointmentDate;
    }

    /**
     * @return mixed
     */
    public function getAppointmentCategory()
    {
        return $this->appointmentCategory;
    }

    /**
     * @param mixed $appointmentCategory
     */
    public function setAppointmentCategory($appointmentCategory)
    {
        $this->appointmentCategory = $appointmentCategory;
    }

    /**
     * @return mixed
     */
    public function getReferralDoctor()
    {
        return $this->referralDoctor;
    }

    /**
     * @param mixed $referralDoctor
     */
    public function setReferralDoctor($referralDoctor)
    {
        $this->referralDoctor = $referralDoctor;
    }

    /**
     * @return mixed
     */
    public function getReferralHospital()
    {
        return $this->referralHospital;
    }

    /**
     * @param mixed $referralHospital
     */
    public function setReferralHospital($referralHospital)
    {
        $this->referralHospital = $referralHospital;
    }

    /**
     * @return mixed
     */
    public function getHospitalLocation()
    {
        return $this->hospitalLocation;
    }

    /**
     * @param mixed $hospitalLocation
     */
    public function setHospitalLocation($hospitalLocation)
    {
        $this->hospitalLocation = $hospitalLocation;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getReferralType()
    {
        return $this->referralType;
    }

    /**
     * @param mixed $referralType
     */
    public function setReferralType($referralType)
    {
        $this->referralType = $referralType;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return mixed
     */
    public function getAppointmentTime()
    {
        return $this->appointmentTime;
    }

    /**
     * @param mixed $appointmentTime
     */
    public function setAppointmentTime($appointmentTime)
    {
        $this->appointmentTime = $appointmentTime;
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param mixed $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
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