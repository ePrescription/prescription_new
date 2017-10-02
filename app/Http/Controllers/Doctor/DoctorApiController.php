<?php

namespace App\Http\Controllers\Doctor;

use App\prescription\mapper\PatientProfileMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\prescription\services\HospitalService;
use App\prescription\common\ResponsePrescription;
use App\prescription\utilities\ErrorEnum\ErrorEnum;
use App\prescription\utilities\Exception\HospitalException;
use Exception;
use App\Http\Controllers\Controller;

class DoctorApiController extends Controller
{
    protected $hospitalService;

    public function __construct(HospitalService $hospitalService) {
        $this->hospitalService = $hospitalService;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $mainSymptoms = $this->hospitalService->getMainSymptoms();

            if(!is_null($mainSymptoms) && !empty($mainSymptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($mainSymptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_MAIN_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($mainSymptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient appointment counts
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDashboardDetails($hospitalId, Request $dashboardRequest)
    {
        $dashboardDetails = null;
        $selectedDate = $dashboardRequest->get('selectedDate');
        //dd($hospitalId);

        try
        {
            $dashboardDetails = $this->hospitalService->getDashboardDetails($hospitalId, $selectedDate);

            if(!is_null($dashboardDetails) && !empty($dashboardDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_COUNT_SUCCESS));
                $responseJson->setCount(sizeof($dashboardDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_DASHBOARD_DETAILS_FOUND));
            }

            $responseJson->setObj($dashboardDetails);
            $responseJson->sendSuccessResponse();
            //dd($appointments);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patients by appointment category
     * @param $hospitalId, $categoryType
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByAppointmentCategory($hospitalId, Request $appointmentRequest)
    {
        $patients = null;
        $categoryType = $appointmentRequest->get('appointmentCategory');
        //dd($hospitalId);

        try
        {
            $patients = $this->hospitalService->getPatientsByAppointmentCategory($hospitalId, $categoryType);

            if(!is_null($patients) && !empty($patients))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_SUCCESS));
                $responseJson->setCount(sizeof($patients));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_BY_CATEGORY));
            }

            $responseJson->setObj($patients);
            $responseJson->sendSuccessResponse();
            //dd($appointments);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient appointment dates by hospital
     * @param $hospitalId, $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointmentDates($hospitalId, $patientId)
    {
        $appointmentDates = null;
        //$hospitalId = $appointmentRequest->get('hospital');
        //dd($hospitalId);

        try
        {
            $appointmentDates = $this->hospitalService->getPatientAppointmentDates($patientId, $hospitalId);

            if(!is_null($appointmentDates) && !empty($appointmentDates))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_DATES_SUCCESS));
                $responseJson->setCount(sizeof($appointmentDates));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_APPOINTMENT_DATES_FOUND));
            }

            $responseJson->setObj($appointmentDates);
            $responseJson->sendSuccessResponse();
            //dd($appointments);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_DATES_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_APPOINTMENT_DATES_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd($mainSymptomsId);

