<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 01/11/2016
 * Time: 7:34 PM
 */

namespace App\prescription\mapper;

use App\Http\ViewModels\DoctorReferralsViewModel;
use App\Http\ViewModels\FeeReceiptViewModel;
use App\Http\ViewModels\NewAppointmentViewModel;
use App\Http\ViewModels\PatientComplaintsViewModel;
use App\Http\ViewModels\PatientDentalViewModel;
use App\Http\ViewModels\PatientDiagnosisViewModel;
use App\Http\ViewModels\PatientDrugHistoryViewModel;
use App\Http\ViewModels\PatientFamilyIllnessViewModel;
use App\Http\ViewModels\PatientGeneralExaminationViewModel;
use App\Http\ViewModels\PatientLabDocumentsViewModel;
use App\Http\ViewModels\PatientLabReceiptViewModel;
use App\Http\ViewModels\PatientPastIllnessViewModel;
use App\Http\ViewModels\PatientPersonalHistoryViewModel;
use App\Http\ViewModels\PatientPrescriptionAttachmentViewModel;
use App\Http\ViewModels\PatientProfileViewModel;
use App\Http\ViewModels\PatientPregnancyViewModel;
use App\Http\ViewModels\PatientScanViewModel;
use App\Http\ViewModels\PatientSymptomsViewModel;
use App\Http\ViewModels\PatientUrineExaminationViewModel;
use App\Http\ViewModels\PatientXRayViewModel;
use Illuminate\Http\Request;
use App\Http\Requests\FeeReceiptRequest;
use Session;
use Exception;

class PatientProfileMapper
{
    public static function setPatientProfile(Request $patientProfileRequest)
    {

       // dd($patientProfileRequest);
        $profileVM = new PatientProfileViewModel();
        $profile = (object) $patientProfileRequest->all();

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $profileVM->setPatientId($profile->patientId);
        $profileVM->setName($profile->name);
        $profileVM->setAddress(property_exists($profile, 'address') ? $profile->address : null);
        $profileVM->setOccupation(property_exists($profile, 'occupation') ? $profile->occupation : null);
        $profileVM->setCareOf(property_exists($profile, 'careof') ? $profile->careof : null);
        $profileVM->setCity(property_exists($profile, 'city') ? $profile->city : null);
        $profileVM->setCountry(property_exists($profile, 'country') ? $profile->country : null);
        $profileVM->setTelephone(property_exists($profile, 'telephone') ? $profile->telephone : null);
        //$profileVM->setTelephone($profile->telephone);
        $profileVM->setEmail(property_exists($profile, 'email') ? $profile->email : null);
        $profileVM->setRelationship(property_exists($profile, 'relationship') ? $profile->relationship : null);
        $profileVM->setSpouseName(property_exists($profile, 'spouseName') ? $profile->spouseName : null);
        //$profileVM->setPatientPhoto(property_exists($profile, 'patientPhoto') ? $profile->patientPhoto : null);
        $profileVM->setPatientPhoto(property_exists($profile, 'patientPhoto') ? $profile->patientPhoto : null);
        $profileVM->setDob(property_exists($profile, 'dob') ? $profile->dob : null);
        $profileVM->setAge(property_exists($profile, 'age') ? $profile->age : null);
        $profileVM->setPlaceOfBirth(property_exists($profile, 'placeOfBirth') ? $profile->placeOfBirth : null);
        $profileVM->setNationality(property_exists($profile, 'nationality') ? $profile->nationality : null);
        $profileVM->setGender(property_exists($profile, 'gender') ? $profile->gender : null);
        //$profileVM->setGender($profile->gender);
        /*For Marital Status*/
        $profileVM->setMaritalStatus(property_exists($profile, 'married') ? $profile->married : null);

        $profileVM->setHospitalId(property_exists($profile, 'hospitalId') ? $profile->hospitalId : null);
        $profileVM->setDoctorId(property_exists($profile, 'doctorId') ? $profile->doctorId : null);

        //dd($profile->appointmentTime);
        //$profileVM->setAppointmentTime($profile->appointmentTime);
        //$profileVM->setAppointmentDate($profile->appointmentDate);
        //$appDate = date("Y-m-d", strtotime($profile->appointmentDate));

        //$profileVM->setAppointmentDate(property_exists($profile, 'appointmentDate') ? $profile->appointmentDate : null);
        $profileVM->setAppointmentDate(property_exists($profile, 'appointmentDate') ? date("Y-m-d", strtotime($profile->appointmentDate)) : null);
        $profileVM->setAppointmentTime(property_exists($profile, 'appointmentTime') ? $profile->appointmentTime : null);
        $profileVM->setBriefHistory(property_exists($profile, 'briefHistory') ? $profile->briefHistory : null);
        //$profileVM->setAppointmentDate($profile->appointmentDate);
        $profileVM->setAppointmentCategory(property_exists($profile, 'appointmentCategory') ? $profile->appointmentCategory : null);
        $profileVM->setReferralType(property_exists($profile, 'referralType') ? $profile->referralType : null);
        $profileVM->setReferralDoctor(property_exists($profile, 'referralDoctor') ? $profile->referralDoctor : null);
        $profileVM->setReferralHospital(property_exists($profile, 'referralHospital') ? $profile->referralHospital : null);
        $profileVM->setHospitalLocation(property_exists($profile, 'hospitalLocation') ? $profile->hospitalLocation : null);
        $profileVM->setAmount(property_exists($profile, 'fee') ? $profile->fee : null);
        $profileVM->setPaymentType(property_exists($profile, 'paymentType') ? $profile->paymentType : null);
        $profileVM->setPaymentStatus(property_exists($profile, 'paymentStatus') ? $profile->paymentStatus : null);

        /*$appointments = $profile->appointment;

        foreach($appointments as $appointment)
        {
            $profileVM->setAppointment($appointment);
        }*/

        //$profileVM->setAppointment();
        //$profileVM->setMainSymptomId(property_exists($profile, 'mainSymptomId') ? $profile->mainSymptomId : null);
        //$profileVM->setSubSymptomId(property_exists($profile, 'subSymptomId') ? $profile->subSymptomId : null);
        //$profileVM->setSymptomId(property_exists($profile, 'symptomId') ? $profile->symptomId : null);

        $profileVM->setCreatedBy($userName);
        $profileVM->setUpdatedBy($userName);
        $profileVM->setCreatedAt(date("Y-m-d H:i:s"));
        $profileVM->setUpdatedAt(date("Y-m-d H:i:s"));

       //dd($profileVM);
        return $profileVM;
    }

