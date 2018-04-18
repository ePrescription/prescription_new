<?php namespace App\prescription\repositories\repointerface;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/2016
 * Time: 5:07 PM
 */

use App\Http\ViewModels\DoctorAvailabilityViewModel;
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
use App\Http\ViewModels\PatientLabTestViewModel;
use App\Http\ViewModels\PatientPastIllnessViewModel;
use App\Http\ViewModels\PatientPersonalHistoryViewModel;
use App\Http\ViewModels\PatientPrescriptionViewModel;
use App\Http\ViewModels\PatientProfileViewModel;

use App\Http\ViewModels\PatientPregnancyViewModel;
use App\Http\ViewModels\PatientScanViewModel;
use App\Http\ViewModels\PatientSymptomsViewModel;
use App\Http\ViewModels\PatientUrineExaminationViewModel;
use App\Http\ViewModels\PatientXRayViewModel;

interface HospitalInterface {
    public function getHospitals();
    public function getHospitalByKeyword($keyword = null);
    public function getHospitalId($userTypeId, $userId);
    public function getDoctorsByHospitalId($hospitalId);

    public function getHospitalsForDoctor($email);
    public function getHospitalsByDoctorId($doctorId);

    public function getDoctorDetails($doctorId);

    //Get Appointment details
    public function getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId);
    public function saveNewAppointment(NewAppointmentViewModel $appointmentVM);

    public function cancelAppointment($appointmentId);
    public function transferAppointment($appointmentId, $doctorId);

    //Get Patient List
    public function getPatientsByHospital($hospitalId, $keyword = null);

    public function getPatientsByHospitalAndDoctor($hospitalId, $doctorId);
    //public function getPatientsByHospital($hospitalId);
    public function getPatientDetailsById($patientId);
    public function getPatientProfile($patientId);
    public function getPatientAppointments($patientId);
    public function getDashboardDetails($hospitalId, $selectedDate);
    public function getFutureAppointmentsForDashboard($fromDate, $toDate, $hospitalId, $doctorId = null);

    public function getDashboardDetailsForDoctor($hospitalId, $doctorId);
    public function getPatientsByAppointmentCategory($hospitalId,$categoryType,$doctorId = null,$fromDate=null,$toDate=null,$status=null);
    public function getPatientsByAppointmentDate($hospitalId, $doctorId, $appointmentDate);

    public function getPatientAppointmentDates($patientId, $hospitalId);
    //public function getPatientsByA

    public function getPatientAppointmentsByHospital($patientId, $hospitalId);
    public function getAppointmentDetails($appointmentId);

    //Get Prescription List
    public function getPrescriptions($hospitalId, $doctorId);
    public function getPrescriptionByPatient($patientId);
    public function getPrescriptionDetails($prescriptionId);
    public function savePatientPrescription(PatientPrescriptionViewModel $patientPrescriptionVM);
    public function savePatientProfile(PatientProfileViewModel $patientProfileVM);
    public function editPatientProfile(PatientProfileViewModel $patientProfileVM);

    public function checkIsNewPatient($hospitalId, $doctorId, $patientId);

    //Search Patient
    public function searchPatientByName($keyword);
    public function searchPatientByPid($pid);

    public function searchByPatientByPidOrName($keyWord = null);
    public function searchPatientByHospitalAndName($hospitalId, $keyword = null);

    //Drug list
    public function getTradeNames($keyword);
    public function getFormulationNames($keyword);

    //Lab Tests
    public function getLabTests($keyword);
    public function getLabTestsForPatient($hospitalId, $doctorId);
    public function getLabTestsByPatient($patientId);
    public function getLabTestDetails($labTestId);
    public function savePatientLabTests(PatientLabTestViewModel $patientLabTestVM);

    //Hospital
    public function getProfile($hospitalId);
    public function getDoctorNames($hospitalId, $keyword);
    public function getPatientNames($hospitalId, $keyword);

    //Fee receipt
    public function getFeeReceipts($hospitalId, $doctorId);
    public function getFeeReceiptsByPatient($patientId);
    public function getReceiptDetails($receiptId);
    public function saveFeeReceipt(FeeReceiptViewModel $feeReceiptVM);

    //Symptoms
    public function getMainSymptoms();
    public function getSubSymptomsForMainSymptoms($mainSymptomsId);
    public function getSymptomsForSubSymptoms($subSymptomId);
    public function getPersonalHistory($patientId, $personalHistoryDate);
    public function getPatientPastIllness($patientId, $pastIllnessDate);
    public function getPatientFamilyIllness($patientId, $familyIllnessDate);
    public function savePersonalHistory(PatientPersonalHistoryViewModel $patientHistoryVM);
    public function getPatientGeneralExamination($patientId, $generalExaminationDate);
    public function savePatientGeneralExamination(PatientGeneralExaminationViewModel $patientExaminationVM);
    public function savePatientPastIllness(PatientPastIllnessViewModel $patientPastIllnessVM);
    public function savePatientFamilyIllness(PatientFamilyIllnessViewModel $patientFamilyIllnessVM);

    public function getExaminationDates($patientId, $hospitalId);
    public function getApiExaminationDates($patientId);
    public function getLatestAppointmentDateForPatient($patientId, $hospitalId);
    //;

    public function getPregnancyDetails($patientId, $pregnancyDate = null);
    public function savePatientPregnancyDetails(PatientPregnancyViewModel $patientPregnancyVM);

    public function getPatientScanDetails($patientId, $scanDate);
    public function savePatientScanDetails(PatientScanViewModel $patientScanVM);
    public function savePatientScanDetailsNew(PatientScanViewModel $patientScanVM);

    public function getPatientSymptoms($patientId, $symptomDate);
    public function savePatientSymptoms(PatientSymptomsViewModel $patientSymVM);

    public function getPatientDrugHistory($patientId);
    public function savePatientDrugHistory(PatientDrugHistoryViewModel $drugHistoryVM);

    public function getPatientUrineTests($patientId, $urineTestDate);
    public function savePatientUrineTests(PatientUrineExaminationViewModel $patientUrineVM);
    public function savePatientUrineTestsNew(PatientUrineExaminationViewModel $patientUrineVM);

    public function getPatientMotionTests($patientId, $motionTestDate);
    public function savePatientMotionTests(PatientUrineExaminationViewModel $patientMotionVM);
    public function savePatientMotionTestsNew(PatientUrineExaminationViewModel $patientMotionVM);

    public function getPatientBloodTests($patientId, $bloodTestDate);
    public function savePatientBloodTests(PatientUrineExaminationViewModel $patientBloodVM);
    public function savePatientBloodTestsNew(PatientUrineExaminationViewModel $patientBloodVM);

    public function getPatientUltraSoundTests($patientId, $ultraSoundDate);
    public function savePatientUltraSoundTests(PatientUrineExaminationViewModel $patientUltraSoundVM);
    public function savePatientUltraSoundTestsNew(PatientUrineExaminationViewModel $patientUltraSoundVM);

    public function getPatientDentalTests($patientId, $dentalDate);
    public function savePatientDentalTests(PatientDentalViewModel $patientDentalVM);

    public function getPatientXrayTests($patientId, $xrayDate);
    public function savePatientXRayTests(PatientXRayViewModel $patientXRayVM);

    public function getAllBloodTests();
    public function getAllMotionTests();
    public function getAllUrineTests();
    public function getAllUltrasoundTests();

    public function getAllFamilyIllness();
    public function getAllPastIllness();
    public function getAllGeneralExaminations();
    public function getAllPersonalHistory();
    public function getAllApiPersonalHistory();

    public function getAllPregnancy();
    public function getAllScans();
    public function getAllDentalItems();
    public function getAllXRayItems();

    public function getPatientLabTests($hospitalId, $patientId, $feeStatus = null);
    public function getLabTestDetailsByPatient($labTestType, $labTestId);

    public function getPatientReceiptDetails($hospitalId, $patientId, $feeReceiptId);
    public function getLabTestDetailsForReceipt($patientId, $hospitalId, $generatedDate = null);
    public function saveLabReceiptDetailsForPatient(PatientLabReceiptViewModel $labReceiptsVM);
    public function getLabReceiptsByPatient($patientId, $hospitalId);

    public function getAllSpecialties();
    public function getDoctorsBySpecialty($specialtyId);
    public function saveReferralDoctor(DoctorReferralsViewModel $doctorReferralsVM);
    public function getReferralDoctorDetails($referralId);

    //
    public function getComplaintTypes();
    public function getComplaints($complaintTypeId);
    public function savePatientComplaints(PatientComplaintsViewModel $patientComVM);
    public function getPatientComplaints($patientId, $complaintsDate);

    public function savePatientInvestigationAndDiagnosis(PatientDiagnosisViewModel $patientDiagnosisVM);
    public function getPatientInvestigations($patientId, $investigationDate);

    public function uploadPatientLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM);
    public function uploadPatientApiLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM);

    public function getPatientReports($doctorId, $patientId);
    public function downloadPatientReports($documentId);

    public function getPatientMedicalProfileForPrint($patientId, $hospitalId);
    public function getPatientLabProfileForPrint($patientId, $hospitalId);
    public function getPatientMedicalHistoryForPrint($patientId, $hospitalId);


    /*NEW ADDITION RAMANA*/
     //ramana start 12-01-2018

    public function updateLabPatientFee($hid,$pid,$rid,$newpaidamount,$paidamount,$paymenttype);//ramana

    public function getPaymentHistory($hospitalId, $patientId, $feeReceiptId);//ramana

    public function getExaminationDatesByDate($patientId, $hid,$date);//ramana

    public function updatePatientFeeStatus($hid,$did,$pid,$rid);

     //ramana end 12-01-2018

    //ADDITION START BY PRASANTH 24-01-2018//
    /*To Get TokenID Count To Display*/
    public function getTokenIdByHospitalIdAndDoctorId($hospitalId,$doctorId,$date,$appointmentCategory);
    /*To Display PatientAppointmentAdmitCard Details in FrontDesk*/
    public function getPatientAppointmentLabel($patientId,$Id);
    //ADDITION END BY PRASANTH 24-01-2018//
    public function getPatientsCount($hospitalId);
    public function getDoctorsInfo($hospitalId);
    public function getDoctorsAvalabilityForHospital($hospitalId,$doctorId);
    public function SaveDoctorAvailability(DoctorAvailabilityViewModel $doctorAvailabilityVM);
    public function saveDoctorLeaves($LeaveRequestVM);
    public function UpdateDoctorLeaves($LeaveRequestVM,$id);
    public function deleteDoctorLeaves($id);

    //Added by Baskar 24-03-2018 - Begin
    /* Function to get the doctor appointments for the next two days from current date. This is for doctors in case of offline*/

    public function getApiTwoDaysDoctorAppointments($hospitalId, $doctorId);

    //Added by Baskar - End


}