        try
        {
            $subSymptoms = $this->hospitalService->getSubSymptomsForMainSymptoms($mainSymptomsId);
            //dd($subSymptoms);

            if(!is_null($subSymptoms) && !empty($subSymptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($subSymptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SUB_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($subSymptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd($subSymptomId);

        try
        {
            $symptoms = $this->hospitalService->getSymptomsForSubSymptoms($subSymptomId);
            //dd($symptoms);

            if(!is_null($symptoms) && !empty($symptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($symptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($symptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get personal history for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPersonalHistory($patientId, Request $patientSearchRequest)
    {
        $personalHistoryDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $personalHistoryDate = date('Y-m-d', strtotime($examinationDate));
            $personalHistoryDetails = $this->hospitalService->getPersonalHistory($patientId, $personalHistoryDate);
            //dd($personalHistoryDetails);

            if(!is_null($personalHistoryDetails) && !empty($personalHistoryDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_SUCCESS));
                $responseJson->setCount(sizeof($personalHistoryDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PERSONAL_HISTORY_FOUND));
            }

            $responseJson->setObj($personalHistoryDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        /*catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient past illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientPastIllness($patientId, Request $patientSearchRequest)
    {
        $pastIllness = null;
        $responseJson = null;
        $examinationDate = null;

        try
        {
            //dd($patientId);
            /*if($patientSearchRequest->has('examinationDate'))
            {

            }*/

            $examinationDate = $patientSearchRequest->get('examinationDate');

            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $pastIllnessDate = date('Y-m-d', strtotime($examinationDate));
            //dd($generalExaminationDate);
            $pastIllness = $this->hospitalService->getPatientPastIllness($patientId, $pastIllnessDate);
            //dd($pastIllness);

            if(!is_null($pastIllness) && !empty($pastIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($pastIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_PAST_ILLNESS_DETAILS_FOUND));
            }

            $responseJson->setObj($pastIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        /*catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient family illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientFamilyIllness($patientId, Request $patientSearchRequest)
    {
        $familyIllness = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $familyIllnessDate = date('Y-m-d', strtotime($examinationDate));
            $familyIllness = $this->hospitalService->getPatientFamilyIllness($patientId, $familyIllnessDate);
            //dd($familyIllness);

            if(!is_null($familyIllness) && !empty($familyIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($familyIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_FAMILY_ILLNESS_DETAILS_FOUND));
            }

            $responseJson->setObj($familyIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient general examination
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientGeneralExamination($patientId, Request $patientSearchRequest)
    {
        $generalExamination = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $generalExaminationDate = date('Y-m-d', strtotime($examinationDate));
            $generalExamination = $this->hospitalService->getPatientGeneralExamination($patientId, $generalExaminationDate);
            //dd($generalExamination);

            if(!is_null($generalExamination) && !empty($generalExamination))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($generalExamination));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_GENERAL_EXAMINATION_DETAILS_FOUND));
            }

            $responseJson->setObj($generalExamination);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient pregnancy details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPregnancyDetails($patientId, Request $patientSearchRequest)
    {
        $pregnancyDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $pregnancyDate = date('Y-m-d', strtotime($examinationDate));
            $pregnancyDetails = $this->hospitalService->getPregnancyDetails($patientId, $pregnancyDate);
            //dd($familyIllness);

            if(!is_null($pregnancyDetails) && !empty($pregnancyDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($pregnancyDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_PREGNANCY_DETAILS_FOUND));
            }

            $responseJson->setObj($pregnancyDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient scan details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientScanDetails($patientId, Request $patientSearchRequest)
    {
        $scanDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $scanDate = date('Y-m-d', strtotime($examinationDate));
            $scanDetails = $this->hospitalService->getPatientScanDetails($patientId, $scanDate);
            //dd($familyIllness);

            if(!is_null($scanDetails) && !empty($scanDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SCAN_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($scanDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_SCAN_DETAILS_FOUND));
            }

            $responseJson->setObj($scanDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient symptom details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientSymptoms($patientId, Request $patientSearchRequest)
    {
        $symptomDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $symptomDate = date('Y-m-d', strtotime($examinationDate));
            $symptomDetails = $this->hospitalService->getPatientSymptoms($patientId, $symptomDate);
            //dd($familyIllness);

            if(!is_null($symptomDetails) && !empty($symptomDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($symptomDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_SYMPTOM_DETAILS_FOUND));
            }

            $responseJson->setObj($symptomDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;

        try
        {
            $drugSurgeryHistory = $this->hospitalService->getPatientDrugHistory($patientId);
            //dd($drugSurgeryHistory);

            if(!is_null($drugSurgeryHistory) && !empty($drugSurgeryHistory))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SUCCESS));
                $responseJson->setCount(sizeof($drugSurgeryHistory));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_DRUG_HISTORY_FOUND));
            }

            $responseJson->setObj($drugSurgeryHistory);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient urine tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUrineTests($patientId, Request $patientSearchRequest)
    {
        $urineTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $urineTests = $this->hospitalService->getPatientUrineTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($urineTests) && !empty($urineTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($urineTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_URINE_DETAILS_FOUND));
            }

            $responseJson->setObj($urineTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient motion tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMotionTests($patientId, Request $patientSearchRequest)
    {
        $motionTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $motionTests = $this->hospitalService->getPatientMotionTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($motionTests) && !empty($motionTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($motionTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_MOTION_DETAILS_FOUND));
            }

            $responseJson->setObj($motionTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient blood tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientBloodTests($patientId, Request $patientSearchRequest)
    {
        $bloodTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $bloodTests = $this->hospitalService->getPatientBloodTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($bloodTests) && !empty($bloodTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($bloodTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_BLOOD_DETAILS_FOUND));
            }

            $responseJson->setObj($bloodTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient ultrasound tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUltraSoundTests($patientId, Request $patientSearchRequest)
    {
        $ultraSound = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $ultraSound = $this->hospitalService->getPatientUltraSoundTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($ultraSound) && !empty($ultraSound))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR));
                $responseJson->setCount(sizeof($ultraSound));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_ULTRASOUND_DETAILS_FOUND));
            }

            $responseJson->setObj($ultraSound);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient ultrasound tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDentalTests($patientId, Request $patientSearchRequest)
    {
        $dentalTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $dentalTests = $this->hospitalService->getPatientDentalTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($dentalTests) && !empty($dentalTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($dentalTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_DENTAL_TESTS_DETAILS_FOUND));
            }

            $responseJson->setObj($dentalTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient xray tests
     * @param $patientId, $xrayDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientXrayTests($patientId, Request $patientSearchRequest)
    {
        $patientXrayTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $patientXrayTests = $this->hospitalService->getPatientXrayTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($patientXrayTests) && !empty($patientXrayTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($patientXrayTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_XRAY_TESTS_DETAILS_FOUND));
            }

            $responseJson->setObj($patientXrayTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $familyIllness = $this->hospitalService->getAllFamilyIllness();
            //dd($familyIllness);

            if(!is_null($familyIllness) && !empty($familyIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FAMILY_ILLNESS_SUCCESS));
                $responseJson->setCount(sizeof($familyIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_FAMILY_ILLNESS_LIST_FOUND));
            }

            $responseJson->setObj($familyIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAMILY_ILLNESS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAMILY_ILLNESS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $pastIllness = $this->hospitalService->getAllPastIllness();
            //dd($familyIllness);

            if(!is_null($pastIllness) && !empty($pastIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PAST_ILLNESS_SUCCESS));
                $responseJson->setCount(sizeof($pastIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PAST_ILLNESS_LIST_FOUND));
            }

            $responseJson->setObj($pastIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PAST_ILLNESS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PAST_ILLNESS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $generalExaminations = $this->hospitalService->getAllGeneralExaminations();
            //dd($familyIllness);

            if(!is_null($generalExaminations) && !empty($generalExaminations))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::GENERAL_EXAMINATIONS_SUCCESS));
                $responseJson->setCount(sizeof($generalExaminations));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_GENERAL_EXAMINATIONS_LIST_FOUND));
            }

            $responseJson->setObj($generalExaminations);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::GENERAL_EXAMINATIONS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::GENERAL_EXAMINATIONS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $personalHistory = $this->hospitalService->getAllPersonalHistory();
            //dd($familyIllness);

            if(!is_null($personalHistory) && !empty($personalHistory))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_LIST_SUCCESS));
                $responseJson->setCount(sizeof($personalHistory));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PERSONAL_HISTORY_LIST_FOUND));
            }

            $responseJson->setObj($personalHistory);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $pregnancy = $this->hospitalService->getAllPregnancy();
            //dd($familyIllness);

            if(!is_null($pregnancy) && !empty($pregnancy))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PREGNANCY_LIST_SUCCESS));
                $responseJson->setCount(sizeof($pregnancy));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PREGNANCY_LIST_FOUND));
            }

            $responseJson->setObj($pregnancy);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PREGNANCY_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PREGNANCY_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $scans = $this->hospitalService->getAllScans();
            //dd($familyIllness);

            if(!is_null($scans) && !empty($scans))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SCAN_LIST_SUCCESS));
                $responseJson->setCount(sizeof($scans));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SCAN_LIST_FOUND));
            }

            $responseJson->setObj($scans);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SCAN_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SCAN_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $dentalExaminations = $this->hospitalService->getAllDentalItems();
            //dd($familyIllness);

            if(!is_null($dentalExaminations) && !empty($dentalExaminations))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::DENTAL_LIST_SUCCESS));
                $responseJson->setCount(sizeof($dentalExaminations));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_DENTAL_LIST_FOUND));
            }

            $responseJson->setObj($dentalExaminations);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DENTAL_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get all xray examinations
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllXRayItems()
    {
        $xrayExaminations = null;
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $xrayExaminations = $this->hospitalService->getAllXRayItems();
            //dd($familyIllness);

            if(!is_null($xrayExaminations) && !empty($xrayExaminations))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::XRAY_LIST_SUCCESS));
                $responseJson->setCount(sizeof($xrayExaminations));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_XRAY_LIST_FOUND));
            }

            $responseJson->setObj($xrayExaminations);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::XRAY_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }


    /**
     * Get patient examination dates
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getExaminationDates($patientId, Request $examinationRequest)
    {
        $examinationDates = null;
        $responseJson = null;

        try
        {
            $hospitalId = $examinationRequest->get('hospitalId');
            $examinationDates = $this->hospitalService->getExaminationDates($patientId, $hospitalId);
            //dd($examinationDates);

            if(!is_null($examinationDates) && !empty($examinationDates))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_SUCCESS));
                $responseJson->setCount(sizeof($examinationDates));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_EXAMINATION_DATES_FOUND));
            }

            $responseJson->setObj($examinationDates);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient latest appointment dates
     * @param $patientId, $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLatestAppointmentDateForPatient($patientId, Request $appDateRequest)
    {
        $hospitalId = null;
        $latestAppointmentDetails = null;

        try
        {
            $hospitalId = $appDateRequest->get('hospitalId');
            //dd($hospitalId);
            $latestAppointmentDetails = $this->hospitalService->getLatestAppointmentDateForPatient($patientId, $hospitalId);

            if(!is_null($latestAppointmentDetails) && !empty($examinationDates))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::APPOINTMENT_DATE_SUCCESS));
                $responseJson->setCount(sizeof($latestAppointmentDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::APPOINTMENT_DATE_NOT_FOUND));
            }

            $responseJson->setObj($latestAppointmentDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_DATE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient examination dates
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    /*public function getPatientExaminations($patientId, Request $examinationRequest)
    {
        $examinations = null;
        $responseJson = null;
        $examinationDate = null;

        try
        {
            if($examinationRequest->has('examinationDate'))
            {
                $examinationDate = $examinationRequest->get('examinationDate');
            }

            $examinationDates = $this->hospitalService->getExaminationDates($patientId);
            //dd($examinationDates);

            if(!is_null($examinationDates) && !empty($examinationDates))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_SUCCESS));
                $responseJson->setCount(sizeof($examinationDates));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_EXAMINATION_DATES_FOUND));
            }

            $responseJson->setObj($examinationDates);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }

        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }*/

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
        $responseJson = null;

        try
        {
            $specialties = $this->hospitalService->getAllSpecialties();
            //dd($specialties);

            if(!is_null($specialties) && !empty($specialties))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SPECIALTIES_LIST_SUCCESS));
                $responseJson->setCount(sizeof($specialties));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SPECIALTIES_LIST_FOUND));
            }

            $responseJson->setObj($specialties);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SPECIALTIES_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;

        try
        {
            $referralDoctors = $this->hospitalService->getDoctorsBySpecialty($specialtyId);
            //dd($referralDoctors);

            if(!is_null($referralDoctors) && !empty($referralDoctors))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_LIST_SUCCESS));
                $responseJson->setCount(sizeof($referralDoctors));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_REFERRAL_DOCTOR_LIST_FOUND));
            }

            $responseJson->setObj($referralDoctors);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save doctor referral
     * @param $doctorReferralRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveReferralDoctor(Request $doctorReferralRequest)
    {
        $doctorReferralsVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $doctorReferralsVM = PatientProfileMapper::setReferralDoctor($doctorReferralRequest);
            //dd($doctorReferralsVM);
            $status = $this->hospitalService->saveReferralDoctor($doctorReferralsVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
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
        $responseJson = null;

        try
        {
            $referralDoctorDetails = $this->hospitalService->getReferralDoctorDetails($referralId);
            //dd($referralDoctorDetails);

            if(!is_null($referralDoctorDetails) && !empty($referralDoctorDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($referralDoctorDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_DETAILS_NOT_FOUND));
            }

            $responseJson->setObj($referralDoctorDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::REFERRAL_DOCTOR_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient personal history
     * @param $personalHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePersonalHistory(Request $personalHistoryRequest)
    {
        $patientExaminationVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientHistoryVM = PatientProfileMapper::setPersonalHistory($personalHistoryRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePersonalHistory($patientHistoryVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient general examination details
     * @param $personalHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientGeneralExamination(Request $personalExaminationRequest)
    {
        $patientExaminationVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientExaminationVM = PatientProfileMapper::setGeneralExamination($personalExaminationRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientGeneralExamination($patientExaminationVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient past illness details
     * @param $pastIllnessRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPastIllness(Request $pastIllnessRequest)
    {
        $patientPastIllnessVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientPastIllnessVM = PatientProfileMapper::setPatientPastIllness($pastIllnessRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientPastIllness($patientPastIllnessVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient family illness details
     * @param $familyIllnessRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientFamilyIllness(Request $familyIllnessRequest)
    {
        $patientFamilyIllnessVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientFamilyIllnessVM = PatientProfileMapper::setPatientFamilyIllness($familyIllnessRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientFamilyIllness($patientFamilyIllnessVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient pregnancy details
     * @param $pregnancyRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPregnancyDetails(Request $pregnancyRequest)
    {
        $patientPregnancyVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientPregnancyVM = PatientProfileMapper::setPatientPregnancyDetails($pregnancyRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientPregnancyDetails($patientPregnancyVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient scan details
     * @param $scanRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientScanDetails(Request $scanRequest)
    {
        $patientScanVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientScanVM = PatientProfileMapper::setPatientScanDetails($scanRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientScanDetails($patientScanVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient symptom details
     * @param $symptomsRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientSymptoms(Request $symptomsRequest)
    {
        $patientSymVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientSymVM = PatientProfileMapper::setPatientSymptomDetails($symptomsRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientSymptoms($patientSymVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient urine examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUrineTests(Request $examinationRequest)
    {
        $patientUrineVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientUrineVM = PatientProfileMapper::setPatientUrineExamination($examinationRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientUrineTests($patientUrineVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient motion examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientMotionTests(Request $examinationRequest)
    {
        $patientMotionVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientMotionVM = PatientProfileMapper::setPatientMotionExamination($examinationRequest);
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientMotionTests($patientMotionVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient patient blood examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientBloodTests(Request $examinationRequest)
    {
        $patientBloodVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientBloodVM = PatientProfileMapper::setPatientBloodExamination($examinationRequest);
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientBloodTests($patientBloodVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient ultra sound details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUltraSoundTests(Request $examinationRequest)
    {
        $patientUltraSoundVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientUltraSoundVM = PatientProfileMapper::setPatientUltraSoundExamination($examinationRequest);
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientUltraSoundTests($patientUltraSoundVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient dental tests
     * @param $dentalRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDentalTests(Request $dentalRequest)
    {
        $patientDentalVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientDentalVM = PatientProfileMapper::setPatientDentalExamination($dentalRequest);
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientDentalTests($patientDentalVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient XRAY tests
     * @param $xrayRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientXRayTests(Request $xrayRequest)
    {
        $patientXRayVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientXRayVM = PatientProfileMapper::setPatientXRayExamination($xrayRequest);
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientXRayTests($patientXRayVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient drug and surgery history
     * @param $drugHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDrugHistory(Request $drugHistoryRequest)
    {
        $patientDrugsVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientDrugsVM = PatientProfileMapper::setPatientDrugHistory($drugHistoryRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientDrugHistory($patientDrugsVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /*Symptom section -- End */
}