    public static function setLabApiDocumentDetails(Request $uploadRequest)
    {
        $labDocumentsVM = new PatientLabDocumentsViewModel();

        $userName = 'Admin';
        //$files = $uploadRequest->allFiles();
        $attachments = $uploadRequest->file('photo');

        //dd($attachments);

        //$labDocumentsVM->setDoctorUploads($files);
        //$labDocumentsVM->setDocumentName($uploadRequest['document_name']);

        if(!empty($attachments))
        {
            foreach ($attachments as $attachment)
            {
                $labDocumentsVM->setPatientLabDocuments($attachment);
            }
        }

        $resultsObj = (object) $uploadRequest->all();

        $labDocumentsVM->setPatientId($resultsObj->patientId);
        $labDocumentsVM->setLabId($resultsObj->providerId);
        $labDocumentsVM->setDocumentUploadDate(date("Y-m-d"));

        $labDocumentsVM->setCreatedBy($userName);
        $labDocumentsVM->setUpdatedBy($userName);
        $labDocumentsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $labDocumentsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $labDocumentsVM;
    }

    public static function setPatientAppointment(Request $patientAppointmentRequest)
    {
        $appointmentVM = new NewAppointmentViewModel();
        $appointment = (object) $patientAppointmentRequest->all();

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $appointmentVM->setPatientId($appointment->patientId);
        $appointmentVM->setHospitalId($appointment->hospitalId);
        $appointmentVM->setDoctorId($appointment->doctorId);
        $appointmentVM->setBriefHistory(trim($appointment->briefHistory));
        $appointmentVM->setAppointmentDate($appointment->appointmentDate);
        $appointmentVM->setAppointmentTime($appointment->appointmentTime);

        $appointmentVM->setCreatedBy($userName);
        $appointmentVM->setUpdatedBy($userName);
        $appointmentVM->setCreatedAt(date("Y-m-d H:i:s"));
        $appointmentVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $appointmentVM;
    }

    public static function setFeeReceipt(FeeReceiptRequest $feeReceiptRequest)
    {
        $feeReceiptVM = new FeeReceiptViewModel();

        $feeReceipt = (object)$feeReceiptRequest->all();

        $userName = Session::get('DisplayName');
        //$userName = 'Admin';

        $feeReceiptVM->setReceiptId($feeReceipt->receiptId);
        $feeReceiptVM->setPatientId($feeReceipt->patientId);
        $feeReceiptVM->setHospitalId($feeReceipt->hospitalId);
        $feeReceiptVM->setDoctorId($feeReceipt->doctorId);
        $feeReceiptVM->setFees($feeReceipt->fees);

        $feeReceiptVM->setCreatedBy($userName);
        $feeReceiptVM->setUpdatedBy($userName);
        $feeReceiptVM->setCreatedAt(date("Y-m-d H:i:s"));
        $feeReceiptVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $feeReceiptVM;
    }

