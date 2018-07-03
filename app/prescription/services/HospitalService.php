<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/2016
 * Time: 5:12 PM
 */

namespace App\prescription\services;

use App\prescription\facades\HospitalServiceFacade;
use App\prescription\repositories\repointerface\HospitalInterface;
use App\prescription\utilities\Exception\HospitalException;
use App\prescription\utilities\ErrorEnum\ErrorEnum;
use App\prescription\utilities\Exception\UserNotFoundException;
use Illuminate\Support\Facades\DB;

use Exception;


class HospitalService {

    protected $hospitalRepo;

    public function __construct(HospitalInterface $hospitalRepo)
    {
        //dd('Inside constructor');
        $this->hospitalRepo = $hospitalRepo;
    }

    /**
     * Get list of hospitals
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitals()
    {
        $hospitals = null;

        try
        {
            $hospitals = $this->hospitalRepo->getHospitals();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        return $hospitals;
    }

    /**
     * Get doctor details
     * @param $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorDetails($doctorId)
    {
        $doctorDetails = null;

        try
        {
            $doctorDetails = $this->hospitalRepo->getDoctorDetails($doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }

        return $doctorDetails;
    }

    /**
     * Get list of hospitals by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalByKeyword($keyword = null)
    {
        $hospitals = null;
        //dd('Inside service method');

        try
        {
            $hospitals = $this->hospitalRepo->getHospitalByKeyword($keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        return $hospitals;
    }

    /**
     * Get list of doctors for the hospital
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorsByHospitalId($hospitalId)
    {
        $doctors = null;

        try
        {
            $doctors = $this->hospitalRepo->getDoctorsByHospitalId($hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR, $exc);
        }

        return $doctors;
    }

    /**
     * Get  Patient Count To display
     * @param $hospitalId
     * @throws $hospitalException
     * @return Count
     * @author Prasanth
     */
    public function getPatientsCount($hospitalId)
    {
        $patientcount = null;

        try
        {
            $patientcount = $this->hospitalRepo->getPatientsCount($hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_TOTAL_COUNT_ERROR, $exc);
        }

        return $patientcount;
    }