    public static function setPersonalHistory(Request $personalHistoryRequest)
    {
        $patientHistoryVM = new PatientPersonalHistoryViewModel();

        $patientHistory = (object) $personalHistoryRequest->all();

        $patientHistoryVM->setPatientId($patientHistory->patientId);
        $patientHistoryVM->setDoctorId(property_exists($patientHistory, 'doctorId') ? $patientHistory->doctorId : null);
        $patientHistoryVM->setHospitalId(property_exists($patientHistory, 'hospitalId') ? $patientHistory->hospitalId : null);
        /*$patientHistoryVM->setHospitalId($patientHistory->hospitalId);
        $patientHistoryVM->setDoctorId($patientHistory->doctorId);*/

        $medicalHistory = $patientHistory->personalHistory;
        //dd($candidateEmployments);

        foreach($medicalHistory as $history)
        {
            $patientHistoryVM->setPatientPersonalHistory($history);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientHistoryVM->setCreatedBy($userName);
        $patientHistoryVM->setUpdatedBy($userName);
        $patientHistoryVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientHistoryVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientHistoryVM;
    }

    public static function setGeneralExamination(Request $personalExaminationRequest)
    {
        $patientGenExaminationVM = new PatientGeneralExaminationViewModel();

        $generalExaminationObj = (object) $personalExaminationRequest->all();

        $patientGenExaminationVM->setPatientId($generalExaminationObj->patientId);
        $patientGenExaminationVM->setDoctorId(property_exists($generalExaminationObj, 'doctorId') ? $generalExaminationObj->doctorId : null);
        $patientGenExaminationVM->setHospitalId(property_exists($generalExaminationObj, 'hospitalId') ? $generalExaminationObj->hospitalId : null);
        /*$patientGenExaminationVM->setDoctorId($generalExaminationObj->doctorId);
        $patientGenExaminationVM->setHospitalId($generalExaminationObj->hospitalId);*/

        $generalExamination = $generalExaminationObj->generalExamination;
        //dd($candidateEmployments);

        foreach($generalExamination as $examination)
        {
            $patientGenExaminationVM->setPatientGeneralExamination($examination);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientGenExaminationVM->setCreatedBy($userName);
        $patientGenExaminationVM->setUpdatedBy($userName);
        $patientGenExaminationVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientGenExaminationVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientGenExaminationVM;
    }

    public static function setPatientPastIllness(Request $pastIllnessRequest)
    {
        $patientPastIllnessVM = new PatientPastIllnessViewModel();

        $pastIllnessObj = (object) $pastIllnessRequest->all();
        $patientPastIllnessVM->setPatientId($pastIllnessObj->patientId);
        /*$patientPastIllnessVM->setDoctorId($pastIllnessObj->doctorId);
        $patientPastIllnessVM->setHospitalId($pastIllnessObj->hospitalId);*/
        $patientPastIllnessVM->setDoctorId(property_exists($pastIllnessObj, 'doctorId') ? $pastIllnessObj->doctorId : null);
        $patientPastIllnessVM->setHospitalId(property_exists($pastIllnessObj, 'hospitalId') ? $pastIllnessObj->hospitalId : null);
        $pastIllness = $pastIllnessObj->pastIllness;
        //dd($candidateEmployments);

        foreach($pastIllness as $illness)
        {
            $patientPastIllnessVM->setPatientPastIllness($illness);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientPastIllnessVM->setCreatedBy($userName);
        $patientPastIllnessVM->setUpdatedBy($userName);
        $patientPastIllnessVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientPastIllnessVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientPastIllnessVM;
    }

    public static function setPatientFamilyIllness(Request $familyIllnessRequest)
    {
        $patientFamilyIllnessVM = new PatientFamilyIllnessViewModel();

        $familyIllnessObj = (object) $familyIllnessRequest->all();
        $patientFamilyIllnessVM->setPatientId($familyIllnessObj->patientId);
        /*$patientFamilyIllnessVM->setDoctorId($familyIllnessObj->doctorId);
        $patientFamilyIllnessVM->setHospitalId($familyIllnessObj->hospitalId);*/
        $patientFamilyIllnessVM->setDoctorId(property_exists($familyIllnessObj, 'doctorId') ? $familyIllnessObj->doctorId : null);
        $patientFamilyIllnessVM->setHospitalId(property_exists($familyIllnessObj, 'hospitalId') ? $familyIllnessObj->hospitalId : null);
        $familyIllness = $familyIllnessObj->familyIllness;
        //dd($candidateEmployments);

        foreach($familyIllness as $illness)
        {
            $patientFamilyIllnessVM->setPatientFamilyIllness($illness);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientFamilyIllnessVM->setCreatedBy($userName);
        $patientFamilyIllnessVM->setUpdatedBy($userName);
        $patientFamilyIllnessVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientFamilyIllnessVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientFamilyIllnessVM;
    }

    public static function setPatientPregnancyDetails(Request $pregnancyRequest)
    {
        $patientPregnancyVM = new PatientPregnancyViewModel();

        $pregnancyObj = (object) $pregnancyRequest->all();
        $patientPregnancyVM->setPatientId($pregnancyObj->patientId);
        /*$patientPregnancyVM->setDoctorId($pregnancyObj->doctorId);
        $patientPregnancyVM->setHospitalId($pregnancyObj->hospitalId);*/
        $patientPregnancyVM->setDoctorId(property_exists($pregnancyObj, 'doctorId') ? $pregnancyObj->doctorId : null);
        $patientPregnancyVM->setHospitalId(property_exists($pregnancyObj, 'hospitalId') ? $pregnancyObj->hospitalId : null);
        $pregnancyDetails = $pregnancyObj->pregnancyDetails;
        //dd($candidateEmployments);

        foreach($pregnancyDetails as $pregnancy)
        {
            $patientPregnancyVM->setPatientPregnancy($pregnancy);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientPregnancyVM->setCreatedBy($userName);
        $patientPregnancyVM->setUpdatedBy($userName);
        $patientPregnancyVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientPregnancyVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientPregnancyVM;
    }

    public static function setPatientScanDetails(Request $scanRequest)
    {
        $patientScanVM = new PatientScanViewModel();

        $scanObj = (object) $scanRequest->all();
        $patientScanVM->setPatientId($scanObj->patientId);
        /*$patientScanVM->setDoctorId($scanObj->doctorId);
        $patientScanVM->setHospitalId($scanObj->hospitalId);*/
        $patientScanVM->setDoctorId(property_exists($scanObj, 'doctorId') ? $scanObj->doctorId : null);
        $patientScanVM->setHospitalId(property_exists($scanObj, 'hospitalId') ? $scanObj->hospitalId : null);
        //$patientScanVM->setLabId(property_exists($scanObj, 'labId') ? $scanObj->labId : null);
        $patientScanVM->setExaminationDate(property_exists($scanObj, 'examinationDate') ? $scanObj->examinationDate : null);
        $patientScanVM->setExaminationTime(property_exists($scanObj, 'examinationTime') ? $scanObj->examinationTime : null);
        $scanDetails = $scanObj->scanDetails;
        //dd($candidateEmployments);

        foreach($scanDetails as $scan)
        {
            $patientScanVM->setPatientScans($scan);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientScanVM->setCreatedBy($userName);
        $patientScanVM->setUpdatedBy($userName);
        $patientScanVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientScanVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientScanVM;
    }

    public static function setPatientSymptomDetails(Request $symptomsRequest)
    {
        $patientSymVM = new PatientSymptomsViewModel();

        $symObj = (object) $symptomsRequest->all();
        $patientSymVM->setPatientId($symObj->patientId);
        $patientSymVM->setDoctorId(property_exists($symObj, 'doctorId') ? $symObj->doctorId : null);
        $patientSymVM->setHospitalId(property_exists($symObj, 'hospitalId') ? $symObj->hospitalId : null);
        /*$patientSymVM->setDoctorId($symObj->doctorId);
        $patientSymVM->setHospitalId($symObj->hospitalId);*/
        $symptomDetails = $symObj->symptomDetails;
        //dd($candidateEmployments);

        foreach($symptomDetails as $symptom)
        {
            $patientSymVM->setPatientSymptoms($symptom);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientSymVM->setCreatedBy($userName);
        $patientSymVM->setUpdatedBy($userName);
        $patientSymVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientSymVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientSymVM;
    }

    public static function setPatientComplaintDetails(Request $complaintRequest)
    {
        $patientComVM = new PatientComplaintsViewModel();

        $comObj = (object) $complaintRequest->all();
        $patientComVM->setPatientId($comObj->patientId);
        $patientComVM->setDoctorId(property_exists($comObj, 'doctorId') ? $comObj->doctorId : null);
        $patientComVM->setHospitalId(property_exists($comObj, 'hospitalId') ? $comObj->hospitalId : null);
        $patientComVM->setComplaintText(property_exists($comObj, 'complaintText') ? $comObj->complaintText : null);
        $patientComVM->setComplaintDate(property_exists($comObj, 'complaintDate') ? $comObj->complaintDate : null);
        $patientComVM->setComplaintTime(property_exists($comObj, 'examinationTime') ? $comObj->examinationTime : null);
        /*$patientSymVM->setDoctorId($symObj->doctorId);
        $patientSymVM->setHospitalId($symObj->hospitalId);*/
        $complaintDetails = $comObj->complaints;
        //dd($candidateEmployments);

        foreach($complaintDetails as $complaint)
        {
            $patientComVM->setPatientComplaints($complaint);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientComVM->setCreatedBy($userName);
        $patientComVM->setUpdatedBy($userName);
        $patientComVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientComVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientComVM;
    }

    public static function setPatientDiagnosisDetails(Request $diagnosisRequest)
    {
        $patientDiagnosisVM = new PatientDiagnosisViewModel();

        $diagnosisObj = (object) $diagnosisRequest->all();
        $patientDiagnosisVM->setPatientId($diagnosisObj->patientId);
        $patientDiagnosisVM->setDoctorId(property_exists($diagnosisObj, 'doctorId') ? $diagnosisObj->doctorId : null);
        $patientDiagnosisVM->setHospitalId(property_exists($diagnosisObj, 'hospitalId') ? $diagnosisObj->hospitalId : null);
        $patientDiagnosisVM->setInvestigations(property_exists($diagnosisObj, 'investigations') ? $diagnosisObj->investigations : null);
        $patientDiagnosisVM->setExaminationFindings(property_exists($diagnosisObj, 'examinationFindings') ? $diagnosisObj->examinationFindings : null);
        $patientDiagnosisVM->setProvisionalDiagnosis(property_exists($diagnosisObj, 'provisionalDiagnosis') ? $diagnosisObj->provisionalDiagnosis : null);
        $patientDiagnosisVM->setFinalDiagnosis(property_exists($diagnosisObj, 'finalDiagnosis') ? $diagnosisObj->finalDiagnosis : null);
        $patientDiagnosisVM->setDiagnosisDate(property_exists($diagnosisObj, 'diagnosisDate') ? $diagnosisObj->diagnosisDate : null);
        $patientDiagnosisVM->setExaminationTime(property_exists($diagnosisObj, 'examinationTime') ? $diagnosisObj->examinationTime : null);
        $patientDiagnosisVM->setTreatmentType(property_exists($diagnosisObj, 'treatmentType') ? $diagnosisObj->treatmentType : null);
        $patientDiagnosisVM->setTreatmentPlanNotes(property_exists($diagnosisObj, 'treatmentPlanNotes') ? $diagnosisObj->treatmentPlanNotes : null);
        /*$patientSymVM->setDoctorId($symObj->doctorId);
        $patientSymVM->setHospitalId($symObj->hospitalId);*/

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientDiagnosisVM->setCreatedBy($userName);
        $patientDiagnosisVM->setUpdatedBy($userName);
        $patientDiagnosisVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientDiagnosisVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientDiagnosisVM;
    }

    public static function setPatientDrugHistory(Request $drugHistoryRequest)
    {
        $patientDrugsVM = new PatientDrugHistoryViewModel();

        $drugHistoryObj = (object) $drugHistoryRequest->all();
        $patientDrugsVM->setPatientId($drugHistoryRequest->patientId);
        $patientDrugsVM->setDoctorId(property_exists($drugHistoryObj, 'doctorId') ? $drugHistoryObj->doctorId : null);
        $patientDrugsVM->setHospitalId(property_exists($drugHistoryObj, 'hospitalId') ? $drugHistoryObj->hospitalId : null);
        //$patientDrugsVM->set
        $drugHistory = $drugHistoryObj->drugHistory;
        $surgeryHistory = $drugHistoryObj->surgeryHistory;
        //dd($candidateEmployments);

        foreach($drugHistory as $history)
        {
            $patientDrugsVM->setDrugHistory($history);
        }

        foreach($surgeryHistory as $history)
        {
            $patientDrugsVM->setSurgeryHistory($history);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientDrugsVM->setCreatedBy($userName);
        $patientDrugsVM->setUpdatedBy($userName);
        $patientDrugsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientDrugsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientDrugsVM;
    }

    public static function setPatientUrineExamination(Request $examinationRequest)
    {
        $patientUrineVM = new PatientUrineExaminationViewModel();

        $examinationObj = (object) $examinationRequest->all();
        $patientUrineVM->setPatientId($examinationObj->patientId);
        /*$patientUrineVM->setDoctorId($examinationObj->doctorId);
        $patientUrineVM->setHospitalId($examinationObj->hospitalId);*/
        $patientUrineVM->setDoctorId(property_exists($examinationObj, 'doctorId') ? $examinationObj->doctorId : null);
        $patientUrineVM->setHospitalId(property_exists($examinationObj, 'hospitalId') ? $examinationObj->hospitalId : null);
        //$patientUrineVM->setLabId(property_exists($examinationObj, 'labId') ? $examinationObj->labId : null);
        $patientUrineVM->setExaminationDate(property_exists($examinationObj, 'examinationDate') ? $examinationObj->examinationDate : null);
        $patientUrineVM->setExaminationTime(property_exists($examinationObj, 'examinationTime') ? $examinationObj->examinationTime : null);
        $examinationDetails = $examinationObj->urineExaminations;

        /*$filteredItems = array_filter($examinationDetails, function($elem)  use($patientUrineVM) {

            if($elem['isValueSet'] != 1)
            {
                return false;
            }

            $patientUrineVM->setExaminations($elem);
            return true;

        });*/
        //dd($candidateEmployments);

        foreach($examinationDetails as $examination)
        {
            $patientUrineVM->setExaminations($examination);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientUrineVM->setCreatedBy($userName);
        $patientUrineVM->setUpdatedBy($userName);
        $patientUrineVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientUrineVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientUrineVM;
    }

    public static function setPatientMotionExamination(Request $examinationRequest)
    {
        $patientMotionVM = new PatientUrineExaminationViewModel();

        $examinationObj = (object) $examinationRequest->all();
        $patientMotionVM->setPatientId($examinationObj->patientId);
        /*$patientMotionVM->setDoctorId($examinationObj->doctorId);
        $patientMotionVM->setHospitalId($examinationObj->hospitalId);*/
        $patientMotionVM->setDoctorId(property_exists($examinationObj, 'doctorId') ? $examinationObj->doctorId : null);
        $patientMotionVM->setHospitalId(property_exists($examinationObj, 'hospitalId') ? $examinationObj->hospitalId : null);
        //$patientMotionVM->setLabId(property_exists($examinationObj, 'labId') ? $examinationObj->labId : null);
        $patientMotionVM->setExaminationDate(property_exists($examinationObj, 'examinationDate') ? $examinationObj->examinationDate : null);
        $patientMotionVM->setExaminationTime(property_exists($examinationObj, 'examinationTime') ? $examinationObj->examinationTime : null);
        $examinationDetails = $examinationObj->motionExaminations;
        //dd($candidateEmployments);

        foreach($examinationDetails as $examination)
        {
            $patientMotionVM->setExaminations($examination);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientMotionVM->setCreatedBy($userName);
        $patientMotionVM->setUpdatedBy($userName);
        $patientMotionVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientMotionVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientMotionVM;
    }

    public static function setPatientBloodExamination(Request $examinationRequest)
    {
        $patientBloodVM = new PatientUrineExaminationViewModel();

        $examinationObj = (object) $examinationRequest->all();
        $patientBloodVM->setPatientId($examinationObj->patientId);
        /*$patientBloodVM->setDoctorId($examinationObj->doctorId);
        $patientBloodVM->setHospitalId($examinationObj->hospitalId);*/
        $patientBloodVM->setDoctorId(property_exists($examinationObj, 'doctorId') ? $examinationObj->doctorId : null);
        $patientBloodVM->setHospitalId(property_exists($examinationObj, 'hospitalId') ? $examinationObj->hospitalId : null);
        //$patientBloodVM->setLabId(property_exists($examinationObj, 'labId') ? $examinationObj->labId : null);
        $patientBloodVM->setExaminationDate(property_exists($examinationObj, 'examinationDate') ? $examinationObj->examinationDate : null);
        $patientBloodVM->setExaminationTime(property_exists($examinationObj, 'examinationTime') ? $examinationObj->examinationTime : null);
        $examinationDetails = $examinationObj->bloodExaminations;
        //dd($examinationDetails);

        /*$filteredItems = array_filter($examinationDetails, function($elem)  use($patientBloodVM) {

            //dd($elem['isValueSet']);
            if($elem['isValueSet'] != 1)
            {
                return false;
            }

            $patientBloodVM->setExaminations($elem);
            return true;

        });*/

        //dd($patientBloodVM);

        foreach($examinationDetails as $examination)
        {
            $patientBloodVM->setExaminations($examination);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientBloodVM->setCreatedBy($userName);
        $patientBloodVM->setUpdatedBy($userName);
        $patientBloodVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientBloodVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientBloodVM;
    }

    public static function setPatientUltraSoundExamination(Request $examinationRequest)
    {
        $patientUltraSoundVM = new PatientUrineExaminationViewModel();

        $examinationObj = (object) $examinationRequest->all();
        $patientUltraSoundVM->setPatientId($examinationObj->patientId);
        //$patientUltraSoundVM->setDoctorId($examinationObj->doctorId);
        $patientUltraSoundVM->setDoctorId(property_exists($examinationObj, 'doctorId') ? $examinationObj->doctorId : null);
        $patientUltraSoundVM->setHospitalId(property_exists($examinationObj, 'hospitalId') ? $examinationObj->hospitalId : null);
        //$patientUltraSoundVM->setLabId(property_exists($examinationObj, 'labId') ? $examinationObj->labId : null);
        $patientUltraSoundVM->setExaminationDate(property_exists($examinationObj, 'examinationDate') ? $examinationObj->examinationDate : null);
        $patientUltraSoundVM->setExaminationTime(property_exists($examinationObj, 'examinationTime') ? $examinationObj->examinationTime : null);
        //$patientUltraSoundVM->setHospitalId($examinationObj->hospitalId);
        $examinationDetails = $examinationObj->ultraSoundExaminations;
        //dd($candidateEmployments);

        foreach($examinationDetails as $examination)
        {
            $patientUltraSoundVM->setExaminations($examination);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientUltraSoundVM->setCreatedBy($userName);
        $patientUltraSoundVM->setUpdatedBy($userName);
        $patientUltraSoundVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientUltraSoundVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientUltraSoundVM;
    }

    public static function setPatientDentalExamination(Request $examinationRequest)
    {
        $patientDentalVM = null;

        $patientDentalVM = new PatientDentalViewModel();

        $dentalObj = (object) $examinationRequest->all();
        $patientDentalVM->setPatientId($dentalObj->patientId);
        //$patientUltraSoundVM->setDoctorId($examinationObj->doctorId);
        $patientDentalVM->setDoctorId(property_exists($dentalObj, 'doctorId') ? $dentalObj->doctorId : null);
        $patientDentalVM->setHospitalId(property_exists($dentalObj, 'hospitalId') ? $dentalObj->hospitalId : null);
        //$patientDentalVM->setLabId(property_exists($dentalObj, 'labId') ? $dentalObj->labId : null);
        $patientDentalVM->setExaminationDate(property_exists($dentalObj, 'examinationDate') ? $dentalObj->examinationDate : null);
        $patientDentalVM->setExaminationTime(property_exists($dentalObj, 'examinationTime') ? $dentalObj->examinationTime : null);
        //$patientUltraSoundVM->setHospitalId($examinationObj->hospitalId);
        $examinationDetails = $dentalObj->dentalExaminations;
        //dd($candidateEmployments);

        foreach($examinationDetails as $examination)
        {
            $patientDentalVM->setPatientDentalTests($examination);
            /*if(count($examination)==3)
            {
                $patientDentalVM->setPatientDentalTests($examination);
            }*/
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientDentalVM->setCreatedBy($userName);
        $patientDentalVM->setUpdatedBy($userName);
        $patientDentalVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientDentalVM->setUpdatedAt(date("Y-m-d H:i:s"));

        /*try
        {
            //dd($examinationRequest);


            //dd($patientDentalVM);
        }
        catch(Exception $ex)
        {
            dd($ex);
        }*/


        return $patientDentalVM;
    }

    public static function setPatientXRayExamination(Request $examinationRequest)
    {
        $patientXRayVM = new PatientXRayViewModel();

        $xRayObj = (object) $examinationRequest->all();
        $patientXRayVM->setPatientId($xRayObj->patientId);
        //$patientUltraSoundVM->setDoctorId($examinationObj->doctorId);
        $patientXRayVM->setDoctorId(property_exists($xRayObj, 'doctorId') ? $xRayObj->doctorId : null);
        $patientXRayVM->setHospitalId(property_exists($xRayObj, 'hospitalId') ? $xRayObj->hospitalId : null);
        //$patientXRayVM->setLabId(property_exists($xRayObj, 'labId') ? $xRayObj->labId : null);
        $patientXRayVM->setExaminationDate(property_exists($xRayObj, 'examinationDate') ? $xRayObj->examinationDate : null);
        $patientXRayVM->setExaminationTime(property_exists($xRayObj, 'examinationTime') ? $xRayObj->examinationTime : null);
        //$patientUltraSoundVM->setHospitalId($examinationObj->hospitalId);
        $examinationDetails = $xRayObj->xrayExaminations;
        //dd($candidateEmployments);

        foreach($examinationDetails as $examination)
        {
            $patientXRayVM->setPatientXRayTests($examination);
            /*if(count($examination)==3)
            {
                $patientXRayVM->setPatientXRayTests($examination);
            }*/


            /*if(count($examination)==3)
            {
                $patientDentalVM->setPatientDentalTests($examination);
            }*/
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $patientXRayVM->setCreatedBy($userName);
        $patientXRayVM->setUpdatedBy($userName);
        $patientXRayVM->setCreatedAt(date("Y-m-d H:i:s"));
        $patientXRayVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $patientXRayVM;
    }

    public static function setReferralDoctor(Request $doctorReferralRequest)
    {
        $doctorReferralsVM = new DoctorReferralsViewModel();

        $referralObj = (object) $doctorReferralRequest->all();
        $doctorReferralsVM->setDoctorName($referralObj->doctorName);
        //$patientUltraSoundVM->setDoctorId($examinationObj->doctorId);
        $doctorReferralsVM->setHospitalName(property_exists($referralObj, 'hospitalName') ? $referralObj->hospitalName : null);
        $doctorReferralsVM->setLocation(property_exists($referralObj, 'location') ? $referralObj->location : null);
        //$patientUltraSoundVM->setHospitalId($examinationObj->hospitalId);
        $doctorReferralsVM->setSpecialtyId($referralObj->specialtyId);

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $doctorReferralsVM->setCreatedBy($userName);
        $doctorReferralsVM->setUpdatedBy($userName);
        $doctorReferralsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $doctorReferralsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $doctorReferralsVM;
    }

    //public static function setPatientLabReceipts(Request $patientLabReceiptRequest)
    public static function setPatientLabReceipts($patientLabReceiptRequest)
    {
        $labReceiptsVM = new PatientLabReceiptViewModel();
        //$receiptObj = (object) $patientLabReceiptRequest->all();
        $receiptObj = (object) $patientLabReceiptRequest;
        $labTests = $receiptObj->labTests;
        //dd($labTests);

        if(array_key_exists('bloodTests', $labTests))
        {
            $labReceiptsVM->setBloodTests($labTests['bloodTests']);
        }
        if(array_key_exists('urineTests', $labTests))
        {
            $labReceiptsVM->setUrineTests($labTests['urineTests']);
        }
        if(array_key_exists('motionTests', $labTests))
        {
            $labReceiptsVM->setMotionTests($labTests['motionTests']);
        }
        if(array_key_exists('scanTests', $labTests))
        {
            $labReceiptsVM->setScanTests($labTests['scanTests']);
        }
        if(array_key_exists('ultraSoundTests', $labTests))
        {
            $labReceiptsVM->setUltraSoundTests($labTests['ultraSoundTests']);
        }
        if(array_key_exists('dentalTests', $labTests))
        {
            $labReceiptsVM->setDentalTests($labTests['dentalTests']);
        }
        if(array_key_exists('xrayTests', $labTests))
        {
            $labReceiptsVM->setXrayTests($labTests['xrayTests']);
        }

        $userName = 'Admin';

        $labReceiptsVM->setPatientId($receiptObj->patientId);
        $labReceiptsVM->setHospitalId($receiptObj->hospitalId);
        $labReceiptsVM->setDoctorId(property_exists($receiptObj, 'doctorId') ? $receiptObj->doctorId : null);
        //$labReceiptsVM->setDoctorId($receiptObj->doctorId);
         //ramana start 12-01-2018
        $labReceiptsVM->setPaidAmount( $receiptObj->paidamount);//by ramana
        $labReceiptsVM->setPaymentType( $receiptObj->paymenttype );//by ramana
        //ramana end 12-01-2018
        $labReceiptsVM->setTotalFees($receiptObj->totalFees);
        $labReceiptsVM->setLabReceiptDate(date("Y-m-d H:i:s"));
        //$labReceiptsVM->setBloodTests()
        $labReceiptsVM->setCreatedBy($userName);
        $labReceiptsVM->setUpdatedBy($userName);
        $labReceiptsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $labReceiptsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $labReceiptsVM;
    }

    public static function setPatientPrescriptionApiAttachments(Request $prescriptionRequest)
    {
        $prescriptionAttachVM = new PatientPrescriptionAttachmentViewModel();

        //$attachments = $prescriptionRequest['prescription_attachments'];

        //$files = $prescriptionRequest->allFiles();
        //$attachments = $prescriptionRequest->allFiles();

        //dd($prescriptionRequest->file('prescription_attachments'));
        $attachments = $prescriptionRequest->file('prescription_attachments');
        //dd($attachments);
        //return json_decode($prescriptionRequest);
        //dd($attachments);
        //$medicalDocuments = $hospitalRequest['medical_new_document'];

        //dd($medicalDocuments);
        //$loggedUserId = Session::get('LoginUserId');
        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        /*foreach ($attachments as $key => $value)
        {
            dd($value->getClientOriginalName());
            //dd($value[0]->getClientOriginalName());
            $filename = $value->prescription_attachments;
            //dd($filename);
            if(!is_null($value['document_upload_path']))
            {
                $prescriptionAttachVM->setPatientPrescriptionAttachments($value);
            }
        }*/

        if(!empty($attachments))
        {
            foreach ($attachments as $attachment)
            {
                $prescriptionAttachVM->setPatientPrescriptionAttachments($attachment);
                //dd($attachment);

                //$files = $prescriptionRequest->file('prescription_attachments');
                //dd($files[0]);
                //dd($files[0]->getClientOriginalName());
                //$filename = $value->prescription_attachments;
                //dd($filename);
                /*if(!is_null($value['document_upload_path']))
                {
                    $prescriptionAttachVM->setPatientPrescriptionAttachments($value);
                }*/
            }
        }


        //$prescriptionAttachVM->setDocumentName($prescriptionRequest['document_name']);
        $prescriptionAttachVM->setPatientId($prescriptionRequest['patientId']);
        $prescriptionAttachVM->setDoctorId($prescriptionRequest['doctorId']);
        $prescriptionAttachVM->setHospitalId($prescriptionRequest['hospitalId']);
        $prescriptionAttachVM->setPrescriptionUploadDate(date("Y-m-d"));


        $prescriptionAttachVM->setCreatedBy($userName);
        $prescriptionAttachVM->setModifiedBy($userName);
        $prescriptionAttachVM->setCreatedAt(date("Y-m-d H:i:s"));
        $prescriptionAttachVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $prescriptionAttachVM;
    }

}