    /**
     * Get list of hospitals for the doctor
     * @param $email
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalsForDoctor($email)
    {
        $hospitals = null;

        try
        {
            $hospitals = $this->hospitalRepo->getHospitalsForDoctor($email);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        return $hospitals;
    }

    /**
     * Get list of hospitals for the doctor
     * @param $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalsByDoctorId($doctorId)
    {
        $hospitals = null;

        try
        {
            $hospitals = $this->hospitalRepo->getHospitalsByDoctorId($doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        return $hospitals;
    }

    /**
     * Save patient profile
     * @param $patientProfileVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientProfile($patientProfileVM)
    {
        //$status = true;
        $patientInfo = null;

        try
        {
            DB::transaction(function() use ($patientProfileVM, &$patientInfo)
            {
                //$status = $this->hospitalRepo->savePatientProfile($patientProfileVM);
                $patientInfo = $this->hospitalRepo->savePatientProfile($patientProfileVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            //$status = false;
            $patientInfo['status'] = false;
            throw $hospitalExc;
        }
        catch(UserNotFoundException $userExc)
        {
            //$status = false;
            $patientInfo['status'] = false;
            throw $userExc;
        }
        catch (Exception $ex) {

            //$status = false;
            $patientInfo['status'] = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $ex);
        }

        //return $status;
        return $patientInfo;
    }

    /**
     * Edit patient profile
     * @param $patientProfileVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function editPatientProfile($patientProfileVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientProfileVM, &$status)
            {
                $status = $this->hospitalRepo->editPatientProfile($patientProfileVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Check if a patient is a new patient or follow up patient
     * @param $hospitalId, $doctorId, $patientId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function checkIsNewPatient($hospitalId, $doctorId, $patientId)
    {
        $isNewPatient = true;

        try
        {
            $isNewPatient = $this->hospitalRepo->checkIsNewPatient($hospitalId, $doctorId, $patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::NEW_PATIENT_ERROR, $exc);
        }

        return $isNewPatient;
    }

    //Get Appointment details

    /**
     * Get list of appointments for the hospital and the doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId)
    {
        $appointments = null;

        try
        {
            $appointments = $this->hospitalRepo->getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_LIST_ERROR, $exc);
        }

        return $appointments;
    }

    //Get Patient List
    /**
     * Get list of patients for the hospital and patient name
     * @param $hospitalId, $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByHospital($hospitalId, $keyword)
    //public function getPatientsByHospital($hospitalId)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->getPatientsByHospital($hospitalId, $keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get list of patients for the hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByHospitalAndDoctor($hospitalId, $doctorId)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->getPatientsByHospitalAndDoctor($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get patient details by patient id
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDetailsById($patientId)
    {
        $patientDetails = null;

        try
        {
            $patientDetails = $this->hospitalRepo->getPatientDetailsById($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patientDetails;
    }

    //Get Patient Profile
    /**
     * Get patient profile by patient id
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientProfile($patientId)
    {
        $patientProfile = null;

        try
        {
            $patientProfile = $this->hospitalRepo->getPatientProfile($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_ERROR, $exc);
        }

        return $patientProfile;
    }

    //Get Prescription List
    /**
     * Get list of prescriptions for the selected hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptions($hospitalId, $doctorId)
    {
        $prescriptions = null;

        try
        {
            $prescriptions = $this->hospitalRepo->getPrescriptions($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $exc);
        }

        return $prescriptions;
    }

    /**
     * Get list of prescriptions for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptionByPatient($patientId)
    {
        $prescriptions = null;

        try
        {
            $prescriptions = $this->hospitalRepo->getPrescriptionByPatient($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $exc);
        }

        return $prescriptions;
    }

    /**
     * Get patient appointments
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointments($patientId)
    {
        $appointments = null;

        try
        {
            $appointments = $this->hospitalRepo->getPatientAppointments($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $exc);
        }

        return $appointments;
    }

    /**
     * Get patient appointment counts
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDashboardDetails($hospitalId, $selectedDate)
    {
        $dashboardDetails = null;

        try
        {
            $dashboardDetails = $this->hospitalRepo->getDashboardDetails($hospitalId, $selectedDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $exc);
        }

        return $dashboardDetails;
    }

    /**
     * Get patient appointment counts by doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDashboardDetailsForDoctor($hospitalId, $doctorId)
    {
        $dashboardDetails = null;

        try
        {
            $dashboardDetails = $this->hospitalRepo->getDashboardDetailsForDoctor($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $exc);
        }

        return $dashboardDetails;
    }

    /**
     * Get future appointment count for the hospital and doctor
     * @param $fromDate, $toDate, $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFutureAppointmentsForDashboard($fromDate, $toDate, $hospitalId, $doctorId = null)
    {
        $futureAppointments = null;

        try
        {
            $futureAppointments = $this->hospitalRepo->getFutureAppointmentsForDashboard($fromDate, $toDate, $hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $exc);
        }

        return $futureAppointments;
    }

    /**
     * Get patients by appointment category
     * @param $hospitalId, $categoryType
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByAppointmentCategory($hospitalId, $categoryType, $doctorId = null,$fromDate=null,$toDate=null,$status=null)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->getPatientsByAppointmentCategory($hospitalId, $categoryType, $doctorId,$fromDate,$toDate,$status);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get patients by appointment date
     * @param $hospitalId, $doctorId, $appointmentDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByAppointmentDate($hospitalId, $doctorId, $appointmentDate)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->getPatientsByAppointmentDate($hospitalId, $doctorId, $appointmentDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get patient appointment dates by hospital
     * @param $hospitalId, $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointmentDates($patientId, $hospitalId)
    {
        $appointmentDates = null;

        try
        {
            $appointmentDates = $this->hospitalRepo->getPatientAppointmentDates($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_DATES_ERROR, $exc);
        }

        return $appointmentDates;
    }

    /**
     * Get patient appointments by hospital
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointmentsByHospital($patientId, $hospitalId)
    {
        $appointments = null;

        try
        {
            $appointments = $this->hospitalRepo->getPatientAppointmentsByHospital($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $exc);
        }

        return $appointments;
    }

    /**
     * Get patient appointment details
     * @param $appointmentId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAppointmentDetails($appointmentId)
    {
        $appointmentDetails = null;

        try
        {
            $appointmentDetails = $this->hospitalRepo->getAppointmentDetails($appointmentId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINT_DETAILS_ERROR, $exc);
        }

        return $appointmentDetails;
    }

    /**
     * Get prescription details for the patient by prescription Id
     * @param $prescriptionId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptionDetails($prescriptionId)
    {
        $prescriptionDetails = null;

        try
        {
            $prescriptionDetails = $this->hospitalRepo->getPrescriptionDetails($prescriptionId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_ERROR, $exc);
        }

        return $prescriptionDetails;
    }

    /**
     * Save Prescription for the patient
     * @param
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPrescription($patientPrescriptionVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientPrescriptionVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientPrescription($patientPrescriptionVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    //Search by Patient Name
    /**
     * Get patient names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByName($keyword)
    {
        $patientNames = null;

        try
        {
            $patientNames = $this->hospitalRepo->searchPatientByName($keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patientNames;
    }

    //Search by Patient Pid
    /**
     * Get patient details by PID
     * @param $pid
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByPid($pid)
    {
        $patient = null;

        try
        {
            $patient = $this->hospitalRepo->searchPatientByPid($pid);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patient;
    }

    /**
     * Get patient by Pid or Name
     * @param $keyWord
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchByPatientByPidOrName($keyWord = null)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->searchByPatientByPidOrName($keyWord);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get patient by Name for the hospital
     * @param $keyword, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByHospitalAndName($hospitalId, $keyword = null)
    {
        $patients = null;

        try
        {
            $patients = $this->hospitalRepo->searchPatientByHospitalAndName($hospitalId, $keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Save new appointments for the patient
     * @param $newAppointmentVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveNewAppointment($newAppointmentVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($newAppointmentVM, &$status)
            {
                $status = $this->hospitalRepo->saveNewAppointment($newAppointmentVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_NEW_APPOINTMENT_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Cancel the appointment
     * @param $appointmentId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function cancelAppointment($appointmentId)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($appointmentId, &$status)
            {
                $status = $this->hospitalRepo->cancelAppointment($appointmentId);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_CANCEL_APPOINTMENT_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Transfer the appointment
     * @param $appointmentId, $doctorId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function transferAppointment($appointmentId, $doctorId)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($appointmentId, $doctorId, &$status)
            {
                $status = $this->hospitalRepo->transferAppointment($appointmentId, $doctorId);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_TRANSFERRED_ERROR, $ex);
        }

        return $status;
    }

    //Drugs
    /**
     * Get brand names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getTradeNames($keyword)
    {
        $brands = null;

        try
        {
            $brands = $this->hospitalRepo->getTradeNames($keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::BRAND_LIST_ERROR, $exc);
        }

        return $brands;
    }

    /**
     * Get formulation names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFormulationNames($keyword)
    {
        $formulations = null;

        try
        {
            $formulations = $this->hospitalRepo->getFormulationNames($keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::FORMULATION_LIST_ERROR, $exc);
        }

        return $formulations;
    }

    //Lab Tests
    /**
     * Get all lab tests
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTests($keyword)
    {
        $labTests = null;

        try
        {
            $labTests = $this->hospitalRepo->getLabTests($keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Get list of lab tests for the selected hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsForPatient($hospitalId, $doctorId)
    {
        $patientLabTests = null;

        try
        {
            $patientLabTests = $this->hospitalRepo->getLabTestsForPatient($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $exc);
        }

        return $patientLabTests;
    }

    /**
     * Get list of labtests for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsByPatient($patientId)
    {
        $patientLabTests = null;

        try
        {
            $patientLabTests = $this->hospitalRepo->getLabTestsByPatient($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $exc);
        }

        return $patientLabTests;
    }

    /**
     * Get lab test details for the given lab test id
     * @param $labTestId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetails($labTestId)
    {
        $labTestDetails = null;

        try
        {
            $labTestDetails = $this->hospitalRepo->getLabTestDetails($labTestId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::LAB_DETAILS_ERROR, $exc);
        }

        return $labTestDetails;
    }

    /**
     * Save labtests for the patient
     * @param $patientLabTestVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientLabTests($patientLabTestVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientLabTestVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientLabTests($patientLabTestVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get the hospital id for the given pharmacy or lab id
     * @param $userTypeId, $userId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalId($userTypeId, $userId)
    {
        $hospitalId = null;

        try
        {
            $hospitalId = $this->hospitalRepo->getHospitalId($userTypeId, $userId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_ID_ERROR, $exc);
        }

        return $hospitalId;
    }


    public function getProfile($hospitalId)
    {
        $hospitalProfile = null;

        try
        {
            $hospitalProfile = $this->hospitalRepo->getProfile($hospitalId);
        }
        catch(HospitalException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_PROFILE_VIEW_ERROR, $exc);
        }

        return $hospitalProfile;
    }

    /**
     * Get the doctor names for the hospital
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorNames($hospitalId, $keyword)
    {
        $doctors = null;

        try
        {
            $doctors = $this->hospitalRepo->getDoctorNames($hospitalId, $keyword);
        }
        catch(HospitalException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND, $exc);
        }

        return $doctors;
    }

    /**
     * Get patient names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientNames($hospitalId, $keyword)
    {
        $patientNames = null;

        try
        {
            $patientNames = $this->hospitalRepo->getPatientNames($hospitalId, $keyword);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patientNames;
    }

    //Fee Receipts

    /**
     * Get list of fee receipts for the hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFeeReceipts($hospitalId, $doctorId)
    {
        $feeReceipts = null;

        try
        {
            $feeReceipts = $this->hospitalRepo->getFeeReceipts($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw $userExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $exc);
        }

        return $feeReceipts;
    }

    /**
     * Get list of fee receipts for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFeeReceiptsByPatient($patientId)
    {
        $feeReceipts = null;

        try
        {
            $feeReceipts = $this->hospitalRepo->getFeeReceiptsByPatient($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $exc);
        }

        return $feeReceipts;
    }

    /**
     * Get fee receipt details, doctor details, patient details
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getReceiptDetails($receiptId)
    {
        $feeReceiptDetails = null;

        try
        {
            $feeReceiptDetails = $this->hospitalRepo->getReceiptDetails($receiptId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_DETAILS_ERROR, $exc);
        }

        return $feeReceiptDetails;
    }

    /**
     * Save fee receipt
     * @param $feeReceiptVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveFeeReceipt($feeReceiptVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($feeReceiptVM, &$status)
            {
                $status = $this->hospitalRepo->saveFeeReceipt($feeReceiptVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /*Symptom section -- Begin */

    /**
     * Get all the symptoms
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getMainSymptoms()
    {
        $mainSymptoms = null;

        try
        {
            $mainSymptoms = $this->hospitalRepo->getMainSymptoms();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR, $exc);
        }

        return $mainSymptoms;
    }

    /**
     * Get all the complaint types
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getComplaintTypes()
    {
        $complaintTypes = null;

        try
        {
            $complaintTypes = $this->hospitalRepo->getComplaintTypes();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::COMPLAINT_TYPES_LIST_ERROR, $exc);
        }

        return $complaintTypes;
    }

    /**
     * Get all the complaints
     * @param $complaintTypeId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getComplaints($complaintTypeId)
    {
        $complaints = null;

        try
        {
            $complaints = $this->hospitalRepo->getComplaints($complaintTypeId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::COMPLAINTS_LIST_ERROR, $exc);
        }

        return $complaints;
    }

    /**
     * Save patient complaint details
     * @param $patientSymVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientComplaints($patientComVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientComVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientComplaints($patientComVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get patient complaint details
     * @param $patientId, $complaintsDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientComplaints($patientId, $complaintsDate)
    {
        $complaintDetails = null;

        try
        {
            $complaintDetails = $this->hospitalRepo->getPatientComplaints($patientId, $complaintsDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_DETAILS_ERROR, $exc);
        }

        return $complaintDetails;
    }

    /**
     * Save patient investigations and diagnosis
     * @param $patientDiagnosisVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientInvestigationAndDiagnosis($patientDiagnosisVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientDiagnosisVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientInvestigationAndDiagnosis($patientDiagnosisVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DIAGNOSIS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get patient investigation details
     * @param $patientId, $investigationDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientInvestigations($patientId, $investigationDate)
    {
        $investigationDetails = null;

        try
        {
            $investigationDetails = $this->hospitalRepo->getPatientInvestigations($patientId, $investigationDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_INVESTIGATION_DETAILS_ERROR, $exc);
        }

        return $investigationDetails;
    }

    /**
     * Get all the sub symptoms for main symptom
     * @param $mainSymptomsId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getSubSymptomsForMainSymptoms($mainSymptomsId)
    {
        $subSymptoms = null;

        try
        {
            $subSymptoms = $this->hospitalRepo->getSubSymptomsForMainSymptoms($mainSymptomsId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::SUB_SYMPTOMS_LIST_ERROR, $exc);
        }

        return $subSymptoms;
    }

    /**
     * Get all the symptoms for sub symptom
     * @param $subSymptomId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getSymptomsForSubSymptoms($subSymptomId)
    {
        $symptoms = null;

        try
        {
            $symptoms = $this->hospitalRepo->getSymptomsForSubSymptoms($subSymptomId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::SYMPTOMS_LIST_ERROR, $exc);
        }

        return $symptoms;
    }

    /**
     * Get personal history for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPersonalHistory($patientId, $personalHistoryDate)
    {
        $personalHistoryDetails = null;

        try
        {
            $personalHistoryDetails = $this->hospitalRepo->getPersonalHistory($patientId, $personalHistoryDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_ERROR, $exc);
        }

        return $personalHistoryDetails;
    }

    /**
     * Get patient past illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientPastIllness($patientId, $pastIllnessDate)
    {
        $pastIllness = null;

        try
        {
            $pastIllness = $this->hospitalRepo->getPatientPastIllness($patientId, $pastIllnessDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR, $exc);
        }

        return $pastIllness;
    }

    /**
     * Get patient family illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientFamilyIllness($patientId, $familyIllnessDate)
    {
        $familyIllness = null;

        try
        {
            $familyIllness = $this->hospitalRepo->getPatientFamilyIllness($patientId, $familyIllnessDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_ERROR, $exc);
        }

        return $familyIllness;
    }

    /**
     * Get patient general examination
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientGeneralExamination($patientId, $generalExaminationDate)
    {
        $generalExamination = null;

        try
        {
            $generalExamination = $this->hospitalRepo->getPatientGeneralExamination($patientId, $generalExaminationDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR, $exc);
        }

        return $generalExamination;
    }

    /**
     * Get patient pregnancy details
     * @param $patientId, $pregnancyDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPregnancyDetails($patientId, $pregnancyDate = null)
    {
        $pregnancyDetails = null;

        try
        {
            $pregnancyDetails = $this->hospitalRepo->getPregnancyDetails($patientId, $pregnancyDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_ERROR, $exc);
        }

        return $pregnancyDetails;
    }

    /**
     * Get patient scan details
     * @param $patientId, $scanDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientScanDetails($patientId, $scanDate)
    {
        $scanDetails = null;

        try
        {
            $scanDetails = $this->hospitalRepo->getPatientScanDetails($patientId, $scanDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_DETAILS_ERROR, $exc);
        }

        return $scanDetails;
    }

    /**
     * Get patient symptom details
     * @param $patientId, $symptomDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientSymptoms($patientId, $symptomDate)
    {
        $symptomDetails = null;

        try
        {
            $symptomDetails = $this->hospitalRepo->getPatientSymptoms($patientId, $symptomDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_SYMPTOM_DETAILS_ERROR, $exc);
        }

        return $symptomDetails;
    }

    /**
     * Get patient drug history
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDrugHistory($patientId)
    {
        $drugSurgeryHistory = null;

        try
        {
            $drugSurgeryHistory = $this->hospitalRepo->getPatientDrugHistory($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_ERROR, $exc);
        }

        return $drugSurgeryHistory;
    }

    /**
     * Get patient urine tests
     * @param $patientId, $urineTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUrineTests($patientId, $urineTestDate)
    {
        $urineTests = null;

        try
        {
            $urineTests = $this->hospitalRepo->getPatientUrineTests($patientId, $urineTestDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_ERROR, $exc);
        }

        return $urineTests;
    }

    /**
     * Get patient motion tests
     * @param $patientId, $motionTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMotionTests($patientId, $motionTestDate)
    {
        $motionTests = null;

        try
        {
            $motionTests = $this->hospitalRepo->getPatientMotionTests($patientId, $motionTestDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_ERROR, $exc);
        }

        return $motionTests;
    }

    /**
     * Get patient blood tests
     * @param $patientId, $bloodTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientBloodTests($patientId, $bloodTestDate)
    {
        $bloodTests = null;

        try
        {
            $bloodTests = $this->hospitalRepo->getPatientBloodTests($patientId, $bloodTestDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_ERROR, $exc);
        }

        return $bloodTests;
    }

    /**
     * Get patient ultrasound tests
     * @param $patientId, $ultraSoundDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUltraSoundTests($patientId, $ultraSoundDate)
    {
        $ultraSound = null;

        try
        {
            $ultraSound = $this->hospitalRepo->getPatientUltraSoundTests($patientId, $ultraSoundDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR, $exc);
        }

        return $ultraSound;
    }

    /**
     * Get patient dental tests
     * @param $patientId, $ultraSoundDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDentalTests($patientId, $dentalDate)
    {
        $dentalTests = null;

        try
        {
            $dentalTests = $this->hospitalRepo->getPatientDentalTests($patientId, $dentalDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_DETAILS_ERROR, $exc);
        }

        return $dentalTests;
    }

    /**
     * Get patient xray tests
     * @param $patientId, $xrayDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientXrayTests($patientId, $xrayDate)
    {
        $patientXrayTests = null;

        try
        {
            $patientXrayTests = $this->hospitalRepo->getPatientXrayTests($patientId, $xrayDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_DETAILS_ERROR, $exc);
        }

        return $patientXrayTests;
    }

    /**
     * Get all blood tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllBloodTests()
    {
        $bloodTests = null;

        try
        {
            $bloodTests = $this->hospitalRepo->getAllBloodTests();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::BLOODTEST_LIST_ERROR, $exc);
        }

        return $bloodTests;
    }

    /**
     * Get all motion tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllMotionTests()
    {
        $motionTests = null;

        try
        {
            $motionTests = $this->hospitalRepo->getAllMotionTests();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::MOTIONTEST_LIST_ERROR, $exc);
        }

        return $motionTests;
    }

    /**
     * Get all urine tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllUrineTests()
    {
        $urineTests = null;

        try
        {
            $urineTests = $this->hospitalRepo->getAllUrineTests();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::URINETEST_LIST_ERROR, $exc);
        }

        return $urineTests;
    }

    /**
     * Get all ultrasound tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllUltrasoundTests()
    {
        $ultrasoundTests = null;

        try
        {
            $ultrasoundTests = $this->hospitalRepo->getAllUltrasoundTests();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::ULTRASOUND_LIST_ERROR, $exc);
        }

        return $ultrasoundTests;
    }

    /**
     * Get all family illness
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllFamilyIllness()
    {
        $familyIllness = null;

        try
        {
            $familyIllness = $this->hospitalRepo->getAllFamilyIllness();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::FAMILY_ILLNESS_ERROR, $exc);
        }

        return $familyIllness;
    }

    /**
     * Get all past illness
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllPastIllness()
    {
        $pastIllness = null;

        try
        {
            $pastIllness = $this->hospitalRepo->getAllPastIllness();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PAST_ILLNESS_ERROR, $exc);
        }

        return $pastIllness;
    }

    /**
     * Get all general examinations
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllGeneralExaminations()
    {
        $generalExaminations = null;

        try
        {
            $generalExaminations = $this->hospitalRepo->getAllGeneralExaminations();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::GENERAL_EXAMINATIONS_ERROR, $exc);
        }

        return $generalExaminations;
    }

    /**
     * Get all personal history
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllPersonalHistory()
    {
        $personalHistory = null;

        try
        {
            $personalHistory = $this->hospitalRepo->getAllPersonalHistory();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_LIST_ERROR, $exc);
        }

        return $personalHistory;
    }

    /**
     * Get all personal history
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllApiPersonalHistory()
    {
        $personalHistory = null;

        try
        {
            $personalHistory = $this->hospitalRepo->getAllApiPersonalHistory();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_LIST_ERROR, $exc);
        }

        return $personalHistory;
    }

    /**
     * Get all pregnancy
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllPregnancy()
    {
        $pregnancy = null;

        try
        {
            $pregnancy = $this->hospitalRepo->getAllPregnancy();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PREGNANCY_LIST_ERROR, $exc);
        }

        return $pregnancy;
    }

    /**
     * Get all scans
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllScans()
    {
        $scans = null;

        try
        {
            $scans = $this->hospitalRepo->getAllScans();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::SCAN_LIST_ERROR, $exc);
        }

        return $scans;
    }

    /**
     * Get all dental examinations
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllDentalItems()
    {
        $dentalExaminations = null;

        try
        {
            $dentalExaminations = $this->hospitalRepo->getAllDentalItems();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DENTAL_LIST_ERROR, $exc);
        }

        return $dentalExaminations;
    }

    /**
     * Get all XRAY examinations
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllXRayItems()
    {
        $xrayExaminations = null;

        try
        {
            $xrayExaminations = $this->hospitalRepo->getAllXRayItems();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::XRAY_LIST_ERROR, $exc);
        }

        return $xrayExaminations;
    }

    /**
     * Get patient lab tests by hospital and fee status
     * @param $patientId, $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientLabTests($hospitalId, $patientId, $feeStatus)
    {
        $patientLabTests = null;

        try
        {
            $patientLabTests = $this->hospitalRepo->getPatientLabTests($hospitalId, $patientId, $feeStatus);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LABTEST_FEES_STATUS_ERROR, $exc);
        }

        return $patientLabTests;
    }

    /**
     * Get patient lab test details by patient and labtesttype
     * @param $patientId, $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetailsByPatient($labTestType, $labTestId)
    {
        $labTestDetails = null;

        try
        {
            $labTestDetails = $this->hospitalRepo->getLabTestDetailsByPatient($labTestType, $labTestId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LABTEST_FEES_STATUS_ERROR, $exc);
        }

        return $labTestDetails;
    }

    /**
     * Get lab receipt details for the patient
     * @param $patientId, $hospitalId, $feeReceiptId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientReceiptDetails($hospitalId, $patientId, $feeReceiptId)
    {
        $labReceiptDetails = null;

        try
        {
            $labReceiptDetails = $this->hospitalRepo->getPatientReceiptDetails($hospitalId, $patientId, $feeReceiptId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $exc);
        }

        return $labReceiptDetails;
    }

    /**
     * Get lab test details to generate receipt
     * @param $patientId, $hospitalId, $generatedDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetailsForReceipt($patientId, $hospitalId, $generatedDate)
    {
        $patientLabTests = null;

        try
        {
            $patientLabTests = $this->hospitalRepo->getLabTestDetailsForReceipt($patientId, $hospitalId, $generatedDate);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::LAB_TEST_LIST_FOR_RECEIPT_ERROR, $exc);
        }

        return $patientLabTests;

    }

    /**
     * Save lab receipt details for the patient
     * @param $labReceiptsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveLabReceiptDetailsForPatient($labReceiptsVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($labReceiptsVM, &$status)
            {
                $status = $this->hospitalRepo->saveLabReceiptDetailsForPatient($labReceiptsVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get lab receipts for the patient
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabReceiptsByPatient($patientId, $hospitalId)
    {
        $labReceipts = null;

        try
        {
            $labReceipts = $this->hospitalRepo->getLabReceiptsByPatient($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_LIST_ERROR, $exc);
        }

        return $labReceipts;
    }

    /**
     * Get all specialties
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllSpecialties()
    {
        $specialties = null;

        try
        {
            $specialties = $this->hospitalRepo->getAllSpecialties();
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::SPECIALTIES_LIST_ERROR, $exc);
        }

        return $specialties;
    }

    /**
     * Get doctors by specialty
     * @param $specialtyId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorsBySpecialty($specialtyId)
    {
        $referralDoctors = null;

        try
        {
            $referralDoctors = $this->hospitalRepo->getDoctorsBySpecialty($specialtyId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_LIST_ERROR, $exc);
        }

        return $referralDoctors;
    }

    /**
     * Save doctor referral
     * @param $doctorReferralsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveReferralDoctor($doctorReferralsVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($doctorReferralsVM, &$status)
            {
                $status = $this->hospitalRepo->saveReferralDoctor($doctorReferralsVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get referral doctor details
     * @param $referralId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getReferralDoctorDetails($referralId)
    {
        $referralDoctorDetails = null;

        try
        {
            $referralDoctorDetails = $this->hospitalRepo->getReferralDoctorDetails($referralId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_DETAILS_ERROR, $exc);
        }

        return $referralDoctorDetails;
    }

    /**
     * Get patient examination dates
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getExaminationDates($patientId, $hospitalId)
    {
        $examinationDates = null;

        try
        {
            $examinationDates = $this->hospitalRepo->getExaminationDates($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        return $examinationDates;
    }

    /**
     * Get patient examination dates
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getApiExaminationDates($patientId)
    {
        $examinationDates = null;

        try
        {
            $examinationDates = $this->hospitalRepo->getApiExaminationDates($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        return $examinationDates;
    }

    /**
     * Get patient medical profile
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMedicalProfileForPrint($patientId, $hospitalId)
    {
        $patientMedicalProfile = null;

        try
        {
            $patientMedicalProfile = $this->hospitalRepo->getPatientMedicalProfileForPrint($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_HISTORY_ERROR, $exc);
        }

        return $patientMedicalProfile;
    }

    /**
     * Get patient lab profile
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientLabProfileForPrint($patientId, $hospitalId)
    {
        $patientLabProfile = null;

        try
        {
            $patientLabProfile = $this->hospitalRepo->getPatientLabProfileForPrint($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_HISTORY_ERROR, $exc);
        }

        return $patientLabProfile;
    }

    /**
     * Get patient medical history for print
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMedicalHistoryForPrint($patientId, $hospitalId)
    {
        $patientMedicalHistory = null;

        try
        {
            $patientMedicalHistory = $this->hospitalRepo->getPatientMedicalHistoryForPrint($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_HISTORY_ERROR, $exc);
        }

        return $patientMedicalHistory;
    }

    /**
     * Get patient latest appointment dates
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLatestAppointmentDateForPatient($patientId, $hospitalId)
    {
        $latestAppointmentDetails = null;

        try
        {
            $latestAppointmentDetails = $this->hospitalRepo->getLatestAppointmentDateForPatient($patientId, $hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_DATE_ERROR, $exc);
        }

        return $latestAppointmentDetails;
    }

    /**
     * Save patient personal history
     * @param $patientHistoryVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePersonalHistory($patientHistoryVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientHistoryVM, &$status)
            {
                $status = $this->hospitalRepo->savePersonalHistory($patientHistoryVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient general examination details
     * @param $patientExaminationVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientGeneralExamination($patientExaminationVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientExaminationVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientGeneralExamination($patientExaminationVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient past illness details
     * @param $patientPastIllnessVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPastIllness($patientPastIllnessVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientPastIllnessVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientPastIllness($patientPastIllnessVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch(UserNotFoundException $userExc)
        {
            $status = false;
            throw $userExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient family illness details
     * @param $patientFamilyIllnessVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientFamilyIllness($patientFamilyIllnessVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientFamilyIllnessVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientFamilyIllness($patientFamilyIllnessVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient pregnancy details
     * @param $patientPregnancyVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPregnancyDetails($patientPregnancyVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientPregnancyVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientPregnancyDetails($patientPregnancyVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient scan details
     * @param $patientScanVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientScanDetails($patientScanVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientScanVM, &$status)
            {
                //$status = $this->hospitalRepo->savePatientScanDetails($patientScanVM);
                $status = $this->hospitalRepo->savePatientScanDetailsNew($patientScanVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient symptom details
     * @param $patientSymVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientSymptoms($patientSymVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientSymVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientSymptoms($patientSymVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient urine examination details
     * @param $patientUrineVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUrineTests($patientUrineVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientUrineVM, &$status)
            {
                //$status = $this->hospitalRepo->savePatientUrineTests($patientUrineVM);
                $status = $this->hospitalRepo->savePatientUrineTestsNew($patientUrineVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient motion examination details
     * @param $patientMotionVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientMotionTests($patientMotionVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientMotionVM, &$status)
            {
                //$status = $this->hospitalRepo->savePatientMotionTests($patientMotionVM);
                $status = $this->hospitalRepo->savePatientMotionTestsNew($patientMotionVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient blood examination details
     * @param $patientBloodVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientBloodTests($patientBloodVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientBloodVM, &$status)
            {
                //$status = $this->hospitalRepo->savePatientBloodTests($patientBloodVM);
                $status = $this->hospitalRepo->savePatientBloodTestsNew($patientBloodVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient ultra sound details
     * @param $patientUltraSoundVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUltraSoundTests($patientUltraSoundVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientUltraSoundVM, &$status)
            {
                //$status = $this->hospitalRepo->savePatientUltraSoundTests($patientUltraSoundVM);
                $status = $this->hospitalRepo->savePatientUltraSoundTestsNew($patientUltraSoundVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient dental tests
     * @param $patientDentalVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDentalTests($patientDentalVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientDentalVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientDentalTests($patientDentalVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient XRAY tests
     * @param $patientXRayVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientXRayTests($patientXRayVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientXRayVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientXRayTests($patientXRayVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save patient drug and surgery history
     * @param $patientDrugsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDrugHistory($patientDrugsVM)
    {
        $status = true;

        try
        {
            DB::transaction(function() use ($patientDrugsVM, &$status)
            {
                $status = $this->hospitalRepo->savePatientDrugHistory($patientDrugsVM);
            });

        }
        catch(HospitalException $hospitalExc)
        {
            $status = false;
            throw $hospitalExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR, $ex);
        }

        return $status;
    }

    /*Symptom section -- End */



/*NEW ADDITION RAMANA*/
//ramana start 12-01-2018

    /**
     * Get lab receipt details for the patient
     * @param $patientId, $hospitalId, $feeReceiptId
     * @throws $hospitalException
     * @return array | null
     * @author Ramana
     */
    public function updateLabPatientFee($hid,$pid,$rid,$newpaidamount,$paidamount,$paymenttype)
    {
        $status = null;

        try
        {
            $status = $this->hospitalRepo->updateLabPatientFee($hid,$pid,$rid,$newpaidamount,$paidamount,$paymenttype);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LABTEST_FEES_STATUS_ERROR, $exc);
        }

        return $status;
    }


    /**
     * Get lab receipt details for the patient
     * @param $patientId, $hospitalId, $feeReceiptId
     * @throws $hospitalException
     * @return array | null
     * @author Ramana
     */

    public function getPaymentHistory($hospitalId, $patientId, $feeReceiptId)
    {
        $paymentHistory = null;

        try
        {
            $paymentHistory = $this->hospitalRepo->getPaymentHistory($hospitalId, $patientId, $feeReceiptId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $exc);
        }

        return $paymentHistory;
    }

    /**
     * Get patient latest appointment dates
     * @param $patientId, $hospitalId,$date
     * @throws $hospitalException
     * @return array | null
     * @author RAMANA
     */

    public function getExaminationDatesByDate($patientId, $hospitalId,$date)
    {
        $examinationDates = null;

        try
        {
            $examinationDates = $this->hospitalRepo->getExaminationDatesByDate($patientId, $hospitalId,$date);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        return $examinationDates;
    }

    //RAMANA NEW
    public function updatePatientFeeStatus($hid,$did,$pid,$rid)
    {
        $status = null;

        try
        {
            $status = $this->hospitalRepo->updatePatientFeeStatus($hid,$did,$pid,$rid);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_FEE_STATUS_ERROR, $exc);
        }

        return $status;
    }


    //ramana end 12-01-2018

    /**
     * Upload patient lab test documents
     * @param $labDocumentsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientLabDocuments($labDocumentsVM)
    {
        $status = true;
        $filePath = null;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($labDocumentsVM, &$status, &$filePath)
            {
                //$status = $this->hospitalRepo->uploadPatientLabDocuments($labDocumentsVM);
                $status = $this->hospitalRepo->uploadPatientApiLabDocuments($labDocumentsVM);
                //$filePath = $this->hospitalRepo->uploadPatientApiLabDocuments($labDocumentsVM);
            });

        }
        catch(HospitalException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $ex);
        }

        //return $filePath;
        return $status;
    }

    /**
     * Get patient reports
     * @param $doctorId, $patientId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function getPatientReports($doctorId, $patientId)
    {
        $reports = null;

        try
        {
            $reports = $this->hospitalRepo->getPatientReports($doctorId, $patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $exc);
        }

        return $reports;
    }

    /**
     * Download patient reports
     * @param $documentId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function downloadPatientReports($documentId)
    {
        $document = null;

        try
        {
            $document = $this->hospitalRepo->downloadPatientReports($documentId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_DOWNLOAD_ERROR, $exc);
        }

        return $document;
    }


    /**
     * Get the latest Token_Id of patient for doctor appointment
     * @param $hospitalId
     * @throws $hospitalException
     * @return Number | 0
     * @author Prasanth
     */

    public function getTokenIdByHospitalIdAndDoctorId($hospitalId,$doctorId,$date,$appointmentCategory)
    {
        $tokenId = null;

        try
        {
            $tokenId = $this->hospitalRepo->getTokenIdByHospitalIdandDoctorId($hospitalId,$doctorId,$date,$appointmentCategory);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_PATIENT_TOKEN_ID_ERROR, $exc);
        }
        return $tokenId;
    }

    /**
     * Get the total patient information of  doctor appointment
     * @param $patientId
     * @throws $hospitalException
     * @return Array | Null
     * @author Prasanth
     */

    public function getPatientAppointmentLabel($patientId,$Id)
    {
        $doctorappointments = null;

        try
        {
            $doctorappointments = $this->hospitalRepo->getPatientAppointmentLabel($patientId,$Id);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINT_DETAILS_ERROR, $exc);
        }
        return $doctorappointments;
    }

    public function getDoctorsInfo($hospitalId){
        $doctorsInfo = null;

        try
        {
            $doctorsInfo = $this->hospitalRepo->getDoctorsInfo($hospitalId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $doctorsInfo;
    }




    public function getDoctorsAvalabilityForHospital($hospitalId,$doctorId){
        $doctorsInfo = null;

        try
        {
            $doctorsInfo = $this->hospitalRepo->getDoctorsAvalabilityForHospital($hospitalId,$doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $doctorsInfo;
    }

    public function SaveDoctorAvailability($doctorAvailabilityVM){
        $status = null;
        try
        {
            $status = $this->hospitalRepo->SaveDoctorAvailability($doctorAvailabilityVM);

        }

        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $status;
    }



    public function UpdateDoctorAvailability($doctorAvailabilityVM){
        $status = null;
        try
        {
            $status = $this->hospitalRepo->UpdateDoctorAvailability($doctorAvailabilityVM);

            if($status){

                $status=" Doctor Timings Updated Successfully";
            }else{
                $status="Error While Updated Details";
            }
        }

        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $status;
    }

    public function saveDoctorLeaves($LeaveRequestVM){
        $status = null;
        try
        {
            //dd($LeaveRequestVM);
            $status = $this->hospitalRepo->saveDoctorLeaves($LeaveRequestVM);
            if($status){

                $status="Saved Leaves Data Successfully";
            }else{
                $status="Details Already Exist With These dates";
            }
        }

        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $status;
    }
    public function UpdateDoctorLeaves($LeaveRequestVM1,$id){
        $status = null;
       //dd($LeaveRequestVM1);
        try
        {
            $status = $this->hospitalRepo->UpdateDoctorLeaves($LeaveRequestVM1,$id);

            if($status){

                $status=" Doctor Dates Updated Successfully";
            }else{
                $status="Error While Updating Details";
            }
        }

        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $status;
    }

    public function deleteDoctorLeaves($id){
        $status = null;
        //dd($LeaveRequestVM1);
        try
        {
            $status = $this->hospitalRepo->deleteDoctorLeaves($id);
            if($status){
                $status="Doctor Dates Deleted Successfully";
            }else{
                $status="Error While Deleting Details";
            }
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_DETAILS_ERROR, $exc);
        }
        return $status;
    }

    /**
     * Get the doctor appointments for the next two days from current date. This is for doctors in case of offline
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return Array|null
     * @author Baskar
     */

    public function getApiTwoDaysDoctorAppointments($hospitalId, $doctorId)
    {
        $twoDaysAppointments = null;

        try
        {
            $twoDaysAppointments = $this->hospitalRepo->getApiTwoDaysDoctorAppointments($hospitalId, $doctorId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::DOCTOR_TWO_DAY_APPOINTMENTS_ERROR, $exc);
        }

        return $twoDaysAppointments;
    }

    /**
     * Upload patient prescription attachments
     * @param $prescriptionAttachVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientPrescriptionApiAttachments($prescriptionAttachVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($prescriptionAttachVM, &$status)
            {
                //$status = $this->hospitalRepo->uploadPatientLabDocuments($labDocumentsVM);
                $status = $this->hospitalRepo->uploadPatientPrescriptionApiAttachments($prescriptionAttachVM);
            });

        }
        catch(HospitalException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PRESCRIPTION_UPLOAD_ERROR, $ex);
        }

        //return $filePath;
        return $status;
    }

    /**
     * Get patient prescription attachments
     * @param $hospitalId, $patientId
     * @throws $hospitalException
     * @return Array|null
     * @author Baskar
     */

    public function getPatientPrescriptionApiAttachments($hospitalId, $patientId)
    {
        $prescriptionAttachments = null;

        try
        {
            $prescriptionAttachments = $this->hospitalRepo->getPatientPrescriptionApiAttachments($hospitalId, $patientId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_PRESCRIPTION_ATTACHMENT_LIST_ERROR, $exc);
        }

        return $prescriptionAttachments;
    }

    /**
     * Download patient prescription attachments
     * @param $attachmentId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function downloadPatientPrescriptionAttachments($attachmentId)
    {
        $attachment = null;

        try
        {
            $attachment = $this->hospitalRepo->downloadPatientPrescriptionAttachments($attachmentId);
        }
        catch(HospitalException $hospitalExc)
        {
            throw $hospitalExc;
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_PRESCRIPTION_ATTACHMENT_DOWNLOAD_ERROR, $exc);
        }

        return $attachment;
    }
}