<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/2016
 * Time: 5:09 PM
 */

namespace App\prescription\repositories\repoimpl;

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
use App\Http\ViewModels\PatientPregnancyViewModel;
use App\Http\ViewModels\PatientPrescriptionViewModel;
use App\Http\ViewModels\PatientProfileViewModel;
use App\Http\ViewModels\PatientScanViewModel;
use App\Http\ViewModels\PatientSymptomsViewModel;
use App\Http\ViewModels\PatientUrineExaminationViewModel;
use App\Http\ViewModels\PatientXRayViewModel;
use App\prescription\model\entities\Doctor;
use App\prescription\model\entities\DoctorAppointments;
use App\prescription\model\entities\DoctorReferral;
use App\prescription\model\entities\FeeReceipt;
use App\prescription\model\entities\LabFeeReceipt;
use App\prescription\model\entities\LabTestDetails;
use App\prescription\model\entities\Patient;
use App\prescription\model\entities\PatientBloodExamination;
use App\prescription\model\entities\PatientBloodExaminationItems;
use App\prescription\model\entities\PatientComplaintDetails;
use App\prescription\model\entities\PatientComplaints;
use App\prescription\model\entities\PatientDentalExamination;
use App\prescription\model\entities\PatientDentalExaminationItems;
use App\prescription\model\entities\PatientDiagnosis;
use App\prescription\model\entities\PatientDocumentItems;
use App\prescription\model\entities\PatientDocuments;
use App\prescription\model\entities\PatientDrugHistory;
use App\prescription\model\entities\PatientLabTests;
use App\prescription\model\entities\PatientMotionExamination;
use App\prescription\model\entities\PatientMotionExaminationItems;
use App\prescription\model\entities\PatientPaymentHistory;
use App\prescription\model\entities\PatientPrescription;
use App\prescription\model\entities\PatientScanExamination;
use App\prescription\model\entities\PatientScanExaminationItems;
use App\prescription\model\entities\PatientSurgeries;
use App\prescription\model\entities\PatientSymptoms;
use App\prescription\model\entities\PatientUltrasoundExamination;
use App\prescription\model\entities\PatientUltrasoundExaminationItems;
use App\prescription\model\entities\PatientUrineExamination;
use App\prescription\model\entities\PatientUrineExaminationItems;
use App\prescription\model\entities\PatientXRayExamination;
use App\prescription\model\entities\PatientXRayExaminationItems;
use App\prescription\model\entities\PrescriptionDetails;
use App\prescription\repositories\repointerface\HospitalInterface;
use App\prescription\utilities\AppointmentType;
use App\prescription\utilities\ErrorEnum\ErrorEnum;
use App\prescription\utilities\Exception\HospitalException;
use App\prescription\utilities\Exception\UserNotFoundException;
use App\prescription\utilities\Helper;
use App\prescription\utilities\UserType;
use App\Role;
use App\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use Numbers_Words;
use Storage;
use Carbon\Carbon;
use Config as CA;
use Crypt;

//by ramana


class HospitalImpl implements HospitalInterface
{

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

        try {
            $query = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name',
                DB::raw('CONCAT(h.address, " ", c.city_name, " ", co.name) as hospital_details'));
            //'h.address as hospital_details', 'c.city_name', 'co.name as country');
            $query->join('users as u', 'u.id', '=', 'h.hospital_id');
            $query->join('cities as c', 'c.id', '=', 'h.city');
            $query->join('countries as co', 'co.id', '=', 'h.country');
            $query->where('u.delete_status', '=', 1);

            $hospitals = $query->get();

            //dd($hospitals);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        //dd($hospitals);
        return $hospitals;
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


        try {
            $query = DB::table('hospital as h')->distinct()->select('h.id', 'h.hospital_id', 'h.hospital_name',
                'h.address', 'c.city_name', 'co.name as country');
            $query->join('users as u', 'u.id', '=', 'h.hospital_id');
            $query->join('cities as c', 'c.id', '=', 'h.city');
            $query->join('countries as co', 'co.id', '=', 'h.country');
            $query->where('h.hospital_name', 'LIKE', '%' . $keyword . '%');
            $query->where('u.delete_status', '=', 1);

            //$query->distinct()
            $hospitals = $query->get();
            //dd($hospitals);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $exc);
        }

        return $hospitals;
    }

    //Get Appointment details

    /**
     * Get list of appointments for the hospital and the doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId)
    {
        $appointments = null;

        try {
            $query = DB::table('doctor_appointment as da')->select('da.id', 'da.patient_id',
                'p.name as patient_name', 'p.pid',
                'da.hospital_id', 'h.hospital_name',
                'da.doctor_id', 'd.name as doctor_name',
                //'da.appointment_date',
                DB::raw('DATE_FORMAT(da.appointment_date, "%d-%b-%Y") as appointment_date'),
                'da.appointment_time', 'da.appointment_type', 'da.brief_history as notes');
            $query->join('hospital as h', 'h.hospital_id', '=', 'da.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('doctor as d', 'd.doctor_id', '=', 'da.doctor_id');
            $query->where('da.hospital_id', '=', $hospitalId);
            $query->where('da.doctor_id', '=', $doctorId);
            $query->orderBy('da.appointment_date', 'DESC');

            //dd($query->toSql());

            $appointments = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_LIST_ERROR, $exc);
        }

        return $appointments;
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

        try {
            $query = DB::table('hospital_doctor as hd')->join('users as usr1', 'usr1.id', '=', 'hd.hospital_id');
            $query->join('users as usr2', 'usr2.id', '=', 'hd.doctor_id');
            $query->join('doctor as d', 'd.doctor_id', '=', 'hd.doctor_id');
            $query->where('usr2.delete_status', '=', 1);
            $query->where('hd.hospital_id', '=', $hospitalId);
            $query->select('d.id as id', 'd.doctor_id as doctorId', 'd.name as doctorName', 'd.did as doctorUniqueId');
            //dd($query->toSql());
            $doctors = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR, $exc);
        }

        return $doctors;
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

        try {
            $query = DB::table('hospital_doctor as hd')->join('users as usr1', 'usr1.id', '=', 'hd.doctor_id');
            $query->join('hospital as h', 'h.hospital_id', '=', 'hd.hospital_id');
            $query->where('hd.doctor_id', function ($query) use ($email) {
                $query->select('usr.id')->from('users as usr');
                $query->where(DB::raw('TRIM(usr.email)'), '=', trim($email));
            });
            $query->where('usr1.delete_status', '=', 1);
            $query->select('h.id as id', 'h.hospital_name');
            //dd($query->toSql());
            $hospitals = $query->get();
            //dd($hospitals);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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
        //dd($doctorId);

        try {
            $query = DB::table('hospital_doctor as hd')->join('users as usr1', 'usr1.id', '=', 'hd.doctor_id');
            $query->join('hospital as h', 'h.hospital_id', '=', 'hd.hospital_id');
            $query->where('hd.doctor_id', '=', $doctorId);
            $query->where('usr1.delete_status', '=', 1);
            $query->select('h.hospital_id as id', 'h.hospital_name', 'h.address as hospital_address');
            //dd($query->toSql());
            $hospitals = $query->get();
            //dd($hospitals);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('doctor as d')->join('users as usr1', 'usr1.id', '=', 'd.doctor_id');
            $query->where('d.doctor_id', '=', $doctorId);
            $query->where('usr1.delete_status', '=', 1);
            $query->select('d.id as id', 'd.doctor_id as doctorId', 'd.name as doctorName', 'd.did as doctorUniqueId',
                'd.specialty as department', 'd.designation',
                DB::raw('CONCAT(d.qualifications, " (", d.specialty, ") ", d.experience, " years") as doctorDetails'));

            //DB::raw('CONCAT(h.address, " ", c.city_name, " ", co.name) as hospital_details'));

            $doctorDetails = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR, $exc);
        }

        return $doctorDetails;
    }

    //Get Patient List

    /**
     * Get list of patients for the hospital and patient name
     * @param $hospitalId , $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByHospital($hospitalId, $keyword = null)
        //public function getPatientsByHospital($hospitalId)
    {
        $patients = null;

        try {
            $query = DB::table('hospital_patient as hp')->select('p.id', 'p.patient_id', 'p.pid', 'p.name', 'p.age',
                'p.gender', 'p.telephone', 'p.married', 'p.email', 'p.address', 'p.careof',
                'h.hospital_id', 'h.hospital_name');
            $query->join('hospital as h', 'h.hospital_id', '=', 'hp.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'hp.patient_id');
            $query->where('hp.hospital_id', '=', $hospitalId);
            if ($keyword != null) {
                $query->where('p.name', 'LIKE', '%' . $keyword . '%');
            }

            $query->orderBy('hp.created_at', 'DESC');
            //$query->where('p.name', 'LIKE', '%'.$keyword.'%');

            //dd($query->toSql());
            $patients = $query->get();
            //$patients = $query->paginate(15);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get list of patients for the hospital and doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByHospitalAndDoctor($hospitalId, $doctorId)
    {
        $patients = null;

        try {
            //dd($hospitalId. '  '.$doctorId);
            /*$query = DB::table('hospital_patient as hp')->select('p.id', 'p.patient_id', 'p.pid', 'p.name', 'p.age', 'p.gender', 'p.telephone',
                'h.hospital_id', 'h.hospital_name');
            $query->join('hospital as h', 'h.hospital_id', '=', 'hp.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'hp.patient_id');
            $query->join('hospital_doctor as hd', 'hd.hospital_id', '=', 'hp.hospital_id');
            $query->where('hp.hospital_id', '=', $hospitalId);
            $query->where('hd.doctor_id', '=', $doctorId);

            $query->orderBy('hp.created_at', 'DESC');*/
            //$query->where('p.name', 'LIKE', '%'.$keyword.'%');

            $query = DB::table('doctor_appointment as da')->select('p.id', 'p.patient_id', 'p.pid', 'p.name', 'p.age', 'p.gender', 'p.telephone',
                'h.hospital_id', 'h.hospital_name');
            $query->join('hospital as h', 'h.hospital_id', '=', 'da.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('hospital_patient as hp', function ($join) {
                $join->on('hp.hospital_id', '=', 'da.hospital_id');
                $join->on('hp.patient_id', '=', 'da.patient_id');
            });
            $query->where('da.hospital_id', '=', $hospitalId);
            $query->where('da.doctor_id', '=', $doctorId);

            $query->orderBy('da.created_at', 'DESC');

            //dd($query->toSql());
            $patients = $query->get();
            //dd($patients);
            //$patients = $query->paginate(15);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    //Get Patient Details

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

        try {
            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name as name', 'p.address', 'p.pid', 'c.city_name',
                'co.name as country', 'p.telephone', 'p.email', 'p.relationship', 'p.patient_spouse_name as spouseName',
                'p.dob', 'p.age', 'p.place_of_birth', 'p.nationality', 'p.gender'
                , 'da.appointment_date', 'da.appointment_time', 'da.brief_history', 'da.fee',
                'p.patient_photo', 'p.married', 'p.occupation');
            $query->leftJoin('doctor_appointment as da', 'da.patient_id', '=', 'p.patient_id');
            $query->leftJoin('cities as c', 'c.id', '=', 'p.city');
            $query->leftJoin('countries as co', 'co.id', '=', 'p.country');
            $query->where('p.patient_id', $patientId);
            $query->orderBy('da.appointment_date', 'DESC');
            $query->orderBy('da.appointment_time', 'DESC');
            $query->limit(1);
            //'p.main_symptoms_id', 'p.sub_symptoms_id', 'p.symptoms_id'

            //dd($query->toSql());

            $patientDetails = $query->get();
            //dd($patientDetails);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_DETAILS_ERROR, $exc);
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

        try {
            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.age',
                'p.gender', 'p.email', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.careof',
                'p.telephone', 'p.address', 'p.patient_photo', 'p.married', 'p.occupation', 'p.dob');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('p.patient_id', $patientId);
            $query->where('usr.delete_status', '=', 1);

            //dd($query->toSql());
            //, 'p.main_symptoms_id', 'p.sub_symptoms_id', 'p.symptoms_id'
            $patientProfile = $query->get();
            //dd($patientProfile);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_ERROR, $exc);
        }

        return $patientProfile;
    }

    //Get Prescription List

    /**
     * Get list of prescriptions for the selected hospital and doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptions($hospitalId, $doctorId)
    {
        $prescriptions = null;

        try {
            $query = DB::table('patient as p')->select('pp.id as prescription_id', 'pp.unique_id as unique_id',
                'p.patient_id', 'p.pid', 'p.name', 'pp.prescription_date', 'pp.brief_description as notes');
            $query->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $query->where('pp.hospital_id', '=', $hospitalId);
            $query->where('pp.doctor_id', '=', $doctorId);
            $query->orderBy('pp.id', 'DESC');

            //dd($query->toSql());

            $prescriptions = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('patient as p')->select('pp.id as prescription_id', 'pp.unique_id as unique_id',
                'pp.patient_id', 'p.pid', 'p.name', 'pp.prescription_date', 'pp.brief_description as notes');
            $query->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $query->where('pp.patient_id', '=', $patientId);
            $query->orderBy('pp.id', 'DESC');

            $prescriptions = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $exc);
        }

        return $prescriptions;
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
        $prescriptionInfo = null;
        $prescriptionDetails = null;
        $patientDetails = null;
        $doctorDetails = null;
        $hospitalDetails = null;
        $patientPrescription = null;

        try {
            /*$query = DB::table('patient as p')->select('p.patient_id', 'p.name', 'p.pid', 'p.telephone',
                'd.brand_name', 'pd.dosage', 'pd.no_of_days', 'pd.morning', 'pd.afternoon', 'pd.night');
            $query->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $query->join('prescription_details as pd', 'pd.patient_prescription_id', '=', 'pp.id');
            $query->join('drugs as d', 'd.id', '=', 'pd.drug_id');
            $query->where('pp.id', '=', $prescriptionId);*/

            $prescriptionQuery = DB::table('patient_prescription as pp')->select('pp.id as prescriptionId', 'pp.unique_id as PRID',
                'pp.brief_description as notes', 'pp.drug_history as illness', 'pp.prescription_date');
            $prescriptionQuery->where('pp.id', '=', $prescriptionId);
            $prescriptionInfo = $prescriptionQuery->get();

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid',
                'pp.prescription_date', 'p.telephone', 'p.email', 'p.patient_photo');
            $patientQuery->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $patientQuery->where('pp.id', '=', $prescriptionId);
            $patientDetails = $patientQuery->get();

            $doctorQuery = DB::table('doctor as d')->select('d.id', 'd.doctor_id', 'd.name', 'd.did', 'd.telephone', 'd.email');
            $doctorQuery->join('patient_prescription as pp', 'pp.doctor_id', '=', 'd.doctor_id');
            $doctorQuery->where('pp.id', '=', $prescriptionId);
            $doctorDetails = $doctorQuery->get();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.hid', 'h.telephone', 'h.email');
            $hospitalQuery->join('patient_prescription as pp', 'pp.hospital_id', '=', 'h.hospital_id');
            $hospitalQuery->where('pp.id', '=', $prescriptionId);
            $hospitalDetails = $hospitalQuery->get();

            $query = DB::table('prescription_details as pd')->select('b.id as trade_id',
                DB::raw('TRIM(UPPER(b.brand_name)) as trade_name'),
                //'d.id as formulation_id',
                //DB::raw('TRIM(UPPER(d.drug_name)) as formulation_name'),
                'b.id as formulation_id',
                DB::raw('TRIM(UPPER(b.brand_name)) as formulation_name'),
                'pd.dosage', 'pd.no_of_days', 'pd.intake_form',
                'pd.morning', 'pd.afternoon', 'pd.night', 'pd.drug_status');
            $query->join('patient_prescription as pp', 'pp.id', '=', 'pd.patient_prescription_id');
            $query->join('brands as b', 'b.id', '=', 'pd.brand_id');
            $query->join('drugs as d', 'd.id', '=', 'pd.drug_id');
            $query->where('pp.id', '=', $prescriptionId);

            //dd($query->toSql());
            $prescriptionDetails = $query->get();

            if (!empty($prescriptionDetails)) {
                $patientPrescription["PrescriptionInfo"] = $prescriptionInfo;
                $patientPrescription["PatientProfile"] = $patientDetails;
                $patientPrescription["DoctorProfile"] = $doctorDetails;
                $patientPrescription["HospitalProfile"] = $hospitalDetails;
                $patientPrescription["PatientDrugDetails"] = $prescriptionDetails;
            }

            //dd($patientPrescription);

        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_ERROR, $exc);
        }

        //dd($patientPrescription);
        return $patientPrescription;
    }

    /**
     * Save Prescription for the patient
     * @param
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPrescription(PatientPrescriptionViewModel $patientPrescriptionVM)
    {
        $status = true;
        $patientPrescription = null;

        try {
            //dd($patientPrescriptionVM);
            $doctorId = $patientPrescriptionVM->getDoctorId();
            $patientId = $patientPrescriptionVM->getPatientId();
            $hospitalId = $patientPrescriptionVM->getHospitalId();

            $doctorUser = User::find($doctorId);
            $hospitalUser = User::find($hospitalId);
            $patientUser = User::find($patientId);

            if (!is_null($doctorUser) && !is_null($hospitalUser) && !is_null($patientUser)) {
                $patientPrescription = new PatientPrescription();
                $patientPrescription->hospital_id = $hospitalId;
                $patientPrescription->doctor_id = $doctorId;
                $patientPrescription->brief_description = $patientPrescriptionVM->getBriefDescription();
                $patientPrescription->drug_history = $patientPrescriptionVM->getDrugHistory();
                //$patientPrescription->unique_id = "PRID".time();
                $patientPrescription->unique_id = 'PRID' . crc32(uniqid(rand()));
                $patientPrescription->prescription_date = $patientPrescriptionVM->getPrescriptionDate();
                $patientPrescription->created_by = 'Admin';
                $patientPrescription->modified_by = 'Admin';
                $patientPrescription->created_at = $patientPrescriptionVM->getCreatedAt();
                $patientPrescription->updated_at = $patientPrescriptionVM->getUpdatedAt();
                $patientUser->prescriptions()->save($patientPrescription);
            }

            $this->savePrescriptionDetails($patientPrescription, $patientPrescriptionVM);
        } catch (QueryException $queryEx) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR, $queryEx);
        } catch (Exception $exc) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    private function savePrescriptionDetails($patientPrescription, PatientPrescriptionViewModel $patientPrescriptionVM)
    {
        $drugs = $patientPrescriptionVM->getDrugDetails();

        foreach ($drugs as $drug) {
            $prescriptionDetails = new PrescriptionDetails();

            $drugObj = (object)$drug;
            $prescriptionDetails->drug_id = $drugObj->drugId;
            $prescriptionDetails->brand_id = $drugObj->brandId;
            //$prescriptionDetails->brief_description = "Test";
            //$prescriptionDetails->brief_description = "Test";
            $prescriptionDetails->dosage = $drugObj->dosage;
            $prescriptionDetails->no_of_days = $drugObj->noOfDays;
            $prescriptionDetails->intake_form = $drugObj->intakeForm;
            $prescriptionDetails->morning = $drugObj->morning;
            $prescriptionDetails->afternoon = $drugObj->afternoon;
            $prescriptionDetails->night = $drugObj->night;
            $prescriptionDetails->created_by = 'Admin';
            $prescriptionDetails->modified_by = 'Admin';

            $prescriptionDetails->created_at = $patientPrescriptionVM->getCreatedAt();
            $prescriptionDetails->updated_at = $patientPrescriptionVM->getUpdatedAt();

            $patientPrescription->prescriptiondetails()->save($prescriptionDetails);
        }
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

        try {
            /*$query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('p.name', 'LIKE', $keyword.'%');

            //dd($query->toSql());
            $patientNames = $query->get();*/

            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('p.pid', 'LIKE', '%' . $keyword . '%');
            $query->orWhere('p.name', 'LIKE', '%' . $keyword . '%');

            //dd($query->toSql());
            $patientNames = $query->get();

        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patientNames;
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

        try {
            $hospitalUser = User::find($hospitalId);

            if (!is_null($hospitalUser)) {
                $query = DB::table('patient as p')->select('p.id', 'p.patient_id as patientId', 'p.name');
                $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
                $query->join('hospital_patient as hp', 'hp.patient_id', '=', 'p.patient_id');
                /*$query->join('hospital_patient as hp', function($join){
                    $join->on('hp.patient_id', '=', 'p.patient_id');
                    $join->on('hp.patient_id', '=', 'usr.id');
                });*/
                $query->where('usr.delete_status', '=', 1);
                $query->where('hp.hospital_id', $hospitalId);
                $query->where('p.name', 'LIKE', '%' . $keyword . '%' )->orWhere('p.patient_id','LIKE', '%' . $keyword . '%')->orWhere('p.pid','LIKE', '%' . $keyword . '%');

                //dd($query->toSql());

                $patientNames = $query->get();
            }
            //dd($query->toSql());


        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('p.pid', 'LIKE', '%' . $pid . '%');

            //dd($query->toSql());

            $patient = $query->get();
            //dd($patient);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('p.pid', 'LIKE', '%' . $keyWord . '%');
            $query->orWhere('p.name', 'LIKE', '%' . $keyWord . '%');

            //dd($query->toSql());
            $patients = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get patient by Name for the hospital
     * @param $keyword , $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByHospitalAndName($hospitalId, $keyword = null)
    {
        $patients = null;

        try {
            $query = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->join('hospital_patient as hp', 'hp.patient_id', '=', 'usr.id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('hp.hospital_id', '=', $hospitalId);
            $query->where('p.name', 'LIKE', '%' . $keyword . '%');

            //dd($query->toSql());
            $patients = $query->get();
            //dd($patients);
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

    public function saveNewAppointment(NewAppointmentViewModel $appointmentVM)
    {
        //dd($appointmentVM);
        $status = true;
        $patientPrescription = null;

        try {
            $doctorId = $appointmentVM->getDoctorId();
            $patientId = $appointmentVM->getPatientId();
            $hospitalId = $appointmentVM->getHospitalId();

            $doctorQuery = User::query();
            $doctorQuery->join('doctor as d', 'd.doctor_id', '=', 'users.id');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);

            $doctorUser = $doctorQuery->first();

            $hospitalQuery = User::query();
            $hospitalQuery->join('hospital as h', 'h.hospital_id', '=', 'users.id');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);

            $hospitalUser = $hospitalQuery->first();

            if (is_null($doctorUser)) {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            if (is_null($hospitalUser)) {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }

            $doctor = User::find($doctorId);
            $hospital = User::find($hospitalId);
            $patientUser = User::find($patientId);

            if (!is_null($doctor) && !is_null($hospital) && !is_null($patientUser)) {
                $appointment = new DoctorAppointments();
                $appointment->patient_id = $patientId;
                $appointment->hospital_id = $hospitalId;
                $appointment->brief_history = $appointmentVM->getBriefHistory();
                $appointment->appointment_date = $appointmentVM->getAppointmentDate();
                $appointment->appointment_time = $appointmentVM->getAppointmentTime();
                $appointment->created_by = $appointmentVM->getCreatedBy();
                $appointment->modified_by = $appointmentVM->getUpdatedBy();
                $appointment->created_at = $appointmentVM->getCreatedAt();
                $appointment->updated_at = $appointmentVM->getUpdatedAt();

                $doctor->appointments()->save($appointment);
            }

        } catch (QueryException $queryEx) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_NEW_APPOINTMENT_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_NEW_APPOINTMENT_ERROR, $exc);
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
        $status = false;

        try {
            $doctorAppointment = DoctorAppointments::find($appointmentId);

            if (!is_null($doctorAppointment)) {
                $status = true;
                $doctorAppointment->appointment_status_id = AppointmentType::APPOINTMENT_CANCELLED;
                //$doctorAppointment->created_at = date("Y-m-d H:i:s");
                $doctorAppointment->updated_at = date("Y-m-d H:i:s");
                $doctorAppointment->save();
            }

        } catch (QueryException $queryEx) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_CANCEL_APPOINTMENT_ERROR, $queryEx);
        } catch (Exception $exc) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_CANCEL_APPOINTMENT_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Transfer the appointment
     * @param $appointmentId , $doctorId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function transferAppointment($appointmentId, $doctorId)
    {
        $status = false;

        try {
            //dd($doctorId);
            //DB::connection()->enableQueryLog();

            $doctorQuery = User::join('role_user as ru', 'ru.user_id', '=', 'users.id');
            $doctorQuery->where('ru.role_id', '=', UserType::USERTYPE_DOCTOR);
            $doctorQuery->where('users.id', '=', $doctorId);
            $doctorQuery->where('users.delete_status', '=', 1);

            //DB::connection()->enableQueryLog();
            //$doctorUser = $doctorQuery->get();
            //$query = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query);

            //dd($doctorQuery->toSql());

            $doctorUser = $doctorQuery->first();
            //dd($doctorUser);

            if (is_null($doctorUser)) {
                $status = false;
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND);
            }

            $doctorAppointment = DoctorAppointments::find($appointmentId);
            //dd($doctorAppointment);

            if (!is_null($doctorAppointment)) {
                $status = true;
                $doctorAppointment->doctor_id = $doctorId;
                $doctorAppointment->appointment_status_id = AppointmentType::APPOINTMENT_TRANSFERRED;
                //$doctorAppointment->created_at = date("Y-m-d H:i:s");
                $doctorAppointment->updated_at = date("Y-m-d H:i:s");
                $doctorAppointment->save();
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_TRANSFERRED_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_TRANSFERRED_ERROR, $exc);
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
        //dd($keyword);

        try {
            /*$query = DB::table('brands as b')->select('b.id as tradeId',
                DB::raw('TRIM(UPPER(b.brand_name)) as tradeName'),
                'b.dosage_amount', 'b.dosage as quantity', 'b.dispensing_form',
                'd.id as formulationId',
                //'b.brand_name as tradeName', 'd.id as formulationId',
                DB::raw('TRIM(UPPER(d.drug_name)) as formulationName'));*/
            $query = DB::table('brands as b')->select('b.id as tradeId',
                DB::raw('TRIM(UPPER(b.brand_name)) as tradeName'),
                'b.dosage_amount', 'b.dosage as quantity', 'b.dispensing_form',
                'b.id as formulationId',
                //'b.brand_name as tradeName', 'd.id as formulationId',
                DB::raw('TRIM(UPPER(b.brand_name)) as formulationName'));
            $query->leftjoin('drugs as d', 'd.id', '=', 'b.drug_id');
            //$query->join('drugs as d', 'd.id', '=', 'b.drug_id');
            $query->where('b.brand_name', 'LIKE', $keyword . '%');
            $query->where('b.brand_status', '=', 1);
            //dd($query->toSql());
            $brands = $query->get();
            //dd($brands);
            /*$query = DB::table('drugs as d')->select('d.id', 'd.brand_name', 'd.drug_name');
            $query->where('d.brand_name', 'LIKE', $keyword.'%');
            $query->where('d.drug_status', '=', 1);

            $brands = $query->get();*/
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::BRAND_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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
        //dd($keyword);

        try {
            $query = DB::table('drugs as d')->select('d.id as formulationId',
                DB::raw('TRIM(UPPER(d.drug_name)) as formulationName')
                , 'b.id as tradeId',
                //DB::raw('CONCAT_WS(" ",TRIM(UPPER(b.brand_name)), NULLIF(b.dosage_amount, ""), NULLIF(b.dosage, "") as tradeName'));
                DB::raw('CONCAT_WS(" ",TRIM(UPPER(b.brand_name)), NULLIF(b.dosage_amount, ""), NULLIF(b.dosage, "")) as tradeName'),
                'b.dosage_amount', 'b.dosage as quantity', 'b.dispensing_form');
            //DB::raw('CONCAT(TRIM(UPPER(b.brand_name)), " ", b.dosage_amount, " ", b.dosage) as tradeName'));

            //DB::raw('TRIM(UPPER(b.brand_name)) as tradeName'));
            $query->join('brands as b', 'b.drug_id', '=', 'd.id');
            $query->where('d.drug_name', 'LIKE', $keyword . '%');
            $query->where('d.drug_status', '=', 1);
            //dd($query->toSql());
            $formulations = $query->get();

            /*DB::raw('CONCAT(TRIM(UPPER(b.brand_name)),
                    COALESCE(b.dosage_amount," "), IF(LENGTH(b.dosage_amount), "", " ")) as tradeName'));*/
            /*$query = DB::table('brands as b')->select('b.id as tradeId',
                DB::raw('CONCAT(TRIM(UPPER(b.brand_name)), " ", b.dosage_amount, " ", b.dosage) as tradeName'), 'd.id as formulationId',
                //'b.brand_name as tradeName', 'd.id as formulationId',
                DB::raw('TRIM(UPPER(d.drug_name)) as formulationName'));
            $query->join('drugs as d', 'd.id', '=', 'b.drug_id');
            $query->where('b.brand_name', 'LIKE', '%'.$keyword.'%');
            $query->where('b.brand_status', '=', 1);*/

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::FORMULATION_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FORMULATION_LIST_ERROR, $exc);
        }

        return $formulations;
    }

    //Lab Tests

    /**
     * Get all lab tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTests($keyword)
    {
        $labTests = null;

        try {
            //dd('Before query');
            $query = DB::table('labtest as lt')->select('lt.id',
                //DB::raw('TRIM(UPPER(lt.test_category)) as test_category'),
                DB::raw('TRIM(UPPER(lt.test_name)) as test_category'),
                DB::raw('TRIM(UPPER(lt.test_name)) as test_name'));
            $query->where('lt.test_status', '=', 1);
            $query->where('lt.test_name', 'LIKE', $keyword . '%');
            //$query = DB::table('labtest as lt')->select('lt.id', 'lt.test_name')->where('lt.test_status', '=', 1);
            //dd($query->toSql());
            $labTests = $query->get();
            //dd($labTests);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Get list of lab tests for the selected hospital and doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsForPatient($hospitalId, $doctorId)
    {
        $patientLabTests = null;

        try {
            $query = DB::table('patient as p')->select('pl.id as labtest_id', 'pl.unique_id as unique_id',
                'p.patient_id', 'p.pid', 'p.name', 'pl.labtest_date', 'pl.brief_description as notes');
            $query->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->where('pl.hospital_id', '=', $hospitalId);
            $query->where('pl.doctor_id', '=', $doctorId);
            $query->orderBy('pl.id', 'DESC');

            $patientLabTests = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::LAB_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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
        $labTests = null;

        try {
            /*$query = DB::table('patient as p')->select('pl.id as labtest_id','pl.unique_id as unique_id', 'pl.patient_id', 'p.pid', 'p.name', 'l.test_name', 'pl.labtest_date');
            $query->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->join('labtest_details as ld', 'ld.patient_labtest_id', '=', 'pl.id');
            $query->join('labtest as l', 'l.id', '=', 'ld.labtest_id');
            $query->where('pl.patient_id', '=', $patientId);
            $query->orderBy('pl.id', 'DESC');*/

            $query = DB::table('patient as p')->select('pl.id as labtest_id', 'pl.unique_id as unique_id', 'pl.patient_id',
                'p.pid', 'p.name', 'pl.labtest_date', 'pl.brief_description as notes');
            $query->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            //$query->join('labtest_details as ld', 'ld.patient_labtest_id', '=', 'pl.id');
            //$query->join('labtest as l', 'l.id', '=', 'ld.labtest_id');
            $query->where('pl.patient_id', '=', $patientId);
            $query->orderBy('pl.id', 'DESC');

            $labTests = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PRESCRIPTION_LIST_ERROR, $exc);
        }

        return $labTests;
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
        $labTestInfo = null;
        $labTestDetails = null;
        $patientDetails = null;
        $doctorDetails = null;
        $hospitalDetails = null;

        $patientLabTests = null;

        try {
            /*$query = DB::table('patient as p')->select('p.patient_id', 'p.name', 'p.pid', 'p.telephone',
                'd.brand_name', 'pd.dosage', 'pd.no_of_days', 'pd.morning', 'pd.afternoon', 'pd.night');
            $query->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $query->join('prescription_details as pd', 'pd.patient_prescription_id', '=', 'pp.id');
            $query->join('drugs as d', 'd.id', '=', 'pd.drug_id');
            $query->where('pp.id', '=', $prescriptionId);*/

            $labTestQuery = DB::table('patient_labtest as pl')->select('pl.id as labtestId', 'pl.unique_id as LTID',
                'pl.brief_description', 'pl.labtest_date');
            $labTestQuery->where('pl.id', '=', $labTestId);
            $labTestInfo = $labTestQuery->get();

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid',
                'pl.labtest_date', 'p.telephone', 'p.email');
            $patientQuery->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $patientQuery->where('pl.id', '=', $labTestId);
            $patientDetails = $patientQuery->get();

            $doctorQuery = DB::table('doctor as d')->select('d.id', 'd.doctor_id', 'd.name', 'd.did', 'd.telephone', 'd.email');
            $doctorQuery->join('patient_labtest as pl', 'pl.doctor_id', '=', 'd.doctor_id');
            $doctorQuery->where('pl.id', '=', $labTestId);
            $doctorDetails = $doctorQuery->get();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.hid', 'h.telephone', 'h.email');
            $hospitalQuery->join('patient_labtest as pl', 'pl.hospital_id', '=', 'h.hospital_id');
            $hospitalQuery->where('pl.id', '=', $labTestId);
            $hospitalDetails = $hospitalQuery->get();

            $query = DB::table('labtest_details as ld')->select('ld.id as ltid',
                'l.id', DB::raw('TRIM(UPPER(l.test_name)) as test_name'),
                DB::raw('TRIM(UPPER(l.test_name)) as test_category'),
                //'l.test_category',
                'ld.brief_description', 'pl.labtest_date', 'ld.labtest_report');
            $query->join('patient_labtest as pl', 'pl.id', '=', 'ld.patient_labtest_id');
            $query->join('labtest as l', 'l.id', '=', 'ld.labtest_id');
            $query->where('pl.id', '=', $labTestId);
            $labTestDetails = $query->get();

            /*$query = DB::table('patient_blood_examination as pbe')->select('pbe.id',
                'be.id', DB::raw('TRIM(UPPER(be.examination_name)) as examination_name'),
                'pbe.examination_date');
            $query->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $query->join('labtest as l', 'l.id', '=', 'ld.labtest_id');
            $query->where('pl.id', '=', $labTestId);
            $labTestDetails = $query->get();*/

            if (!empty($labTestDetails)) {
                $patientLabTests["LabTestInfo"] = $labTestInfo;
                $patientLabTests["PatientProfile"] = $patientDetails;
                $patientLabTests["DoctorProfile"] = $doctorDetails;
                $patientLabTests["HospitalProfile"] = $hospitalDetails;
                $patientLabTests["PatientLabTestDetails"] = $labTestDetails;
            }


            //dd($patientLabTests);

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::LAB_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::LAB_DETAILS_ERROR, $exc);
        }

        //dd($patientLabTests);
        return $patientLabTests;
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

        try {
            $query = DB::table('doctor_appointment as da')->join('hospital as h', 'h.hospital_id', '=', 'da.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('doctor as d', 'd.doctor_id', '=', 'da.doctor_id');
            $query->where('da.patient_id', $patientId);
            $query->select('p.id', 'p.patient_id', 'p.pid', 'p.name as patient_name', 'h.hospital_id', 'h.hospital_name',
                'd.doctor_id', 'd.name', 'da.appointment_date', 'da.appointment_time', 'da.brief_history as notes');
            $query->orderBy('da.appointment_date', 'DESC');

            $appointments = $query->paginate();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $ex);
        }

        return $appointments;
    }

    /**
     * Get patient appointment counts
     * @param $hospitalId , $selectedDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDashboardDetails($hospitalId, $selectedDate)
    {
        $appointments = null;
        $totalAmount = null;
        $dashboardDetails = null;

        $openAppointments = null;
        $visitedAppointments = null;
        $transferredAppointments = null;
        $cancelledAppointments = null;
        $postponedAppointments = null;

        try {
            $currentDate = Carbon::now()->format('Y-m-d');
            //dd($currentDate);
            //$currentDate = '2017-07-14';

            //dd($currentDate);
            /*$query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->whereDate('da.appointment_date', '=', $currentDate);
            $query->whereNotNull('da.appointment_date');
            $query->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $query->groupBy('da.appointment_category');*/

            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $query->whereDate('da.appointment_date', '=', $currentDate);
            $query->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_OPEN);
            $query->whereNotNull('da.appointment_date');
            $query->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $query->groupBy('da.appointment_category');

            $openAppointments = $query->get();

            $visitedQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $visitedQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $visitedQuery->whereDate('da.appointment_date', '=', $currentDate);
            $visitedQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_VISITED);
            $visitedQuery->whereNotNull('da.appointment_date');
            $visitedQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $visitedQuery->groupBy('da.appointment_category');

            $visitedAppointments = $visitedQuery->get();

            $transferredQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $transferredQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $transferredQuery->whereDate('da.appointment_date', '=', $currentDate);
            $transferredQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_TRANSFERRED);
            $transferredQuery->whereNotNull('da.appointment_date');
            $transferredQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $transferredQuery->groupBy('da.appointment_category');

            $transferredAppointments = $transferredQuery->get();

            //DB::connection()->enableQueryLog();

            $cancelledQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $cancelledQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $cancelledQuery->whereDate('da.appointment_date', '=', $currentDate);
            $cancelledQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_CANCELLED);
            $cancelledQuery->whereNotNull('da.appointment_date');
            $cancelledQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $cancelledQuery->groupBy('da.appointment_category');

            $cancelledAppointments = $cancelledQuery->get();

            //$query1 = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query1);
            //dd($cancelledAppointments);

            $postponedQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $postponedQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $postponedQuery->whereDate('da.appointment_date', '=', $currentDate);
            $postponedQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_POSTPONED);
            $postponedQuery->whereNotNull('da.appointment_date');
            $postponedQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $postponedQuery->groupBy('da.appointment_category');

            $postponedAppointments = $postponedQuery->get();

            //dd($query->toSql());

            //DB::connection()->enableQueryLog();
            //$appointments = $query->get();
            //$query = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query);

            //dd($query->toSql());

            //$appointments = $query->get();

            $dashBoardQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $dashBoardQuery->whereDate('da.appointment_date', '=', $currentDate);
            $dashBoardQuery->where(function ($dashBoardQuery) {
                $dashBoardQuery->where('da.appointment_time', '>=', '07:00:00');
                $dashBoardQuery->where('da.appointment_time', '<=', '19:00:00');
            });

            $dashBoardQuery->select(DB::raw("SUM(da.fee) as appAmount"));
            //dd($dashBoardQuery->toSql());
            $appFees = $dashBoardQuery->get();
            $appTotalFees = $appFees[0]->appAmount;

            //dd($totalFees);

            /*$hospitalQuery->join('hospital as h', function($join) {
                $join->on('h.hospital_id', '=', 'users.id');
                $join->on('h.hospital_id', '=', DB::raw('?'));
            })->setBindings(array_merge($doctorQuery->getBindings(), array($hospitalId)));*/

            $bloodExamQuery = DB::table('patient_blood_examination as pbe')->where('pbe.hospital_id', '=', $hospitalId);
            $bloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $bloodExamQuery->whereDate('pbe.created_at', '=', $currentDate);
            $bloodExamQuery->where(function ($bloodExamQuery) {
                $bloodExamQuery->where(DB::raw('TIME(pbe.created_at)'), '>=', '07:00:00');
                $bloodExamQuery->where(DB::raw('TIME(pbe.created_at)'), '<=', '19:00:00');
            });

            $bloodExamQuery->select(DB::raw("SUM(pbei.fees) as bloodTestAmount"));
            //dd($bloodExamQuery->toSql());

            $bloodTestFees = $bloodExamQuery->get();
            $bloodTotalFees = $bloodTestFees[0]->bloodTestAmount;
            //dd($bloodTestFees);

            $motionExamQuery = DB::table('patient_motion_examination as pme')->where('pme.hospital_id', '=', $hospitalId);
            $motionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $motionExamQuery->whereDate('pme.created_at', '=', $currentDate);
            $motionExamQuery->where(function ($motionExamQuery) {
                $motionExamQuery->where(DB::raw('TIME(pme.created_at)'), '>=', '07:00:00');
                $motionExamQuery->where(DB::raw('TIME(pme.created_at)'), '<=', '19:00:00');
            });

            $motionExamQuery->select(DB::raw("SUM(pmei.fees) as motionTestAmount"));
            //dd($bloodExamQuery->toSql());
            $motionTestFees = $motionExamQuery->get();
            $motionTotalFees = $motionTestFees[0]->motionTestAmount;


            $urineExamQuery = DB::table('patient_urine_examination as pue')->where('pue.hospital_id', '=', $hospitalId);
            $urineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $urineExamQuery->whereDate('pue.created_at', '=', $currentDate);
            $urineExamQuery->where(function ($urineExamQuery) {
                $urineExamQuery->where(DB::raw('TIME(pue.created_at)'), '>=', '07:00:00');
                $urineExamQuery->where(DB::raw('TIME(pue.created_at)'), '<=', '19:00:00');
            });

            $urineExamQuery->select(DB::raw("SUM(puei.fees) as urineTestAmount"));
            //dd($bloodExamQuery->toSql());
            $urineTestFees = $urineExamQuery->get();
            $urineTotalFees = $urineTestFees[0]->urineTestAmount;

            $scanExamQuery = DB::table('patient_scan as ps')->where('ps.hospital_id', '=', $hospitalId);
            $scanExamQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
            $scanExamQuery->whereDate('ps.created_at', '=', $currentDate);
            $scanExamQuery->where(function ($scanExamQuery) {
                $scanExamQuery->where(DB::raw('TIME(ps.created_at)'), '>=', '07:00:00');
                $scanExamQuery->where(DB::raw('TIME(ps.created_at)'), '<=', '19:00:00');
            });

            $scanExamQuery->select(DB::raw("SUM(psi.fees) as scanTestAmount"));

            $scanTestFees = $scanExamQuery->get();
            $scanTotalFees = $scanTestFees[0]->scanTestAmount;

            $ultraSoundExamQuery = DB::table('patient_ultra_sound as pus')->where('pus.hospital_id', '=', $hospitalId);
            $ultraSoundExamQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
            $ultraSoundExamQuery->whereDate('pus.created_at', '=', $currentDate);
            $ultraSoundExamQuery->where(function ($ultraSoundExamQuery) {
                $ultraSoundExamQuery->where(DB::raw('TIME(pus.created_at)'), '>=', '07:00:00');
                $ultraSoundExamQuery->where(DB::raw('TIME(pus.created_at)'), '<=', '19:00:00');
            });

            $ultraSoundExamQuery->select(DB::raw("SUM(pusi.fees) as ultraSoundTestAmount"));

            $ultraSoundTestFees = $ultraSoundExamQuery->get();
            $ultraSoundTotalFees = $ultraSoundTestFees[0]->ultraSoundTestAmount;

            $dentalExamQuery = DB::table('patient_dental_examination_item as pdei');
            $dentalExamQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $dentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            $dentalExamQuery->whereDate('pdei.created_at', '=', $currentDate);
            $dentalExamQuery->where(function ($dentalExamQuery) {
                $dentalExamQuery->where(DB::raw('TIME(pdei.created_at)'), '>=', '07:00:00');
                $dentalExamQuery->where(DB::raw('TIME(pdei.created_at)'), '<=', '19:00:00');
            });

            $dentalExamQuery->select(DB::raw("SUM(pdei.fees) as dentalTestAmount"));

            $dentalTestFees = $dentalExamQuery->get();
            $dentalTotalFees = $dentalTestFees[0]->dentalTestAmount;

            $xrayExamQuery = DB::table('patient_xray_examination_item as pxei');
            $xrayExamQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $xrayExamQuery->where('pxe.hospital_id', '=', $hospitalId);
            $xrayExamQuery->whereDate('pxei.created_at', '=', $currentDate);
            $xrayExamQuery->where(function ($xrayExamQuery) {
                $xrayExamQuery->where(DB::raw('TIME(pxei.created_at)'), '>=', '07:00:00');
                $xrayExamQuery->where(DB::raw('TIME(pxei.created_at)'), '<=', '19:00:00');
            });

            $xrayExamQuery->select(DB::raw("SUM(pxei.fees) as xrayTestAmount"));

            $xRayFees = $xrayExamQuery->get();
            $xRayTotalFees = $xRayFees[0]->xrayTestAmount;

            //$query = DB::getQueryLog();
            //dd($query);

            /*SELECT * FROM doctor_appointment da
            WHERE da.`hospital_id` = 1
            AND DATE(da.`created_at`) = '2017-07-13'
            AND TIME(da.`created_at`) >= '07:00:00'
            AND TIME(da.`created_at`) <= '19:00:00'
            */

            $totalAmount = $appTotalFees + $bloodTotalFees + $motionTotalFees + $urineTotalFees + $scanTotalFees + $ultraSoundTotalFees + $dentalTotalFees + $xRayTotalFees;
            $labAmount = $bloodTotalFees + $motionTotalFees + $urineTotalFees + $scanTotalFees + $ultraSoundTotalFees + $dentalTotalFees + $xRayTotalFees;
            $appTotalFees = $appTotalFees + 0;


            $dashboardDetails["openAppointments"] = $openAppointments;
            $dashboardDetails["visitedAppointments"] = $visitedAppointments;
            $dashboardDetails["transferredAppointments"] = $transferredAppointments;
            $dashboardDetails["cancelledAppointments"] = $cancelledAppointments;
            $dashboardDetails["postponedAppointments"] = $postponedAppointments;
            $dashboardDetails["totalAmountCollected"] = $totalAmount;
            $dashboardDetails["totalLabFees"] = $labAmount;
            $dashboardDetails["consultingFees"] = $appTotalFees;

            //dd($dashboardDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $ex);
        }

        return $dashboardDetails;
    }

    /**
     * Get patient appointment counts by doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDashboardDetailsForDoctor($hospitalId, $doctorId)
    {
        $appointments = null;
        $totalAmount = null;
        $dashboardDetails = null;

        $openAppointments = null;
        $visitedAppointments = null;
        $transferredAppointments = null;
        $cancelledAppointments = null;
        $postponedAppointments = null;

        try {
            $currentDate = Carbon::now()->format('Y-m-d');
            //dd($currentDate);
            //$currentDate = '2017-09-20';

            //dd($currentDate);
            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $query->where('da.doctor_id', '=', $doctorId);
            $query->whereDate('da.appointment_date', '=', $currentDate);
            $query->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_OPEN);
            $query->whereNotNull('da.appointment_date');
            $query->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $query->groupBy('da.appointment_category');

            //dd($query->toSql());

            //DB::connection()->enableQueryLog();
            //$appointments = $query->get();
            //$query = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query);

            //dd($query->toSql());

            $openAppointments = $query->get();

            $visitedQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $visitedQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $visitedQuery->where('da.doctor_id', '=', $doctorId);
            $visitedQuery->whereDate('da.appointment_date', '=', $currentDate);
            $visitedQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_VISITED);
            $visitedQuery->whereNotNull('da.appointment_date');
            $visitedQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $visitedQuery->groupBy('da.appointment_category');

            $visitedAppointments = $visitedQuery->get();

            //DB::connection()->enableQueryLog();

            $transferredQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $transferredQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $transferredQuery->where('da.doctor_id', '=', $doctorId);
            $transferredQuery->whereDate('da.appointment_date', '=', $currentDate);
            $transferredQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_TRANSFERRED);
            $transferredQuery->whereNotNull('da.appointment_date');
            $transferredQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $transferredQuery->groupBy('da.appointment_category');

            $transferredAppointments = $transferredQuery->get();

            //$query1 = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query1);

            //DB::connection()->enableQueryLog();

            $cancelledQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $cancelledQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $cancelledQuery->where('da.doctor_id', '=', $doctorId);
            $cancelledQuery->whereDate('da.appointment_date', '=', $currentDate);
            $cancelledQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_CANCELLED);
            $cancelledQuery->whereNotNull('da.appointment_date');
            $cancelledQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $cancelledQuery->groupBy('da.appointment_category');

            $cancelledAppointments = $cancelledQuery->get();

            //$query1 = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query1);
            //dd($cancelledAppointments);


            $postponedQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $postponedQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            $postponedQuery->where('da.doctor_id', '=', $doctorId);
            $postponedQuery->whereDate('da.appointment_date', '=', $currentDate);
            $postponedQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_POSTPONED);
            $postponedQuery->whereNotNull('da.appointment_date');
            $postponedQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $postponedQuery->groupBy('da.appointment_category');

            $postponedAppointments = $postponedQuery->get();

            //$query1 = DB::getQueryLog();
            //dd($query1);

            $dashBoardQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $dashBoardQuery->where('da.doctor_id', '=', $doctorId);
            $dashBoardQuery->whereDate('da.appointment_date', '=', $currentDate);
            $dashBoardQuery->where(function ($dashBoardQuery) {
                $dashBoardQuery->where('da.appointment_time', '>=', '07:00:00');
                $dashBoardQuery->where('da.appointment_time', '<=', '19:00:00');
            });

            $dashBoardQuery->select(DB::raw("SUM(da.fee) as appAmount"));
            //dd($dashBoardQuery->toSql());
            $appFees = $dashBoardQuery->get();
            $appTotalFees = $appFees[0]->appAmount;

            //dd($totalFees);

            /*$hospitalQuery->join('hospital as h', function($join) {
                $join->on('h.hospital_id', '=', 'users.id');
                $join->on('h.hospital_id', '=', DB::raw('?'));
            })->setBindings(array_merge($doctorQuery->getBindings(), array($hospitalId)));*/

            $bloodExamQuery = DB::table('patient_blood_examination as pbe')->where('pbe.hospital_id', '=', $hospitalId);
            $bloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $bloodExamQuery->where('pbe.doctor_id', '=', $doctorId);
            $bloodExamQuery->whereDate('pbe.created_at', '=', $currentDate);
            $bloodExamQuery->where(function ($bloodExamQuery) {
                $bloodExamQuery->where(DB::raw('TIME(pbe.created_at)'), '>=', '07:00:00');
                $bloodExamQuery->where(DB::raw('TIME(pbe.created_at)'), '<=', '19:00:00');
            });

            $bloodExamQuery->select(DB::raw("SUM(pbei.fees) as bloodTestAmount"));
            //dd($bloodExamQuery->toSql());

            $bloodTestFees = $bloodExamQuery->get();
            $bloodTotalFees = $bloodTestFees[0]->bloodTestAmount;
            //dd($bloodTestFees);

            $motionExamQuery = DB::table('patient_motion_examination as pme')->where('pme.hospital_id', '=', $hospitalId);
            $motionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $motionExamQuery->where('pme.doctor_id', '=', $doctorId);
            $motionExamQuery->whereDate('pme.created_at', '=', $currentDate);
            $motionExamQuery->where(function ($motionExamQuery) {
                $motionExamQuery->where(DB::raw('TIME(pme.created_at)'), '>=', '07:00:00');
                $motionExamQuery->where(DB::raw('TIME(pme.created_at)'), '<=', '19:00:00');
            });

            $motionExamQuery->select(DB::raw("SUM(pmei.fees) as motionTestAmount"));
            //dd($bloodExamQuery->toSql());
            $motionTestFees = $motionExamQuery->get();
            $motionTotalFees = $motionTestFees[0]->motionTestAmount;


            $urineExamQuery = DB::table('patient_urine_examination as pue')->where('pue.hospital_id', '=', $hospitalId);
            $urineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $urineExamQuery->where('pue.doctor_id', '=', $doctorId);
            $urineExamQuery->whereDate('pue.created_at', '=', $currentDate);
            $urineExamQuery->where(function ($urineExamQuery) {
                $urineExamQuery->where(DB::raw('TIME(pue.created_at)'), '>=', '07:00:00');
                $urineExamQuery->where(DB::raw('TIME(pue.created_at)'), '<=', '19:00:00');
            });

            $urineExamQuery->select(DB::raw("SUM(puei.fees) as urineTestAmount"));
            //dd($bloodExamQuery->toSql());
            $urineTestFees = $urineExamQuery->get();
            $urineTotalFees = $urineTestFees[0]->urineTestAmount;

            $scanExamQuery = DB::table('patient_scan as ps')->where('ps.hospital_id', '=', $hospitalId);
            $scanExamQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
            $scanExamQuery->where('ps.doctor_id', '=', $doctorId);
            $scanExamQuery->whereDate('ps.created_at', '=', $currentDate);
            $scanExamQuery->where(function ($scanExamQuery) {
                $scanExamQuery->where(DB::raw('TIME(ps.created_at)'), '>=', '07:00:00');
                $scanExamQuery->where(DB::raw('TIME(ps.created_at)'), '<=', '19:00:00');
            });

            $scanExamQuery->select(DB::raw("SUM(psi.fees) as scanTestAmount"));

            $scanTestFees = $scanExamQuery->get();
            $scanTotalFees = $scanTestFees[0]->scanTestAmount;

            $ultraSoundExamQuery = DB::table('patient_ultra_sound as pus')->where('pus.hospital_id', '=', $hospitalId);
            $ultraSoundExamQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
            $ultraSoundExamQuery->where('pus.doctor_id', '=', $doctorId);
            $ultraSoundExamQuery->whereDate('pus.created_at', '=', $currentDate);
            $ultraSoundExamQuery->where(function ($ultraSoundExamQuery) {
                $ultraSoundExamQuery->where(DB::raw('TIME(pus.created_at)'), '>=', '07:00:00');
                $ultraSoundExamQuery->where(DB::raw('TIME(pus.created_at)'), '<=', '19:00:00');
            });

            $ultraSoundExamQuery->select(DB::raw("SUM(pusi.fees) as ultraSoundTestAmount"));

            $ultraSoundTestFees = $ultraSoundExamQuery->get();
            $ultraSoundTotalFees = $ultraSoundTestFees[0]->ultraSoundTestAmount;

            $dentalExamQuery = DB::table('patient_dental_examination_item as pdei');
            $dentalExamQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $dentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            $dentalExamQuery->where('pde.doctor_id', '=', $doctorId);
            $dentalExamQuery->whereDate('pdei.created_at', '=', $currentDate);
            $dentalExamQuery->where(function ($dentalExamQuery) {
                $dentalExamQuery->where(DB::raw('TIME(pdei.created_at)'), '>=', '07:00:00');
                $dentalExamQuery->where(DB::raw('TIME(pdei.created_at)'), '<=', '19:00:00');
            });

            $dentalExamQuery->select(DB::raw("SUM(pdei.fees) as dentalTestAmount"));

            $dentalTestFees = $dentalExamQuery->get();
            $dentalTotalFees = $dentalTestFees[0]->dentalTestAmount;

            $xrayExamQuery = DB::table('patient_xray_examination_item as pxei');
            $xrayExamQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $xrayExamQuery->where('pxe.hospital_id', '=', $hospitalId);
            $xrayExamQuery->where('pxe.doctor_id', '=', $doctorId);
            $xrayExamQuery->whereDate('pxei.created_at', '=', $currentDate);
            $xrayExamQuery->where(function ($xrayExamQuery) {
                $xrayExamQuery->where(DB::raw('TIME(pxei.created_at)'), '>=', '07:00:00');
                $xrayExamQuery->where(DB::raw('TIME(pxei.created_at)'), '<=', '19:00:00');
            });

            $xrayExamQuery->select(DB::raw("SUM(pxei.fees) as xrayTestAmount"));

            $xRayFees = $xrayExamQuery->get();
            $xRayTotalFees = $xRayFees[0]->xrayTestAmount;

            //$query = DB::getQueryLog();
            //dd($query);

            /*SELECT * FROM doctor_appointment da
            WHERE da.`hospital_id` = 1
            AND DATE(da.`created_at`) = '2017-07-13'
            AND TIME(da.`created_at`) >= '07:00:00'
            AND TIME(da.`created_at`) <= '19:00:00'
            */

            $totalAmount = $appTotalFees + $bloodTotalFees + $motionTotalFees + $urineTotalFees + $scanTotalFees + $ultraSoundTotalFees + $dentalTotalFees + $xRayTotalFees;
            $labAmount = $bloodTotalFees + $motionTotalFees + $urineTotalFees + $scanTotalFees + $ultraSoundTotalFees + $dentalTotalFees + $xRayTotalFees;
            $appTotalFees = $appTotalFees + 0;


            /*$dashboardDetails["appointmentCategory"] = $appointments;
            $dashboardDetails["totalAmountCollected"] = $totalAmount;
            $dashboardDetails["totalLabFees"] = $labAmount;
            $dashboardDetails["consultingFees"] = $appTotalFees;*/

            $dashboardDetails["openAppointments"] = $openAppointments;
            $dashboardDetails["visitedAppointments"] = $visitedAppointments;
            $dashboardDetails["transferredAppointments"] = $transferredAppointments;
            $dashboardDetails["cancelledAppointments"] = $cancelledAppointments;
            $dashboardDetails["postponedAppointments"] = $postponedAppointments;
            $dashboardDetails["totalAmountCollected"] = $totalAmount;
            $dashboardDetails["totalLabFees"] = $labAmount;
            $dashboardDetails["consultingFees"] = $appTotalFees;

            //dd($dashboardDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $ex);
        }

        return $dashboardDetails;
    }

    /**
     * Get future appointment count for the hospital and doctor
     * @param $fromDate , $toDate, $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFutureAppointmentsForDashboard($fromDate, $toDate, $hospitalId, $doctorId = null)
    {
        $appointments = null;
        $totalAmount = null;
        $futureAppointments = null;
        $currentDateTime = null;

        $openAppointments = null;
        //$visitedAppointments = null;
        $transferredAppointments = null;
        $cancelledAppointments = null;
        $isFromDate = false;
        //$postponedAppointments = null;

        try {
            $currentDate = date("Y-m-d");
            //dd($fromDate);

            //$currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            //$date =

            //dd(date("Y-m-d H:i:s"));
            //dd($fromDate);
            //dd($currentDate);

            if($fromDate == $currentDate)
            {
                $isFromDate = true;
                $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            }

            if (is_null($fromDate) || empty($fromDate)) {
                //$query->where('da.doctor_id', '=', $doctorId);
                $isFromDate = true;
                $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            }

            //dd($currentDateTime);

            //DB::connection()->enableQueryLog();
            //dd($currentDate);
            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            if (!is_null($doctorId)) {
                $query->where('da.doctor_id', '=', $doctorId);
            }
            //dd($currentDateTime);
            //$query->whereDate('da.appointment_date', '>=', $fromDate);
            //$query->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>', $fromDate);
            //$query->whereDate('da.appointment_date', '<=', $toDate);
            //AND TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, '%H:%i:%s')) > NOW()
            //if((is_null($fromDate) || empty($fromDate)) && !is_null($currentDateTime))
            if($isFromDate)
            {
                //$query->whereDate(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
                $query->where(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
            }
            else
            {
                $query->where(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>', $fromDate);
            }

            $query->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '<=', $toDate);
            $query->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_OPEN);
            $query->whereNotNull('da.appointment_date');
            $query->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            //$query->select('da.*');
            $query->groupBy('da.appointment_category');

            //dd($query->toSql());

            //DB::connection()->enableQueryLog();
            //$appointments = $query->get();
            //$query = DB::getQueryLog();
            //$lastQuery = end($query);
            //dd($query);

            //dd($query->toSql());

            $openAppointments = $query->get();
            //$query = DB::getQueryLog();
            //dd($query);
            //dd($openAppointments);


            $transferredQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $transferredQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            if (!is_null($doctorId)) {
                $transferredQuery->where('da.doctor_id', '=', $doctorId);
            }
            //$transferredQuery->whereDate('da.appointment_date', '>=', $fromDate);
            //$transferredQuery->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>=', $fromDate);
            if($isFromDate)
            {
                //$query->whereDate(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
                $query->where(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
            }
            else
            {
                $query->where(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>', $fromDate);
            }
            //$transferredQuery->whereDate('da.appointment_date', '<=', $toDate);
            $transferredQuery->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '<=', $toDate);
            $transferredQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_TRANSFERRED);
            $transferredQuery->whereNotNull('da.appointment_date');
            $transferredQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $transferredQuery->groupBy('da.appointment_category');

            $transferredAppointments = $transferredQuery->get();

            //DB::connection()->enableQueryLog();

            $cancelledQuery = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $cancelledQuery->join('appointment_status as aps', 'aps.id', '=', 'da.appointment_status_id');
            if (!is_null($doctorId)) {
                $cancelledQuery->where('da.doctor_id', '=', $doctorId);
            }
            //$cancelledQuery->whereDate('da.appointment_date', '>=', $fromDate);
            //$cancelledQuery->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>=', $fromDate);
            if($isFromDate)
            {
                //$query->whereDate(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
                $query->where(DB::raw('TIMESTAMP(DATE_FORMAT(da.appointment_date, "%Y-%m-%d"), TIME_FORMAT(da.appointment_time, "%H:%i:%s"))'), '>', $currentDateTime);
            }
            else
            {
                $query->where(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '>', $fromDate);
            }
            //$cancelledQuery->whereDate('da.appointment_date', '<=', $toDate);
            $cancelledQuery->whereDate(DB::raw('DATE_FORMAT(da.appointment_date, "%Y-%m-%d")'), '<=', $toDate);
            $cancelledQuery->where('da.appointment_status_id', '=', AppointmentType::APPOINTMENT_CANCELLED);
            $cancelledQuery->whereNotNull('da.appointment_date');
            $cancelledQuery->select(DB::raw("COUNT(*) as noAppointments"), 'da.appointment_category');
            $cancelledQuery->groupBy('da.appointment_category');

            $cancelledAppointments = $cancelledQuery->get();

            $futureAppointments["openAppointments"] = $openAppointments;
            $futureAppointments["transferredAppointments"] = $transferredAppointments;
            $futureAppointments["cancelledAppointments"] = $cancelledAppointments;

            //dd($dashboardDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_COUNT_ERROR, $ex);
        }

        //dd($futureAppointments);
        return $futureAppointments;
    }

    /**
     * Get patients by appointment category
     * @param $hospitalId , $categoryType
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByAppointmentCategory($hospitalId, $categoryType, $doctorId = null)
    {
        $patients = null;
        //dd($doctorId);
        try {
            //DB::connection()->enableQueryLog();

            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            if ($categoryType != "") {
                $query->where('da.appointment_category', '=', $categoryType);
            }
            /*else
            {
                $query->where('da.appointment_date', '=', date('Y-m-d'));
            }*/
            if (!is_null($doctorId)) {
                $query->where('da.doctor_id', '=', $doctorId);
            }
            $query->where('da.appointment_date', '=', date('Y-m-d'));
            $query->whereIn('da.appointment_status_id', [AppointmentType::APPOINTMENT_OPEN, AppointmentType::APPOINTMENT_TRANSFERRED]);
            $query->orderBy('da.appointment_date', '=', 'DESC');
            $query->select('p.patient_id', 'p.name as name', 'p.address', 'p.pid', 'p.telephone', 'p.email', 'p.relationship',
                'da.id', 'da.id as appointment_id', 'da.appointment_category', 'da.appointment_date', 'da.appointment_time');

            //dd($query->toSql());

            $patients = $query->get();

            //$query1 = DB::getQueryLog();
            //dd($query1);
            //dd($patients);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR, $ex);
        }

        return $patients;
    }

    /**
     * Get patients by appointment date
     * @param $hospitalId , $doctorId, $appointmentDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByAppointmentDate($hospitalId, $doctorId, $appointmentDate)
    {
        $patients = null;
        //dd($doctorId);
        try {
            //DB::connection()->enableQueryLog();

            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('users as usr', 'usr.id', '=', 'p.patient_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('da.doctor_id', '=', $doctorId);
            $query->where('da.appointment_date', '=', $appointmentDate);
            $query->select('p.patient_id', 'p.name as name', 'p.address', 'p.pid', 'p.telephone', 'p.email', 'p.relationship',
                'da.id', 'da.id as appointment_id', 'da.appointment_category', 'da.appointment_date', 'da.appointment_time');

            //dd($query->toSql());

            $patients = $query->get();

            //$query1 = DB::getQueryLog();
            //dd($query1);
            //dd($patients);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $ex);
        }

        return $patients;
    }

    /**
     * Get patient appointment dates by hospital
     * @param $hospitalId , $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointmentDates($patientId, $hospitalId)
    {
        $appointmentDates = null;

        try {
            $query = DB::table('doctor_appointment as da')->where('da.hospital_id', '=', $hospitalId);
            $query->where('da.patient_id', '=', $patientId);
            $query->select('da.patient_id', 'da.appointment_date');

            $appointmentDates = $query->get();
            //dd($patients);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_DATES_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_DATES_ERROR, $ex);
        }

        return $appointmentDates;
    }

    /**
     * Get patient appointments by hospital
     * @param $patientId , $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointmentsByHospital($patientId, $hospitalId)
    {
        $appointments = null;


        try {
            $query = DB::table('doctor_appointment as da')->join('hospital as h', 'h.hospital_id', '=', 'da.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'da.patient_id');
            $query->join('doctor as d', 'd.doctor_id', '=', 'da.doctor_id');
            $query->join('hospital_doctor as hd', 'hd.doctor_id', '=', 'da.doctor_id');
            $query->where('hd.hospital_id', $hospitalId);
            $query->where('da.patient_id', $patientId);
            $query->select('p.id', 'p.patient_id', 'p.pid', 'p.name as patient_name', 'h.hospital_id', 'h.hospital_name',
                'd.doctor_id', 'd.name', 'da.id as appointment_id', 'da.appointment_date', 'da.appointment_time', 'da.brief_history as notes');

            //
            $appointments = $query->paginate();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINTMENT_LIST_ERROR, $ex);
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
        $appointments = null;
        $appointmentDetails = null;

        try {
            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.pid',
                'p.telephone', 'p.email');
            $patientQuery->join('doctor_appointment as da', 'da.patient_id', '=', 'p.patient_id');
            $patientQuery->where('da.id', '=', $appointmentId);
            $patientDetails = $patientQuery->get();

            $doctorQuery = DB::table('doctor as d')->select('d.id', 'd.doctor_id', 'd.name', 'd.did', 'd.telephone', 'd.email');
            $doctorQuery->join('doctor_appointment as da', 'da.doctor_id', '=', 'd.doctor_id');
            $doctorQuery->where('da.id', '=', $appointmentId);
            $doctorDetails = $doctorQuery->get();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.hid', 'h.telephone', 'h.email');
            $hospitalQuery->join('doctor_appointment as da', 'da.hospital_id', '=', 'h.hospital_id');
            $hospitalQuery->where('da.id', '=', $appointmentId);
            $hospitalDetails = $hospitalQuery->get();

            $query = DB::table('doctor_appointment as da')->join('hospital as h', 'h.hospital_id', '=', 'da.hospital_id');
            $query->where('da.id', $appointmentId);
            $query->select('da.appointment_category', 'da.appointment_date', 'da.appointment_time',
                'da.brief_history as notes', 'da.fee', 'da.referral_type', 'da.referral_doctor',
                'da.referral_hospital', 'da.referral_hospital_location');

            //
            $appointments = $query->get();

            $appointmentDetails["patientProfile"] = $patientDetails;
            $appointmentDetails["doctorProfile"] = $doctorDetails;
            $appointmentDetails["hospitalProfile"] = $hospitalDetails;
            $appointmentDetails["appointmentDetails"] = $appointments;
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINT_DETAILS_ERROR, $queryEx);
        } catch (Exception $ex) {
            throw new HospitalException(null, ErrorEnum::PATIENT_APPOINT_DETAILS_ERROR, $ex);
        }

        //dd($appointmentDetails);
        return $appointmentDetails;
    }


    /**
     * Save patient profile
     * @param $patientProfileVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveNewPatientProfile(PatientProfileViewModel $patientProfileVM)
    {
        $status = true;
        $user = null;
        $patientId = null;
        $patient = null;
        $hospitalPatient = null;
        $hospitalId = null;

        try {
            $patientId = $patientProfileVM->getPatientId();
            $hospitalId = $patientProfileVM->getHospitalId();
            //dd($patientId);

            if ($patientId == 0) {
                $user = $this->registerNewPatient($patientProfileVM);
                $this->attachPatientRole($user);
                $patient = new Patient();
            } else {
                $patient = Patient::where('patient_id', '=', $patientId)->first();
                if (!is_null($patient)) {
                    //$user = User::find($companyId);
                    $user = $this->registerNewPatient($patientProfileVM);
                }
            }

            $patient->name = $patientProfileVM->getName();
            $patient->address = $patientProfileVM->getAddress();
            $patient->city = $patientProfileVM->getCity();
            $patient->country = $patientProfileVM->getCountry();
            /*Generated For BikKina Specific request*/
            $pid = $this->generatePID($hospitalId);
            $patient->pid = 'PID'.date('Ym') . $pid;
            //$patient->pid = 'PID'.md5(uniqid(rand()));
            $patient->telephone = $patientProfileVM->getTelephone();
            $patient->email = $patientProfileVM->getEmail();
            $patient->patient_photo = $patientProfileVM->getPatientPhoto();
            $patient->dob = $patientProfileVM->getDob();
            $patient->age = $patientProfileVM->getPlaceOfBirth();
            $patient->nationality = $patientProfileVM->getNationality();
            $patient->gender = $patientProfileVM->getGender();
            $patient->married = $patientProfileVM->getMaritalStatus();

            $patient->created_by = $patientProfileVM->getCreatedBy();
            $patient->created_at = $patientProfileVM->getCreatedAt();
            $patient->updated_by = $patientProfileVM->getUpdatedBy();
            $patient->updated_at = $patientProfileVM->getUpdatedAt();

            $user->patient()->save($patient);

            $user->patienthospitals()->attach($hospitalId, array('created_by' => $patientProfileVM->getCreatedBy(),
                'updated_by' => $patientProfileVM->getUpdatedBy()));
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Save patient profile
     * @param $patientProfileVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientProfile(PatientProfileViewModel $patientProfileVM)
    {
        //dd('Inside save profile');
        $status = true;
        $user = null;
        $patientId = null;
        $patient = null;
        $hospitalPatient = null;
        $hospitalId = null;
        $doctorId = null;

        $patientUserId = null;
        $appointmentDate=null;
        $patientTokenId=null;

        try {
            $patientId = $patientProfileVM->getPatientId();
            $hospitalId = $patientProfileVM->getHospitalId();
            $doctorId = $patientProfileVM->getDoctorId();
            $appointmentDate=$patientProfileVM->getAppointmentDate();
            //dd($appointmentDate);

            $hospitalUser = User::find($hospitalId);

            if (is_null($hospitalUser)) {
                $status = false;
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND);
            }

            /*$doctorQuery = User::query();
            $doctorQuery->join('doctor as d', 'd.doctor_id', '=', 'users.id');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);
            $doctorQuery->where('users.delete_status', '=', 1);
            $doctorUser = $doctorQuery->first();*/

            $doctorQuery = User::where('id', '=', $doctorId)->where('delete_status', '=', 1);
            /*$doctorQuery->join('doctor as d', 'd.doctor_id', '=', 'users.id');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);
            $doctorQuery->where('users.delete_status', '=', 1);*/
            $doctorUser = $doctorQuery->first();
            //dd($doctorUser);
            //BY PARASANTH START 24-01-2018 //

            $patientTokenQuery = DB::table('doctor_appointment as dp');
            $patientTokenQuery->where('dp.hospital_id', '=', $hospitalId)->where('dp.doctor_id', '=', $doctorId)->where('appointment_date','=',$appointmentDate);
            $patientTokenQuery->select(DB::raw('count(token_id) as token_count'))->get();
            $patientToken = $patientTokenQuery->first();
            $patientTokenId = $patientToken->token_count;

           //dd($patientTokenId->token_count);
            //BY PARASANTH END 24-01-2018 //

            if (is_null($doctorUser)) {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }
            //dd($patientId);

            if ($patientId == 0) {
                $user = $this->registerNewPatient($patientProfileVM);
                $this->attachPatientRole($user);
                $patient = new Patient();

                $pid = $this->generateRandomString();
                $patient->pid = 'PID' . $pid;
                //$patient->pid = 'PID'.crc32(uniqid(rand()));
                $patient->email = $patientProfileVM->getEmail();

                $patientUserId = $user->id;

                $patient->name = $patientProfileVM->getName();
                $patient->address = $patientProfileVM->getAddress();
                $patient->occupation = $patientProfileVM->getOccupation();
                $patient->careof = $patientProfileVM->getCareOf();
                $patient->city = $patientProfileVM->getCity();
                $patient->country = $patientProfileVM->getCountry();
                $patient->telephone = $patientProfileVM->getTelephone();
                $patient->relationship = $patientProfileVM->getRelationship();
                $patient->patient_spouse_name = $patientProfileVM->getSpouseName();
                $patient->patient_photo = $patientProfileVM->getPatientPhoto();
                $patient->payment_status = $patientProfileVM->getPaymentStatus();
                $patient->dob = $patientProfileVM->getDob();
                $patient->age = $patientProfileVM->getAge();
                $patient->nationality = $patientProfileVM->getNationality();
                $patient->gender = $patientProfileVM->getGender();
                $patient->married = $patientProfileVM->getMaritalStatus();

                $patient->created_by = $patientProfileVM->getCreatedBy();
                $patient->created_at = $patientProfileVM->getCreatedAt();
                $patient->updated_by = $patientProfileVM->getUpdatedBy();
                $patient->updated_at = $patientProfileVM->getUpdatedAt();

                $user->patient()->save($patient);

                $user->patienthospitals()->attach($hospitalId, array('created_by' => $patientProfileVM->getCreatedBy(),
                    'updated_by' => $patientProfileVM->getUpdatedBy()));

                /*if($patientId == 0)
                {
                    $user->patienthospitals()->attach($hospitalId, array('created_by' => $patientProfileVM->getCreatedBy(),
                        'updated_by' => $patientProfileVM->getUpdatedBy()));
                }*/
            } else {
                $patient = Patient::where('patient_id', '=', $patientId)->first();
                $patientUserId = $patient->patient_id;

                if (is_null($patient)) {
                    $status = false;
                    throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND);
                }
                //dd($patient);
                /*if(!is_null($patient))
                {
                    $user = User::find($patientUserId);
                    //$user = $this->registerNewPatient($patientProfileVM);
                }
                else
                {
                    $status = false;
                    throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND);
                }*/
            }
           //BY PARASANTH START 24-01-2018 //
            $this->savePatientAppointment($patientProfileVM, $doctorUser, $patientUserId);

            //BY PARASANTH END 24-01-2018//

            /*if (!is_null($doctorUser) && !is_null($hospitalUser))
            {
                $this->savePatientAppointment($patientProfileVM, $doctorUser, $patientUserId);
            }*/

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $exc);
        }

        return $status;
        //return $patient;
    }

    /**
     * Edit patient profile
     * @param $patientProfileVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function editPatientProfile(PatientProfileViewModel $patientProfileVM)
    {
        //dd('Inside save profile');
        $status = true;
        $user = null;
        $patientId = null;
        $patient = null;
        $patientUser = null;

        $patientUserId = null;

        try {
            $patientId = $patientProfileVM->getPatientId();
            //$hospitalId = $patientProfileVM->getHospitalId();
            //$doctorId = $patientProfileVM->getDoctorId();

            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                $status = false;
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_EXIST);
            } else {
                $patientUser->email = $patientProfileVM->getEmail();
                $patientUser->save();
            }

            $patient = Patient::where('patient_id', '=', $patientId)->first();

            if (!is_null($patient)) {
                $patient->name = $patientProfileVM->getName();
                $patient->address = $patientProfileVM->getAddress();
                $patient->careof = $patientProfileVM->getCareOf();
                $patient->city = $patientProfileVM->getCity();
                $patient->country = $patientProfileVM->getCountry();
                $patient->telephone = $patientProfileVM->getTelephone();
                $patient->email = $patientProfileVM->getEmail();
                $patient->relationship = $patientProfileVM->getRelationship();
                $patient->patient_spouse_name = $patientProfileVM->getSpouseName();
                $patient->patient_photo = $patientProfileVM->getPatientPhoto();
                $patient->dob = $patientProfileVM->getDob();
                $patient->age = $patientProfileVM->getAge();
                $patient->nationality = $patientProfileVM->getNationality();
                $patient->gender = $patientProfileVM->getGender();
                $patient->married = $patientProfileVM->getMaritalStatus();

                $patient->created_by = $patientProfileVM->getCreatedBy();
                $patient->created_at = $patientProfileVM->getCreatedAt();
                $patient->updated_by = $patientProfileVM->getUpdatedBy();
                $patient->updated_at = $patientProfileVM->getUpdatedAt();

                $patient->save();
            }
            //$user->patient()->save($patient);

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PROFILE_SAVE_ERROR, $exc);
        }

        return $status;
        //return $patient;
    }

    private function savePatientAppointment(PatientProfileViewModel $patientProfileVM, User $doctorUser, $patientUserId)
    {
        //$appointments = $patientProfileVM->getAppointment();
        //dd($doctorUser);

        $appointmentStatus = AppointmentType::APPOINTMENT_OPEN;
        $doctorAppointment = new DoctorAppointments();

        $doctorAppointment->patient_id = $patientUserId;
        $doctorAppointment->hospital_id = $patientProfileVM->getHospitalId();
        $doctorAppointment->brief_history = $patientProfileVM->getBriefHistory();
        $doctorAppointment->appointment_date = $patientProfileVM->getAppointmentDate();
        $doctorAppointment->appointment_time = $patientProfileVM->getAppointmentTime();
        $doctorAppointment->appointment_category = $patientProfileVM->getAppointmentCategory();
        $doctorAppointment->appointment_status_id = $appointmentStatus;
        //BY PRASANTH 24-01-2018 START//
        //we are adding+1 for existing count value for display current TokenID
       // $patientTokenId=intval($patientTokenId)+1;


        $patientTokenId = $this->generateTokenId($patientProfileVM->getHospitalId(), $doctorUser->id, $patientProfileVM->getAppointmentDate());
        //dd($patientTokenId);
        //$patientTokenId=intval($patientTokenId)+1;
        $doctorAppointment->token_id = $patientTokenId;
        //BY PRASANTH 24-01-2018 END//
        $doctorAppointment->referral_type = $patientProfileVM->getReferralType();
        $doctorAppointment->referral_doctor = $patientProfileVM->getReferralDoctor();
        $doctorAppointment->referral_hospital = $patientProfileVM->getReferralHospital();
        $doctorAppointment->referral_hospital_location = $patientProfileVM->getHospitalLocation();
        $doctorAppointment->fee = $patientProfileVM->getAmount();
        $doctorAppointment->payment_type = $patientProfileVM->getPaymentType();
        //$doctorAppointment->doctor_id = $doctorUser->doctor_id;
        /*$doctorAppointment->brief_history = $appointment->briefHistory;
        $doctorAppointment->appointment_date = $appointment->appointmentDate;
        $doctorAppointment->appointment_time = $appointment->appointmentTime;
        $doctorAppointment->appointment_category = $appointment->appointmentCategory;
        $doctorAppointment->referral_doctor = $appointment->referralDoctor;
        $doctorAppointment->referral_hospital = $appointment->referralHospital;
        $doctorAppointment->referral_hospital_location = $appointment->hospitalLocation;*/
        $doctorAppointment->created_by = $patientProfileVM->getCreatedBy();
        $doctorAppointment->modified_by = $patientProfileVM->getUpdatedBy();
        $doctorAppointment->created_at = $patientProfileVM->getCreatedAt();
        $doctorAppointment->updated_at = $patientProfileVM->getUpdatedAt();

        $doctorUser->appointments()->save($doctorAppointment);
        //$doctorAppointment->save();

        /*foreach($appointments as $appointment)
        {
            $doctorAppointment = new DoctorAppointments();
            $doctorAppointment->patient_id = $patientUserId;
            $doctorAppointment->hospital_id = $patientProfileVM->getHospitalId();
            $doctorAppointment->doctor_id = $doctorUser->doctor_id;
            $doctorAppointment->brief_history = $appointment->briefHistory;
            $doctorAppointment->appointment_date = $appointment->appointmentDate;
            $doctorAppointment->appointment_time = $appointment->appointmentTime;
            $doctorAppointment->appointment_category = $appointment->appointmentCategory;
            $doctorAppointment->referral_doctor = $appointment->referralDoctor;
            $doctorAppointment->referral_hospital = $appointment->referralHospital;
            $doctorAppointment->referral_hospital_location = $appointment->hospitalLocation;
            $doctorAppointment->created_by = $patientProfileVM->getCreatedBy();
            $doctorAppointment->modified_by = $patientProfileVM->getUpdatedBy();
            $doctorAppointment->created_at = $patientProfileVM->getCreatedAt();
            $doctorAppointment->updated_at = $patientProfileVM->getUpdatedAt();

            //$doctorUser->appointments()->save($doctorAppointment);
            $doctorAppointment->save();
        }*/

    }

    private function generateTokenId($hospitalId, $doctorId, $appointmentDate)
    {
        //$defaultTokenId = trans('constants.token_id');
        $defaultTokenId = CA::get('constants.token_id');
        //$maxVal = 0;

        /*$maxId = DB::table('doctor_appointment')->max('token_id');*/

        $maxId = DoctorAppointments::where('hospital_id', '=', $hospitalId)
            ->where('doctor_id', '=', $doctorId)
            ->where('appointment_date','=',$appointmentDate)->max('token_id');

        //dd($maxId);

        //$maxVal = $maxId + 1;

        //dd($maxId);

        /*$patientTokenQuery = DB::table('doctor_appointment as da');
        $patientTokenQuery->where('da.hospital_id', '=', $hospitalId)->where('da.doctor_id', '=', $doctorId)
            ->where('appointment_date','=',$appointmentDate);
        $patientTokenQuery->select(DB::raw('count(token_id) as token_count'))->get();
        $patientToken = $patientTokenQuery->first();
        $patientTokenId = $patientToken->token_count;*/

        if($maxId == 0 || $maxId == "")
        {
            //$maxVal = intval($defaultValue);
            $maxVal = $defaultTokenId;
        }
        else
        {
            $maxVal = $maxId + 1;
        }

        return $maxVal;
    }

    /**
     * Check if a patient is a new patient or follow up patient
     * @param $hospitalId , $doctorId, $patientId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function checkIsNewPatient($hospitalId, $doctorId, $patientId)
    {
        $isNewPatient = 'true';

        try {
            $doctorUser = User::find($doctorId);
            $hospitalUser = User::find($hospitalId);
            $patientUser = User::find($patientId);

            if (!is_null($doctorUser) && !is_null($hospitalUser) && !is_null($patientUser)) {
                $query = DB::table('patient_prescription as pp')->where('patient_id', '=', $patientId);
                $query->where('hospital_id', '=', $hospitalId);
                $query->where('doctor_id', '=', $doctorId);

                //dd($query->toSql());
                $count = $query->count();

                if ($count > 0) {
                    $isNewPatient = 'false';
                }
            } else {
                $isNewPatient = 'false';
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::NEW_PATIENT_ERROR, $queryEx);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::NEW_PATIENT_ERROR, $exc);
        }

        return $isNewPatient;
    }

    private function registerNewPatient(PatientProfileViewModel $patientProfileVM)
    {
        $user = null;
        $patientId = $patientProfileVM->getPatientId();

        if ($patientId == 0) {
            $user = new User();
        } else {
            $user = User::find($patientId);
        }

        $user->name = $patientProfileVM->getName();
        $user->email = $patientProfileVM->getEmail();
        $user->password = bcrypt($patientProfileVM->getName());
        $user->delete_status = 1;
        $user->created_at = $patientProfileVM->getCreatedAt();
        $user->updated_at = $patientProfileVM->getUpdatedAt();

        $user->save();

        return $user;
    }

    private function attachPatientRole(User $user)
    {
        $role = Role::find(UserType::USERTYPE_PATIENT);

        if (!is_null($role)) {
            $user->attachRole($role);
        }
    }

    /**
     * Save labtests for the patient
     * @param $patientLabTestVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientLabTests(PatientLabTestViewModel $patientLabTestVM)
    {
        $status = true;
        $patientLabTests = null;

        try {
            $doctorId = $patientLabTestVM->getDoctorId();
            $patientId = $patientLabTestVM->getPatientId();
            $hospitalId = $patientLabTestVM->getHospitalId();

            $doctorUser = User::find($doctorId);
            $hospitalUser = User::find($hospitalId);
            $patientUser = User::find($patientId);

            if (!is_null($doctorUser) && !is_null($hospitalUser) && !is_null($patientUser)) {
                $patientLabTests = new PatientLabTests();
                $patientLabTests->hospital_id = $hospitalId;
                $patientLabTests->doctor_id = $doctorId;
                //$patientLabTests->unique_id = "LTID".time();

                $patientLabTests->unique_id = 'LTID' . crc32(uniqid(rand()));
                $patientLabTests->brief_description = $patientLabTestVM->getDescription();
                $patientLabTests->labtest_date = $patientLabTestVM->getLabTestDate();
                $patientLabTests->created_by = 'Admin';
                $patientLabTests->modified_by = 'Admin';
                $patientUser->labtests()->save($patientLabTests);
            }

            $this->saveLabTestDetails($patientLabTests, $patientLabTestVM);
        } catch (QueryException $queryEx) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::LABTESTS_DETAILS_SAVE_ERROR, $queryEx);
        } catch (Exception $exc) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::LABTESTS_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    private function saveLabTestDetails($patientLabTests, PatientLabTestViewModel $patientLabTestVM)
    {
        $labTests = $patientLabTestVM->getLabTestDetails();
        foreach ($labTests as $labTest) {
            $labTestDetails = new LabTestDetails();

            $labTestObj = (object)$labTest;
            $labTestDetails->labtest_id = $labTestObj->labtestId;
            $labTestDetails->brief_description = $labTestObj->description;
            $labTestDetails->created_by = 'Admin';
            $labTestDetails->modified_by = 'Admin';

            $patientLabTests->labtestdetails()->save($labTestDetails);
        }
    }

    /**
     * Get the hospital id for the given pharmacy or lab id
     * @param $userId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */
    public function getHospitalId($userTypeId, $userId)
    {
        $hospitalId = null;
        $query = null;

        try {
            if (UserType::USERTYPE_PHARMACY == $userTypeId) {
                //$hospitalId = DB::table('hospital_pharmacy as hp')->where('hp.pharmacy_id', $userId)->select('hp.hospital_id')->get();
                $query = DB::table('hospital_pharmacy as hp')->where('hp.pharmacy_id', $userId)->select('hp.hospital_id');
            } elseif (UserType::USERTYPE_LAB == $userTypeId) {
                //$hospitalId = DB::table('hospital_lab as hl')->where('hl.lab_id', $userId)->select('hl.hospital_id')->get();
                $query = DB::table('hospital_lab as hl')->where('hl.lab_id', $userId)->select('hl.hospital_id');
            } elseif (UserType::USERTYPE_DOCTOR == $userTypeId) {
                //$hospitalId = DB::table('hospital_lab as hl')->where('hl.lab_id', $userId)->select('hl.hospital_id')->get();
                $query = DB::table('hospital_doctor as hd')->where('hd.doctor_id', $userId)->select('hd.hospital_id');
            }

            //dd($query->toSql());
            $hospitalId = $query->get();

            //dd($hospitalId);

        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::HOSPITAL_ID_ERROR, $queryExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::HOSPITAL_ID_ERROR, $exc);
        }

        return $hospitalId;
    }

    public function test()
    {
        //dd('Inside test function in implementation');
    }


    public function getProfile($hospitalId)
    {
        $hospitalProfile = null;

        try {
            /*$pharmacyProfile = Pharmacy::where('pharmacy_id', '=', $pharmacyId)
                ->get(array('id', 'pharmacy_id', 'name', 'address', ''))->toArray();*/
            //$pharmacyProfile = Pharmacy::where('pharmacy_id', $pharmacyId)->get();

            $query = DB::table('hospital as h')->join('cities as c', 'c.id', '=', 'h.city');
            $query->join('countries as co', 'co.id', '=', 'h.country');
            $query->where('h.hospital_id', '=', $hospitalId);
            $query->select('h.id', 'h.hospital_id', 'h.hospital_name as hospital_name', 'h.address', 'c.id as city_id', 'c.city_name',
                'co.id as country_id', 'co.name as country_name', 'h.hid', 'h.telephone', 'h.email');

            //dd($query->toSql());
            $hospitalProfile = $query->get();
            //dd($pharmacyProfile);

            //dd($pharmacyProfile);
        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::PHARMACY_PROFILE_VIEW_ERROR, $queryExc);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PHARMACY_PROFILE_VIEW_ERROR, $exc);
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

        try {
            $query = DB::table('doctor as d');
            $query->join('users as usr', 'usr.id', '=', 'd.doctor_id');
            $query->join('hospital_doctor as hd', 'hd.doctor_id', '=', 'd.doctor_id');
            $query->where('usr.delete_status', '=', 1);
            $query->where('hd.hospital_id', '=', $hospitalId);

            if ($keyword != "") {
                $query->where('d.name', 'LIKE', '%' . $keyword . '%');
            }
            $query->select('d.doctor_id as doctorId', 'd.name as doctorName', 'd.specialty as department', 'd.designation',
                'hd.hospital_id as hospitalId');
            $query->orderBy('d.name', 'ASC');

            $doctors = $query->get();

            //ADDED BY PRASANTH 25-01-2018 START
            //for doctor token count for  in doctor dashboard we have added this piece of code
            $patientTokenQuery = DB::table('doctor_appointment as dp');
            $patientTokenQuery->where('dp.hospital_id', '=', $hospitalId);
            $patientTokenQuery->where('dp.appointment_date','=',Carbon::now()->format('Y-m-d'));
            $patientTokenQuery->select(DB::raw('count(token_id) as token_count,doctor_id'))->groupBy('dp.doctor_id');
            $patientTokenId=$patientTokenQuery->get();

            foreach ($doctors as $doctor){
                $tokencount=0;
                foreach ($patientTokenId as $patient){
                    if($patient->doctor_id==$doctor->doctorId){
                        $tokencount=$patient->token_count;
                    }
                }
                $doctor->token_count=$tokencount;
            }
            //ADDED BY PRASANTH 25-01-2018 END
            //dd($doctors);

        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND, $queryExc);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND, $exc);
        }

        return $doctors;
    }

    //Fee Receipts

    /**
     * Get list of fee receipts for the hospital and doctor
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFeeReceipts($hospitalId, $doctorId)
    {
        $feeReceipts = null;

        try {

            /*$hospitalQuery = User::query();
            $hospitalQuery->join('hospital as h', function($join) {
                $join->on('h.hospital_id', '=', 'users.id');
                $join->on('h.hospital_id', '=', DB::raw('?'));
            })->setBindings(array_merge($doctorQuery->getBindings(), array($hospitalId)));*/

            $doctorQuery = User::query();
            $doctorQuery->join('doctor as d', 'd.doctor_id', '=', 'users.id');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);

            $doctor = $doctorQuery->first();

            //dd($doctor->doctor_id);

            $hospitalQuery = User::query();
            $hospitalQuery->join('hospital as h', 'h.hospital_id', '=', 'users.id');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);

            //dd($hospitalQuery->toSql());
            $hospital = $hospitalQuery->first();

            if (is_null($doctor)) {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            if (is_null($hospital)) {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }

            if (!is_null($doctor) && !is_null($hospital)) {
                /*  $query = DB::table('fee_receipt as fr')->join('patient as p', 'p.patient_id', '=', 'fr.patient_id');
                  $query->join('doctor as d', 'd.doctor_id', '=', 'fr.doctor_id');
                  $query->where('fr.hospital_id', '=', $hospitalId);
                  $query->where('fr.doctor_id', '=', $doctorId);
                  $query->orderBy('fr.created_at', 'DESC');
                  $query->select('fr.id as receiptId', 'p.id as patientId', 'p.name as patientName', 'p.pid as PID',
                          'p.relationship','p.patient_spouse_name as spouseName',
                          'p.telephone as contactNumber', 'd.name as doctorName', 'fr.fee');

  */
                /*RAMAMA ADDED*/
                $query = DB::table('doctor_appointment as dp')->join('patient as p', 'p.patient_id', '=', 'dp.patient_id');
                $query->join('doctor as d', 'd.doctor_id', '=', 'dp.doctor_id');
                $query->where('dp.hospital_id', '=', $hospitalId);
                $query->where('dp.doctor_id', '=', $doctorId);
                $query->orderBy('dp.created_at', 'DESC');
                $query->select('dp.id as receiptId', 'p.patient_id as patientId', 'p.name as patientName', 'p.pid as PID',
                    'p.relationship', 'p.patient_spouse_name as spouseName',
                    'p.telephone as contactNumber', 'd.name as doctorName', 'dp.fee', 'dp.payment_type', 'p.payment_status','dp.doctor_id','dp.created_at','dp.updated_at');
                // dd($query->toSql());
                $feeReceipts = $query->get();
                // dd($feeReceipts);

            }

        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $queryExc);
        } catch (UserNotFoundException $userExc) {
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $exc);
        }

//dd($feeReceipts);
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

        try {
            $patientQuery = User::query();
            $patientQuery->join('patient as p', 'p.patient_id', '=', 'users.id');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientQuery->where('users.delete_status', '=', 1);

            $patient = $patientQuery->first();

            if (is_null($patient)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            if (!is_null($patient)) {
                $query = DB::table('fee_receipt as fr')->join('patient as p', 'p.patient_id', '=', 'fr.patient_id');
                $query->join('doctor as d', 'd.doctor_id', '=', 'fr.doctor_id');
                //$query->where('fr.doctor_id', '=', 'd.doctor_id');
                $query->where('p.patient_id', '=', $patientId);
                $query->orderBy('fr.created_at', 'DESC');
                $query->select('fr.id as receiptId', 'p.id as patientId', 'p.name as patientName', 'p.pid as PID',
                    'p.relationship', 'p.patient_spouse_name as spouseName',
                    'p.telephone as contactNumber', 'd.name as doctorName', 'fr.fee');

                //dd($query->toSql());
                $feeReceipts = $query->get();
                //dd($feeReceipts);

            }

        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $queryExc);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $exc);
        }

        //dd($feeReceipts);
        return $feeReceipts;
    }

    /**
     * Get fee receipt details, doctor details, patient details
     * @param $hospitalId , $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getReceiptDetails($receiptId)
    {
        $feeInfo = null;
        $doctorId = null;
        $patientId = null;
        $hospitalId = null;
        $feeWords = null;
        $fees = null;
        $payment_status=null;

        $patientDetails = null;
        $doctorDetails = null;
        $hospitalDetails = null;
        $feeReceiptDetails = null;

        try {
            /*RAMANA ADDED*/

            $feeDetailsQuery = DB::table('doctor_appointment as dp')->where('dp.id', '=', $receiptId);
            $feeDetailsQuery->join('patient as p', 'p.patient_id', '=', 'dp.patient_id');

            $feeDetailsQuery->select('dp.id as receiptId', 'dp.patient_id as patientId', 'dp.doctor_id as doctorId',
                'dp.hospital_id as hospitalId', 'dp.fee','p.payment_status');


            /* $feeDetailsQuery = DB::table('fee_receipt as fr')->where('fr.id', '=', $receiptId);
             $feeDetailsQuery->select('fr.id as receiptId', 'fr.patient_id as patientId', 'fr.doctor_id as doctorId',
                         'fr.hospital_id as hospitalId', 'fr.fee');
 */
            $feeInfo = $feeDetailsQuery->first();

            //dd($feeInfo);

            $doctorId = $feeInfo->doctorId;
            $hospitalId = $feeInfo->hospitalId;
            $patientId = $feeInfo->patientId;
            $fees = $feeInfo->fee;
            $payment_status=$feeInfo->payment_status;
//dd($feeInfo);

            $feeWords = $this->convertFee($fees);
            //dd($feeWords);

            //$feeDetails = (array)$feeInfo;
            $feeDetails['inWords'] = $feeWords;
            $feeDetails['fee'] = $fees;
            $feeDetails['payment_status'] = $payment_status;

            //array_push($feeDetails, $feeWords);
           //dd($feeDetails);

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $doctorQuery = DB::table('doctor as d')->select('d.id', 'd.doctor_id', 'd.name', 'd.did', 'd.designation',
                'd.specialty as department');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);
            $doctorDetails = $doctorQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.hid',
                'h.address', 'h.hospital_logo', 'c.city_name as cityName', 'co.name as country');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $feeReceiptDetails["patientDetails"] = $patientDetails;
            $feeReceiptDetails["doctorDetails"] = $doctorDetails;
            $feeReceiptDetails["hospitalDetails"] = $hospitalDetails;
            $feeReceiptDetails["feeDetails"] = $feeDetails;

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_DETAILS_ERROR, $exc);
        }

        //dd($feeReceiptDetails);
        return $feeReceiptDetails;
    }

    private function convertFee($fee)
    {
        $feeInWords = null;
        $currency = CA::get('constants.currency');
        $locale = CA::get('constants.locale');


        $numberWords = new Numbers_Words();
        if (!is_null($numberWords)) {
            //$feeInWords = $numberWords->toWords($fee);
            $feeInWords = $numberWords->toCurrency($fee, $locale, $currency);
        }


        //$feeInWords  = $fee." VALUE";
        return $feeInWords;
    }

    /**
     * Save fee receipt
     * @param $feeReceiptVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveFeeReceipt(FeeReceiptViewModel $feeReceiptVM)
    {
        $status = true;

        try {
            $doctorId = $feeReceiptVM->getDoctorId();
            $patientId = $feeReceiptVM->getPatientId();
            $hospitalId = $feeReceiptVM->getHospitalId();

            //$doctorUser = User::find($doctorId);
            //$hospitalUser = User::find($hospitalId);
            $patientUser = User::find($patientId);

            $doctorQuery = User::query();
            $doctorQuery->join('doctor as d', 'd.doctor_id', '=', 'users.id');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);

            $doctorUser = $doctorQuery->first();

            $hospitalQuery = User::query();
            $hospitalQuery->join('hospital as h', 'h.hospital_id', '=', 'users.id');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);

            $hospitalUser = $hospitalQuery->first();

            if (is_null($doctorUser)) {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            if (is_null($hospitalUser)) {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }


            if (!is_null($doctorUser) && !is_null($hospitalUser) && !is_null($patientUser)) {
                $feeReceipt = new FeeReceipt();
                $feeReceipt->hospital_id = $hospitalId;
                $feeReceipt->patient_id = $patientId;
                $feeReceipt->doctor_id = $doctorId;
                //$patientLabTests->unique_id = "LTID".time();

                $feeReceipt->fee = $feeReceiptVM->getFees();
                $feeReceipt->created_by = 'Admin';
                $feeReceipt->modified_by = 'Admin';
                //$feeReceipt->created_by = $feeReceiptVM->getCreatedBy();
                //$feeReceipt->modified_by = $feeReceiptVM->getUpdatedBy();
                $feeReceipt->created_at = $feeReceiptVM->getCreatedAt();
                $feeReceipt->updated_at = $feeReceiptVM->getUpdatedAt();
                $feeReceipt->save();


                //$doctor->feereceipts()->save($feeReceipt);$doctorUser
                //$doctorUser->feereceipts()->save($feeReceipt);
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_SAVE_ERROR, $exc);
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

        try {
            $query = DB::table('main_symptoms as ms')->where('ms.status', '=', 1);
            $query->select('ms.id', 'ms.main_symptom_name', 'ms.main_symptom_code');
            $mainSymptoms = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('complaint_type as ct')->where('ct.status', '=', 1);
            $query->select('ct.id', 'ct.complaint_name');
            $complaintTypes = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::COMPLAINT_TYPES_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('complaints as c')->where('c.status', '=', 1);
            if ($complaintTypeId > 0) {
                $query->where('c.complaint_type_id', $complaintTypeId);
            }
            $query->select('c.id', 'c.complaint_name', 'c.complaint_type_id');
            $complaints = $query->get();

        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::COMPLAINTS_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

    public function savePatientComplaints(PatientComplaintsViewModel $patientComVM)
    {
        $status = true;

        try {
            $patientId = $patientComVM->getPatientId();
            $doctorId = $patientComVM->getDoctorId();
            $hospitalId = $patientComVM->getHospitalId();
            $complaintText = $patientComVM->getComplaintText();

            $complaintDate = $patientComVM->getComplaintDate();
            $complaintTime = $patientComVM->getComplaintTime();

            if (!is_null($complaintDate)) {
                $patientComplaintDate = date('Y-m-d', strtotime($complaintDate));
            } else {
                $patientComplaintDate = null;
            }

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            //$patientUser = User::find($patientId);

            $patientComplaints = $patientComVM->getPatientComplaints();

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();

                $patientComplaint = new PatientComplaints();
                $patientComplaint->patient_id = $patientId;
                $patientComplaint->hospital_id = $hospitalId;
                $patientComplaint->doctor_id = $doctorId;
                $patientComplaint->complaint_text = $complaintText;
                $patientComplaint->complaint_date = $patientComplaintDate;
                $patientComplaint->examination_time = $complaintTime;
                $patientComplaint->created_by = $patientComVM->getCreatedBy();
                $patientComplaint->modified_by = $patientComVM->getUpdatedBy();
                $patientComplaint->created_at = $patientComVM->getCreatedAt();
                $patientComplaint->updated_at = $patientComVM->getUpdatedAt();
                $patientComplaint->save();

                foreach ($patientComplaints as $complaint) {
                    //dd($patientHistory);
                    $complaintId = $complaint->complaintId;
                    $isValueSet = $complaint->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $patientComplaintDetails = new PatientComplaintDetails();
                    $patientComplaintDetails->complaint_id = $complaintId;
                    $patientComplaintDetails->is_value_set = $isValueSet;
                    $patientComplaintDetails->created_by = $patientComVM->getCreatedBy();
                    $patientComplaintDetails->modified_by = $patientComVM->getUpdatedBy();
                    $patientComplaintDetails->created_at = $patientComVM->getCreatedAt();
                    $patientComplaintDetails->updated_at = $patientComVM->getUpdatedAt();

                    $patientComplaint->patientcomplaintdetails()->save($patientComplaintDetails);

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_SAVE_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Get patient complaint details
     * @param $patientId , $complaintsDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientComplaints($patientId, $complaintsDate)
    {
        $complaintDetails = array();

        try {
            $patientUser = User::find($patientId);
            //dd('Inside impl');

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $timeQuery = DB::table('patient_complaints as pc');
            $timeQuery->where('pc.patient_id', '=', $patientId);
            $timeQuery->where('pc.complaint_date', '=', $complaintsDate);
            $timeQuery->whereNotNull('pc.examination_time');
            //$timeQuery->where('ps.is_value_set', '=', 1);
            $timeQuery->select('pc.examination_time');
            $timeQuery->groupBy('pc.examination_time');
            $timeQuery->orderby('pc.examination_time', 'DESC');

            $examinationTime = $timeQuery->get();
            //dd($examinationTime);

            foreach ($examinationTime as $time) {
                //DB::connection()->enableQueryLog();

                $query = DB::table('patient_complaint_details as pcd')->select('pc.id', 'pc.patient_id', 'pc.hospital_id',
                    'pc.doctor_id', 'pc.complaint_text', 'pc.complaint_date', 'pc.examination_time',
                    'pcd.is_value_set', 'c.id as complaint_id',
                    'c.complaint_name', 'ct.id as complaint_type_id', 'ct.complaint_name as complaint_type_name');
                $query->join('patient_complaints as pc', 'pc.id', '=', 'pcd.patient_complaint_id');
                $query->join('complaints as c', function ($join) {
                    $join->on('c.id', '=', 'pcd.complaint_id');
                    $join->on('c.status', '=', DB::raw('?'));
                })->setBindings(array_merge($query->getBindings(), array(1)));
                $query->join('complaint_type as ct', function ($join) {
                    $join->on('ct.id', '=', 'c.complaint_type_id');
                    $join->on('ct.status', '=', DB::raw('?'));
                })->setBindings(array_merge($query->getBindings(), array(1)));
                $query->where('pc.patient_id', '=', $patientId);
                $query->where('pc.complaint_date', '=', $complaintsDate);
                $query->where('pc.examination_time', '=', $time->examination_time);
                $query->orderBy('pc.examination_time', 'DESC');

                $complaints = $query->get();
                //$query = DB::getQueryLog();
                //dd($query);

                array_push($complaintDetails, $complaints);
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_COMPLAINT_DETAILS_ERROR, $exc);
        }

        //dd($complaintDetails);
        //dd($complaintDetails);
        return $complaintDetails;
    }

    /**
     * Save patient investigations and diagnosis
     * @param $patientDiagnosisVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientInvestigationAndDiagnosis(PatientDiagnosisViewModel $patientDiagnosisVM)
    {
        $status = true;

        try {
            $patientId = $patientDiagnosisVM->getPatientId();
            $doctorId = $patientDiagnosisVM->getDoctorId();
            $hospitalId = $patientDiagnosisVM->getHospitalId();
            $investigations = $patientDiagnosisVM->getInvestigations();
            $examinationFindings = $patientDiagnosisVM->getExaminationFindings();
            $provisionalDiagnosis = $patientDiagnosisVM->getProvisionalDiagnosis();
            $finalDiagnosis = $patientDiagnosisVM->getFinalDiagnosis();
            $treatmentType = $patientDiagnosisVM->getTreatmentType();
            $treatmentPlanNotes = $patientDiagnosisVM->getTreatmentPlanNotes();

            $diagnosisDate = $patientDiagnosisVM->getDiagnosisDate();
            $examinationTime = $patientDiagnosisVM->getExaminationTime();

            if (!is_null($diagnosisDate)) {
                $patientDiagnosistDate = date('Y-m-d', strtotime($diagnosisDate));
            } else {
                $patientDiagnosistDate = null;
            }

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            //$patientUser = User::find($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                $patientDiagnosis = new PatientDiagnosis();
                $patientDiagnosis->patient_id = $patientId;
                $patientDiagnosis->hospital_id = $hospitalId;
                $patientDiagnosis->doctor_id = $doctorId;
                $patientDiagnosis->investigations = $investigations;
                $patientDiagnosis->examination_findings = $examinationFindings;
                $patientDiagnosis->provisional_diagnosis = $provisionalDiagnosis;
                $patientDiagnosis->final_diagnosis = $finalDiagnosis;
                $patientDiagnosis->diagnosis_date = $patientDiagnosistDate;
                $patientDiagnosis->examination_time = $examinationTime;
                $patientDiagnosis->treatment_plan_id = $treatmentType;
                $patientDiagnosis->treatment_plan_notes = $treatmentPlanNotes;
                $patientDiagnosis->created_by = $patientDiagnosisVM->getCreatedBy();
                $patientDiagnosis->modified_by = $patientDiagnosisVM->getUpdatedBy();
                $patientDiagnosis->created_at = $patientDiagnosisVM->getCreatedAt();
                $patientDiagnosis->updated_at = $patientDiagnosisVM->getUpdatedAt();

                $patientUser->patientdiagnosis()->save($patientDiagnosis);
                //$patientComplaint->save();

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DIAGNOSIS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DIAGNOSIS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Get patient investigation details
     * @param $patientId , $investigationDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientInvestigations($patientId, $investigationDate)
    {
        $investigationDetails = array();

        try {
            $patientUser = User::find($patientId);
            //dd('Inside impl');

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $timeQuery = DB::table('patient_investigations_diagnosis as pid');
            $timeQuery->where('pid.patient_id', '=', $patientId);
            $timeQuery->where('pid.diagnosis_date', '=', $investigationDate);
            $timeQuery->whereNotNull('pid.examination_time');
            //$timeQuery->where('ps.is_value_set', '=', 1);
            $timeQuery->select('pid.examination_time');
            $timeQuery->groupBy('pid.examination_time');
            $timeQuery->orderby('pid.examination_time', 'DESC');

            $examinationTime = $timeQuery->get();
            //dd($examinationTime);

            foreach ($examinationTime as $time) {
                //DB::connection()->enableQueryLog();

                $query = DB::table('patient_investigations_diagnosis as pid')->select('pid.id', 'pid.patient_id', 'pid.hospital_id',
                    'pid.doctor_id', 'pid.investigations', 'pid.examination_findings',
                    'pid.provisional_diagnosis', 'pid.final_diagnosis', 'pid.diagnosis_date',
                    'pid.examination_time', 'tt.id as treatmentPlanId', 'pid.treatment_plan_notes',
                    'tt.treatment_type', 'tt.treatment_code');
                $query->join('treatment_type as tt', 'tt.id', '=', 'pid.treatment_plan_id');
                $query->where('pid.patient_id', '=', $patientId);
                $query->where('pid.diagnosis_date', '=', $investigationDate);
                $query->where('pid.examination_time', '=', $time->examination_time);
                $query->orderBy('pid.examination_time', 'DESC');

                $investigations = $query->get();
                //$query = DB::getQueryLog();
                //dd($query);

                array_push($investigationDetails, $investigations);
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_INVESTIGATION_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_INVESTIGATION_DETAILS_ERROR, $exc);
        }

        //dd($complaintDetails);
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

        try {
            $query = DB::table('sub_symptoms as ss')->where('ss.status', '=', 1);
            if ($mainSymptomsId > 0) {
                $query->where('ss.main_symptom_id', $mainSymptomsId);
            }
            $query->select('ss.id', 'ss.main_symptom_id', 'ss.sub_symptom_name', 'ss.sub_symptom_code');
            $subSymptoms = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::SUB_SYMPTOMS_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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

        try {
            $query = DB::table('symptoms as s')->where('s.status', '=', 1);
            if ($subSymptomId > 0) {
                $query->where('s.sub_symptom_id', $subSymptomId);
            }
            $query->select('s.id', 's.sub_symptom_id', 's.symptom_name', 's.symptom_code');
            $symptoms = $query->get();
        } catch (QueryException $queryEx) {
            throw new HospitalException(null, ErrorEnum::SYMPTOMS_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
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
        $feeInfo = null;
        $doctorId = null;

        $personalHistory = null;
        $patientHistory = null;
        //$personalHistoryDetails = null;
        $personalHistoryDetails = array();

        //$personalHistoryQuery

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$patientHistoryQuery = DB::table('personal_history as ph')->where('pph.patient_id', '=', $patientId);
            $patientHistoryQuery->join('personal_history_item as phi', 'phi.personal_history_id', '=', 'ph.id');
            $patientHistoryQuery->join('patient_personal_history as pph', function($join){
                $join->on('pph.personal_history_id', '=', 'ph.id');
                $join->on('pph.personal_history_id', '=', 'ph.id');
            });*/

            /*$patientHistoryQuery = DB::table('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId)->where('pph.personal_history_date', '=', $personalHistoryDate);
            $patientHistoryQuery->join('personal_history as ph', 'ph.id', '=', 'pph.personal_history_id');
            $patientHistoryQuery->join('personal_history_item as phi', 'phi.id', '=', 'pph.personal_history_item_id');

            $patientHistoryQuery->select('pph.id', 'pph.patient_id as patientId', 'ph.id as personalHistoryId',
                'ph.personal_history_name as personalHistoryName', 'phi.id as personalHistoryItemId',
                'phi.personal_history_item_name as personalHistoryItemName',
                'pph.personal_history_value as personalHistoryValue');
            $patientHistoryQuery->orderBy('pph.created_at', 'DESC');

            //dd($patientHistoryQuery->toSql());
            $patientHistory = $patientHistoryQuery->get();*/
            //dd($patientHistory);

            /*$personalHistoryQuery = DB::table('personal_history as ph')->join('personal_history_item as phi', 'phi.personal_history_id', '=', 'ph.id');
            $personalHistoryQuery->select('ph.id as personalHistoryId', 'ph.personal_history_name as personalHistoryName',
                'phi.id as personalHistoryItemId', 'phi.personal_history_item_name as personalHistoryItemName');
            $personalHistory = $personalHistoryQuery->get();*/

            /*if(!is_null($patientFeedback) && !empty($patientFeedback))
            {

            }*/

            /*$patientHistoryQuery = DB::table('patient_personal_history as pph');
            $patientHistoryQuery->join('personal_history as ph', 'ph.id', '=', 'pph.personal_history_id');
            $patientHistoryQuery->join('personal_history_item as phi', 'phi.id', '=', 'pph.personal_history_item_id');
            $patientHistoryQuery->whereIn('pph.personal_history_date', function($query) use($patientId, $personalHistoryDate){
                $query->select('pph.personal_history_date');
                $query->from('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
                $query->where('pph.personal_history_date', '=', $personalHistoryDate);
            });
            $patientHistoryQuery->where('pph.patient_id', '=', $patientId);
            $patientHistoryQuery->where('pph.personal_history_date', '=', $personalHistoryDate);
            //$patientHistoryQuery->where('pph.is_value_set', '=', 1);
            $patientHistoryQuery->select('pph.id', 'pph.patient_id', 'ph.personal_history_name',
                'phi.personal_history_item_name','pph.personal_history_date', 'pph.personal_history_value',
                'pph.examination_time', 'pph.is_value_set');
            $patientHistoryQuery->orderBy('pph.id', '=', 'ASC');
            //dd($patientHistoryQuery->toSql());
            $personalHistoryDetails = $patientHistoryQuery->get();*/


            /*$patientHistoryQuery = DB::table('patient_personal_history as pph');
            $patientHistoryQuery->join('personal_history as ph', 'ph.id', '=', 'pph.personal_history_id');
            $patientHistoryQuery->join('personal_history_item as phi', 'phi.id', '=', 'pph.personal_history_item_id');
            $patientHistoryQuery->where('pph.patient_id', '=', $patientId);
            $patientHistoryQuery->where('pph.personal_history_date', '=', $personalHistoryDate);
            $patientHistoryQuery->where('pph.is_value_set', '=', 1);
            $patientHistoryQuery->select('pph.id', 'pph.patient_id', 'ph.personal_history_name',
                'phi.personal_history_item_name','pph.personal_history_date', 'pph.personal_history_value',
                'pph.examination_time', 'pph.is_value_set');

            //dd($patientHistoryQuery->toSql());
            $patientHistory = $patientHistoryQuery->get();*/

            //dd($bloodTests);
            //$bloodTests = $latestBloodExamQuery->get();
            //dd($patientHistoryQuery->toSql());
            //$personalHistoryDetails = $query->get();

            $timeQuery = DB::table('patient_personal_history as pph');
            $timeQuery->where('pph.patient_id', '=', $patientId);
            $timeQuery->where('pph.personal_history_date', '=', $personalHistoryDate);
            $timeQuery->where('pph.is_value_set', '=', 1);
            $timeQuery->select('pph.examination_time');
            $timeQuery->groupBy('pph.examination_time');

            $examinationTime = $timeQuery->get();

            //dd($examinationTime);
            //$accommodations = null;
            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                //$accommodations = array();
                /*$historyRecord = array_filter($patientHistory, function($e) use ($patientHistory, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $patientHistoryQuery = DB::table('patient_personal_history as pph');
                $patientHistoryQuery->join('personal_history as ph', 'ph.id', '=', 'pph.personal_history_id');
                $patientHistoryQuery->join('personal_history_item as phi', 'phi.id', '=', 'pph.personal_history_item_id');
                $patientHistoryQuery->where('pph.patient_id', '=', $patientId);
                $patientHistoryQuery->where('pph.personal_history_date', '=', $personalHistoryDate);
                $patientHistoryQuery->where('pph.examination_time', '=', $time->examination_time);
                $patientHistoryQuery->where('pph.is_value_set', '=', 1);
                $patientHistoryQuery->orderBy('pph.examination_time', 'DESC');
                $patientHistoryQuery->select('pph.id', 'pph.patient_id', 'ph.personal_history_name',
                    'phi.personal_history_item_name', 'pph.personal_history_date', 'pph.personal_history_value',
                    'pph.examination_time', 'pph.is_value_set');

                //dd($patientHistoryQuery->toSql());
                $patientHistory = $patientHistoryQuery->get();

                //array_push($personalHistoryDetails, $historyRecord);
                array_push($personalHistoryDetails, $patientHistory);

                //dd($bloodTestRecord);
                //$patientBloodTests[$time->examination_time] = $accommodations;
                //reset($accommodations);
            }

            //dd($personalHistoryDetails);

            //$personalHistoryDetails["patientHistory"] = $patientHistory;
            //$personalHistoryDetails["personalHistory"] = $personalHistory;
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_ERROR, $exc);
        }

        //dd($personalHistoryDetails);
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
        $pastIllnessDetails = array();

        //dd($patientId);

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('past_illness as pii')->select('ppi.id as patientPastIllnessId', 'pii.id as patientIllnessId', 'pii.illness_name as illnessName',
                'ppi.past_illness_name as otherIllnessName', 'ppi.relation', 'ppi.is_value_set as isValueSet');
            $query->join('patient_past_illness as ppi', function($join){
                $join->on('ppi.past_illness_id', '=', 'pii.id');
                $join->on('ppi.patient_id', '=', DB::raw('?'));
                $join->on('ppi.past_illness_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $pastIllnessDate)));
            $query->where('pii.status', '=', 1);*/

            /*$query = DB::table('past_illness as pii');
            $query->join('patient_past_illness as ppi', 'ppi.past_illness_id', '=', 'pii.id');
            $query->where('ppi.patient_id', '=', $patientId);
            $query->where('ppi.past_illness_date', '=', $pastIllnessDate);
            $query->where('pii.status', '=', 1);
            $query->select( 'ppi.patient_id', 'ppi.hospital_id', 'ppi.id as patientPastIllnessId',
                'pii.id as patientIllnessId', 'pii.illness_name as illnessName', 'ppi.past_illness_name as otherIllnessName',
                'ppi.relation', 'ppi.is_value_set as isValueSet',
                'ppi.past_illness_date as examinationDate',
                'ppi.examination_time');
            $query->orderBy('ppi.id');

            //dd($query->toSql());
            $pastIllness = $query->get();*/
            //dd($pastIllness);

            $timeQuery = DB::table('patient_past_illness as ppi');
            $timeQuery->where('ppi.patient_id', '=', $patientId);
            $timeQuery->where('ppi.past_illness_date', '=', $pastIllnessDate);
            //$timeQuery->where('pbe.is_value_set', '=', 1);
            $timeQuery->select('ppi.examination_time');
            $timeQuery->groupBy('ppi.examination_time');

            $examinationTime = $timeQuery->get();

            //dd($examinationTime);

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$pastIllnessTestRecord = array_filter($pastIllness, function($e) use ($pastIllness, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $query = DB::table('past_illness as pii');
                $query->join('patient_past_illness as ppi', 'ppi.past_illness_id', '=', 'pii.id');
                $query->where('ppi.patient_id', '=', $patientId);
                $query->where('ppi.past_illness_date', '=', $pastIllnessDate);
                $query->where('ppi.examination_time', '=', $time->examination_time);
                $query->where('pii.status', '=', 1);
                $query->orderBy('ppi.examination_time', 'DESC');
                $query->select('ppi.patient_id', 'ppi.hospital_id', 'ppi.id as patientPastIllnessId',
                    'pii.id as patientIllnessId', 'pii.illness_name as illnessName', 'ppi.past_illness_name as otherIllnessName',
                    'ppi.relation', 'ppi.is_value_set as isValueSet',
                    'ppi.past_illness_date as examinationDate',
                    'ppi.examination_time');

                //dd($query->toSql());
                $pastIllness = $query->get();

                //array_push($pastIllnessDetails, $pastIllnessTestRecord);
                array_push($pastIllnessDetails, $pastIllness);

                //dd($bloodTestRecord);
                //$patientBloodTests[$time->examination_time] = $accommodations;
                //reset($accommodations);
            }

            //dd($pastIllnessDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR, $exc);
        }

        //dd($pastIllnessDetails);
        return $pastIllnessDetails;
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
        $familyIllnessDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('family_illness as fi')->select('fi.id as familyIllnessId', 'fi.illness_name as familyIllnessName',
                'pfi.id as patientIllnessId', 'pfi.family_illness_name as otherIllnessName', 'pfi.relation', 'pfi.is_value_set as isValueSet');
            //$query->leftJoin('patient_family_illness as pfi', function($join){
            $query->join('patient_family_illness as pfi', function($join){
                $join->on('pfi.family_illness_id', '=', 'fi.id');
                $join->on('pfi.patient_id', '=', DB::raw('?'));
                $join->on('pfi.family_illness_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $familyIllnessDate)));
            $query->where('fi.status', '=', 1);*/

            /*$query = DB::table('family_illness as fi');
            $query->join('patient_family_illness as pfi', 'pfi.family_illness_id', '=', 'fi.id');
            $query->where('pfi.patient_id', '=', $patientId);
            $query->where('pfi.family_illness_date', '=', $familyIllnessDate);
            $query->where('fi.status', '=', 1);
            $query->select( 'pfi.patient_id', 'pfi.hospital_id', 'fi.id as familyIllnessId',
                'fi.illness_name as familyIllnessName', 'pfi.id as patientIllnessId', 'pfi.family_illness_name as otherIllnessName',
                'pfi.relation', 'pfi.is_value_set as isValueSet',
                'pfi.family_illness_date as examinationDate',
                'pfi.examination_time');
            $query->orderBy('pfi.id');

            //dd($query->toSql());
            $familyIllness = $query->get();*/
            //dd($pastIllness);

            $timeQuery = DB::table('patient_family_illness as pfi');
            $timeQuery->where('pfi.patient_id', '=', $patientId);
            $timeQuery->where('pfi.family_illness_date', '=', $familyIllnessDate);
            //$timeQuery->where('pbe.is_value_set', '=', 1);
            $timeQuery->select('pfi.examination_time');
            $timeQuery->groupBy('pfi.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$familyIllnessTestRecord = array_filter($familyIllness, function($e) use ($familyIllness, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $query = DB::table('family_illness as fi');
                $query->join('patient_family_illness as pfi', 'pfi.family_illness_id', '=', 'fi.id');
                $query->where('pfi.patient_id', '=', $patientId);
                $query->where('pfi.family_illness_date', '=', $familyIllnessDate);
                $query->where('pfi.examination_time', '=', $time->examination_time);
                $query->where('fi.status', '=', 1);
                $query->orderBy('pfi.examination_time', 'DESC');
                $query->select('pfi.patient_id', 'pfi.hospital_id', 'fi.id as familyIllnessId',
                    'fi.illness_name as familyIllnessName', 'pfi.id as patientIllnessId', 'pfi.family_illness_name as otherIllnessName',
                    'pfi.relation', 'pfi.is_value_set as isValueSet',
                    'pfi.family_illness_date as examinationDate',
                    'pfi.examination_time');


                //dd($query->toSql());
                $familyIllness = $query->get();

                //array_push($familyIllnessDetails, $familyIllnessTestRecord);
                array_push($familyIllnessDetails, $familyIllness);
            }

            //dd($familyIllnessDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_ERROR, $exc);
        }

        //dd($familyIllnessDetails);
        return $familyIllnessDetails;
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
        $generalExaminations = null;
        $generalExaminationDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_general_examination as pge')->select('ge.id', 'ge.general_examination_name as generalExaminationName',
                'pge.id as patientExaminationId', 'pge.general_examination_value as generalExaminationValue');
            //$query->rightJoin('general_examination as ge', function($join){
            $query->join('general_examination as ge', function($join){
                $join->on('ge.id', '=', 'pge.general_examination_id');
                $join->on('pge.patient_id', '=', DB::raw('?'));
                $join->on('pge.general_examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $generalExaminationDate)));
            $query->where('ge.status', '=', 1);*/

            /*$query = DB::table('patient_general_examination as pge');
            $query->join('general_examination as ge', 'ge.id', '=', 'pge.general_examination_id');
            $query->where('pge.patient_id', '=', $patientId);
            $query->where('pge.general_examination_date', '=', $generalExaminationDate);
            $query->where('ge.status', '=', 1);
            $query->select( 'pge.patient_id', 'pge.hospital_id', 'ge.id', 'ge.general_examination_name as generalExaminationName',
                'pge.id as patientExaminationId',
                'pge.general_examination_value as generalExaminationValue',
                'pge.general_examination_date as examinationDate',
                'pge.examination_time');


            //dd('ge query');
            //$bloodTests = $query->get();
            //dd($query->toSql());
            $generalExaminations = $query->get();*/
            //dd($generalExaminations);

            $timeQuery = DB::table('patient_general_examination as pge');
            $timeQuery->where('pge.patient_id', '=', $patientId);
            $timeQuery->where('pge.general_examination_date', '=', $generalExaminationDate);
            //$timeQuery->where('pbe.is_value_set', '=', 1);
            $timeQuery->select('pge.examination_time');
            $timeQuery->groupBy('pge.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$examinationTestRecord = array_filter($generalExaminations, function($e) use ($generalExaminations, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $query = DB::table('patient_general_examination as pge');
                $query->join('general_examination as ge', 'ge.id', '=', 'pge.general_examination_id');
                $query->where('pge.patient_id', '=', $patientId);
                $query->where('pge.general_examination_date', '=', $generalExaminationDate);
                $query->where('pge.examination_time', '=', $time->examination_time);
                $query->where('ge.status', '=', 1);
                $query->orderBy('pge.examination_time', 'DESC');
                $query->select('pge.patient_id', 'pge.hospital_id', 'ge.id', 'ge.general_examination_name as generalExaminationName',
                    'pge.id as patientExaminationId',
                    'pge.general_examination_value as generalExaminationValue',
                    'pge.general_examination_date as examinationDate',
                    'pge.examination_time');


                //dd('ge query');
                //$bloodTests = $query->get();
                //dd($query->toSql());
                $generalExaminations = $query->get();

                //array_push($generalExaminationDetails, $examinationTestRecord);
                array_push($generalExaminationDetails, $generalExaminations);

                //dd($bloodTestRecord);
                //$patientBloodTests[$time->examination_time] = $accommodations;
                //reset($accommodations);
            }

            //dd($query->toSql());


            //dd($generalExaminationDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR, $exc);
        }

        return $generalExaminationDetails;
    }

    /**
     * Get patient pregnancy details
     * @param $patientId , $pregnancyDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPregnancyDetails($patientId, $pregnancyDate = null)
    {
        $pregnancy = null;
        $pregnancyDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_pregnancy as pp')->select('p.id as pregnancyId', 'p.pregnancy_details as pregnancyDetails',
                'pp.id as patientPregnancyId', 'pp.pregnancy_value as pregnancyValue',
                'pp.pregnancy_date as pregnancyExaminationDate', 'pp.is_value_set as isValueSet');
            $query->join('pregnancy as p', function($join){
            //$query->rightJoin('pregnancy as p', function($join){
                $join->on('p.id', '=', 'pp.pregnancy_id');
                $join->on('pp.patient_id', '=', DB::raw('?'));
                $join->on('pp.pregnancy_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $pregnancyDate)));
            $query->where('p.status', '=', 1);*/

            /*$query = DB::table('patient_pregnancy as pp');
            $query->join('pregnancy as p', 'p.id', '=', 'pp.pregnancy_id');
            $query->where('pp.patient_id', '=', $patientId);
            $query->where('pp.pregnancy_date', '=', $pregnancyDate);
            $query->where('p.status', '=', 1);
            $query->select( 'pp.patient_id', 'pp.hospital_id', 'p.id as pregnancyId',
                'p.pregnancy_details as pregnancyDetails', 'pp.id as patientPregnancyId', 'pp.pregnancy_value as pregnancyValue',
                'pp.pregnancy_date as pregnancyExaminationDate', 'pp.is_value_set as isValueSet',
                'pp.examination_time');
            $query->orderBy('pp.id');

            //dd($query->toSql());
            $pregnancy = $query->get();*/
            //dd($pastIllness);


            //DB::connection()->enableQueryLog();

            $timeQuery = DB::table('patient_pregnancy as pp');
            $timeQuery->where('pp.patient_id', '=', $patientId);
            if (!is_null($pregnancyDate)) {
                $timeQuery->where('pp.pregnancy_date', '=', $pregnancyDate);
            }
            //$timeQuery->where('pbe.is_value_set', '=', 1);
            $timeQuery->select('pp.pregnancy_date', 'pp.examination_time');
            $timeQuery->groupBy('pp.examination_time');
            $timeQuery->orderBy('pp.pregnancy_date', 'DESC');
            $timeQuery->orderBy('pp.examination_time', 'DESC');
            /*if(is_null($pregnancyDate))
            {
                $timeQuery->orderBy('pp.pregnancy_date', 'DESC');
                $timeQuery->orderBy('pp.examination_time', 'DESC');
            }*/

            $examinationTime = $timeQuery->get();
            //dd($examinationTime);
            //$query = DB::getQueryLog();
            //dd($query);

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$pregnancyTestRecord = array_filter($pregnancy, function($e) use ($pregnancy, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                //DB::connection()->enableQueryLog();

                $query = DB::table('patient_pregnancy as pp');
                $query->join('pregnancy as p', 'p.id', '=', 'pp.pregnancy_id');
                $query->where('pp.patient_id', '=', $patientId);
                if (!is_null($pregnancyDate)) {
                    $query->where('pp.pregnancy_date', '=', $pregnancyDate);
                } else {
                    $query->where('pp.pregnancy_date', '=', $time->pregnancy_date);
                }

                $query->where('pp.examination_time', '=', $time->examination_time);
                $query->where('p.status', '=', 1);
                $query->orderBy('pp.pregnancy_date', 'DESC');
                $query->orderBy('pp.examination_time', 'DESC');
                /*if(is_null($pregnancyDate))
                {
                    $query->orderBy('pp.pregnancy_date', 'DESC');
                    $query->orderBy('pp.examination_time', 'DESC');
                }
                else
                {
                    $query->orderBy('pp.examination_time', 'DESC');
                }*/

                $query->select('pp.patient_id', 'pp.hospital_id', 'p.id as pregnancyId',
                    'p.pregnancy_details as pregnancyDetails', 'pp.id as patientPregnancyId', 'pp.pregnancy_value as pregnancyValue',
                    'pp.pregnancy_date as pregnancyExaminationDate', 'pp.is_value_set as isValueSet',
                    'pp.examination_time');


                //dd($query->toSql());
                $pregnancy = $query->get();
                //$query = DB::getQueryLog();
                //dd($query);

                //array_push($pregnancyDetails, $pregnancyTestRecord);
                array_push($pregnancyDetails, $pregnancy);
            }

            //dd($pregnancyDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_ERROR, $exc);
        }

        return $pregnancyDetails;
    }

    /**
     * Get patient scan details
     * @param $patientId , $scanDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientScanDetails($patientId, $scanDate)
    {
        $scanTests = null;
        $scanDetails = array();
        //dd($patientId);

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_scan as ps')->select('s.id as scanId', 's.scan_name as scanName',
                'ps.id as patientScanId', 'ps.is_value_set as isValueSet', 'ps.scan_date as scanDate');
            //$query->rightJoin('scans as s', function($join){
            $query->join('scans as s', function($join){
                $join->on('s.id', '=', 'ps.scan_id');
                $join->on('ps.patient_id', '=', DB::raw('?'));
                $join->on('ps.scan_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $scanDate)));
            $query->where('s.status', '=', 1);

            //dd($query->toSql());

            $scanDetails = $query->get();*/

            /*$scanTestQuery = DB::table('patient_scan as ps');
            $scanTestQuery->join('scans as s', 's.id', '=', 'ps.scan_id');
            $scanTestQuery->where('ps.patient_id', '=', $patientId);
            $scanTestQuery->where('ps.scan_date', '=', $scanDate);
            $scanTestQuery->where('s.status', '=', 1);
            $scanTestQuery->select('ps.patient_id', 'ps.hospital_id', 's.id as scanId',
                's.scan_name as scanName', 'ps.scan_date as scanDate',
                'ps.id as patientScanId', 'ps.is_value_set as isValueSet',
                'ps.examination_time');

            $scanTests = $scanTestQuery->get();*/

            $timeQuery = DB::table('patient_scan as ps');
            $timeQuery->where('ps.patient_id', '=', $patientId);
            $timeQuery->where('ps.scan_date', '=', $scanDate);
            //$timeQuery->where('ps.is_value_set', '=', 1);
            $timeQuery->select('ps.examination_time');
            $timeQuery->groupBy('ps.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$scanTestRecord = array_filter($scanTests, function($e) use ($scanTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $scanTestQuery = DB::table('patient_scan as ps');
                $scanTestQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
                $scanTestQuery->join('scans as s', 's.id', '=', 'psi.scan_id');
                $scanTestQuery->where('ps.patient_id', '=', $patientId);
                $scanTestQuery->where('ps.scan_date', '=', $scanDate);
                $scanTestQuery->where('ps.examination_time', '=', $time->examination_time);
                $scanTestQuery->where('psi.is_value_set', '=', 1);
                $scanTestQuery->where('s.status', '=', 1);
                $scanTestQuery->orderBy('ps.examination_time', 'DESC');
                $scanTestQuery->select('ps.id as patientScanId', 'ps.patient_id', 'ps.hospital_id', 's.id as scanId',
                    's.scan_name as scanName', 'ps.scan_date as scanDate',
                    'psi.id as patientScanItemId',
                    'psi.is_value_set as isValueSet',
                    'ps.examination_time');

                $scanTests = $scanTestQuery->get();

                //array_push($scanDetails, $scanTestRecord);
                array_push($scanDetails, $scanTests);

            }

            //dd($scanDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_DETAILS_ERROR, $exc);
        }

        return $scanDetails;
    }

    /**
     * Get patient symptom details
     * @param $patientId , $symptomDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientSymptoms($patientId, $symptomDate)
    {
        $symptomDetails = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $query = DB::table('patient_symptoms as ps')->select('ps.patient_id as patientId', 'ps.main_symptom_id as mainSymptomId',
                'ms.main_symptom_name as mainSymptomName',
                'ps.sub_symptom_id as subSymptomId', 'ss.sub_symptom_name as subSymptomName',
                'ps.symptom_id as symptomId', 's.symptom_name as symptomName',
                'ps.is_value_set as isValueSet', 'ps.patient_symptom_date as symptomDate');
            $query->join('main_symptoms as ms', function ($join) {
                $join->on('ms.id', '=', 'ps.main_symptom_id');
                $join->on('ms.status', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array(1)));
            $query->join('sub_symptoms as ss', function ($join) {
                $join->on('ss.id', '=', 'ps.sub_symptom_id');
                $join->on('ss.status', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array(1)));
            $query->join('symptoms as s', function ($join) {
                $join->on('s.id', '=', 'ps.symptom_id');
                $join->on('s.status', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array(1)));
            $query->where('ps.patient_id', '=', $patientId);
            $query->where('ps.patient_symptom_date', '=', $symptomDate);

            //dd($query->toSql());

            $symptomDetails = $query->get();
            //dd($symptomDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_SYMPTOM_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
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
        $drugHistory = null;
        $surgeryHistory = null;
        $drugSurgeryHistory = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $drugQuery = DB::table('patient_drug_history as pdh')->select('pdh.id as id', 'pdh.patient_id as patientId',
                'pdh.drug_name as drugName', 'pdh.dosage', 'pdh.timings');
            $drugQuery->where('pdh.patient_id', $patientId);

            //dd($query->toSql());

            $drugHistory = $drugQuery->get();

            $surgeryQuery = DB::table('patient_surgeries as ps')->select('ps.id as id', 'ps.patient_id as patientId',
                'ps.patient_surgeries as patientSurgeries', 'ps.operation_date as operationDate');
            $surgeryQuery->where('ps.patient_id', $patientId);

            $surgeryHistory = $surgeryQuery->get();

            $drugSurgeryHistory['drugHistory'] = $drugHistory;
            $drugSurgeryHistory['surgeryHistory'] = $surgeryHistory;


            //dd($drugHistory);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_ERROR, $exc);
        }

        return $drugSurgeryHistory;
    }

    /**
     * Get patient urine tests
     * @param $patientId , $urineTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUrineTests($patientId, $urineTestDate)
    {
        $urineTests = null;
        $urineTestDetails = array();
        $testArray = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_urine_examination as pue')->select('ue.id as examinationId', 'ue.examination_name as examinationName',
                'pue.id as patientExaminationId', 'pue.is_value_set as isValueSet', 'pue.examination_date as examinationDate');
            //$query->rightJoin('scans as s', function($join){
            $query->join('urine_examination as ue', function($join){
                $join->on('ue.id', '=', 'pue.urine_examination_id');
                $join->on('pue.patient_id', '=', DB::raw('?'));
                $join->on('pue.examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $urineTestDate)));
            $query->where('ue.status', '=', 1);

            //dd($query->toSql());

            $urineTests = $query->get();*/

            /*$urineTestQuery = DB::table('patient_urine_examination as pue');
            $urineTestQuery->join('urine_examination as ue', 'ue.id', '=', 'pue.urine_examination_id');
            $urineTestQuery->where('pue.patient_id', '=', $patientId);
            $urineTestQuery->where('pue.examination_date', '=', $urineTestDate);
            $urineTestQuery->where('pue.is_value_set', '=', 1);
            $urineTestQuery->select('pue.patient_id', 'pue.hospital_id', 'ue.id as examinationId',
                'ue.examination_name as examinationName', 'pue.examination_date as examinationDate',
                'pue.id as patientExaminationId', 'pue.is_value_set as isValueSet',
                'pue.examination_time');

            $urineTests = $urineTestQuery->get();*/

            $timeQuery = DB::table('patient_urine_examination as pue');
            $timeQuery->where('pue.patient_id', '=', $patientId);
            $timeQuery->where('pue.examination_date', '=', $urineTestDate);
            //$timeQuery->where('pue.is_value_set', '=', 1);
            $timeQuery->select('pue.examination_time');
            $timeQuery->groupBy('pue.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$urineTestRecord = array_filter($urineTests, function($e) use ($urineTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                /*$urineTestQuery = DB::table('patient_urine_examination as pue');
                $urineTestQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
                $urineTestQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
                $urineTestQuery->where('pue.patient_id', '=', $patientId);
                $urineTestQuery->where('pue.examination_date', '=', $urineTestDate);
                $urineTestQuery->where('pue.examination_time', '=', $time->examination_time);
                $urineTestQuery->where('puei.is_value_set', '=', 1);
                $urineTestQuery->orderBY('pue.examination_time', 'DESC');
                $urineTestQuery->select('pue.id as patientExaminationId', 'pue.patient_id', 'pue.hospital_id',
                    'ue.id as examinationId',
                    'ue.examination_name as examinationName','ue.normal_default_values as examinationDefaultValue', 'pue.examination_date as examinationDate',
                    'puei.id as patientExaminationItemId','puei.test_readings as Reading','puei.test_reading_status as ReadingStatus',
                    'puei.is_value_set as isValueSet', 'pue.examination_time');

                $urineTests = $urineTestQuery->get();*/

                /*$urineTestQuery = DB::table('patient_urine_examination_item as puei');
                $urineTestQuery->join('patient_urine_examination as pue', 'pue.id', '=', 'puei.patient_urine_examination_id');
                $urineTestQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
                $urineTestQuery->join('urine_examination as ue1', 'ue1.id', '=', 'ue.parent_id');
                $urineTestQuery->where('pue.patient_id', '=', $patientId);
                $urineTestQuery->where('pue.examination_date', '=', $urineTestDate);
                $urineTestQuery->where('pue.examination_time', '=', $time->examination_time);
                $urineTestQuery->where('puei.is_value_set', '=', 1);
                $urineTestQuery->orderBy('pue.examination_time', 'DESC');
                //$latestBloodExamQuery->groupBy('pbe.id');
                $urineTestQuery->select('pue.id as patientExaminationId', 'pue.patient_id', 'pue.hospital_id',
                    'ue.id as examinationId', 'ue.examination_name as examinationName', 'ue1.parent_id',
                    'ue1.examination_name AS parent_examination_name', 'ue.is_parent',
                    'ue.normal_default_values as examinationDefaultValue',
                    'pue.examination_date as examinationDate', 'pue.examination_time',
                    'puei.id as patientExaminationItemId', 'puei.test_readings as readings',
                    'puei.test_reading_status as readingStatus',
                    'puei.is_value_set as isValueSet');*/

                $urineTestQuery = DB::table('patient_urine_examination_item as puei');
                $urineTestQuery->join('patient_urine_examination as pue', 'pue.id', '=', 'puei.patient_urine_examination_id');
                $urineTestQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
                $urineTestQuery->join('urine_examination as ue1', 'ue1.id', '=', 'ue.parent_id');
                $urineTestQuery->where('pue.patient_id', '=', $patientId);
                $urineTestQuery->where('pue.examination_date', '=', $urineTestDate);
                $urineTestQuery->where('pue.examination_time', '=', $time->examination_time);
                $urineTestQuery->where('puei.is_value_set', '=', 1);
                $urineTestQuery->groupBy('ue.parent_id');
                $urineTestQuery->select('ue.parent_id', 'ue1.examination_name AS parent_examination_name');
                $urineTests = $urineTestQuery->get();

                //$urineTests = $urineTestQuery->get();

                foreach ($urineTests as $urineTest) {
                    $finalUrineTestQuery = DB::table('patient_urine_examination_item as puei');
                    $finalUrineTestQuery->join('patient_urine_examination as pue', 'pue.id', '=', 'puei.patient_urine_examination_id');
                    $finalUrineTestQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
                    $finalUrineTestQuery->where('pue.patient_id', '=', $patientId);
                    $finalUrineTestQuery->where('pue.examination_date', '=', $urineTestDate);
                    $finalUrineTestQuery->where('pue.examination_time', '=', $time->examination_time);
                    $finalUrineTestQuery->where('puei.is_value_set', '=', 1);
                    $finalUrineTestQuery->where('ue.parent_id', '=', $urineTest->parent_id);
                    $finalUrineTestQuery->select('pue.id as patientExaminationId', 'pue.patient_id', 'pue.hospital_id',
                        'ue.id as examinationId', 'ue.examination_name as examinationName',
                        'ue.is_parent',
                        'ue.normal_default_values as examinationDefaultValue',
                        'pue.examination_date as examinationDate', 'pue.examination_time',
                        'puei.id as patientExaminationItemId', 'puei.test_readings as readings', 'puei.test_reading_status as readingStatus',
                        'puei.is_value_set as isValueSet');

                    $testArray[$urineTest->parent_examination_name] = $finalUrineTestQuery->get();


                }

                //array_push($urineTestDetails, $urineTestRecord);
                //array_push($urineTestDetails, $urineTests);
                array_push($urineTestDetails, $testArray);

            }

            //dd($urineTestDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_ERROR, $exc);
        }

        return $urineTestDetails;
    }

    /**
     * Get patient motion tests
     * @param $patientId , $motionTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMotionTests($patientId, $motionTestDate)
    {
        $motionTests = null;
        $motionTestDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_motion_examination as pme')->select('me.id as examinationId', 'me.examination_name as examinationName',
                'pme.id as patientExaminationId', 'pme.is_value_set as isValueSet', 'pme.examination_date as examinationDate');
            //$query->rightJoin('scans as s', function($join){
            $query->join('motion_examination as me', function($join){
                $join->on('me.id', '=', 'pme.motion_examination_id');
                $join->on('pme.patient_id', '=', DB::raw('?'));
                $join->on('pme.examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $motionTestDate)));
            $query->where('me.status', '=', 1);

            //dd($query->toSql());

            $motionTests = $query->get();*/

            /*$motionTestQuery = DB::table('patient_motion_examination as pme');
            $motionTestQuery->join('motion_examination as me', 'me.id', '=', 'pme.motion_examination_id');
            $motionTestQuery->where('pme.patient_id', '=', $patientId);
            $motionTestQuery->where('pme.examination_date', '=', $motionTestDate);
            $motionTestQuery->where('pme.is_value_set', '=', 1);
            $motionTestQuery->select('pme.patient_id', 'pme.hospital_id', 'me.id as examinationId',
                'me.examination_name as examinationName', 'pme.examination_date as examinationDate',
                'pme.id as patientExaminationId', 'pme.is_value_set as isValueSet',
                'pme.examination_time');

            $motionTests = $motionTestQuery->get();*/

            $timeQuery = DB::table('patient_motion_examination as pme');
            $timeQuery->where('pme.patient_id', '=', $patientId);
            $timeQuery->where('pme.examination_date', '=', $motionTestDate);
            //$timeQuery->where('pme.is_value_set', '=', 1);
            $timeQuery->select('pme.examination_time');
            $timeQuery->groupBy('pme.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$motionTestRecord = array_filter($motionTests, function($e) use ($motionTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $motionTestQuery = DB::table('patient_motion_examination as pme');
                $motionTestQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
                $motionTestQuery->join('motion_examination as me', 'me.id', '=', 'pmei.motion_examination_id');
                $motionTestQuery->where('pme.patient_id', '=', $patientId);
                $motionTestQuery->where('pme.examination_date', '=', $motionTestDate);
                $motionTestQuery->where('pme.examination_time', '=', $time->examination_time);
                $motionTestQuery->where('pmei.is_value_set', '=', 1);
                $motionTestQuery->orderBy('pme.examination_time', 'DESC');
                $motionTestQuery->select('pme.id as patientExaminationId', 'pme.patient_id', 'pme.hospital_id', 'me.id as examinationId',
                    'me.examination_name as examinationName', 'me.normal_default_values as examinationDefaultValue', 'pme.examination_date as examinationDate',
                    'pmei.id as patientExaminationItemId', 'pmei.is_value_set as isValueSet', 'pmei.test_readings as Reading', 'pmei.test_reading_status as ReadingStatus',
                    'pme.examination_time');

                $motionTests = $motionTestQuery->get();

                //array_push($motionTestDetails, $motionTestRecord);
                array_push($motionTestDetails, $motionTests);

            }
            //dd($pregnancyDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_ERROR, $exc);
        }

        return $motionTestDetails;
    }

    /**
     * Get patient blood tests
     * @param $patientId , $bloodTestDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientBloodTests($patientId, $bloodTestDate)
    {
        $bloodTests = null;
        $finalBloodTests = null;

        //$bloodTestRecord = null;

        //$accommodations = array();
        $patientBloodTests = array();
        //$patientBloodTests = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_blood_examination as pbe')->select('be.id as examinationId', 'be.examination_name as examinationName',
                'pbe.id as patientExaminationId', 'pbe.is_value_set as isValueSet', 'pbe.examination_date as examinationDate');
            //$query->rightJoin('scans as s', function($join){
            $query->join('blood_examination as be', function($join){
                $join->on('be.id', '=', 'pbe.blood_examination_id');
                $join->on('pbe.patient_id', '=', DB::raw('?'));
                $join->on('pbe.examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $bloodTestDate)));
            $query->where('be.status', '=', 1);*/

            /*$query = DB::table('patient_blood_examination as pbe');
            $query->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $query->whereIn('pbe.examination_date', function($query) use($patientId, $bloodTestDate){
                $query->select('pbe.examination_date');
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                $query->where('pbe.examination_date', '=', $bloodTestDate);
            });
            $query->where('pbe.patient_id', '=', $patientId);
            $query->where('pbe.examination_date', '=', $bloodTestDate);
            //$patientHistoryQuery->where('pph.is_value_set', '=', 1);
            $query->select('be.id as examinationId', 'be.examination_name as examinationName', 'pbe.id as patientExaminationId',
                'pbe.is_value_set as isValueSet','pbe.examination_date as examinationDate');
            $query->orderBy('pbe.id', '=', 'ASC');*/

            /*$latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
            $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $latestBloodExamQuery->whereIn('pbe.examination_date', function($query) use($patientId, $bloodTestDate){
                $query->select('pbe.examination_date');
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                $query->where('pbe.examination_date', '=', $bloodTestDate);
            });
            $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $latestBloodExamQuery->where('pbe.examination_date', '=', $bloodTestDate);
            $latestBloodExamQuery->where('pbe.is_value_set', '=', 1);
            $latestBloodExamQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                'be.id as examinationId','be.examination_name as examinationName', 'pbe.examination_date as examinationDate',
                'pbe.examination_time',
                'pbe.is_value_set as isValueSet');

            $bloodTests = $latestBloodExamQuery->get();*/


            /*$latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
            $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $latestBloodExamQuery->where('pbe.examination_date', '=', $bloodTestDate);
            $latestBloodExamQuery->where('pbe.is_value_set', '=', 1);
            //$latestBloodExamQuery->groupBy('pbe.id');
            $latestBloodExamQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                'be.id as examinationId','be.examination_name as examinationName', 'pbe.examination_date as examinationDate',
                'pbe.examination_time',
                'pbe.is_value_set as isValueSet');

            $bloodTests = $latestBloodExamQuery->get();*/

            //dd($bloodTests);
            //$bloodTests = $latestBloodExamQuery->get();
            //dd($patientHistoryQuery->toSql());
            //$personalHistoryDetails = $query->get();

            $timeQuery = DB::table('patient_blood_examination as pbe');
            $timeQuery->where('pbe.patient_id', '=', $patientId);
            $timeQuery->where('pbe.examination_date', '=', $bloodTestDate);
            //$timeQuery->where('pbe.is_value_set', '=', 1);
            $timeQuery->select('pbe.examination_time');
            $timeQuery->groupBy('pbe.examination_time');
            $timeQuery->orderBy('pbe.examination_time', 'desc');

            $examinationTime = $timeQuery->get();

            /*if(!is_null($examinationTime) && !empty($examinationTime))
            {
                foreach($examinationTime as $time)
                {
                    $latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
                    $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
                    $latestBloodExamQuery->whereIn('pbe.examination_date', function($query) use($patientId, $bloodTestDate){
                        $query->select('pbe.examination_date');
                        $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                        $query->where('pbe.examination_date', '=', $bloodTestDate);
                    });
                    $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
                    $latestBloodExamQuery->where('pbe.examination_date', '=', $bloodTestDate);
                    $latestBloodExamQuery->where('pbe.is_value_set', '=', 1);
                    $latestBloodExamQuery->where('pbe.examination_time', '=', $time->examination_time);
                    $latestBloodExamQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                        'be.id as examinationId','be.examination_name as examinationName', 'pbe.examination_date as examinationDate',
                        'pbe.examination_time',
                        'pbe.is_value_set as isValueSet');

                    $bloodTests = $latestBloodExamQuery->get();

                    array_push($accommodations, $bloodTests);
                }
            }*/


            //dd($examinationTime);
            //$accommodations = null;
            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                //$accommodations = array();
                /*$bloodTestRecord = array_filter($bloodTests, function($e) use ($bloodTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                /*$latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
                $latestBloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
                $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
                $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
                $latestBloodExamQuery->where('pbe.examination_date', '=', $bloodTestDate);
                $latestBloodExamQuery->where('pbe.examination_time', '=', $time->examination_time);
                $latestBloodExamQuery->where('pbei.is_value_set', '=', 1);
                $latestBloodExamQuery->orderBy('pbe.examination_time', 'DESC');
                //$latestBloodExamQuery->groupBy('pbe.id');
                $latestBloodExamQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                    'be.id as examinationId','be.examination_name as examinationName','be.default_normal_values as examinationDefaultValue', 'pbe.examination_date as examinationDate',
                    'pbe.examination_time', 'pbei.id as patientExaminationItemId','pbei.test_readings as Reading','pbei.test_reading_status as ReadingStatus',
                    'pbei.is_value_set as isValueSet');*/

                //$subQuery = BloodExamination::where('status', '=', 1);

                //$latestBloodExamQuery =

                /*$latestBloodExamQuery = DB::select("(SELECT pbe.id as patientExaminationId, pbe.patient_id, pbe.hospital_id,
                                        be.id AS examinationId, be.examination_name as examinationName,
                                        be.default_normal_values as examinationDefaultValue, pbe.examination_date as examinationDate,
                                        pbe.examination_time, be.parent_id,
                                        be1.examination_name AS parent_examination_name,
                                        pbei.id as examinationItemId, pbei.is_value_set FROM
                                        (SELECT be1.id, be1.parent_id, be1.examination_name FROM blood_examination be1
                                            WHERE be1.status = 1) AS be1,
                                        patient_blood_examination_item pbei
                                        INNER JOIN blood_examination be ON be.id = pbei.blood_examination_id
                                        INNER JOIN patient_blood_examination pbe ON pbe.id = pbei.patient_blood_examination_id
                                        WHERE be1.id = be.parent_id
                                        AND pbe.patient_id = ".$patientId."
                                        AND pbe.examination_date = '".$bloodTestDate."'
                                        AND pbe.examination_time = '".$time->examination_time."'
                                        AND pbei.is_value_set = 1
                                        ORDER BY pbe.examination_time DESC )");*/

                /*$latestBloodExamQuery = DB::select("(SELECT pbe.id as patientExaminationId, pbe.patient_id, pbe.hospital_id,
                                        be.id AS examinationId, be.examination_name as examinationName,
                                        be.default_normal_values as examinationDefaultValue, pbe.examination_date as examinationDate,
                                        pbe.examination_time, be.parent_id,
                                        be1.examination_name AS parent_examination_name,
                                        pbei.id as examinationItemId, pbei.is_value_set FROM
                                        (SELECT be1.id, be1.parent_id, be1.examination_name FROM blood_examination be1
                                            WHERE be1.status = 1) AS be1,
                                        patient_blood_examination_item pbei
                                        INNER JOIN blood_examination be ON be.id = pbei.blood_examination_id
                                        INNER JOIN patient_blood_examination pbe ON pbe.id = pbei.patient_blood_examination_id
                                        WHERE be1.id = be.parent_id
                                        AND pbe.patient_id = :patientId
                                        AND pbe.examination_date = :bloodTestDate
                                        AND pbe.examination_time = :examinationTime
                                        AND pbei.is_value_set = 1
                                        ORDER BY pbe.examination_time DESC )", array('patientId' => $patientId,
                                                'bloodTestDate' => $bloodTestDate, 'examinationTime' => $time->examination_time));*/

                /*$latestBloodExamQuery = DB::table('patient_blood_examination_item as pbei');
                $latestBloodExamQuery->join('patient_blood_examination as pbe', 'pbe.id', '=', 'pbei.patient_blood_examination_id');
                $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
                $latestBloodExamQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');
                $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
                $latestBloodExamQuery->where('pbe.examination_date', '=', $bloodTestDate);
                $latestBloodExamQuery->where('pbe.examination_time', '=', $time->examination_time);
                $latestBloodExamQuery->where('pbei.is_value_set', '=', 1);
                $latestBloodExamQuery->orderBy('pbe.examination_time', 'DESC');
                //$latestBloodExamQuery->groupBy('pbe.id');
                $latestBloodExamQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                    'be.id as examinationId', 'be.examination_name as examinationName', 'be1.parent_id',
                    'be1.examination_name AS parent_examination_name', 'be.is_parent',
                    'be.default_normal_values as examinationDefaultValue',
                    'pbe.examination_date as examinationDate', 'pbe.examination_time',
                    'pbei.id as patientExaminationItemId','pbei.test_readings as readings','pbei.test_reading_status as readingStatus',
                    'pbei.is_value_set as isValueSet');*/
                //dd($latestBloodExamQuery->toSql());
                //$latestBloodExamQuery->groupBy('pbe.id');

                $bloodTestQuery = DB::table('patient_blood_examination_item as pbei');
                $bloodTestQuery->join('patient_blood_examination as pbe', 'pbe.id', '=', 'pbei.patient_blood_examination_id');
                $bloodTestQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
                $bloodTestQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');
                $bloodTestQuery->where('pbe.patient_id', '=', $patientId);
                $bloodTestQuery->where('pbe.examination_date', '=', $bloodTestDate);
                $bloodTestQuery->where('pbe.examination_time', '=', $time->examination_time);
                $bloodTestQuery->where('pbei.is_value_set', '=', 1);
                $bloodTestQuery->groupBy('be.parent_id');
                $bloodTestQuery->select('be.parent_id', 'be1.examination_name AS parent_examination_name');
                $bloodTests = $bloodTestQuery->get();

                foreach ($bloodTests as $bloodTest) {
                    $finalBloodTestQuery = DB::table('patient_blood_examination_item as pbei');
                    $finalBloodTestQuery->join('patient_blood_examination as pbe', 'pbe.id', '=', 'pbei.patient_blood_examination_id');
                    $finalBloodTestQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
                    $finalBloodTestQuery->where('pbe.patient_id', '=', $patientId);
                    $finalBloodTestQuery->where('pbe.examination_date', '=', $bloodTestDate);
                    $finalBloodTestQuery->where('pbe.examination_time', '=', $time->examination_time);
                    $finalBloodTestQuery->where('pbei.is_value_set', '=', 1);
                    $finalBloodTestQuery->where('be.parent_id', '=', $bloodTest->parent_id);
                    //$finalBloodTestQuery->select('be.parent_id');
                    $finalBloodTestQuery->select('pbe.id as patientExaminationId', 'pbe.patient_id', 'pbe.hospital_id',
                        'be.id as examinationId', 'be.examination_name as examinationName',
                        'be.is_parent',
                        'be.default_normal_values as examinationDefaultValue',
                        'pbe.examination_date as examinationDate', 'pbe.examination_time',
                        'pbei.id as patientExaminationItemId', 'pbei.test_readings as readings', 'pbei.test_reading_status as readingStatus',
                        'pbei.is_value_set as isValueSet');

                    $finalBloodTests[$bloodTest->parent_examination_name] = $finalBloodTestQuery->get();


                }


                //$bloodTests = $latestBloodExamQuery->get();

                //dd($bloodTests);

                /*$bloodTestRecord = array_filter($bloodTests, function($e) use ($bloodTests, $bloodArray){
                    if($e->examinationId != $e->parent_id)
                    {
                        if(!in_array($e->parent_id, $bloodArray))
                        {
                            //dd($e->parent_id);
                            //array_push($bloodArray, $e->parent_id);
                            //dd($bloodArray);
                            return true;
                        }
                        else
                        {
                            //dd('Inside else');
                            return false;
                        }

                    }
                    else
                    {
                        return false;
                    }
                });*/

                //dd($bloodTestRecord);

                //array_push($bloodArray, $bloodTestRecord[0]['parent_id']);


                //dd($bloodArray);

                //$patientBloodTests = $bloodTestRecord;
                //dd($bloodTestRecord);

                //array_push($patientBloodTests, $latestBloodExamQuery);
                //array_push($patientBloodTests, $bloodTests);

                array_push($patientBloodTests, $finalBloodTests);

            }

            //dd($patientBloodTests);


        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_ERROR, $exc);
        }

        //dd($patientBloodTests);
        return $patientBloodTests;
        //return $bloodTestRecord;
    }

    private function filterArray($value)
    {
        //return ($value == 2);
    }

    /**
     * Get patient ultrasound tests
     * @param $patientId , $ultraSoundDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUltraSoundTests($patientId, $ultraSoundDate)
    {
        $ultraSound = null;
        $ultraSoundDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_ultra_sound as pus')->select('us.id as examinationId', 'us.examination_name as examinationName',
                'pus.id as patientExaminationId', 'pus.is_value_set as isValueSet', 'pus.examination_date as examinationDate');
            //$query->rightJoin('scans as s', function($join){
            $query->join('ultra_sound as us', function($join){
                $join->on('us.id', '=', 'pus.ultra_sound_id');
                $join->on('pus.patient_id', '=', DB::raw('?'));
                $join->on('pus.examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $ultraSoundDate)));
            $query->where('us.status', '=', 1);

            //dd($query->toSql());

            $ultraSound = $query->get();*/

            /*$ultraSoundQuery = DB::table('patient_ultra_sound as pus');
            $ultraSoundQuery->join('ultra_sound as us', 'us.id', '=', 'pus.ultra_sound_id');
            $ultraSoundQuery->where('pus.patient_id', '=', $patientId);
            $ultraSoundQuery->where('pus.examination_date', '=', $ultraSoundDate);
            $ultraSoundQuery->where('pus.is_value_set', '=', 1);
            $ultraSoundQuery->orderBy('pus.examination_time', 'DESC');
            $ultraSoundQuery->select('pus.patient_id', 'pus.hospital_id', 'us.id as examinationId',
                'us.examination_name as examinationName', 'pus.examination_date as examinationDate',
                'pus.id as patientExaminationId', 'pus.is_value_set as isValueSet',
                'pus.examination_time');

            $ultraSound = $ultraSoundQuery->get();*/

            $timeQuery = DB::table('patient_ultra_sound as pus');
            $timeQuery->where('pus.patient_id', '=', $patientId);
            $timeQuery->where('pus.examination_date', '=', $ultraSoundDate);
            //$timeQuery->where('pus.is_value_set', '=', 1);
            $timeQuery->select('pus.examination_time');
            $timeQuery->groupBy('pus.examination_time');

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$ultraSoundTestRecord = array_filter($ultraSound, function($e) use ($ultraSound, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $ultraSoundQuery = DB::table('patient_ultra_sound as pus');
                $ultraSoundQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
                $ultraSoundQuery->join('ultra_sound as us', 'us.id', '=', 'pusi.ultra_sound_id');
                $ultraSoundQuery->where('pus.patient_id', '=', $patientId);
                $ultraSoundQuery->where('pus.examination_date', '=', $ultraSoundDate);
                $ultraSoundQuery->where('pus.examination_time', '=', $time->examination_time);
                $ultraSoundQuery->where('pusi.is_value_set', '=', 1);
                $ultraSoundQuery->orderBy('pus.examination_time', 'DESC');
                $ultraSoundQuery->select('pus.id as patientExaminationId', 'pus.patient_id', 'pus.hospital_id', 'us.id as examinationId',
                    'us.examination_name as examinationName', 'pus.examination_date as examinationDate',
                    'pusi.id as patientExaminationItemId', 'pusi.is_value_set as isValueSet',
                    'pus.examination_time');

                $ultraSound = $ultraSoundQuery->get();

                //array_push($ultraSoundDetails, $ultraSoundTestRecord);
                array_push($ultraSoundDetails, $ultraSound);

            }

            //dd($pregnancyDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR, $exc);
        }

        return $ultraSoundDetails;
    }

    /**
     * Get patient dental tests
     * @param $patientId , $dentalDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDentalTests($patientId, $dentalDate)
    {
        $dentalTests = null;
        $dentalTestDetails = array();

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_dental_examination_item as pdei')->select('dei.id as examinationId',
                'dei.examination_name as examinationName',
                'pdei.id as patientExaminationId', 'pde.examination_date as examinationDate');
            $query->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $query->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');
            $query->where('pde.patient_id', '=', $patientId);
            $query->where('pde.examination_date', '=', $dentalDate);*/

            //$query->rightJoin('scans as s', function($join){
            /*$query->join('ultra_sound as us', function($join){
                $join->on('us.id', '=', 'pus.ultra_sound_id');
                $join->on('pus.patient_id', '=', DB::raw('?'));
                $join->on('pus.examination_date', '=', DB::raw('?'));
            })->setBindings(array_merge($query->getBindings(), array($patientId, $ultraSoundDate)));*/
            //$query->where('us.status', '=', 1);

            //dd($query->toSql());

            //$dentalTests = $query->get();
            //dd($pregnancyDetails);

            /*$dentalTestQuery = DB::table('patient_dental_examination_item as pdei');
            $dentalTestQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $dentalTestQuery->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');
            $dentalTestQuery->where('pde.patient_id', '=', $patientId);
            $dentalTestQuery->where('pde.examination_date', '=', $dentalDate);
            $dentalTestQuery->orderBy('pde.examination_time', 'DESC');
            //$dentalTestQuery->where('pme.is_value_set', '=', 1);
            $dentalTestQuery->select('pde.patient_id', 'pde.hospital_id', 'dei.id as examinationId',
                'dei.examination_name as examinationName', 'pde.examination_date as examinationDate',
                'pdei.id as patientExaminationId', 'pde.examination_time');

            $dentalTests = $dentalTestQuery->get();*/

            $timeQuery = DB::table('patient_dental_examination as pde');
            $timeQuery->where('pde.patient_id', '=', $patientId);
            $timeQuery->where('pde.examination_date', '=', $dentalDate);
            //$timeQuery->where('pme.is_value_set', '=', 1);
            $timeQuery->select('pde.examination_time');
            $timeQuery->groupBy('pde.examination_time');

            //dd($timeQuery->toSql());

            $examinationTime = $timeQuery->get();

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$dentalTestRecord = array_filter($dentalTests, function($e) use ($dentalTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                $dentalTestQuery = DB::table('patient_dental_examination_item as pdei');
                $dentalTestQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
                $dentalTestQuery->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');
                $dentalTestQuery->join('dental_category as dc', 'dc.id', '=', 'dei.dental_category_id');
                $dentalTestQuery->where('pde.patient_id', '=', $patientId);
                $dentalTestQuery->where('pde.examination_date', '=', $dentalDate);
                $dentalTestQuery->where('pde.examination_time', '=', $time->examination_time);
                $dentalTestQuery->orderBy('pde.examination_time', 'DESC');
                //$dentalTestQuery->where('pme.is_value_set', '=', 1);
                $dentalTestQuery->select('pde.patient_id', 'pde.hospital_id', 'dc.id as categoryId',
                    'dei.id as examinationId', 'dc.category_name',
                    'dei.examination_name as examinationName', 'pde.examination_date as examinationDate',
                    'pdei.id as patientExaminationId', 'pde.examination_time');

                //dd($dentalTestQuery->toSql());

                $dentalTests = $dentalTestQuery->get();

                //array_push($dentalTestDetails, $dentalTestRecord);
                array_push($dentalTestDetails, $dentalTests);

            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_DETAILS_ERROR, $exc);
        }

        //dd($dentalTestDetails);
        return $dentalTestDetails;
    }

    /**
     * Get patient xray tests
     * @param $patientId , $xrayDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientXrayTests($patientId, $xrayDate)
    {
        $patientXrayTests = null;
        $xrayTestDetails = array();

        $finalXrayTests = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            /*$query = DB::table('patient_xray_examination_item as pxei')->select('xe.id as examinationId',
                'xe.examination_name as examinationName',
                'pxei.id as patientExaminationId', 'pxe.examination_date as examinationDate');
            $query->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $query->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_id');
            $query->where('pxe.patient_id', '=', $patientId);
            $query->where('pxe.examination_date', '=', $xrayDate);

            //dd($query->toSql());

            $patientXrayTests = $query->get();*/
            //dd($patientXrayTests);

            /*$xrayTestQuery = DB::table('patient_xray_examination_item as pxei');
            $xrayTestQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $xrayTestQuery->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_id');
            $xrayTestQuery->where('pxe.patient_id', '=', $patientId);
            $xrayTestQuery->where('pxe.examination_date', '=', $xrayDate);
            $xrayTestQuery->orderBy('pxe.examination_time', 'DESC');
            //$dentalTestQuery->where('pme.is_value_set', '=', 1);
            $xrayTestQuery->select('pxe.patient_id', 'pxe.hospital_id', 'xe.id as examinationId',
                'xe.examination_name as examinationName', 'pxe.examination_date as examinationDate',
                'pxei.id as patientExaminationId', 'pxe.examination_time');

            $patientXrayTests = $xrayTestQuery->get();*/

            $timeQuery = DB::table('patient_xray_examination as pxe');
            $timeQuery->where('pxe.patient_id', '=', $patientId);
            $timeQuery->where('pxe.examination_date', '=', $xrayDate);
            //$timeQuery->where('pme.is_value_set', '=', 1);
            $timeQuery->select('pxe.examination_time');
            $timeQuery->groupBy('pxe.examination_time');

            $examinationTime = $timeQuery->get();

            //dd($examinationTime);

            foreach ($examinationTime as $time) {
                //dd($time->examination_time);
                /*$xrayTestRecord = array_filter($patientXrayTests, function($e) use ($patientXrayTests, $time){
                    if($e->examination_time == $time->examination_time)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                });*/

                //$dentalTestQuery->where('pme.is_value_set', '=', 1);

                $xrayTestQuery = DB::table('patient_xray_examination_item as pxei');
                $xrayTestQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
                $xrayTestQuery->join('xray_examination_items as xei', 'xei.id', '=', 'pxei.xray_examination_item_id');
                $xrayTestQuery->join('xray_category as xc', 'xc.id', '=', 'xei.xray_category_id');
                $xrayTestQuery->where('pxe.patient_id', '=', $patientId);
                $xrayTestQuery->where('pxe.examination_date', '=', $xrayDate);
                $xrayTestQuery->where('pxe.examination_time', '=', $time->examination_time);
                $xrayTestQuery->orderBy('pxe.examination_time', 'DESC');
                //$dentalTestQuery->where('pme.is_value_set', '=', 1);
                $xrayTestQuery->select('pxe.patient_id', 'pxe.hospital_id', 'xc.id as categoryId',
                    'xei.id as examinationId', 'xc.category_name',
                    'xei.examination_name as examinationName', 'pxe.examination_date as examinationDate',
                    'pxei.id as patientExaminationId', 'pxe.examination_time');

                $xrayTests = $xrayTestQuery->get();

                /*$xrayTestQuery = DB::table('patient_xray_examination_item as pxei');
                $xrayTestQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
                $xrayTestQuery->join('xray_examination_items as xei', 'xei.id', '=', 'pxei.xray_examination_item_id');
                $xrayTestQuery->join('xray_category as xc', 'xc.id', '=', 'xei.xray_category_id');
                $xrayTestQuery->where('pxe.patient_id', '=', $patientId);
                $xrayTestQuery->where('pxe.examination_date', '=', $xrayDate);
                $xrayTestQuery->where('pxe.examination_time', '=', $time->examination_time);
                $xrayTestQuery->groupBy('xc.id');
                $xrayTestQuery->select('xc.id', 'xc.category_name');
                $xrayTests = $xrayTestQuery->get();

                foreach($xrayTests as $xrayTest)
                {
                    $finalXrayTestQuery = DB::table('patient_xray_examination_item as pxei');
                    $finalXrayTestQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
                    $finalXrayTestQuery->join('xray_examination_items as xei', 'xei.id', '=', 'pxei.xray_examination_item_id');
                    $finalXrayTestQuery->join('xray_category as xc', 'xc.id', '=', 'xei.xray_category_id');
                    $finalXrayTestQuery->where('pxe.patient_id', '=', $patientId);
                    $finalXrayTestQuery->where('pxe.examination_date', '=', $xrayDate);
                    $finalXrayTestQuery->where('pxe.examination_time', '=', $time->examination_time);
                    $finalXrayTestQuery->where('xc.id', '=', $xrayTest->id);
                    //$finalBloodTestQuery->select('be.parent_id');
                    $finalXrayTestQuery->select('pxe.id as patientExaminationId', 'pxe.patient_id', 'pxe.hospital_id',
                        'xei.id as examinationId', 'xei.examination_name as examinationName',
                        'pxe.examination_date as examinationDate', 'pxe.examination_time',
                        'pxei.id as patientExaminationItemId', 'xc.id as category_id', 'xc.category_name');

                    $finalXrayTests[$xrayTest->category_name] = $finalXrayTestQuery->get();
                }*/

                //$patientXrayTests = $xrayTestQuery->get();

                array_push($xrayTestDetails, $xrayTests);
                //array_push($xrayTestDetails, $finalXrayTests);

                //dd($xrayTestDetails);


            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_DETAILS_ERROR, $exc);
        }

        return $xrayTestDetails;
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

        try {
            $query = DB::table('blood_examination as be')->where('be.status', '=', 1);
            $query->where('be.is_parent', '=', 1);
            $query->select('be.id', 'be.examination_name');

            $bloodTests = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::BLOODTEST_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::BLOODTEST_LIST_ERROR, $exc);
        }

        return $bloodTests;
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

        try {
            $query = DB::table('urine_examination as ue')->where('ue.status', '=', 1);
            $query->where('ue.is_parent', '=', 1);
            $query->select('ue.id', 'ue.examination_name');

            $urineTests = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::URINETEST_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::URINETEST_LIST_ERROR, $exc);
        }

        return $urineTests;
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

        try {
            $query = DB::table('family_illness as fi')->where('fi.status', '=', 1);
            $query->select('fi.id', 'fi.illness_name');

            $familyIllness = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::FAMILY_ILLNESS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('past_illness as pi')->where('pi.status', '=', 1);
            $query->select('pi.id', 'pi.illness_name');

            $pastIllness = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PAST_ILLNESS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('general_examination as ge')->where('ge.status', '=', 1);
            $query->select('ge.id', 'ge.general_examination_name');

            $generalExaminations = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::GENERAL_EXAMINATIONS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('personal_history as ph')->where('ph.status', '=', 1);
            $query->select('ph.id', 'ph.personal_history_name');

            $personalHistory = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PERSONAL_HISTORY_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('pregnancy as p')->where('p.status', '=', 1);
            $query->select('p.id', 'p.pregnancy_details');

            $pregnancy = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PREGNANCY_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('scans as s')->where('s.status', '=', 1);
            $query->select('s.id', 's.scan_name');

            $scans = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::SCAN_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('dental_examination_items as dei')->where('dei.examination_status', '=', 1);
            $query->join('dental_category as dc', 'dc.id', '=', 'dei.dental_category_id');
            $query->select('dei.id', 'dei.examination_name', 'dc.id as category_id', 'dc.category_name');

            //dd($query->toSql());
            $dentalExaminations = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::DENTAL_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            /*$query = DB::table('xray_examination as xe')->where('xe.status', '=', 1);
            $query->select('xe.id', 'xe.examination_name', 'xe.category');*/

            $query = DB::table('xray_examination_items as xei')->where('xei.examination_status', '=', 1);
            $query->join('xray_category as xc', 'xc.id', '=', 'xei.xray_category_id');
            $query->select('xei.id', 'xei.examination_name', 'xc.id as category_id', 'xc.category_name');

            $xrayExaminations = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::XRAY_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::XRAY_LIST_ERROR, $exc);
        }

        return $xrayExaminations;
    }

    /**
     * Get patient lab tests by hospital and fee status
     * @param $patientId , $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientLabTests($hospitalId, $patientId, $feeStatus = null)
    {
        $patientLabTests = null;
        //$bloodExamination = null;
        $motionExamination = null;
        $scanExamination = null;
        $ultraSoundExamination = null;
        $urineExamination = null;

        try {
            $patientUser = User::find($patientId);
            $hospitalUser = User::find($hospitalId);

            //dd($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            if (is_null($hospitalUser)) {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }

            $bloodExaminationQuery = DB::table('patient as p');
            $bloodExaminationQuery->join('patient_blood_examination as pbe', 'pbe.patient_id', '=', 'p.patient_id');
            //$bloodExaminationQuery->
            //'pbe.id', 'pbe.examination_date', 'pbe.is_fees_paid');

            $bloodExaminationQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $bloodExaminationQuery->where('pbe.patient_id', $patientId);
            $bloodExaminationQuery->where('pbe.hospital_id', $hospitalId);
            if (!is_null($feeStatus)) {
                //dd('Inside not null');
                $bloodExaminationQuery->where('pbe.is_fees_paid', $feeStatus);
            }
            $bloodExaminationQuery->select('p.patient_id', 'p.name', 'p.pid', 'pbe.id', 'pbe.examination_date',
                'pbe.is_fees_paid', 'pbe.examination_type', 'be.examination_name');
            //$bloodExaminationQuery->groupBy('pbe.examination_date');

            //dd($bloodExaminationQuery->toSql());
            $bloodExamination = $bloodExaminationQuery->get();
            //dd($bloodExamination);

            $motionExaminationQuery = DB::table('patient_motion_examination as pme');
            $motionExaminationQuery->join('patient as p', 'p.patient_id', '=', 'pme.patient_id');
            $motionExaminationQuery->join('motion_examination as me', 'me.id', '=', 'pme.motion_examination_id');
            $motionExaminationQuery->where('pme.patient_id', '=', $patientId);
            $motionExaminationQuery->where('pme.hospital_id', '=', $hospitalId);
            if (!is_null($feeStatus)) {
                $motionExaminationQuery->where('pme.is_fees_paid', '=', $feeStatus);
            }
            $motionExaminationQuery->select('p.patient_id', 'p.name', 'p.pid',
                'pme.id', 'pme.examination_date', 'pme.is_fees_paid', 'pme.examination_type', 'me.examination_name');
            $motionExamination = $motionExaminationQuery->get();

            $scanQuery = DB::table('patient_scan as ps');
            $scanQuery->join('patient as p', 'p.patient_id', '=', 'ps.patient_id');
            $scanQuery->join('scans as s', 's.id', '=', 'ps.scan_id');
            $scanQuery->where('ps.patient_id', '=', $patientId);
            $scanQuery->where('ps.hospital_id', '=', $hospitalId);
            if (!is_null($feeStatus)) {
                $scanQuery->where('ps.is_fees_paid', '=', $feeStatus);
            }
            $scanQuery->select('p.patient_id', 'p.name', 'p.pid',
                'ps.id', 'ps.scan_date', 'ps.is_fees_paid', 'ps.examination_type', 's.scan_name');
            $scanExamination = $scanQuery->get();

            $ultraSoundQuery = DB::table('patient_ultra_sound as pus');
            $ultraSoundQuery->join('patient as p', 'p.patient_id', '=', 'pus.patient_id');
            $ultraSoundQuery->join('ultra_sound as us', 'us.id', '=', 'pus.ultra_sound_id');
            $ultraSoundQuery->where('pus.patient_id', '=', $patientId);
            $ultraSoundQuery->where('pus.hospital_id', '=', $hospitalId);
            if (!is_null($feeStatus)) {
                $ultraSoundQuery->where('pus.is_fees_paid', '=', $feeStatus);
            }
            $ultraSoundQuery->select('p.patient_id', 'p.name', 'p.pid',
                'pus.id', 'pus.examination_date', 'pus.is_fees_paid', 'pus.examination_type', 'us.examination_name');
            $ultraSoundExamination = $ultraSoundQuery->get();

            $urineExaminationQuery = DB::table('patient_urine_examination as pue');
            $urineExaminationQuery->join('patient as p', 'p.patient_id', '=', 'pue.patient_id');
            $urineExaminationQuery->join('urine_examination as ue', 'ue.id', '=', 'pue.urine_examination_id');
            $urineExaminationQuery->where('pue.patient_id', '=', $patientId);
            $urineExaminationQuery->where('pue.hospital_id', '=', $hospitalId);
            if (!is_null($feeStatus)) {
                $urineExaminationQuery->where('pue.is_fees_paid', '=', $feeStatus);
            }
            $urineExaminationQuery->select('p.patient_id', 'p.name', 'p.pid',
                'pue.id', 'pue.examination_date', 'pue.is_fees_paid', 'pue.examination_type', 'ue.examination_name');
            $urineExamination = $urineExaminationQuery->get();

            $patientLabTests["bloodExamination"] = $bloodExamination;
            $patientLabTests["motionExamination"] = $motionExamination;
            $patientLabTests["scanExamination"] = $scanExamination;
            $patientLabTests["ultraSoundExamination"] = $ultraSoundExamination;
            $patientLabTests["urineExamination"] = $urineExamination;

            //dd($patientLabTests);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LABTEST_FEES_STATUS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            throw new HospitalException(null, ErrorEnum::PATIENT_LABTEST_FEES_STATUS_ERROR, $exc);
        }

        return $patientLabTests;
    }

    /**
     * Get patient lab test details by patient and labtesttype
     * @param $patientId , $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetailsByPatient($labTestType, $labTestId)
    {

        $doctorId = null;
        $hospitalId = null;
        $patientDetails = null;
        $doctorDetails = null;
        $hospitalDetails = null;
        $examinationDetails = null;
        $patientId = null;

        try {
            //dd($labTestId);
            $tableName = CA::get('constants.' . $labTestType);

            /*\DB::listen(function($sql, $bindings, $time) {
                var_dump($sql);
                var_dump($bindings);
                var_dump($time);
                dd($sql. "   ".$bindings);
            });*/

            //dd(DB::getQueryLog());

            //dd($sql)

            $examinationQuery = DB::table($tableName . ' as ltd')->where('ltd.id', '=', $labTestId);
            //$examinationQuery->select('ltd.id', '')
            $examinationQuery->select('ltd.id', 'ltd.patient_id as patientId', 'ltd.doctor_id as doctorId',
                'ltd.hospital_id as hospitalId');

            $examinationDetails = $examinationQuery->first();

            //dd($examinationQuery->toSql());
            /*DB::connection()->enableQueryLog();
            $examinationDetails = $examinationQuery->first();
            $query = DB::getQueryLog();
            //$lastQuery = end($query);
            dd($query);*/

            //dd($examinationDetails);

            $doctorId = $examinationDetails->doctorId;
            $hospitalId = $examinationDetails->hospitalId;
            $patientId = $examinationDetails->patientId;

            /*$fees = $feeInfo->fee;

            $feeWords = $this->convertFee($fees);
            //dd($feeWords);

            //$feeDetails = (array)$feeInfo;
            $feeDetails['inWords'] = $feeWords;
            $feeDetails['fee'] = $fees;

            //array_push($feeDetails, $feeWords);
            //dd($feeDetails);

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $doctorQuery = DB::table('doctor as d')->select('d.id', 'd.doctor_id', 'd.name', 'd.did', 'd.designation',
                'd.specialty as department');
            $doctorQuery->where('d.doctor_id', '=', $doctorId);
            $doctorDetails = $doctorQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.hid',
                'h.address', 'h.hospital_logo', 'c.city_name as cityName', 'co.name as country');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $feeReceiptDetails["patientDetails"] = $patientDetails;
            $feeReceiptDetails["doctorDetails"] = $doctorDetails;
            $feeReceiptDetails["hospitalDetails"] = $hospitalDetails;
            $feeReceiptDetails["feeDetails"] = $feeDetails;*/

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_DETAILS_ERROR, $exc);
        }

        //dd($feeReceiptDetails);
        return $examinationDetails;
    }

    /**
     * Get lab receipt details for the patient
     * @param $patientId , $hospitalId, $feeReceiptId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientReceiptDetails($hospitalId, $patientId, $feeReceiptId)
    {
        $labReceiptDetails = null;

        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
            //DB::connection()->enableQueryLog();

            $bloodExamQuery = DB::table('patient_blood_examination as pbe');
            $bloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $bloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
            $bloodExamQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');

            //  $bloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            // $bloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');

            $bloodExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pbe.fee_receipt_id');
            $bloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $bloodExamQuery->where('pbe.hospital_id', '=', $hospitalId);
            $bloodExamQuery->where('pbe.fee_receipt_id', '=', $feeReceiptId);
            $bloodExamQuery->whereNotNull('pbei.fees');
            $bloodExamQuery->select('pbe.id', 'pbe.patient_id', 'pbe.hospital_id', 'be.examination_name', 'pbe.examination_date',
                'pbei.fees', 'be1.examination_name as parent_examination_name');

            //dd($bloodExamQuery->toSql());
            $bloodExaminations = $bloodExamQuery->get();

            $motionExamQuery = DB::table('patient_motion_examination as pme');
            $motionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $motionExamQuery->join('motion_examination as me', 'me.id', '=', 'pmei.motion_examination_id');
            $motionExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pme.fee_receipt_id');
            $motionExamQuery->where('pme.patient_id', '=', $patientId);
            $motionExamQuery->where('pme.hospital_id', '=', $hospitalId);
            $motionExamQuery->where('pme.fee_receipt_id', '=', $feeReceiptId);
            $motionExamQuery->where('pmei.is_value_set', '=', 1);
            $motionExamQuery->whereNotNull('pmei.fees');
            $motionExamQuery->select('pme.id', 'pme.patient_id', 'pme.hospital_id', 'me.examination_name', 'pme.examination_date',
                'pmei.fees');

            //dd($motionExamQuery->toSql());
            $motionExaminations = $motionExamQuery->get();
            //$query = DB::getQueryLog();
            //dd($query);
            //dd($motionExaminations);

            $urineExamQuery = DB::table('patient_urine_examination as pue');
            $urineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $urineExamQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');

            $urineExamQuery->join('urine_examination as ue1', 'ue1.id', '=', 'ue.parent_id');

            $urineExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pue.fee_receipt_id');
            $urineExamQuery->where('pue.patient_id', '=', $patientId);
            $urineExamQuery->where('pue.hospital_id', '=', $hospitalId);
            $urineExamQuery->where('pue.fee_receipt_id', '=', $feeReceiptId);

            $urineExamQuery->where('puei.is_value_set', '=', 1);
            $urineExamQuery->select('pue.id', 'ue1.examination_name as parent_examination_name', 'pue.patient_id', 'pue.hospital_id', 'ue.examination_name', 'pue.examination_date', 'puei.fees');
            //$urineExamQuery->select('pue.id', 'pue.patient_id', 'pue.hospital_id', 'ue.examination_name', 'pue.examination_date', 'puei.fees');

            //  $urineExamQuery->select('pue.id', 'pue.patient_id', 'pue.hospital_id', 'ue.examination_name', 'pue.examination_date',
            // 'puei.fees');

            //dd($bloodExamQuery->toSql());
            $urineExaminations = $urineExamQuery->get();

            $ultraSoundExamQuery = DB::table('patient_ultra_sound as pus');
            $ultraSoundExamQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
            $ultraSoundExamQuery->join('ultra_sound as us', 'us.id', '=', 'pusi.ultra_sound_id');
            $ultraSoundExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pus.fee_receipt_id');
            $ultraSoundExamQuery->where('pus.patient_id', '=', $patientId);
            $ultraSoundExamQuery->where('pus.hospital_id', '=', $hospitalId);
            $ultraSoundExamQuery->where('pus.fee_receipt_id', '=', $feeReceiptId);
            $ultraSoundExamQuery->whereNotNull('pusi.fees');
            $ultraSoundExamQuery->select('pus.id', 'pus.patient_id', 'pus.hospital_id', 'us.examination_name', 'pus.examination_date',
                'pusi.fees');
            $ultraSoundExamQuery->where('pusi.is_value_set', '=', 1);
            //$ultraSoundExamQuery->select('pus.id', 'pus.patient_id', 'pus.hospital_id', 'us.examination_name', 'pus.examination_date','pusi.fees');

            //dd($bloodExamQuery->toSql());
            $ultraSoundExaminations = $ultraSoundExamQuery->get();

            $scanExamQuery = DB::table('patient_scan as ps');
            $scanExamQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
            $scanExamQuery->join('scans as s', 's.id', '=', 'psi.scan_id');
            $scanExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'ps.fee_receipt_id');
            $scanExamQuery->where('ps.patient_id', '=', $patientId);
            $scanExamQuery->where('ps.hospital_id', '=', $hospitalId);
            $scanExamQuery->where('ps.fee_receipt_id', '=', $feeReceiptId);
            $scanExamQuery->where('psi.is_value_set', '=', 1);
            $scanExamQuery->select('ps.id', 'ps.patient_id', 'ps.hospital_id', 's.scan_name', 'ps.scan_date', 'psi.fees');
            $scanExamQuery->whereNotNull('psi.fees');
            $scanExamQuery->select('ps.id', 'ps.patient_id', 'ps.hospital_id', 's.scan_name', 'ps.scan_date',
                'psi.fees');

            //dd($bloodExamQuery->toSql());
            $scanExaminations = $scanExamQuery->get();

            $dentalExamQuery = DB::table('patient_dental_examination as pde');
            $dentalExamQuery->join('patient_dental_examination_item as pdei', 'pdei.patient_dental_examination_id', '=', 'pde.id');
            $dentalExamQuery->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');

            $dentalExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pde.fee_receipt_id');
            $dentalExamQuery->where('pde.patient_id', '=', $patientId);
            $dentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            $dentalExamQuery->where('pde.fee_receipt_id', '=', $feeReceiptId);
            $dentalExamQuery->whereNotNull('pdei.fees');
            $dentalExamQuery->select('pde.id', 'pde.patient_id', 'pde.hospital_id', 'dei.examination_name', 'pde.examination_date',
                'pdei.fees');

            //dd($bloodExamQuery->toSql());
            $dentalExaminations = $dentalExamQuery->get();

            $xrayExamQuery = DB::table('patient_xray_examination as pxe');
            $xrayExamQuery->join('patient_xray_examination_item as pxei', 'pxei.patient_xray_examination_id', '=', 'pxe.id');
            $xrayExamQuery->join('lab_fee_receipt as lfr', 'lfr.id', '=', 'pxe.fee_receipt_id');
            $xrayExamQuery->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_item_id');
            $xrayExamQuery->where('pxe.patient_id', '=', $patientId);
            $xrayExamQuery->where('pxe.hospital_id', '=', $hospitalId);
            $xrayExamQuery->where('pxe.fee_receipt_id', '=', $feeReceiptId);
            $xrayExamQuery->whereNotNull('pxei.fees');
            $xrayExamQuery->select('pxe.id', 'pxe.patient_id', 'pxe.hospital_id', 'xe.examination_name', 'pxe.examination_date',
                'pxei.fees');

            //dd($bloodExamQuery->toSql());
            $xrayExaminations = $xrayExamQuery->get();

            $labReceiptQuery = DB::table('lab_fee_receipt as lfr')->where('lfr.patient_id', '=', $patientId);
            $labReceiptQuery->where('lfr.hospital_id', '=', $hospitalId);
            $labReceiptQuery->where('lfr.id', '=', $feeReceiptId);
            $labReceiptQuery->select('lfr.id', 'lfr.patient_id', 'lfr.hospital_id', 'lfr.lab_receipt_date', 'lfr.total_fees', 'lfr.paid_amount', 'lfr.payment_type');

            $labTotalFees = $labReceiptQuery->get();

            //DB::connection()->enableQueryLog();

            //$query = DB::getQueryLog();
            //dd($query);
            //dd($scanExaminations);

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.address', 'c.city_name',
                'co.name');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $labReceiptDetails['patientDetails'] = $patientDetails;
            $labReceiptDetails['hospitalDetails'] = $hospitalDetails;
            $labReceiptDetails['bloodTests'] = $bloodExaminations;
            $labReceiptDetails['urineTests'] = $urineExaminations;
            $labReceiptDetails['motionTests'] = $motionExaminations;
            $labReceiptDetails['scanTests'] = $scanExaminations;
            $labReceiptDetails['ultraSoundTests'] = $ultraSoundExaminations;
            $labReceiptDetails['dentalTests'] = $dentalExaminations;
            $labReceiptDetails['xrayTests'] = $xrayExaminations;
            $labReceiptDetails['labTotalFees'] = $labTotalFees;

            //dd($patientLabTests);

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $exc);
        }

        return $labReceiptDetails;
    }

    /**
     * Get lab test details to generate receipt
     * @param $patientId , $hospitalId, $generatedDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetailsForReceipt($patientId, $hospitalId, $generatedDate = null)
    {
        //$labTestDetails = null;
        $patientLabTests = null;
        $receiptDate = null;

        try {
            if (!is_null($generatedDate)) {
                $receiptDate = date("Y-m-d", strtotime($generatedDate));
            }

            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
            //DB::connection()->enableQueryLog();

            $bloodExamQuery = DB::table('patient_blood_examination as pbe');
            $bloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $bloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
            $bloodExamQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');
            $bloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $bloodExamQuery->where('pbe.hospital_id', '=', $hospitalId);
            $bloodExamQuery->where('pbei.is_value_set', '=', 1);
            //$bloodExamQuery->where('be.id', '=', 'be1.parent_id');
            $bloodExamQuery->where(function ($query) {
                $query->where('pbei.is_fees_paid', '=', 0);
                $query->orWhereNull('pbei.is_fees_paid');
            });
            //$bloodExamQuery->groupBy('be1.parent_id');
            //$bloodExamQuery->where('pbe.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $bloodExamQuery->whereDate('pbe.created_at', '=', $receiptDate);
            }
            $bloodExamQuery->select('pbe.id', 'pbe.patient_id', 'pbe.hospital_id', 'pbei.id as examination_item_id',
                'be.examination_name', 'pbe.examination_date', 'pbei.fees',
                'be1.id as parent_examination_id', 'be1.examination_name as parent_examination_name');

            /*$bloodExamQuery = DB::table('patient_blood_examination as pbe');
            $bloodExamQuery->join('patient_blood_examination_fees as pbef', 'pbef.patient_blood_examination_id', '=', 'pbe.id');
            $bloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbef.blood_examination_id');
            $bloodExamQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');
            $bloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $bloodExamQuery->where('pbe.hospital_id', '=', $hospitalId);
            //$bloodExamQuery->where('pbei.is_value_set', '=', 1);
            //$bloodExamQuery->where('be.id', '=', 'be1.parent_id');
            $bloodExamQuery->where(function ($query) {
                $query->where('pbef.is_fees_paid', '=', 0);
                $query->orWhereNull('pbef.is_fees_paid');
            });
            //$bloodExamQuery->groupBy('be1.parent_id');
            //$bloodExamQuery->where('pbe.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $bloodExamQuery->whereDate('pbe.created_at', '=', $receiptDate);
            }
            $bloodExamQuery->select('pbe.id', 'pbe.patient_id', 'pbe.hospital_id', 'pbef.id as examination_item_id',
                'be.examination_name', 'pbe.examination_date', 'pbef.fees',
                'be1.id as parent_examination_id', 'be1.examination_name as parent_examination_name');*/

            //dd($bloodExamQuery->toSql());
            $bloodExaminations = $bloodExamQuery->get();
            //$query = DB::getQueryLog();
            //dd($query);
            //dd($bloodExaminations);

            $urineExamQuery = DB::table('patient_urine_examination as pue');
            $urineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $urineExamQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
            $urineExamQuery->join('urine_examination as ue1', 'ue1.id', '=', 'ue.parent_id');
            $urineExamQuery->where('pue.patient_id', '=', $patientId);
            $urineExamQuery->where('pue.hospital_id', '=', $hospitalId);
            $urineExamQuery->where('puei.is_value_set', '=', 1);
            $urineExamQuery->where(function ($query) {
                $query->where('puei.is_fees_paid', '=', 0);
                $query->orWhereNull('puei.is_fees_paid');
            });
            //$urineExamQuery->where('pue.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $urineExamQuery->whereDate('pue.created_at', '=', $receiptDate);
            }
            $urineExamQuery->select('pue.id', 'pue.patient_id', 'pue.hospital_id', 'puei.id as examination_item_id',
                'ue.examination_name', 'ue1.examination_name as parent_examination_name', 'pue.examination_date', 'puei.fees');

            //dd($urineExamQuery->toSql());
            $urineExaminations = $urineExamQuery->get();

            $motionExamQuery = DB::table('patient_motion_examination as pme');
            $motionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $motionExamQuery->join('motion_examination as me', 'me.id', '=', 'pmei.motion_examination_id');
            $motionExamQuery->where('pme.patient_id', '=', $patientId);
            $motionExamQuery->where('pme.hospital_id', '=', $hospitalId);
            $motionExamQuery->where('pmei.is_value_set', '=', 1);
            //$motionExamQuery->where('pme.is_fees_paid', '=', 0);
            $motionExamQuery->where(function ($query) {
                $query->where('pmei.is_fees_paid', '=', 0);
                $query->orWhereNull('pmei.is_fees_paid');
            });
            if (!is_null($receiptDate)) {
                $motionExamQuery->whereDate('pme.created_at', '=', $receiptDate);
            }
            $motionExamQuery->select('pme.id', 'pme.patient_id', 'pme.hospital_id', 'pmei.id as examination_item_id',
                'me.examination_name', 'pme.examination_date', 'pmei.fees');

            //dd($motionExamQuery->toSql());
            $motionExaminations = $motionExamQuery->get();

            //DB::connection()->enableQueryLog();

            $scanExamQuery = DB::table('patient_scan as ps');
            $scanExamQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
            $scanExamQuery->join('scans as s', 's.id', '=', 'psi.scan_id');
            $scanExamQuery->where('ps.patient_id', '=', $patientId);
            $scanExamQuery->where('ps.hospital_id', '=', $hospitalId);
            $scanExamQuery->where('psi.is_value_set', '=', 1);
            $scanExamQuery->where(function ($query) {
                $query->where('psi.is_fees_paid', '=', 0);
                $query->orWhereNull('psi.is_fees_paid');
            });
            //$scanExamQuery->where('ps.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $scanExamQuery->whereDate('ps.created_at', '=', $receiptDate);
            }
            $scanExamQuery->select('ps.id', 'ps.patient_id', 'ps.hospital_id', 'psi.id as examination_item_id',
                's.scan_name', 'ps.scan_date', 'psi.fees');

            //dd($scanExamQuery->toSql());
            $scanExaminations = $scanExamQuery->get();

            //$query = DB::getQueryLog();
            //dd($query);
            //dd($scanExaminations);

            $ultraSoundExamQuery = DB::table('patient_ultra_sound as pus');
            $ultraSoundExamQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
            $ultraSoundExamQuery->join('ultra_sound as us', 'us.id', '=', 'pusi.ultra_sound_id');
            $ultraSoundExamQuery->where('pus.patient_id', '=', $patientId);
            $ultraSoundExamQuery->where('pus.hospital_id', '=', $hospitalId);
            $ultraSoundExamQuery->where('pusi.is_value_set', '=', 1);
            $ultraSoundExamQuery->where(function ($query) {
                $query->where('pusi.is_fees_paid', '=', 0);
                $query->orWhereNull('pusi.is_fees_paid');
            });
            //$ultraSoundExamQuery->where('pus.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $ultraSoundExamQuery->whereDate('pus.created_at', '=', $receiptDate);
            }
            $ultraSoundExamQuery->select('pus.id', 'pus.patient_id', 'pus.hospital_id', 'pusi.id as examination_item_id',
                'us.examination_name', 'pus.examination_date', 'pusi.fees');

            //dd($ultraSoundExamQuery->toSql());
            $ultraSoundExaminations = $ultraSoundExamQuery->get();

            $dentalExamQuery = DB::table('patient_dental_examination_item as pdei');
            $dentalExamQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $dentalExamQuery->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');
            $dentalExamQuery->where('pde.patient_id', '=', $patientId);
            $dentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            //$dentalExamQuery->where('pus.is_value_set', '=', 1);
            $dentalExamQuery->where(function ($query) {
                $query->where('pdei.is_fees_paid', '=', 0);
                $query->orWhereNull('pdei.is_fees_paid');
            });
            //$ultraSoundExamQuery->where('pus.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $dentalExamQuery->whereDate('pde.created_at', '=', $receiptDate);
            }
            $dentalExamQuery->select('pde.id as examination_id', 'pde.patient_id', 'pde.hospital_id', 'dei.examination_name',
                'pdei.id as examination_item_id', 'pdei.id as id', 'pde.examination_date', 'pdei.fees');

            //dd($ultraSoundExamQuery->toSql());
            $dentalExaminations = $dentalExamQuery->get();

            $xrayExamQuery = DB::table('patient_xray_examination_item as pxei');
            $xrayExamQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $xrayExamQuery->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_item_id');


            //$xrayExamQuery->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_id');

            $xrayExamQuery->where('pxe.patient_id', '=', $patientId);
            $xrayExamQuery->where('pxe.hospital_id', '=', $hospitalId);
            //$dentalExamQuery->where('pus.is_value_set', '=', 1);
            $xrayExamQuery->where(function ($query) {
                $query->where('pxei.is_fees_paid', '=', 0);
                $query->orWhereNull('pxei.is_fees_paid');
            });
            //$ultraSoundExamQuery->where('pus.is_fees_paid', '=', 0);
            if (!is_null($receiptDate)) {
                $xrayExamQuery->whereDate('pxe.created_at', '=', $receiptDate);
            }
            $xrayExamQuery->select('pxe.id as examination_id', 'pxe.patient_id', 'pxe.hospital_id', 'xe.examination_name',
                'pxei.id as examination_item_id', 'pxei.id as id', 'pxe.examination_date', 'pxei.fees');

            //dd($xrayExamQuery->toSql());
            $xrayExaminations = $xrayExamQuery->get();

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.address', 'c.city_name',
                'co.name');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $patientLabTests['patientDetails'] = $patientDetails;
            $patientLabTests['hospitalDetails'] = $hospitalDetails;
            $patientLabTests['bloodTests'] = $bloodExaminations;
            $patientLabTests['urineTests'] = $urineExaminations;
            $patientLabTests['motionTests'] = $motionExaminations;
            $patientLabTests['scanTests'] = $scanExaminations;
            $patientLabTests['ultraSoundTests'] = $ultraSoundExaminations;
            $patientLabTests['dentalTests'] = $dentalExaminations;
            $patientLabTests['xrayTests'] = $xrayExaminations;

            //dd($patientLabTests);

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::LAB_TEST_LIST_FOR_RECEIPT_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::LAB_TEST_LIST_FOR_RECEIPT_ERROR, $exc);
        }

        //dd($patientLabTests);
        return $patientLabTests;
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

        try {
            $query = DB::table('specialty as s')->select('s.id', 's.specialty_name')->where('s.specialty_status', '=', 1);
            $specialties = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::SPECIALTIES_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

        try {
            $query = DB::table('doctor_specialty_referral as drs')->select('drs.id', 'drs.doctor_name',
                'drs.hospital_name', 'drs.location');
            $query->where('drs.specialty_id', '=', $specialtyId);

            $referralDoctors = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_LIST_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
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

    public function saveReferralDoctor(DoctorReferralsViewModel $doctorReferralsVM)
    {
        $status = true;

        try {
            $doctorReferral = new DoctorReferral();
            $doctorReferral->doctor_name = $doctorReferralsVM->getDoctorName();
            $doctorReferral->hospital_name = $doctorReferralsVM->getHospitalName();
            $doctorReferral->location = $doctorReferralsVM->getLocation();
            $doctorReferral->specialty_id = $doctorReferralsVM->getSpecialtyId();
            $doctorReferral->created_by = $doctorReferralsVM->getCreatedBy();
            $doctorReferral->modified_by = $doctorReferralsVM->getUpdatedBy();
            $doctorReferral->created_at = $doctorReferralsVM->getCreatedAt();
            $doctorReferral->updated_at = $doctorReferralsVM->getUpdatedAt();

            $doctorReferral->save();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_SAVE_ERROR, $exc);
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

        try {
            $query = DB::table('doctor_specialty_referral as drs')->select('drs.id', 'drs.doctor_name',
                'drs.hospital_name', 'drs.location');
            $query->where('drs.id', '=', $referralId);

            $referralDoctorDetails = $query->get();
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_DETAILS_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::REFERRAL_DOCTOR_DETAILS_ERROR, $exc);
        }

        return $referralDoctorDetails;
    }

    /**
     * Get patient examination dates
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getExaminationDates($patientId, $hospitalId)
    {
        $examinationDates = null;
        $generalExaminationDates = null;
        $pastIllnessDates = null;
        //$drugDates = null;

        $familyIllnessDates = null;
        $personalHistoryDates = null;
        $pregnancyDates = null;
        $scanDates = null;
        $symptomDates = null;
        $complaintDates = null;
        $ultraSoundDates = null;
        $bloodTestDates = null;
        $urineTestDates = null;
        $motionTestDates = null;
        $drugTestDates = null;
        $dentalTestDates = null;
        $diagnosisDates = null;

        $patientLabTests = null;

        $latestPrescription = null;
        try {
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            //dd('Inside examination dates');
            //DB::connection()->enableQueryLog();

            /*$latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
            $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $latestBloodExamQuery->where('pbe.examination_date', function($query) use($patientId){
                $query->select(DB::raw('MAX(pbe.examination_date)'));
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
            });
            $latestBloodExamQuery->where('pbe.examination_time', function($query) use($patientId){
                $query->select(DB::raw('MAX(pbe.examination_time)'));
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                $query->where('pbe.examination_date', function($query1) use($patientId){
                    $query1->select(DB::raw('MAX(pbe.examination_date)'));
                    $query1->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                });
            });
            $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $latestBloodExamQuery->where('pbe.is_value_set', '=', 1);
            $latestBloodExamQuery->select('pbe.id', 'pbe.patient_id', 'pbe.hospital_id', 'be.examination_name', 'pbe.examination_date');
            $bloodExaminations = $latestBloodExamQuery->get();*/

            $latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
            $latestBloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
            $latestBloodExamQuery->where('pbe.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pbe.examination_date)'));
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
            });
            $latestBloodExamQuery->where('pbe.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pbe.examination_time)'));
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                $query->where('pbe.examination_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pbe.examination_date)'));
                    $query1->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
                });
            });
            $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $latestBloodExamQuery->where('pbei.is_value_set', '=', 1);
            $latestBloodExamQuery->select('pbe.id as examinationId', 'pbei.id as examinationItemId', 'pbe.patient_id',
                'pbe.hospital_id', 'be.examination_name', 'pbe.examination_date');
            $bloodExaminations = $latestBloodExamQuery->get();

            //$query = DB::getQueryLog();
            //dd($query);

            //dd($bloodExaminations);


            //DB::connection()->enableQueryLog();

            $latestGeneralExamQuery = DB::table('patient_general_examination as pge');
            $latestGeneralExamQuery->join('general_examination as ge', 'ge.id', '=', 'pge.general_examination_id');
            $latestGeneralExamQuery->where('pge.general_examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pge.general_examination_date)'));
                $query->from('patient_general_examination as pge')->where('pge.patient_id', '=', $patientId);
            });
            $latestGeneralExamQuery->where('pge.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pge.examination_time)'));
                $query->from('patient_general_examination as pge')->where('pge.patient_id', '=', $patientId);
                $query->where('pge.general_examination_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pge.general_examination_date)'));
                    $query1->from('patient_general_examination as pge')->where('pge.patient_id', '=', $patientId);
                });
            });
            $latestGeneralExamQuery->where('pge.patient_id', '=', $patientId);
            $latestGeneralExamQuery->where('pge.is_value_set', '=', 1);
            $latestGeneralExamQuery->select('pge.id', 'pge.patient_id', 'ge.general_examination_name', 'pge.general_examination_value',
                'pge.general_examination_date');
            $generalExaminations = $latestGeneralExamQuery->get();
            //dd($generalExaminations);
            //$query = DB::getQueryLog();
            //dd($latestGeneralExamQuery->toSql());

            $latestPastIllnessQuery = DB::table('patient_past_illness as ppi');
            $latestPastIllnessQuery->join('past_illness as pii', 'pii.id', '=', 'ppi.past_illness_id');
            $latestPastIllnessQuery->where('ppi.past_illness_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ppi.past_illness_date)'));
                $query->from('patient_past_illness as ppi')->where('ppi.patient_id', '=', $patientId);
            });
            $latestPastIllnessQuery->where('ppi.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ppi.examination_time)'));
                $query->from('patient_past_illness as ppi')->where('ppi.patient_id', '=', $patientId);
                $query->where('ppi.past_illness_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(ppi.past_illness_date)'));
                    $query1->from('patient_past_illness as ppi')->where('ppi.patient_id', '=', $patientId);
                });
            });
            $latestPastIllnessQuery->where('ppi.patient_id', '=', $patientId);
            $latestPastIllnessQuery->where('ppi.is_value_set', '=', 1);
            $latestPastIllnessQuery->select('ppi.id', 'ppi.patient_id', 'pii.illness_name', 'ppi.past_illness_name', 'ppi.past_illness_date');
            $latestPastIllness = $latestPastIllnessQuery->get();

            //dd($latestPastIllnessQuery->toSql());

            $latestFamilyIllnessQuery = DB::table('patient_family_illness as pfi');
            $latestFamilyIllnessQuery->join('family_illness as fi', 'fi.id', '=', 'pfi.family_illness_id');
            $latestFamilyIllnessQuery->where('pfi.family_illness_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pfi.family_illness_date)'));
                $query->from('patient_family_illness as pfi')->where('pfi.patient_id', '=', $patientId);
            });
            $latestFamilyIllnessQuery->where('pfi.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pfi.examination_time)'));
                $query->from('patient_family_illness as pfi')->where('pfi.patient_id', '=', $patientId);
                $query->where('pfi.family_illness_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pfi.family_illness_date)'));
                    $query1->from('patient_family_illness as pfi')->where('pfi.patient_id', '=', $patientId);
                });
            });
            $latestFamilyIllnessQuery->where('pfi.patient_id', '=', $patientId);
            $latestFamilyIllnessQuery->where('pfi.is_value_set', '=', 1);
            $latestFamilyIllnessQuery->select('pfi.id', 'pfi.patient_id', 'fi.illness_name', 'pfi.family_illness_name',
                'pfi.relation', 'pfi.family_illness_date');
            $latestFamilyIllness = $latestFamilyIllnessQuery->get();

            //dd($latestFamilyIllnessQuery->toSql());

            $latestPersonalHistoryQuery = DB::table('patient_personal_history as pph');
            $latestPersonalHistoryQuery->join('personal_history as ph', 'ph.id', '=', 'pph.personal_history_id');
            $latestPersonalHistoryQuery->join('personal_history_item as phi', 'phi.id', '=', 'pph.personal_history_item_id');
            $latestPersonalHistoryQuery->where('pph.personal_history_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pph.personal_history_date)'));
                $query->from('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
            });
            $latestPersonalHistoryQuery->where('pph.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pph.examination_time)'));
                $query->from('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
                $query->where('pph.personal_history_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pph.personal_history_date)'));
                    $query1->from('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
                });
            });
            $latestPersonalHistoryQuery->where('pph.patient_id', '=', $patientId);
            $latestPersonalHistoryQuery->where('pph.is_value_set', '=', 1);
            $latestPersonalHistoryQuery->select('pph.id', 'pph.patient_id', 'ph.personal_history_name',
                'phi.personal_history_item_name', 'pph.personal_history_date', 'pph.personal_history_value');
            $latestPersonalHistory = $latestPersonalHistoryQuery->get();

            $latestPregnancyQuery = DB::table('patient_pregnancy as pp');
            $latestPregnancyQuery->join('pregnancy as p', 'p.id', '=', 'pp.pregnancy_id');
            $latestPregnancyQuery->where('pp.pregnancy_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pp.pregnancy_date)'));
                $query->from('patient_pregnancy as pp')->where('pp.patient_id', '=', $patientId);
            });
            $latestPregnancyQuery->where('pp.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pp.examination_time)'));
                $query->from('patient_pregnancy as pp')->where('pp.patient_id', '=', $patientId);
                $query->where('pp.pregnancy_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pp.pregnancy_date)'));
                    $query1->from('patient_pregnancy as pp')->where('pp.patient_id', '=', $patientId);
                });
            });
            $latestPregnancyQuery->where('pp.patient_id', '=', $patientId);
            $latestPregnancyQuery->where('pp.is_value_set', '=', 1);
            $latestPregnancyQuery->select('pp.id', 'pp.patient_id', 'p.pregnancy_details', 'pp.pregnancy_value', 'pp.pregnancy_date');
            $latestPregnancy = $latestPregnancyQuery->get();

            $latestScanQuery = DB::table('patient_scan as ps');
            $latestScanQuery->join('patient_scan_item as psi', 'psi.patient_scan_id', '=', 'ps.id');
            $latestScanQuery->join('scans as s', 's.id', '=', 'psi.scan_id');
            $latestScanQuery->where('ps.scan_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ps.scan_date)'));
                $query->from('patient_scan as ps')->where('ps.patient_id', '=', $patientId);
            });
            $latestScanQuery->where('ps.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ps.examination_time)'));
                $query->from('patient_scan as ps')->where('ps.patient_id', '=', $patientId);
                $query->where('ps.scan_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(ps.scan_date)'));
                    $query1->from('patient_scan as ps')->where('ps.patient_id', '=', $patientId);
                });
            });
            $latestScanQuery->where('ps.patient_id', '=', $patientId);
            $latestScanQuery->where('psi.is_value_set', '=', 1);
            $latestScanQuery->select('ps.id as examinationId', 'psi.id as examinationItemId',
                'ps.patient_id', 's.scan_name', 'ps.scan_date');
            //dd($latestScanQuery->toSql());
            $latestScans = $latestScanQuery->get();

            $latestSymptomsQuery = DB::table('patient_symptoms as ps');
            $latestSymptomsQuery->join('main_symptoms as ms', 'ms.id', '=', 'ps.main_symptom_id');
            $latestSymptomsQuery->join('sub_symptoms as ss', 'ss.id', '=', 'ps.sub_symptom_id');
            $latestSymptomsQuery->join('symptoms as s', 's.id', '=', 'ps.symptom_id');
            $latestSymptomsQuery->where('ps.patient_symptom_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ps.patient_symptom_date)'));
                $query->from('patient_symptoms as ps')->where('ps.patient_id', '=', $patientId);
            });
            $latestSymptomsQuery->where('ps.patient_id', '=', $patientId);
            $latestSymptomsQuery->where('ps.is_value_set', '=', 1);
            $latestSymptomsQuery->select('ps.id', 'ps.patient_id', 'ms.id as main_symptom_id', 'ms.main_symptom_name',
                'ss.id as sub_symptom_id', 'ss.sub_symptom_name', 's.id as symptom_id', 's.symptom_name', 'ps.patient_symptom_date');
            $latestSymptoms = $latestSymptomsQuery->get();

            $latestComplaintsQuery = DB::table('patient_complaint_details as pcd');
            $latestComplaintsQuery->join('patient_complaints as pc', 'pc.id', '=', 'pcd.patient_complaint_id');
            $latestComplaintsQuery->join('complaints as c', 'c.id', '=', 'pcd.complaint_id');
            $latestComplaintsQuery->join('complaint_type as ct', 'ct.id', '=', 'c.complaint_type_id');
            $latestComplaintsQuery->where('pc.complaint_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pc.complaint_date)'));
                $query->from('patient_complaints as pc')->where('pc.patient_id', '=', $patientId);
            });
            $latestComplaintsQuery->where('pc.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pc.examination_time)'));
                $query->from('patient_complaints as pc')->where('pc.patient_id', '=', $patientId);
                $query->where('pc.complaint_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pc.complaint_date)'));
                    $query1->from('patient_complaints as pc')->where('pc.patient_id', '=', $patientId);
                });
            });
            $latestComplaintsQuery->where('pc.patient_id', '=', $patientId);
            $latestComplaintsQuery->where('pcd.is_value_set', '=', 1);
            $latestComplaintsQuery->select('pc.id', 'pc.patient_id', 'pc.complaint_text', 'pc.complaint_date',
                'c.id as complaintId', 'c.complaint_name', 'ct.complaint_name as complaintType');
            $latestComplaints = $latestComplaintsQuery->get();
            //dd($latestComplaintsQuery->toSql());

            //dd($latestComplaints);

            $latestUltrasoundQuery = DB::table('patient_ultra_sound as pus');
            $latestUltrasoundQuery->join('patient_ultra_sound_item as pusi', 'pusi.patient_ultra_sound_id', '=', 'pus.id');
            $latestUltrasoundQuery->join('ultra_sound as us', 'us.id', '=', 'pusi.ultra_sound_id');
            $latestUltrasoundQuery->where('pus.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pus.examination_date)'));
                $query->from('patient_ultra_sound as pus')->where('pus.patient_id', '=', $patientId);
            });
            $latestUltrasoundQuery->where('pus.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pus.examination_time)'));
                $query->from('patient_ultra_sound as pus')->where('pus.patient_id', '=', $patientId);
                $query->where('pus.examination_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pus.examination_date)'));
                    $query1->from('patient_ultra_sound as pus')->where('pus.patient_id', '=', $patientId);
                });
            });
            $latestUltrasoundQuery->where('pus.patient_id', '=', $patientId);
            $latestUltrasoundQuery->where('pusi.is_value_set', '=', 1);
            $latestUltrasoundQuery->select('pus.id as examinationId', 'pusi.id as examinationItemId',
                'pus.patient_id', 'us.examination_name', 'pus.examination_date');
            $latestUltrasound = $latestUltrasoundQuery->get();

            $latestUrineExamQuery = DB::table('patient_urine_examination as pue');
            $latestUrineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $latestUrineExamQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
            $latestUrineExamQuery->where('pue.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pue.examination_date)'));
                $query->from('patient_urine_examination as pue')->where('pue.patient_id', '=', $patientId);
            });
            $latestUrineExamQuery->where('pue.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pue.examination_time)'));
                $query->from('patient_urine_examination as pue')->where('pue.patient_id', '=', $patientId);
                $query->where('pue.examination_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pue.examination_date)'));
                    $query1->from('patient_urine_examination as pue')->where('pue.patient_id', '=', $patientId);
                });
            });
            $latestUrineExamQuery->where('pue.patient_id', '=', $patientId);
            $latestUrineExamQuery->where('puei.is_value_set', '=', 1);
            $latestUrineExamQuery->select('pue.id as examinationId', 'puei.id as examinationItemId',
                'pue.patient_id', 'ue.examination_name', 'pue.examination_date');
            $latestUrineExaminations = $latestUrineExamQuery->get();

            $latestMotionExamQuery = DB::table('patient_motion_examination as pme');
            $latestMotionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $latestMotionExamQuery->join('motion_examination as me', 'me.id', '=', 'pmei.motion_examination_id');
            $latestMotionExamQuery->where('pme.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pme.examination_date)'));
                $query->from('patient_motion_examination as pme')->where('pme.patient_id', '=', $patientId);
            });
            $latestMotionExamQuery->where('pme.examination_time', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pme.examination_time)'));
                $query->from('patient_motion_examination as pme')->where('pme.patient_id', '=', $patientId);
                $query->where('pme.examination_date', function ($query1) use ($patientId) {
                    $query1->select(DB::raw('MAX(pme.examination_date)'));
                    $query1->from('patient_motion_examination as pme')->where('pme.patient_id', '=', $patientId);
                });
            });
            $latestMotionExamQuery->where('pme.patient_id', '=', $patientId);
            $latestMotionExamQuery->where('pmei.is_value_set', '=', 1);
            $latestMotionExamQuery->select('pme.id as examinationId', 'pmei.id as examinationItemId',
                'pme.patient_id', 'me.examination_name', 'pme.examination_date');
            $latestMotionExaminations = $latestMotionExamQuery->get();

            $latestDrugHistoryQuery = DB::table('patient_drug_history as pdh');
            $latestDrugHistoryQuery->where('pdh.drug_history_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pdh.drug_history_date)'));
                $query->from('patient_drug_history as pdh')->where('pdh.patient_id', '=', $patientId);
            });
            $latestDrugHistoryQuery->where('pdh.patient_id', '=', $patientId);
            $latestDrugHistoryQuery->select('pdh.id', 'pdh.patient_id',
                'pdh.drug_name', 'pdh.dosage', 'pdh.timings', 'pdh.drug_history_date');
            $latestDrugHistory = $latestDrugHistoryQuery->get();

            $latestSurgeryHistoryQuery = DB::table('patient_surgeries as ps');
            $latestSurgeryHistoryQuery->where('ps.surgery_input_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(ps.surgery_input_date)'));
                $query->from('patient_surgeries as ps')->where('ps.patient_id', '=', $patientId);
            });
            $latestSurgeryHistoryQuery->where('ps.patient_id', '=', $patientId);
            $latestSurgeryHistoryQuery->select('ps.id', 'ps.patient_id',
                'ps.patient_surgeries', 'ps.surgery_input_date', 'ps.operation_date');
            $latestSurgeryHistory = $latestSurgeryHistoryQuery->get();

            $latestDentalExamQuery = DB::table('patient_dental_examination_item as pdei');
            $latestDentalExamQuery->join('patient_dental_examination as pde', 'pde.id', '=', 'pdei.patient_dental_examination_id');
            $latestDentalExamQuery->join('dental_examination_items as dei', 'dei.id', '=', 'pdei.dental_examination_item_id');
            $latestDentalExamQuery->join('dental_category as dc', 'dc.id', '=', 'dei.dental_category_id');
            $latestDentalExamQuery->where('pde.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pde.examination_date)'));
                $query->from('patient_dental_examination as pde')->where('pde.patient_id', '=', $patientId);
            });
            $latestDentalExamQuery->where('pde.patient_id', '=', $patientId);
            //$latestDentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            //$latestDentalExamQuery->where('pbe.is_value_set', '=', 1);
            $latestDentalExamQuery->select('pdei.id', 'pde.patient_id',
                'pde.hospital_id', 'dc.id as category_id', 'dc.category_name',
                'dei.id as examination_id', 'dei.examination_name', 'pde.examination_date');
            //dd($latestDentalExamQuery->toSql());
            $dentalExaminations = $latestDentalExamQuery->get();

            $latestXrayExamQuery = DB::table('patient_xray_examination_item as pxei');
            $latestXrayExamQuery->join('patient_xray_examination as pxe', 'pxe.id', '=', 'pxei.patient_xray_examination_id');
            $latestXrayExamQuery->join('xray_examination as xe', 'xe.id', '=', 'pxei.xray_examination_item_id');
            $latestXrayExamQuery->where('pxe.examination_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pxe.examination_date)'));
                $query->from('patient_xray_examination as pxe')->where('pxe.patient_id', '=', $patientId);
            });
            $latestXrayExamQuery->where('pxe.patient_id', '=', $patientId);
            //$latestDentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            //$latestDentalExamQuery->where('pbe.is_value_set', '=', 1);
            $latestXrayExamQuery->select('pxei.id', 'pxe.patient_id',
                'pxe.hospital_id', 'xe.id as examination_id', 'xe.examination_name', 'xe.category',
                'pxe.examination_date');
            //dd($latestDentalExamQuery->toSql());
            $xrayExaminations = $latestXrayExamQuery->get();

            $latestDiagnosisQuery = DB::table('patient_investigations_diagnosis as pid');
            $latestDiagnosisQuery->join('treatment_type as tt', 'tt.id', '=', 'pid.treatment_plan_id');
            $latestDiagnosisQuery->where('pid.diagnosis_date', function ($query) use ($patientId) {
                $query->select(DB::raw('MAX(pid.diagnosis_date)'));
                $query->from('patient_investigations_diagnosis as pid')->where('pid.patient_id', '=', $patientId);
            });
            $latestDiagnosisQuery->where('pid.patient_id', '=', $patientId);
            //$latestDentalExamQuery->where('pde.hospital_id', '=', $hospitalId);
            //$latestDentalExamQuery->where('pbe.is_value_set', '=', 1);
            $latestDiagnosisQuery->select('pid.id', 'pid.patient_id',
                'pid.hospital_id', 'pid.doctor_id', 'pid.investigations', 'pid.examination_findings', 'pid.provisional_diagnosis',
                'pid.final_diagnosis', 'pid.diagnosis_date', 'pid.treatment_plan_id', 'tt.treatment_type', 'tt.treatment_code');
            //dd($latestDentalExamQuery->toSql());
            $diagnosticExaminations = $latestDiagnosisQuery->get();

            $latestPresQuery = DB::table('prescription_details as pd')->select('b.id as trade_id',
                DB::raw('TRIM(UPPER(b.brand_name)) as trade_name'),
                //'d.id as formulation_id',
                //DB::raw('TRIM(UPPER(d.drug_name)) as formulation_name'),
                'b.id as formulation_id',
                DB::raw('TRIM(UPPER(b.brand_name)) as formulation_name'),
                'pd.dosage', 'pd.no_of_days', 'pd.intake_form',
                'pd.morning', 'pd.afternoon', 'pd.night', 'pd.drug_status');
            $latestPresQuery->join('patient_prescription as pp', 'pp.id', '=', 'pd.patient_prescription_id');
            $latestPresQuery->join('brands as b', 'b.id', '=', 'pd.brand_id');
            $latestPresQuery->join('drugs as d', 'd.id', '=', 'pd.drug_id');
            $latestPresQuery->where('pp.prescription_date', function ($latestPresQuery) use ($patientId) {
                $latestPresQuery->select(DB::raw('MAX(pp.prescription_date)'));
                $latestPresQuery->from('patient_prescription as pp')->where('pp.patient_id', '=', $patientId);
            });
            $latestPresQuery->where('pp.patient_id', '=', $patientId);

            $latestPrescription = $latestPresQuery->get();

            //$latestPresQuery =

            //dd($dentalExaminations);

            /*$drugQuery = DB::table('patient_drug_history as pdh')->select('pdh.id as id', 'pdh.patient_id as patientId',
                'pdh.drug_name as drugName', 'pdh.dosage', 'pdh.timings');
            $drugQuery->where('pdh.patient_id', $patientId);*/

            //dd($generalExaminations);
            //dd($latestGeneralExamQuery->toSql());
            //$generalExaminations = $latestGeneralExamQuery->get();
            //$query = DB::getQueryLog();
            //dd($query);

            $examinationQuery = DB::table('patient_general_examination as pge')->where('pge.patient_id', '=', $patientId);
            $examinationQuery->select('pge.general_examination_date')->orderBy('pge.general_examination_date', 'DESC');
            $generalExaminationDates = $examinationQuery->distinct()->get();
            //dd($examinationQuery->toSql());
            //$generalExaminationDates = $examinationQuery->distinct()->take(2147483647)->skip(1)->get();
            //dd($generalExaminationDates);

            $pastIllnessQuery = DB::table('patient_past_illness as ppi')->where('ppi.patient_id', '=', $patientId);
            $pastIllnessQuery->select('ppi.past_illness_date')->orderBy('ppi.past_illness_date', 'DESC');
            $pastIllnessDates = $pastIllnessQuery->distinct()->get();
            //$pastIllnessDates = $pastIllnessQuery->distinct()->take(2147483647)->skip(1)->get();

            $familyIllnessQuery = DB::table('patient_family_illness as pfi')->where('pfi.patient_id', '=', $patientId);
            $familyIllnessQuery->select('pfi.family_illness_date')->orderBy('pfi.family_illness_date', 'DESC');
            $familyIllnessDates = $familyIllnessQuery->distinct()->get();
            //$familyIllnessDates = $familyIllnessQuery->distinct()->take(2147483647)->skip(1)->get();

            $personalHistoryQuery = DB::table('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
            $personalHistoryQuery->select('pph.personal_history_date')->orderBy('pph.personal_history_date', 'DESC');
            $personalHistoryDates = $personalHistoryQuery->distinct()->get();
            //$personalHistoryDates = $personalHistoryQuery->distinct()->take(2147483647)->skip(1)->get();

            $pregnancyDetailsQuery = DB::table('patient_pregnancy as pp')->where('pp.patient_id', '=', $patientId);
            $pregnancyDetailsQuery->select('pp.pregnancy_date')->orderBy('pp.pregnancy_date', 'DESC');
            $pregnancyDates = $pregnancyDetailsQuery->distinct()->get();
            //$pregnancyDates = $pregnancyDetailsQuery->distinct()->take(2147483647)->skip(1)->get();

            $scanDetailsQuery = DB::table('patient_scan as ps')->where('ps.patient_id', '=', $patientId);
            $scanDetailsQuery->select('ps.scan_date')->orderBy('ps.scan_date', 'DESC');
            $scanDates = $scanDetailsQuery->distinct()->get();
            //$scanDates = $scanDetailsQuery->distinct()->take(2147483647)->skip(1)->get();

            $symptomDatesQuery = DB::table('patient_symptoms as ps')->where('ps.patient_id', '=', $patientId);
            $symptomDatesQuery->select('ps.patient_symptom_date')->orderBy('ps.patient_symptom_date', 'DESC');
            $symptomDates = $symptomDatesQuery->distinct()->get();

            $complaintDatesQuery = DB::table('patient_complaints as pc')->where('pc.patient_id', '=', $patientId);
            $complaintDatesQuery->select('pc.complaint_date')->orderBy('pc.complaint_date', 'DESC');
            $complaintDates = $complaintDatesQuery->distinct()->get();

            $diagnosisDatesQuery = DB::table('patient_investigations_diagnosis as pid')->where('pid.patient_id', '=', $patientId);
            $diagnosisDatesQuery->select('pid.diagnosis_date')->orderBy('pid.diagnosis_date', 'DESC');
            $diagnosisDates = $diagnosisDatesQuery->distinct()->get();

            //$symptomDates = $symptomDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            $ultraSoundDatesQuery = DB::table('patient_ultra_sound as pus')->where('pus.patient_id', '=', $patientId);
            $ultraSoundDatesQuery->select('pus.examination_date')->orderBy('pus.examination_date', 'DESC');
            $ultraSoundDates = $ultraSoundDatesQuery->distinct()->get();
            //$ultraSoundDates = $ultraSoundDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            $bloodDatesQuery = DB::table('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
            $bloodDatesQuery->select('pbe.examination_date')->orderBy('pbe.examination_date', 'DESC');
            $bloodTestDates = $bloodDatesQuery->distinct()->get();
            //$bloodTestDates = $bloodDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            //dd($bloodDatesQuery->toSql());

            $urineDatesQuery = DB::table('patient_urine_examination as pue')->where('pue.patient_id', '=', $patientId);
            $urineDatesQuery->select('pue.examination_date')->orderBy('pue.examination_date', 'DESC');
            $urineTestDates = $urineDatesQuery->distinct()->get();
            //$urineTestDates = $urineDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            $motionDatesQuery = DB::table('patient_motion_examination as pme')->where('pme.patient_id', '=', $patientId);
            $motionDatesQuery->select('pme.examination_date')->orderBy('pme.examination_date', 'DESC');
            $motionTestDates = $motionDatesQuery->distinct()->get();

            $dentalDatesQuery = DB::table('patient_dental_examination as pde')->where('pde.patient_id', '=', $patientId);
            $dentalDatesQuery->select('pde.examination_date')->orderBy('pde.examination_date', 'DESC');
            $dentalTestDates = $dentalDatesQuery->distinct()->get();

            $xrayDatesQuery = DB::table('patient_xray_examination as pxe')->where('pxe.patient_id', '=', $patientId);
            $xrayDatesQuery->select('pxe.examination_date')->orderBy('pxe.examination_date', 'DESC');
            $xrayTestDates = $xrayDatesQuery->distinct()->get();
            //$motionTestDates = $motionDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            $drugDatesQuery = DB::table('patient_drug_history as pdh')->where('pdh.patient_id', '=', $patientId);
            $drugDatesQuery->select('pdh.drug_history_date')->orderBy('pdh.drug_history_date', 'DESC');
            $drugTestDates = $drugDatesQuery->distinct()->get();

            $surgeryDatesQuery = DB::table('patient_surgeries as ps')->where('ps.patient_id', '=', $patientId);
            $surgeryDatesQuery->select('ps.surgery_input_date')->orderBy('ps.surgery_input_date', 'DESC');
            $surgeryTestDates = $surgeryDatesQuery->distinct()->get();

            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.address', 'c.city_name',
                'co.name');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $examinationDates['patientDetails'] = $patientDetails;
            $examinationDates['hospitalDetails'] = $hospitalDetails;
            $examinationDates['recentBloodTests'] = $bloodExaminations;
            $examinationDates['recentGeneralTests'] = $generalExaminations;
            $examinationDates['recentPastIllness'] = $latestPastIllness;
            $examinationDates['recentFamilyIllness'] = $latestFamilyIllness;
            $examinationDates['recentPersonalHistory'] = $latestPersonalHistory;
            $examinationDates['recentPregnancy'] = $latestPregnancy;
            $examinationDates['recentScans'] = $latestScans;
            $examinationDates['recentSymptoms'] = $latestSymptoms;
            $examinationDates['recentComplaints'] = $latestComplaints;
            $examinationDates['recentUltrasound'] = $latestUltrasound;
            $examinationDates['recentUrineExaminations'] = $latestUrineExaminations;
            $examinationDates['recentMotionExaminations'] = $latestMotionExaminations;
            $examinationDates['recentDrugHistory'] = $latestDrugHistory;
            $examinationDates['recentSurgeryHistory'] = $latestSurgeryHistory;
            $examinationDates['dentalExaminations'] = $dentalExaminations;
            $examinationDates['xrayExaminations'] = $xrayExaminations;
            $examinationDates['diagnosticExaminations'] = $diagnosticExaminations;
            $examinationDates['latestPrescription'] = $latestPrescription;

            $examinationDates["generalExaminationDates"] = $generalExaminationDates;
            $examinationDates["pastIllnessDates"] = $pastIllnessDates;
            $examinationDates["familyIllnessDates"] = $familyIllnessDates;
            $examinationDates["personalHistoryDates"] = $personalHistoryDates;
            $examinationDates["drugTestDates"] = $drugTestDates;
            $examinationDates["surgeryTestDates"] = $surgeryTestDates;
            $examinationDates["pregnancyDates"] = $pregnancyDates;
            $examinationDates["scanDates"] = $scanDates;
            $examinationDates["symptomDates"] = $symptomDates;
            $examinationDates["complaintDates"] = $complaintDates;
            $examinationDates["diagnosisDates"] = $diagnosisDates;
            $examinationDates["ultraSoundDates"] = $ultraSoundDates;
            $examinationDates["bloodTestDates"] = $bloodTestDates;
            $examinationDates["urineTestDates"] = $urineTestDates;
            $examinationDates["motionTestDates"] = $motionTestDates;
            $examinationDates["dentalTestDates"] = $dentalTestDates;
            $examinationDates["xrayTestDates"] = $xrayTestDates;

            //dd($examinationDates);

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        //dd($patientLabTests);
        return $examinationDates;
    }

    /**
     * Get patient latest appointment dates
     * @param $patientId , $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLatestAppointmentDateForPatient($patientId, $hospitalId)
    {
        $latestAppointmentDetails = null;

        try {
            $query = DB::table('doctor_appointment as da')->select('da.id', 'da.patient_id', 'da.appointment_date');
            $query->where('da.patient_id', '=', $patientId);
            $query->where('da.hospital_id', '=', $hospitalId);
            $query->groupBy('da.appointment_date');
            $query->orderBy('da.appointment_date', 'DESC');

            //dd($query->toSql());

            $latestAppointmentDetails = $query->first();

            //dd($latestAppointmentDetails);
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_DATE_ERROR, $queryEx);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::APPOINTMENT_DATE_ERROR, $exc);
        }

        return $latestAppointmentDetails;
    }

    /**
     * Get recent patient examinations and patient examination dates
     * @param $patientId , $examinationDate
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    /*public function getPatientExaminations($patientId, $examinationDate = null)
    {
        $examinationDates = null;
        $generalExaminationDates = null;
        $pastIllnessDates = null;
        $familyIllnessDates = null;
        $personalHistoryDates = null;
        $pregnancyDates = null;
        $scanDates = null;
        $symptomDates = null;
        $ultraSoundDates = null;
        $bloodTestDates = null;
        $urineTestDates = null;
        $motionTestDates = null;

        $patientLabTests = null;

        try
        {
            $patientUser = User::find($patientId);

            if(is_null($patientUser))
            {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            //DB::connection()->enableQueryLog();

            $latestGeneralExamQuery = DB::table('patient_blood_examination as pbe');
            $latestGeneralExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            $latestGeneralExamQuery->where('pbe.examination_date', function($query) use($patientId){
                $query->select(DB::raw('MAX(pbe.examination_date)'));
                $query->from('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
            });
            $latestGeneralExamQuery->select('pbe.id', 'pbe.patient_id', 'be.examination_name', 'pbe.examination_date');
            $generalExaminations = $latestGeneralExamQuery->get();

            //dd($generalExaminations);
            //dd($latestGeneralExamQuery->toSql());
            //$generalExaminations = $latestGeneralExamQuery->get();
            //$query = DB::getQueryLog();
            //dd($query);


            //$examinationDetails = $examinationQuery->first();



            $examinationQuery = DB::table('patient_general_examination as pge')->where('pge.patient_id', '=', $patientId);
            $examinationQuery->select('pge.general_examination_date')->orderBy('pge.general_examination_date', 'DESC');
            //dd($examinationQuery->toSql());
            $generalExaminationDates = $examinationQuery->distinct()->get();
            //dd($generalExaminationDates);

            $pastIllnessQuery = DB::table('patient_past_illness as ppi')->where('ppi.patient_id', '=', $patientId);
            $pastIllnessQuery->select('ppi.past_illness_date')->orderBy('ppi.past_illness_date', 'DESC');
            $pastIllnessDates = $pastIllnessQuery->distinct()->get();

            $familyIllnessQuery = DB::table('patient_family_illness as pfi')->where('pfi.patient_id', '=', $patientId);
            $familyIllnessQuery->select('pfi.family_illness_date')->orderBy('pfi.family_illness_date', 'DESC');
            $familyIllnessDates = $familyIllnessQuery->distinct()->get();

            $personalHistoryQuery = DB::table('patient_personal_history as pph')->where('pph.patient_id', '=', $patientId);
            $personalHistoryQuery->select('pph.personal_history_date')->orderBy('pph.personal_history_date', 'DESC');
            $personalHistoryDates = $personalHistoryQuery->distinct()->get();

            $pregnancyDetailsQuery = DB::table('patient_pregnancy as pp')->where('pp.patient_id', '=', $patientId);
            $pregnancyDetailsQuery->select('pp.pregnancy_date')->orderBy('pp.pregnancy_date', 'DESC');
            $pregnancyDates = $pregnancyDetailsQuery->distinct()->get();

            $scanDetailsQuery = DB::table('patient_scan as ps')->where('ps.patient_id', '=', $patientId);
            $scanDetailsQuery->select('ps.scan_date')->orderBy('ps.scan_date', 'DESC');
            $scanDates = $scanDetailsQuery->distinct()->get();

            $symptomDatesQuery = DB::table('patient_symptoms as ps')->where('ps.patient_id', '=', $patientId);
            $symptomDatesQuery->select('ps.patient_symptom_date')->orderBy('ps.patient_symptom_date', 'DESC');
            $symptomDates = $symptomDatesQuery->distinct()->get();

            $ultraSoundDatesQuery = DB::table('patient_ultra_sound as pus')->where('pus.patient_id', '=', $patientId);
            $ultraSoundDatesQuery->select('pus.examination_date')->orderBy('pus.examination_date', 'DESC');
            $ultraSoundDates = $ultraSoundDatesQuery->distinct()->get();

            $bloodDatesQuery = DB::table('patient_blood_examination as pbe')->where('pbe.patient_id', '=', $patientId);
            $bloodDatesQuery->select('pbe.examination_date')->orderBy('pbe.examination_date', 'DESC');
            $bloodTestDates = $bloodDatesQuery->distinct()->take(2147483647)->skip(1)->get();

            dd($bloodDatesQuery->toSql());

            $urineDatesQuery = DB::table('patient_urine_examination as pue')->where('pue.patient_id', '=', $patientId);
            $urineDatesQuery->select('pue.examination_date')->orderBy('pue.examination_date', 'DESC');
            $urineTestDates = $urineDatesQuery->distinct()->get();

            $motionDatesQuery = DB::table('patient_motion_examination as pme')->where('pme.patient_id', '=', $patientId);
            $motionDatesQuery->select('pme.examination_date')->orderBy('pme.examination_date', 'DESC');
            $motionTestDates = $motionDatesQuery->distinct()->get();

            $examinationDates["generalExaminationDates"] = $generalExaminationDates;
            $examinationDates["pastIllnessDates"] = $pastIllnessDates;
            $examinationDates["familyIllnessDates"] = $familyIllnessDates;
            $examinationDates["personalHistoryDates"] = $personalHistoryDates;
            $examinationDates["pregnancyDates"] = $pregnancyDates;
            $examinationDates["scanDates"] = $scanDates;
            $examinationDates["symptomDates"] = $symptomDates;
            $examinationDates["ultraSoundDates"] = $ultraSoundDates;
            $examinationDates["bloodTestDates"] = $bloodTestDates;
            $examinationDates["urineTestDates"] = $urineTestDates;
            $examinationDates["motionTestDates"] = $motionTestDates;

            //dd($examinationDates);

        }
        catch(QueryException $queryEx)
        {
            dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        //dd($patientLabTests);
        return $examinationDates;
    }*/

    /**
     * Save patient personal history
     * @param $patientHistoryVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePersonalHistory(PatientPersonalHistoryViewModel $patientHistoryVM)
    {
        $status = true;
        $personalHistoryIds = null;

        try {
            $patientId = $patientHistoryVM->getPatientId();
            $doctorId = $patientHistoryVM->getDoctorId();
            $hospitalId = $patientHistoryVM->getHospitalId();

            $patientPersonalHistory = $patientHistoryVM->getPatientPersonalHistory();
            //dd($patientPersonalHistory);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_personal_history')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientPersonalHistory as $patientHistory) {
                    //dd($patientHistory);
                    $personalHistoryId = $patientHistory->personalHistoryId;
                    $personalHistoryItemId = $patientHistory->personalHistoryItemId;
                    $isValueSet = property_exists($patientHistory, 'isValueSet') ? $patientHistory->isValueSet : null;
                    $personalHistoryValue = (isset($patientHistory->personalHistoryItemValue)) ? $patientHistory->personalHistoryItemValue : null;
                    $examinationTime = (isset($patientHistory->examinationTime)) ? $patientHistory->examinationTime : null;
                    //$personalHistoryDate = \DateTime::createFromFormat('Y-m-d', $patientHistory->personalHistoryDate);
                    //$historyDate = $patientHistory->personalHistoryDate;

                    $historyDate = property_exists($patientHistory, 'personalHistoryDate') ? $patientHistory->personalHistoryDate : null;

                    if (!is_null($historyDate)) {
                        $personalHistoryDate = date('Y-m-d', strtotime($historyDate));
                    } else {
                        $personalHistoryDate = null;
                    }
                    //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);

                    //$dentalExaminationItems->dental_examination_name = (isset($examination->dentalExaminationName)) ? $examination->dentalExaminationName : null;


                    $patientUser->personalhistory()->attach($personalHistoryId,
                        array('personal_history_item_id' => $personalHistoryItemId,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'personal_history_value' => $personalHistoryValue,
                            'is_value_set' => $isValueSet,
                            'personal_history_date' => $personalHistoryDate,
                            'examination_time' => $examinationTime,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                    /*$count = DB::table('patient_personal_history as pph')
                        ->where('pph.personal_history_id', '=', $personalHistoryId)
                        ->where('pph.patient_id', '=', $patientId)->count();

                    if($count == 0)
                    {
                        $patientUser->personalhistory()->attach($personalHistoryId,
                            array('personal_history_item_id' => $personalHistoryItemId,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }
                    else
                    {
                        $patientUser->personalhistory()->updateExistingPivot($personalHistoryId,
                            array('personal_history_item_id' => $personalHistoryItemId,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }*/
                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR, $exc);
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

    public function savePatientGeneralExamination(PatientGeneralExaminationViewModel $patientExaminationVM)
    {
        $status = true;

        try {
            $patientId = $patientExaminationVM->getPatientId();
            $doctorId = $patientExaminationVM->getDoctorId();
            $hospitalId = $patientExaminationVM->getHospitalId();
            //$patientUser = User::find($patientId);


            $patientGeneralExamination = $patientExaminationVM->getPatientGeneralExamination();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            //dd($patientGeneralExamination);

            if (!is_null($patient)) {

                $patientUser = User::find($patientId);

                //DB::table('patient_general_history')->where('patient_id', $patientId)->delete();

                foreach ($patientGeneralExamination as $examination) {
                    //dd($patientHistory);
                    $generalExaminationId = $examination->generalExaminationId;
                    $generalExaminationValue = $examination->generalExaminationValue;
                    $isValueSet = property_exists($examination, 'isValueSet') ? $examination->isValueSet : null;
                    $examinationTime = (isset($examination->examinationTime)) ? $examination->examinationTime : null;
                    //$isValueSet = $examination->isValueSet;
                    //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examination->generalExaminationDate);
                    //$examinationDate = $examination->examinationDate;

                    $examinationDate = property_exists($examination, 'examinationDate') ? $examination->examinationDate : null;

                    if (!is_null($examinationDate)) {
                        $generalExaminationDate = date('Y-m-d', strtotime($examinationDate));
                    } else {
                        $generalExaminationDate = null;
                    }

                    //dd($examinationDate);
                    //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
                    //$generalExaminationDate = date('Y-m-d', strtotime($examinationDate));

                    $patientUser->patientgeneralexaminations()->attach($generalExaminationId,
                        array('general_examination_value' => $generalExaminationValue,
                            'is_value_set' => $isValueSet,
                            'general_examination_date' => $generalExaminationDate,
                            'examination_time' => $examinationTime,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));


                    /*$count = DB::table('patient_general_examination as pge')
                        ->where('pge.general_examination_id', '=', $generalExaminationId)
                        ->where('pge.patient_id', '=', $patientId)->count();

                    if($count == 0)
                    {
                        $patientUser->patientgeneralexaminations()->attach($generalExaminationId,
                            array('general_examination_value' => $generalExaminationValue,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }
                    else
                    {
                        $patientUser->patientgeneralexaminations()->updateExistingPivot($generalExaminationId,
                            array('general_examination_value' => $generalExaminationValue,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }*/
                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR, $exc);
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

    public function savePatientPastIllness(PatientPastIllnessViewModel $patientPastIllnessVM)
    {
        $status = true;
        $patientUser = null;
        //dd()

        try {
            $patientId = $patientPastIllnessVM->getPatientId();
            $doctorId = $patientPastIllnessVM->getDoctorId();
            $hospitalId = $patientPastIllnessVM->getHospitalId();
            //$patientUser = User::find($patientId);

            //dd($patientId);

            $patient = Helper::checkPatientExists($patientId);
            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            //dd($patientUser);

            /*$doctorQuery = User::join('role_user as ru', 'ru.user_id', '=', 'users.id');
            $doctorQuery->where('ru.role_id', '=', UserType::USERTYPE_DOCTOR);
            $doctorQuery->where('users.id', '=', $doctorId);
            $doctorQuery->where('users.delete_status', '=', 1);*/
            //$query =

            $patientPastIllness = $patientPastIllnessVM->getPatientPastIllness();

            //$pivotData = array();

            if (!is_null($patient)) {
                //DB::table('patient_past_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientPastIllness as $illness) {
                    //dd($patientHistory);
                    $pastIllnessId = $illness->pastIllnessId;
                    $pastIllnessName = $illness->pastIllnessName;
                    //$pastIllnessDate = \DateTime::createFromFormat('Y-m-d', $illness->pastIllnessDate);
                    //$relation = $illness->relation;
                    $isValueSet = property_exists($illness, 'isValueSet') ? $illness->isValueSet : null;
                    $examinationTime = (isset($illness->examinationTime)) ? $illness->examinationTime : null;
                    //$illnessDate = $illness->pastIllnessDate;
                    //dd($examinationDate);
                    //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
                    //$pastIllnessDate = date('Y-m-d', strtotime($illnessDate));

                    $illnessDate = property_exists($illness, 'pastIllnessDate') ? $illness->pastIllnessDate : null;

                    if (!is_null($illnessDate)) {
                        $pastIllnessDate = date('Y-m-d', strtotime($illnessDate));
                    } else {
                        $pastIllnessDate = null;
                    }

                    $patientUser->patientpastillness()->attach($pastIllnessId,
                        array('past_illness_name' => $pastIllnessName,
                            'past_illness_date' => $pastIllnessDate,
                            'examination_time' => $examinationTime,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            //'relation' => $relation,
                            'is_value_set' => $isValueSet,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                    /*$count = DB::table('patient_past_illness as ppi')
                        ->where('ppi.past_illness_id', '=', $pastIllnessId)
                        ->where('ppi.patient_id', '=', $patientId)->count();

                    if($count == 0)
                    {
                        $patientUser->patientpastillness()->attach($pastIllnessId,
                            array('past_illness_name' => $pastIllnessName,
                                //'relation' => $relation,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }
                    else
                    {
                        $patientUser->patientpastillness()->updateExistingPivot($pastIllnessId,
                            array('general_examination_value' => $pastIllnessName,
                                //'relation' => $relation,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }*/
                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
            //throw $userExc;
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR, $exc);
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

    public function savePatientFamilyIllness(PatientFamilyIllnessViewModel $patientFamilyIllnessVM)
    {
        $status = true;

        try {
            $patientId = $patientFamilyIllnessVM->getPatientId();
            $doctorId = $patientFamilyIllnessVM->getDoctorId();
            $hospitalId = $patientFamilyIllnessVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientFamilyIllness = $patientFamilyIllnessVM->getPatientFamilyIllness();

            $patient = Helper::checkPatientExists($patientId);
            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientFamilyIllness as $illness) {
                    //dd($patientHistory);
                    $familyIllnessId = $illness->familyIllnessId;
                    $familyIllnessName = $illness->familyIllnessName;
                    $relation = $illness->relation;
                    $isValueSet = property_exists($illness, 'isValueSet') ? $illness->isValueSet : null;
                    $examinationTime = (isset($illness->examinationTime)) ? $illness->examinationTime : null;

                    //$familyIllnessDate = \DateTime::createFromFormat('Y-m-d', $illness->familyIllnessDate);
                    //$illnessDate = $illness->familyIllnessDate;
                    //dd($examinationDate);
                    //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
                    //$familyIllnessDate = date('Y-m-d', strtotime($illnessDate));

                    $illnessDate = property_exists($illness, 'familyIllnessDate') ? $illness->familyIllnessDate : null;

                    if (!is_null($illnessDate)) {
                        $familyIllnessDate = date('Y-m-d', strtotime($illnessDate));
                    } else {
                        $familyIllnessDate = null;
                    }

                    $patientUser->patientfamilyillness()->attach($familyIllnessId,
                        array('family_illness_name' => $familyIllnessName,
                            'family_illness_date' => $familyIllnessDate,
                            'examination_time' => $examinationTime,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'relation' => $relation,
                            'is_value_set' => $isValueSet,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));


                    /*$count = DB::table('patient_family_illness as pfi')
                        ->where('pfi.family_illness_id', '=', $familyIllnessId)
                        ->where('pfi.patient_id', '=', $patientId)->count();

                    if($count == 0)
                    {
                        $patientUser->patientfamilyillness()->attach($familyIllnessId,
                            array('family_illness_name' => $familyIllnessName,
                                'relation' => $relation,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }
                    else
                    {
                        $patientUser->patientfamilyillness()->updateExistingPivot($familyIllnessId,
                            array('family_illness_name' => $familyIllnessName,
                                'relation' => $relation,
                                'created_by' => 'Admin',
                                'modified_by' => 'Admin',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ));
                    }*/
                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR, $exc);
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

    public function savePatientPregnancyDetails(PatientPregnancyViewModel $patientPregnancyVM)
    {
        $status = true;

        try {
            $patientId = $patientPregnancyVM->getPatientId();
            $doctorId = $patientPregnancyVM->getDoctorId();
            $hospitalId = $patientPregnancyVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientPregnancy = $patientPregnancyVM->getPatientPregnancy();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            //dd($patientPregnancy);

            if (!is_null($patient)) {
                $patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();

                foreach ($patientPregnancy as $pregnancy) {
                    //dd($pregnancy);
                    $pregnancyId = $pregnancy->pregnancyId;
                    $pregnancyValue = $pregnancy->pregnancyValue;
                    $isValueSet = $pregnancy->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;
                    $pregnancyDate = property_exists($pregnancy, 'pregnancyDate') ? $pregnancy->pregnancyDate : null;
                    $examinationTime = (isset($pregnancy->examinationTime)) ? $pregnancy->examinationTime : null;

                    if (!is_null($pregnancyDate)) {
                        $patientPregnancyDate = date('Y-m-d', strtotime($pregnancyDate));
                    } else {
                        $patientPregnancyDate = null;
                    }

                    //dd($pregnancy);

                    $patientUser->patientpregnancy()->attach($pregnancyId,
                        array('pregnancy_value' => $pregnancyValue,
                            'pregnancy_date' => $patientPregnancyDate,
                            'examination_time' => $examinationTime,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'is_value_set' => $isValueSet,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR, $exc);
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

    public function savePatientScanDetails(PatientScanViewModel $patientScanVM)
    {
        //dd($patientScanVM);
        $status = true;

        try {
            $patientId = $patientScanVM->getPatientId();
            $doctorId = $patientScanVM->getDoctorId();
            $hospitalId = $patientScanVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientScans = $patientScanVM->getPatientScans();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //dd('in');
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();

                $patientUser = User::find($patientId);

                foreach ($patientScans as $scans) {
                    //dd($patientHistory);
                    $scanId = $scans->scanId;
                    $isValueSet = $scans->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $scanDate = property_exists($scans, 'scanDate') ? $scans->scanDate : null;
                    $examinationTime = (isset($scans->examinationTime)) ? $scans->examinationTime : null;

                    if (!is_null($scanDate)) {
                        $patientScanDate = date('Y-m-d', strtotime($scanDate));
                    } else {
                        $patientScanDate = null;
                    }

                    $patientUser->patientscans()->attach($scanId,
                        array('scan_date' => $patientScanDate,
                            'examination_time' => $examinationTime,
                            'is_value_set' => $isValueSet,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                //dd('out');
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_SAVE_ERROR, $exc);
        }

        return $status;
    }

    public function savePatientScanDetailsNew(PatientScanViewModel $patientScanVM)
    {
        $status = true;
        //$hospitalLabId = null;

        try {
            //dd($patientScanVM);
            $patientId = $patientScanVM->getPatientId();
            $doctorId = $patientScanVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientScanVM->getHospitalId();
            //$labId = $patientScanVM->getLabId();
            //$patientUser = User::find($patientId);

            $patientScans = $patientScanVM->getPatientScans();
            $examinationDate = $patientScanVM->getExaminationDate();
            $examinationTime = $patientScanVM->getExaminationTime();
            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                //dd('Test');
                //$examinationDt = property_exists($patientBloodVM, 'examinationDate') ? $examinationDate : null;
                //dd('After Test');
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $scanExamination = new PatientScanExamination();
                $scanExamination->patient_id = $patientId;
                $scanExamination->hospital_id = $hospitalId;
                $scanExamination->doctor_id = $doctorId;
                //$scanExamination->lab_id = $hospitalLabId;
                $scanExamination->scan_date = $patientExaminationDate;
                $scanExamination->examination_time = $examinationTime;
                $scanExamination->created_by = $patientScanVM->getCreatedBy();
                $scanExamination->modified_by = $patientScanVM->getUpdatedBy();
                $scanExamination->created_at = $patientScanVM->getCreatedAt();
                $scanExamination->updated_at = $patientScanVM->getUpdatedAt();
                //$patientBloodExamination = $bloodExamination->save();
                $scanExamination->save();

                foreach ($patientScans as $examination) {
                    //dd($bloodExaminations);
                    //$examinationId = $examination->examinationId;
                    //$examinationName = $examination->examinationName;
                    //$pregnancyDate = $pregnancy->pregnancyDate;
                    $scanExaminationItems = new PatientScanExaminationItems();
                    $scanExaminationItems->scan_id = $examination->scanId;
                    //$examinationDate = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;

                    //$dentalExaminationItems->dental_examination_name = property_exists($examination->dentalExaminationName, 'dentalExaminationName') ? $examination->dentalExaminationName : null;
                    //$dentalExaminationItems->dental_examination_name = (isset($examination->dentalExaminationName)) ? $examination->dentalExaminationName : null;

                    //$dentalExaminationItems->dental_examination_name = $examination->dentalExaminationName;
                    $scanExaminationItems->is_value_set = $examination->isValueSet;
                    $scanExaminationItems->created_by = $patientScanVM->getCreatedBy();
                    $scanExaminationItems->modified_by = $patientScanVM->getUpdatedBy();
                    $scanExaminationItems->created_at = $patientScanVM->getCreatedAt();
                    $scanExaminationItems->updated_at = $patientScanVM->getUpdatedAt();

                    $scanExamination->scanexaminationitems()->save($scanExaminationItems);

                }

                $query1 = PatientLabTests::where('patient_id', '=', $patientId)->where('hospital_id', '=', $hospitalId);
                //dd($query1->toSql());

                /*if($count == 0) {
                    $patientLabTest = new PatientLabTests();
                    $patientLabTest->patient_id = $patientId;
                    $patientLabTest->hospital_id = $hospitalId;
                    $patientLabTest->created_by = 'Admin';
                    $patientLabTest->modified_by = 'Admin';
                    $patientLabTest->created_at = date("Y-m-d H:i:s");
                    $patientLabTest->updated_at = date("Y-m-d H:i:s");

                    $patientLabTest->save();
                }*/

                //$this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SCAN_SAVE_ERROR, $exc);
        }

        return $status;
    }

    private function getLabIdForHospital($hospitalId)
    {
        $labId = null;

        $query = DB::table('hospital_lab as hl')->where('hl.hospital_id', '=', $hospitalId);
        $labId = $query->select('hl.lab_id')->get();

        return $labId;
    }

    private function setPatientLabTests($patientId, $hospitalId)
    {
        //$isExists = false;
        $count = PatientLabTests::where('patient_id', '=', $patientId)->where('hospital_id', '=', $hospitalId)->count();
        //dd($count);

        if ($count == 0) {
            $patientLabTest = new PatientLabTests();
            $patientLabTest->patient_id = $patientId;
            $patientLabTest->hospital_id = $hospitalId;
            $patientLabTest->created_by = 'Admin';
            $patientLabTest->modified_by = 'Admin';
            $patientLabTest->created_at = date("Y-m-d H:i:s");
            $patientLabTest->updated_at = date("Y-m-d H:i:s");

            $patientLabTest->save();
            //$isExists = true;
        }

        //return $isExists;
    }


    /**
     * Save patient symptom details
     * @param $patientSymVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientSymptoms(PatientSymptomsViewModel $patientSymVM)
    {
        $status = true;

        try {
            $patientId = $patientSymVM->getPatientId();
            $doctorId = $patientSymVM->getDoctorId();
            $hospitalId = $patientSymVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientSymptoms = $patientSymVM->getPatientSymptoms();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //$patientUser = User::find($patientId);

                foreach ($patientSymptoms as $symptom) {
                    //dd($patientHistory);
                    $mainSymptomId = $symptom->mainSymptomId;
                    $subSymptomId = $symptom->subSymptomId;
                    $symptomId = $symptom->symptomId;
                    $isValueSet = $symptom->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $symptomDate = property_exists($symptom, 'symptomDate') ? $symptom->symptomDate : null;

                    if (!is_null($symptomDate)) {
                        $patientSymptomDate = date('Y-m-d', strtotime($symptomDate));
                    } else {
                        $patientSymptomDate = null;
                    }

                    $patientSymptom = new PatientSymptoms();
                    $patientSymptom->patient_id = $patientId;
                    $patientSymptom->doctor_id = $doctorId;
                    $patientSymptom->hospital_id = $hospitalId;
                    $patientSymptom->main_symptom_id = $mainSymptomId;
                    $patientSymptom->sub_symptom_id = $subSymptomId;
                    $patientSymptom->symptom_id = $symptomId;
                    $patientSymptom->patient_symptom_date = $patientSymptomDate;
                    $patientSymptom->is_value_set = $isValueSet;
                    $patientSymptom->created_by = $patientSymVM->getCreatedBy();
                    $patientSymptom->modified_by = $patientSymVM->getUpdatedBy();
                    $patientSymptom->created_at = $patientSymVM->getCreatedAt();
                    $patientSymptom->updated_at = $patientSymVM->getUpdatedAt();

                    $patientSymptom->save();

                    /*$patientUser->patientscans()->attach($scanId,
                        array('scan_date' => $patientScanDate,
                            'is_value_set' => $isValueSet,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));*/

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR, $exc);
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

    public function savePatientUrineTests(PatientUrineExaminationViewModel $patientUrineVM)
    {
        $status = true;

        try {
            $patientId = $patientUrineVM->getPatientId();
            $doctorId = $patientUrineVM->getDoctorId();
            $hospitalId = $patientUrineVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientExaminations = $patientUrineVM->getExaminations();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientExaminations as $examination) {
                    //dd($patientHistory);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $examinationDate = property_exists($examination, 'examinationDate') ? $examination->examinationDate : null;
                    $examinationTime = (isset($examination->examinationTime)) ? $examination->examinationTime : null;

                    if (!is_null($examinationDate)) {
                        $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                    } else {
                        $patientExaminationDate = null;
                    }

                    $patientUser->patienturineexaminations()->attach($examinationId,
                        array('examination_date' => $patientExaminationDate,
                            'examination_time' => $examinationTime,
                            'is_value_set' => $isValueSet,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    public function savePatientUrineTestsNew(PatientUrineExaminationViewModel $patientUrineVM)
    {
        $status = true;
        //$hospitalLabId = null;

        try {
            $patientId = $patientUrineVM->getPatientId();
            $doctorId = $patientUrineVM->getDoctorId();
            //$labId = $patientUrineVM->getLabId();
            //dd($doctorId);
            $hospitalId = $patientUrineVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $urineExaminations = $patientUrineVM->getExaminations();
            $examinationDate = $patientUrineVM->getExaminationDate();
            $examinationTime = $patientUrineVM->getExaminationTime();

            $urineExamCategory = CA::get('constants.URINE_EXAMINATION_CATEGORY');
            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                //dd('Test');
                //$examinationDt = property_exists($patientBloodVM, 'examinationDate') ? $examinationDate : null;
                //dd('After Test');
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $urineExamination = new PatientUrineExamination();
                $urineExamination->patient_id = $patientId;
                $urineExamination->hospital_id = $hospitalId;
                $urineExamination->doctor_id = $doctorId;
                //$urineExamination->lab_id = $hospitalLabId;
                $urineExamination->examination_date = $patientExaminationDate;
                $urineExamination->examination_time = $examinationTime;
                $urineExamination->created_by = $patientUrineVM->getCreatedBy();
                $urineExamination->modified_by = $patientUrineVM->getUpdatedBy();
                $urineExamination->created_at = $patientUrineVM->getCreatedAt();
                $urineExamination->updated_at = $patientUrineVM->getUpdatedAt();
                //$patientBloodExamination = $bloodExamination->save();
                $urineExamination->save();

                /*foreach($urineExaminations as $examination)
                {
                    //dd($bloodExaminations);
                    //$examinationId = $examination->examinationId;

                    $urineExaminationItems = new PatientUrineExaminationItems();
                    $urineExaminationItems->urine_examination_id = $examination->examinationId;

                    $urineExaminationItems->is_value_set = $examination->isValueSet;
                    $urineExaminationItems->created_by = $patientUrineVM->getCreatedBy();
                    $urineExaminationItems->modified_by = $patientUrineVM->getUpdatedBy();
                    $urineExaminationItems->created_at = $patientUrineVM->getCreatedAt();
                    $urineExaminationItems->updated_at = $patientUrineVM->getUpdatedAt();

                    $urineExamination->urineexaminationitems()->save($urineExaminationItems);

                }*/

                foreach ($urineExaminations as $examination) {

                    //dd($bloodExaminations);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;

                    if (in_array($examinationId, $urineExamCategory)) {

                        //dd($examinationId);
                        $categoryQuery = DB::table('urine_examination as ue')->where('ue.parent_id', '=', $examinationId);
                        $categoryQuery->where('ue.has_child', '!=', 1);
                        $categoryQuery->where('ue.status', '=', 1);
                        $categoryQuery->select('id');

                        //dd($categoryQuery->toSql());

                        $categoryItems = $categoryQuery->get();
                        //dd($categoryItems);

                        foreach ($categoryItems as $item) {
                            //dd($item);
                            $urineExaminationItems = new PatientUrineExaminationItems();

                            $urineExaminationItems->urine_examination_id = $item->id;
                            $urineExaminationItems->is_value_set = $examination->isValueSet;
                            $urineExaminationItems->created_by = $patientUrineVM->getCreatedBy();
                            $urineExaminationItems->modified_by = $patientUrineVM->getUpdatedBy();
                            $urineExaminationItems->created_at = $patientUrineVM->getCreatedAt();
                            $urineExaminationItems->updated_at = $patientUrineVM->getUpdatedAt();

                            $urineExamination->urineexaminationitems()->save($urineExaminationItems);
                        }
                        /*if($isValueSet == 1)
                        {

                        }*/


                    } else {
                        $urineExaminationItems = new PatientUrineExaminationItems();

                        $urineExaminationItems->urine_examination_id = $examination->examinationId;
                        $urineExaminationItems->is_value_set = $examination->isValueSet;
                        $urineExaminationItems->created_by = $patientUrineVM->getCreatedBy();
                        $urineExaminationItems->modified_by = $patientUrineVM->getUpdatedBy();
                        $urineExaminationItems->created_at = $patientUrineVM->getCreatedAt();
                        $urineExaminationItems->updated_at = $patientUrineVM->getUpdatedAt();

                        $urineExamination->urineexaminationitems()->save($urineExaminationItems);
                    }

                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR, $exc);
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

    public function savePatientMotionTests(PatientUrineExaminationViewModel $patientMotionVM)
    {
        $status = true;

        try {
            $patientId = $patientMotionVM->getPatientId();
            $doctorId = $patientMotionVM->getDoctorId();
            $hospitalId = $patientMotionVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientExaminations = $patientMotionVM->getExaminations();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientExaminations as $examination) {
                    //dd($patientHistory);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $examinationDate = property_exists($examination, 'examinationDate') ? $examination->examinationDate : null;
                    $examinationTime = (isset($examination->examinationTime)) ? $examination->examinationTime : null;

                    if (!is_null($examinationDate)) {
                        $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                    } else {
                        $patientExaminationDate = null;
                    }

                    $patientUser->patientmotionexaminations()->attach($examinationId,
                        array('examination_date' => $patientExaminationDate,
                            'examination_time' => $examinationTime,
                            'is_value_set' => $isValueSet,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    public function savePatientMotionTestsNew(PatientUrineExaminationViewModel $patientMotionVM)
    {
        $status = true;
        //$hospitalLabId = null;

        try {
            $patientId = $patientMotionVM->getPatientId();
            $doctorId = $patientMotionVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientMotionVM->getHospitalId();
            //$labId = $patientMotionVM->getLabId();
            //$patientUser = User::find($patientId);

            $motionExaminations = $patientMotionVM->getExaminations();
            $examinationDate = $patientMotionVM->getExaminationDate();
            $examinationTime = $patientMotionVM->getExaminationTime();
            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                //dd('Test');
                //$examinationDt = property_exists($patientBloodVM, 'examinationDate') ? $examinationDate : null;
                //dd('After Test');
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $motionExamination = new PatientMotionExamination();
                $motionExamination->patient_id = $patientId;
                $motionExamination->hospital_id = $hospitalId;
                $motionExamination->doctor_id = $doctorId;
                //$motionExamination->lab_id = $hospitalLabId;
                $motionExamination->examination_date = $patientExaminationDate;
                $motionExamination->examination_time = $examinationTime;
                $motionExamination->created_by = $patientMotionVM->getCreatedBy();
                $motionExamination->modified_by = $patientMotionVM->getUpdatedBy();
                $motionExamination->created_at = $patientMotionVM->getCreatedAt();
                $motionExamination->updated_at = $patientMotionVM->getUpdatedAt();
                //$patientBloodExamination = $bloodExamination->save();
                $motionExamination->save();

                foreach ($motionExaminations as $examination) {
                    //dd($bloodExaminations);
                    //$examinationId = $examination->examinationId;
                    //$examinationName = $examination->examinationName;
                    //$pregnancyDate = $pregnancy->pregnancyDate;
                    $motionExaminationItems = new PatientMotionExaminationItems();
                    $motionExaminationItems->motion_examination_id = $examination->examinationId;
                    //$examinationDate = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;

                    //$dentalExaminationItems->dental_examination_name = property_exists($examination->dentalExaminationName, 'dentalExaminationName') ? $examination->dentalExaminationName : null;
                    //$dentalExaminationItems->dental_examination_name = (isset($examination->dentalExaminationName)) ? $examination->dentalExaminationName : null;

                    //$dentalExaminationItems->dental_examination_name = $examination->dentalExaminationName;
                    $motionExaminationItems->is_value_set = $examination->isValueSet;
                    $motionExaminationItems->created_by = $patientMotionVM->getCreatedBy();
                    $motionExaminationItems->modified_by = $patientMotionVM->getUpdatedBy();
                    $motionExaminationItems->created_at = $patientMotionVM->getCreatedAt();
                    $motionExaminationItems->updated_at = $patientMotionVM->getUpdatedAt();

                    $motionExamination->motionexaminationitems()->save($motionExaminationItems);

                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR, $exc);
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

    public function savePatientBloodTests(PatientUrineExaminationViewModel $patientBloodVM)
    {
        $status = true;
        $hospitalLabId = null;

        try {
            $patientId = $patientBloodVM->getPatientId();
            $doctorId = $patientBloodVM->getDoctorId();
            $hospitalId = $patientBloodVM->getHospitalId();
            $labId = $patientBloodVM->getLabId();

            //$patientUser = User::find($patientId);

            $patientExaminations = $patientBloodVM->getExaminations();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientExaminations as $examination) {
                    //dd($patientHistory);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $examinationDate = property_exists($examination, 'examinationDate') ? $examination->examinationDate : null;
                    $examinationTime = (isset($examination->examinationTime)) ? $examination->examinationTime : null;

                    if (!is_null($examinationDate)) {
                        $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                    } else {
                        $patientExaminationDate = null;
                    }

                    $patientUser->patientbloodexaminations()->attach($examinationId,
                        array('examination_date' => $patientExaminationDate,
                            'examination_time' => $examinationTime,
                            'is_value_set' => $isValueSet,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    public function savePatientBloodTestsNew(PatientUrineExaminationViewModel $patientBloodVM)
    {
        $status = true;
        //$hospitalLabId = null;
        //dd($patientBloodVM);

        try {
            $patientId = $patientBloodVM->getPatientId();
            $doctorId = $patientBloodVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientBloodVM->getHospitalId();
            //$labId = $patientBloodVM->getLabId();
            //$patientUser = User::find($patientId);

            $bloodExaminations = $patientBloodVM->getExaminations();
            $examinationDate = $patientBloodVM->getExaminationDate();
            $examinationTime = $patientBloodVM->getExaminationTime();

            $bloodExamCategory = CA::get('constants.BLOOD_EXAMINATION_CATEGORY');


            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                //dd('Test');
                //$examinationDt = property_exists($patientBloodVM, 'examinationDate') ? $examinationDate : null;
                //dd('After Test');
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $bloodExamination = new PatientBloodExamination();
                $bloodExamination->patient_id = $patientId;
                $bloodExamination->hospital_id = $hospitalId;
                $bloodExamination->doctor_id = $doctorId;
                //$bloodExamination->lab_id = $hospitalLabId;
                $bloodExamination->examination_date = $patientExaminationDate;
                $bloodExamination->examination_time = $examinationTime;
                $bloodExamination->created_by = $patientBloodVM->getCreatedBy();
                $bloodExamination->modified_by = $patientBloodVM->getUpdatedBy();
                $bloodExamination->created_at = $patientBloodVM->getCreatedAt();
                $bloodExamination->updated_at = $patientBloodVM->getUpdatedAt();
                //$patientBloodExamination = $bloodExamination->save();
                $bloodExamination->save();

                foreach ($bloodExaminations as $examination) {

                    //dd($bloodExaminations);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;

                    if (in_array($examinationId, $bloodExamCategory)) {

                        //dd($examinationId);
                        $categoryQuery = DB::table('blood_examination as be')->where('be.parent_id', '=', $examinationId);
                        $categoryQuery->where('be.has_child', '!=', 1);
                        $categoryQuery->where('be.status', '=', 1);
                        $categoryQuery->select('id');

                        //dd($categoryQuery->toSql());

                        $categoryItems = $categoryQuery->get();
                        //dd($categoryItems);

                        foreach ($categoryItems as $item) {
                            //dd($item);
                            $bloodExaminationItems = new PatientBloodExaminationItems();

                            $bloodExaminationItems->blood_examination_id = $item->id;
                            $bloodExaminationItems->is_value_set = $examination->isValueSet;
                            $bloodExaminationItems->created_by = $patientBloodVM->getCreatedBy();
                            $bloodExaminationItems->modified_by = $patientBloodVM->getUpdatedBy();
                            $bloodExaminationItems->created_at = $patientBloodVM->getCreatedAt();
                            $bloodExaminationItems->updated_at = $patientBloodVM->getUpdatedAt();

                            $bloodExamination->bloodexaminationitems()->save($bloodExaminationItems);
                        }
                        /*if($isValueSet == 1)
                        {

                        }*/


                    } else {
                        $bloodExaminationItems = new PatientBloodExaminationItems();

                        $bloodExaminationItems->blood_examination_id = $examination->examinationId;
                        $bloodExaminationItems->is_value_set = $examination->isValueSet;
                        $bloodExaminationItems->created_by = $patientBloodVM->getCreatedBy();
                        $bloodExaminationItems->modified_by = $patientBloodVM->getUpdatedBy();
                        $bloodExaminationItems->created_at = $patientBloodVM->getCreatedAt();
                        $bloodExaminationItems->updated_at = $patientBloodVM->getUpdatedAt();

                        $bloodExamination->bloodexaminationitems()->save($bloodExaminationItems);
                    }

                    /*$patientBloodExamFees = new PatientBloodExaminationFees();
                    $patientBloodExamFees->blood_examination_id = $examinationId;
                    $patientBloodExamFees->created_by = $patientBloodVM->getCreatedBy();
                    $patientBloodExamFees->modified_by = $patientBloodVM->getUpdatedBy();
                    $patientBloodExamFees->created_at = $patientBloodVM->getCreatedAt();
                    $patientBloodExamFees->updated_at = $patientBloodVM->getUpdatedAt();
                    $bloodExamination->bloodexaminationfees()->save($patientBloodExamFees);*/


                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    private function savePatientBloodTestsFees(PatientUrineExaminationViewModel $patientBloodVM, $bloodExamination, $examination)
    {
        $patientBloodExamFees = new PatientBloodExaminationFees();
        //$patientBloodExamFees->


    }

    /**
     * Save patient ultra sound details
     * @param $patientUltraSoundVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUltraSoundTests(PatientUrineExaminationViewModel $patientUltraSoundVM)
    {
        $status = true;

        try {
            //dd('test');
            $patientId = $patientUltraSoundVM->getPatientId();
            $doctorId = $patientUltraSoundVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientUltraSoundVM->getHospitalId();
            //$patientUser = User::find($patientId);

            $patientExaminations = $patientUltraSoundVM->getExaminations();

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                $patientUser = User::find($patientId);

                foreach ($patientExaminations as $examination) {
                    //dd($patientHistory);
                    $examinationId = $examination->examinationId;
                    $isValueSet = $examination->isValueSet;
                    $examinationTime = (isset($examination->examinationTime)) ? $examination->examinationTime : null;
                    //$pregnancyDate = $pregnancy->pregnancyDate;

                    $examinationDate = property_exists($examination, 'examinationDate') ? $examination->examinationDate : null;

                    if (!is_null($examinationDate)) {
                        $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                    } else {
                        $patientExaminationDate = null;
                    }

                    $patientUser->patientultrasounds()->attach($examinationId,
                        array('examination_date' => $patientExaminationDate,
                            'examination_time' => $examinationTime,
                            'is_value_set' => $isValueSet,
                            'doctor_id' => $doctorId,
                            'hospital_id' => $hospitalId,
                            'created_by' => 'Admin',
                            'modified_by' => 'Admin',
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ));

                }

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    public function savePatientUltraSoundTestsNew(PatientUrineExaminationViewModel $patientUltraSoundVM)
    {
        $status = true;
        //$hospitalLabId = null;

        try {
            $patientId = $patientUltraSoundVM->getPatientId();
            $doctorId = $patientUltraSoundVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientUltraSoundVM->getHospitalId();
            //$labId = $patientUltraSoundVM->getLabId();
            //$patientUser = User::find($patientId);

            $ultrasoundExaminations = $patientUltraSoundVM->getExaminations();
            $examinationDate = $patientUltraSoundVM->getExaminationDate();
            $examinationTime = $patientUltraSoundVM->getExaminationTime();
            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                //dd('Test');
                //$examinationDt = property_exists($patientBloodVM, 'examinationDate') ? $examinationDate : null;
                //dd('After Test');
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $ultrasoundExamination = new PatientUltrasoundExamination();
                $ultrasoundExamination->patient_id = $patientId;
                $ultrasoundExamination->hospital_id = $hospitalId;
                $ultrasoundExamination->doctor_id = $doctorId;
                //$ultrasoundExamination->lab_id = $hospitalLabId;
                $ultrasoundExamination->examination_date = $patientExaminationDate;
                $ultrasoundExamination->examination_time = $examinationTime;
                $ultrasoundExamination->created_by = $patientUltraSoundVM->getCreatedBy();
                $ultrasoundExamination->modified_by = $patientUltraSoundVM->getUpdatedBy();
                $ultrasoundExamination->created_at = $patientUltraSoundVM->getCreatedAt();
                $ultrasoundExamination->updated_at = $patientUltraSoundVM->getUpdatedAt();
                //$patientBloodExamination = $bloodExamination->save();
                $ultrasoundExamination->save();

                foreach ($ultrasoundExaminations as $examination) {
                    //dd($bloodExaminations);
                    //$examinationId = $examination->examinationId;
                    //$examinationName = $examination->examinationName;
                    //$pregnancyDate = $pregnancy->pregnancyDate;
                    $ultrasoundExaminationItems = new PatientUltrasoundExaminationItems();
                    $ultrasoundExaminationItems->ultra_sound_id = $examination->examinationId;
                    //$examinationDate = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;

                    //$dentalExaminationItems->dental_examination_name = property_exists($examination->dentalExaminationName, 'dentalExaminationName') ? $examination->dentalExaminationName : null;
                    //$dentalExaminationItems->dental_examination_name = (isset($examination->dentalExaminationName)) ? $examination->dentalExaminationName : null;

                    //$dentalExaminationItems->dental_examination_name = $examination->dentalExaminationName;
                    $ultrasoundExaminationItems->is_value_set = $examination->isValueSet;
                    $ultrasoundExaminationItems->created_by = $patientUltraSoundVM->getCreatedBy();
                    $ultrasoundExaminationItems->modified_by = $patientUltraSoundVM->getUpdatedBy();
                    $ultrasoundExaminationItems->created_at = $patientUltraSoundVM->getCreatedAt();
                    $ultrasoundExaminationItems->updated_at = $patientUltraSoundVM->getUpdatedAt();

                    $ultrasoundExamination->ultrasoundexaminationitems()->save($ultrasoundExaminationItems);

                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR, $exc);
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

    public function savePatientDentalTests(PatientDentalViewModel $patientDentalVM)
    {
        $status = true;
        $patientExaminationDate = null;
        $patientDentalExamination = null;
        //$hospitalLabId = null;

        try {
            //dd('test');
            $patientId = $patientDentalVM->getPatientId();
            $doctorId = $patientDentalVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientDentalVM->getHospitalId();
            //$labId = $patientDentalVM->getLabId();
            //$patientUser = User::find($patientId);

            $dentalExaminations = $patientDentalVM->getPatientDentalTests();
            $examinationDate = $patientDentalVM->getExaminationDate();
            $examinationTime = $patientDentalVM->getExaminationTime();
            //dd($examinationDate);

            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //$patientUser = User::find($patientId);
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                $examinationDt = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                 {
                     $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                 }*/

                //dd($patientExaminationDate);

                $dentalExamination = new PatientDentalExamination();
                $dentalExamination->patient_id = $patientId;
                $dentalExamination->hospital_id = $hospitalId;
                $dentalExamination->doctor_id = $patientDentalVM->getDoctorId();
                //$dentalExamination->lab_id = $hospitalLabId;
                $dentalExamination->examination_date = $patientExaminationDate;
                $dentalExamination->examination_time = $examinationTime;
                $dentalExamination->created_by = $patientDentalVM->getCreatedBy();
                $dentalExamination->modified_by = $patientDentalVM->getUpdatedBy();
                $dentalExamination->created_at = $patientDentalVM->getCreatedAt();
                $dentalExamination->updated_at = $patientDentalVM->getUpdatedAt();
                $dentalExamination->save();

                foreach ($dentalExaminations as $examination) {
                    //dd($examination);
                    //$examinationId = $examination->examinationId;
                    //$examinationName = $examination->examinationName;
                    //$pregnancyDate = $pregnancy->pregnancyDate;
                    $dentalExaminationItems = new PatientDentalExaminationItems();
                    $dentalExaminationItems->dental_examination_item_id = $examination->dentalExaminationId;
                    //$examinationDate = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;

                    //$dentalExaminationItems->dental_examination_name = property_exists($examination->dentalExaminationName, 'dentalExaminationName') ? $examination->dentalExaminationName : null;
                    $dentalExaminationItems->dental_examination_name = (isset($examination->dentalExaminationName)) ? $examination->dentalExaminationName : null;

                    //$dentalExaminationItems->dental_examination_name = $examination->dentalExaminationName;
                    $dentalExaminationItems->created_by = $patientDentalVM->getCreatedBy();
                    $dentalExaminationItems->modified_by = $patientDentalVM->getUpdatedBy();
                    $dentalExaminationItems->created_at = $patientDentalVM->getCreatedAt();
                    $dentalExaminationItems->updated_at = $patientDentalVM->getUpdatedAt();
                    if (!is_null($dentalExaminationItems->dental_examination_name)) {
                        $dentalExamination->dentalexaminationitems()->save($dentalExaminationItems);
                    }

                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR, $exc);
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

    public function savePatientXRayTests(PatientXRayViewModel $patientXRayVM)
    {
        $status = true;
        $patientExaminationDate = null;
        //$hospitalLabId = null;
        //$patientXRayExamination = null;

        try {
            //dd('test');
            $patientId = $patientXRayVM->getPatientId();
            $doctorId = $patientXRayVM->getDoctorId();
            //dd($doctorId);
            $hospitalId = $patientXRayVM->getHospitalId();
            //$labId = $patientXRayVM->getLabId();

            $xrayExaminations = $patientXRayVM->getPatientXRayTests();
            $examinationDate = $patientXRayVM->getExaminationDate();
            $examinationTime = $patientXRayVM->getExaminationTime();
            //dd($xrayExaminations);

            //$patientUser = User::find($patientId);
            /*$doctor = Helper::checkDoctorExists($doctorId);

            if(is_null($doctor))
            {
                throw new UserNotFoundException(null, ErrorEnum::USER_NOT_FOUND, null);
            }

            $hospital = Helper::checkHospitalExists($hospitalId);

            if(is_null($hospital))
            {
                throw new UserNotFoundException(null, ErrorEnum::HOSPITAL_USER_NOT_FOUND, null);
            }*/

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {
                //DB::table('patient_family_illness')->where('patient_id', $patientId)->delete();
                //dd($patientDentalVM->getExaminationDate());
                $examinationDt = property_exists($patientXRayVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;
                //dd($examinationDt);

                if (!is_null($examinationDate)) {
                    $patientExaminationDate = date('Y-m-d', strtotime($examinationDate));
                } else {
                    $patientExaminationDate = null;
                }

                /*if(is_null($labId))
                {
                    $hospitalLabId = $this->getLabIdForHospital($hospitalId);
                }*/

                //dd($patientExaminationDate);

                $xrayExamination = new PatientXRayExamination();
                $xrayExamination->patient_id = $patientId;
                $xrayExamination->hospital_id = $hospitalId;
                $xrayExamination->doctor_id = $patientXRayVM->getDoctorId();
                //$xrayExamination->lab_id = $hospitalLabId;
                $xrayExamination->examination_date = $patientExaminationDate;
                $xrayExamination->examination_time = $examinationTime;
                $xrayExamination->created_by = $patientXRayVM->getCreatedBy();
                $xrayExamination->modified_by = $patientXRayVM->getUpdatedBy();
                $xrayExamination->created_at = $patientXRayVM->getCreatedAt();
                $xrayExamination->updated_at = $patientXRayVM->getUpdatedAt();
                $xrayExamination->save();

                foreach ($xrayExaminations as $examination) {
                    //dd($examination);
                    $xrayExaminationItems = new PatientXRayExaminationItems();
                    $xrayExaminationItems->xray_examination_item_id = $examination->xrayExaminationId;
                    //$examinationDate = property_exists($patientDentalVM->getExaminationDate(), 'examinationDate') ? $examinationDate : null;

                    //$xrayExaminationItems->xray_examination_name = property_exists($examination->xrayExaminationName, 'xrayExaminationName') ? $examination->xrayExaminationName : null;
                    $xrayExaminationItems->xray_examination_name = (isset($examination->xrayExaminationName)) ? $examination->xrayExaminationName : null;

                    //$dentalExaminationItems->dental_examination_name = $examination->dentalExaminationName;
                    $xrayExaminationItems->created_by = $patientXRayVM->getCreatedBy();
                    $xrayExaminationItems->modified_by = $patientXRayVM->getUpdatedBy();
                    $xrayExaminationItems->created_at = $patientXRayVM->getCreatedAt();
                    $xrayExaminationItems->updated_at = $patientXRayVM->getUpdatedAt();
                    if (!is_null($xrayExaminationItems->xray_examination_name)) {
                        $xrayExamination->xrayexaminationitems()->save($xrayExaminationItems);
                    }

                }

                $this->setPatientLabTests($patientId, $hospitalId);

            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
        } catch (QueryException $queryEx) {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Save patient drug and surgery history
     * @param $drugHistoryVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDrugHistory(PatientDrugHistoryViewModel $drugHistoryVM)
    {
        $status = true;
        $patientDrugHistory = null;

        try {
            $patientId = $drugHistoryVM->getPatientId();
            //$patientUser = User::find($patientId);

            $patientDrugHistory = $drugHistoryVM->getDrugHistory();
            $patientSurgeryHistory = $drugHistoryVM->getSurgeryHistory();

            $patient = Helper::checkPatientExists($patientId);

            if (!is_null($patient)) {

                $patientUser = User::find($patientId);

                foreach ($patientDrugHistory as $history) {
                    $patientDrugHistory = new PatientDrugHistory();
                    //$patientDrugHistory->patient_id = $patientId;
                    $patientDrugHistory->drug_name = $history->drugName;
                    $patientDrugHistory->dosage = $history->dosage;
                    $patientDrugHistory->timings = $history->timings;
                    $patientDrugHistory->drug_history_date = $history->drugHistoryDate;
                    $patientDrugHistory->doctor_id = $drugHistoryVM->getDoctorId();
                    $patientDrugHistory->hospital_id = $drugHistoryVM->getHospitalId();
                    $patientDrugHistory->created_by = $drugHistoryVM->getCreatedBy();
                    $patientDrugHistory->modified_by = $drugHistoryVM->getUpdatedBy();
                    $patientDrugHistory->created_at = $drugHistoryVM->getCreatedAt();
                    $patientDrugHistory->updated_at = $drugHistoryVM->getUpdatedAt();

                    $patientUser->patientdrughistory()->save($patientDrugHistory);
                }

                foreach ($patientSurgeryHistory as $history) {
                    $patientSurgeryHistory = new PatientSurgeries();
                    //$patientDrugHistory->patient_id = $patientId;
                    $patientSurgeryHistory->patient_surgeries = $history->surgeryName;
                    $patientSurgeryHistory->operation_date = $history->operationDate;
                    $patientSurgeryHistory->surgery_input_date = $history->surgeryInputDate;
                    $patientSurgeryHistory->created_by = $drugHistoryVM->getCreatedBy();
                    $patientSurgeryHistory->modified_by = $drugHistoryVM->getUpdatedBy();
                    $patientSurgeryHistory->created_at = $drugHistoryVM->getCreatedAt();
                    $patientSurgeryHistory->updated_at = $drugHistoryVM->getUpdatedAt();

                    $patientUser->patientsurgeries()->save($patientSurgeryHistory);
                }

                //$patientDrugHistory->drug_name = $drugHistoryVM->getd;
                //$patientLabTests->unique_id = "LTID".time();

                /*$patientLabTests->unique_id = 'LTID'.crc32(uniqid(rand()));
                $patientLabTests->brief_description = $patientLabTestVM->getDescription();
                $patientLabTests->labtest_date = $patientLabTestVM->getLabTestDate();
                $patientLabTests->created_by = 'Admin';
                $patientLabTests->modified_by = 'Admin';
                $patientUser->labtests()->save($patientLabTests);*/
            } else {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

        } catch (QueryException $queryEx) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR, $queryEx);
        } catch (UserNotFoundException $userExc) {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Save lab receipt details for the patient
     * @param $labReceiptsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveLabReceiptDetailsForPatient(PatientLabReceiptViewModel $labReceiptsVM)
    {
        $status = true;
        $patientDrugHistory = null;
        $bloodTests = null;
        $labFeeReceipt = null;
        $isXrayTest = false;
        $isDentalTest = false;
        $isBloodTest = false;
        $isUrineTest = false;
        $isMotionTest = false;
        $isScanTest = false;
        $isUltrasoundTest = false;

        try
        {
            $patientId = $labReceiptsVM->getPatientId();
            $patientUser = User::find($patientId);

            if (is_null($patientUser)) {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $bloodTests = $labReceiptsVM->getBloodTests();
            $urineTests = $labReceiptsVM->getUrineTests();
            $motionTests = $labReceiptsVM->getMotionTests();
            $scanTests = $labReceiptsVM->getScanTests();
            $ultraSoundTests = $labReceiptsVM->getUltraSoundTests();
            $dentalTests = $labReceiptsVM->getDentalTests();
            $xrayTests = $labReceiptsVM->getXrayTests();

           // dd($bloodTests);
            //dd($isDentalTest);

            //dd($dentalTests[0]['id']);

            $labFeeReceipt = $this->saveLabFeeReceipt($labReceiptsVM);

            //dd($labFeeReceipt->id);

            if(!is_null($labFeeReceipt))
            {
                //$patientPaymentHistory= $this->saveLabFeeReceiptHistory($labReceiptsVM,$labFeeReceipt->id);//by ramana 12-01-2018

                /*if(!is_null($bloodTests) && !empty($bloodTests))
                {
                    foreach($bloodTests as $bloodTest)
                    {
                        if($bloodTest['fees'] > 0)
                        {
                            $updateValues = array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1,
                                'pbe.fee_receipt_id' => $labFeeReceipt->id,
                                'pbe.created_at' => $labReceiptsVM->getCreatedAt(), 'pbe.updated_at' => $labReceiptsVM->getUpdatedAt());
                            $query = DB::table('patient_blood_examination as pbe')->where('pbe.id', '=', $bloodTest['id']);
                            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                            $query->update($updateValues);
                        }

                    }
                }*/

                if(!is_null($bloodTests) && !empty($bloodTests))
                {
                    //dd($dentalTests);
                    $examinationId = $bloodTests[0]['id'];

                    foreach($bloodTests as $bloodTest)
                    {
                        if($bloodTest['fees'] > 0)
                        {
                            $isBloodTest = true;
                            break;
                        }
                    }

                    if($isBloodTest)
                    {
                        $bloodExamination = PatientBloodExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($bloodExamination))
                        {
                            $bloodExamination->fee_receipt_id = $labFeeReceipt->id;
                            $bloodExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $bloodExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($bloodTests as $bloodTest)
                        {
                            if($bloodTest['fees'] >= 0)
                            {
                                $updateValues = array('pbei.fees' => $bloodTest['fees'], 'pbei.is_fees_paid' => 1,
                                    'pbei.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_blood_examination_item as pbei')->where('pbei.id', '=', $bloodTest['item_id']);

                                /*$updateValues = array('pbef.fees' => $bloodTest['fees'], 'pbef.is_fees_paid' => 1,
                                    'pbef.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_blood_examination_fees as pbef')->where('pbef.id', '=', $bloodTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));*/
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                /*if(!is_null($urineTests) && !empty($urineTests))
                {
                    foreach($urineTests as $urineTest)
                    {
                        if($urineTest['fees'] > 0)
                        {
                            $updateValues = array('pue.fees' => $urineTest['fees'], 'pue.is_fees_paid' => 1,
                                'pue.fee_receipt_id' => $labFeeReceipt->id,
                                'pue.created_at' => $labReceiptsVM->getCreatedAt(), 'pue.updated_at' => $labReceiptsVM->getUpdatedAt());
                            $query = DB::table('patient_urine_examination as pue')->where('pue.id', '=', $urineTest['id']);
                            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                            $query->update($updateValues);
                        }

                    }
                }*/

                if(!is_null($urineTests) && !empty($urineTests))
                {
                    //dd($dentalTests);
                    $examinationId = $urineTests[0]['id'];

                    foreach($urineTests as $urineTest)
                    {
                        if($urineTest['fees'] > 0)
                        {
                            $isUrineTest = true;
                            break;
                        }
                    }

                    if($isUrineTest)
                    {
                        $urineExamination = PatientUrineExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($urineExamination))
                        {
                            $urineExamination->fee_receipt_id = $labFeeReceipt->id;
                            $urineExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $urineExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($urineTests as $urineTest)
                        {
                            if($urineTest['fees'] > 0)
                            {
                                $updateValues = array('puei.fees' => $urineTest['fees'], 'puei.is_fees_paid' => 1,
                                    'puei.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_urine_examination_item as puei')->where('puei.id', '=', $urineTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                /*if(!is_null($motionTests) && !empty($motionTests))
                {
                    foreach($motionTests as $motionTest)
                    {
                        if($motionTest['fees'] > 0)
                        {
                            $updateValues = array('pme.fees' => $motionTest['fees'], 'pme.is_fees_paid' => 1,
                                'pme.fee_receipt_id' => $labFeeReceipt->id,
                                'pme.created_at' => $labReceiptsVM->getCreatedAt(), 'pme.updated_at' => $labReceiptsVM->getUpdatedAt());
                            $query = DB::table('patient_motion_examination as pme')->where('pme.id', '=', $motionTest['id']);
                            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                            $query->update($updateValues);
                        }

                    }
                }*/

                if(!is_null($motionTests) && !empty($motionTests))
                {
                    //dd($dentalTests);
                    $examinationId = $motionTests[0]['id'];

                    foreach($motionTests as $motionTest)
                    {
                        if($motionTest['fees'] > 0)
                        {
                            $isMotionTest = true;
                            break;
                        }
                    }

                    if($isMotionTest)
                    {
                        $motionExamination = PatientMotionExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($motionExamination))
                        {
                            $motionExamination->fee_receipt_id = $labFeeReceipt->id;
                            $motionExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $motionExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($motionTests as $motionTest)
                        {
                            if($motionTest['fees'] > 0)
                            {
                                $updateValues = array('pmei.fees' => $motionTest['fees'], 'pmei.is_fees_paid' => 1,
                                    'pmei.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_motion_examination_item as pmei')->where('pmei.id', '=', $motionTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                /*if(!is_null($scanTests) && !empty($scanTests))
                {
                    foreach($scanTests as $scanTest)
                    {
                        if($scanTest['fees'] > 0)
                        {
                            $updateValues = array('ps.fees' => $scanTest['fees'], 'ps.is_fees_paid' => 1,
                                'ps.fee_receipt_id' => $labFeeReceipt->id,
                                'ps.created_at' => $labReceiptsVM->getCreatedAt(), 'ps.updated_at' => $labReceiptsVM->getUpdatedAt());
                            $query = DB::table('patient_scan as ps')->where('ps.id', '=', $scanTest['id']);
                            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                            $query->update($updateValues);
                        }

                    }
                }*/

                if(!is_null($scanTests) && !empty($scanTests))
                {
                    //dd($dentalTests);
                    $examinationId = $scanTests[0]['id'];

                    foreach($scanTests as $scanTest)
                    {
                        if($scanTest['fees'] > 0)
                        {
                            $isScanTest = true;
                            break;
                        }
                    }

                    if($isScanTest)
                    {
                        $scanExamination = PatientScanExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($scanExamination))
                        {
                            $scanExamination->fee_receipt_id = $labFeeReceipt->id;
                            $scanExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $scanExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($scanTests as $scanTest)
                        {
                            if($scanTest['fees'] > 0)
                            {
                                $updateValues = array('psi.fees' => $scanTest['fees'], 'psi.is_fees_paid' => 1,
                                    'psi.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_scan_item as psi')->where('psi.id', '=', $scanTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                /*if(!is_null($ultraSoundTests) && !empty($ultraSoundTests))
                {
                    foreach($ultraSoundTests as $ultraSoundTest)
                    {
                        if($ultraSoundTest['fees'] > 0)
                        {
                            $updateValues = array('pus.fees' => $ultraSoundTest['fees'], 'pus.is_fees_paid' => 1,
                                'pus.fee_receipt_id' => $labFeeReceipt->id,
                                'pus.created_at' => $labReceiptsVM->getCreatedAt(), 'pus.updated_at' => $labReceiptsVM->getUpdatedAt());
                            $query = DB::table('patient_ultra_sound as pus')->where('pus.id', '=', $ultraSoundTest['id']);
                            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                            $query->update($updateValues);
                        }

                    }
                }*/

                if(!is_null($ultraSoundTests) && !empty($ultraSoundTests))
                {
                    //dd($dentalTests);
                    $examinationId = $ultraSoundTests[0]['id'];

                    foreach($ultraSoundTests as $ultraSoundTest)
                    {
                        if($ultraSoundTest['fees'] > 0)
                        {
                            $isUltrasoundTest = true;
                            break;
                        }
                    }

                    if($isUltrasoundTest)
                    {
                        $ultraSoundExamination = PatientUltrasoundExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($ultraSoundExamination))
                        {
                            $ultraSoundExamination->fee_receipt_id = $labFeeReceipt->id;
                            $ultraSoundExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $ultraSoundExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($ultraSoundTests as $ultraSoundTest)
                        {
                            if($ultraSoundTest['fees'] > 0)
                            {
                                $updateValues = array('pusi.fees' => $ultraSoundTest['fees'], 'pusi.is_fees_paid' => 1,
                                    'pusi.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_ultra_sound_item as pusi')->where('pusi.id', '=', $ultraSoundTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                if(!is_null($dentalTests) && !empty($dentalTests))
                {
                    //dd($dentalTests);
                    $examinationId = $dentalTests[0]['id'];

                    foreach($dentalTests as $dentalTest)
                    {
                        if($dentalTest['fees'] > 0)
                        {
                            $isDentalTest = true;
                            break;
                        }
                    }

                    if($isDentalTest)
                    {
                        $dentalExamination = PatientDentalExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($dentalExamination))
                        {
                            $dentalExamination->fee_receipt_id = $labFeeReceipt->id;
                            $dentalExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $dentalExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($dentalTests as $dentalTest)
                        {
                            if($dentalTest['fees'] > 0)
                            {
                                $updateValues = array('pdei.fees' => $dentalTest['fees'], 'pdei.is_fees_paid' => 1,
                                    'pdei.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_dental_examination_item as pdei')->where('pdei.id', '=', $dentalTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }

                }

                if(!is_null($xrayTests) && !empty($xrayTests))
                {
                    //dd($dentalTests);
                    $examinationId = $xrayTests[0]['id'];

                    foreach($xrayTests as $xrayTest)
                    {
                        if($xrayTest['fees'] > 0)
                        {
                            $isXrayTest = true;
                            break;
                        }
                    }

                    if($isXrayTest)
                    {
                        $xrayExamination = PatientXRayExamination::where('id', '=', $examinationId)->first();
                        //dd($dentalExamination);

                        if(!is_null($xrayExamination))
                        {
                            $xrayExamination->fee_receipt_id = $labFeeReceipt->id;
                            $xrayExamination->updated_at = $labReceiptsVM->getUpdatedAt();

                            //dd($dentalExamination);
                            $xrayExamination->save();
                        }
                        //dd($dentalExamination);

                        foreach($xrayTests as $xrayTest)
                        {
                            if($xrayTest['fees'] > 0)
                            {
                                $updateValues = array('pxei.fees' => $xrayTest['fees'], 'pxei.is_fees_paid' => 1,
                                    'pxei.updated_at' => $labReceiptsVM->getUpdatedAt());
                                $query = DB::table('patient_xray_examination_item as pxei')->where('pxei.id', '=', $xrayTest['item_id']);
                                //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
                                $query->update($updateValues);
                            }

                        }
                    }


                }

                $this->saveLabFeeReceiptHistory($labReceiptsVM, $labFeeReceipt->id);//by ramana 12-01-2018
            }
            //dd($bloodTests);

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_SAVE_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_SAVE_ERROR, $exc);
        }

        return $status;
    }

    private function saveLabFeeReceipt(PatientLabReceiptViewModel $labReceiptsVM)
    {
        $labFeeReceipt = new LabFeeReceipt();

        $labFeeReceipt->patient_id = $labReceiptsVM->getPatientId();
        $labFeeReceipt->hospital_id = $labReceiptsVM->getHospitalId();
        $labFeeReceipt->doctor_id = $labReceiptsVM->getDoctorId();
        $labFeeReceipt->total_fees = $labReceiptsVM->getTotalFees();
        $labFeeReceipt->paid_amount = $labReceiptsVM->getPaidAmount();//by ramana
        $labFeeReceipt->lab_receipt_date = $labReceiptsVM->getLabReceiptDate();
        $labFeeReceipt->created_by = $labReceiptsVM->getCreatedBy();
        $labFeeReceipt->modified_by = $labReceiptsVM->getUpdatedBy();
        $labFeeReceipt->created_at = $labReceiptsVM->getCreatedAt();
        $labFeeReceipt->updated_at = $labReceiptsVM->getUpdatedAt();

        $labFeeReceipt->save();

        return $labFeeReceipt;

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
            $query = DB::table('lab_fee_receipt as lfr')->join('patient as p', 'p.patient_id', '=', 'lfr.patient_id');
            $query->where('lfr.patient_id', '=', $patientId);
            $query->where('lfr.hospital_id', '=', $hospitalId);
            $query->orderBy('lfr.created_at', 'DESC');

            $query->select('lfr.id as receiptId', 'lfr.patient_id', 'p.name', 'p.pid', 'lfr.total_fees', 'lfr.lab_receipt_date','lfr.paid_amount');

            //dd($query->toSql());
            $labReceipts = $query->get();

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPTS_LIST_ERROR, $exc);
        }

        return $labReceipts;
    }

    /*Symptom section -- End */

    /**
     * Upload patient lab test documents
     * @param $labDocumentsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM)
    {
        $labDocuments = null;
        $status = true;

        try
        {
            $patientId = $labDocumentsVM->getPatientId();
            $labId = $labDocumentsVM->getLabId();
            $labDocuments = $labDocumentsVM->getPatientLabDocuments();

            if (!is_null($labDocuments))
            {
                $labDocument = new PatientDocuments();
                $labDocument->patient_id = $patientId;
                $labDocument->lab_id = $labId;
                $labDocument->document_upload_date = $labDocumentsVM->getDocumentUploadDate();
                $labDocument->created_by = $labDocumentsVM->getCreatedBy();
                $labDocument->modified_by = $labDocumentsVM->getUpdatedBy();
                $labDocument->created_at = $labDocumentsVM->getCreatedAt();
                $labDocument->updated_at = $labDocumentsVM->getUpdatedAt();
                $labDocument->save();

                foreach ($labDocuments as $document)
                {
                    $uploadPath = $document['document_upload_path'];
                    $documentContents = File::get($uploadPath);

                    $filename = $uploadPath->getClientOriginalName();
                    $extension = $uploadPath->getClientOriginalExtension();

                    $randomName = $this->generateUniqueFileName();

                    $documentPath = 'medical_document/' . 'patient_document_' . $patientId . '/' . 'patient_document_' . $patientId . '_' . $randomName . '.' . $extension;
                    Storage::disk('local')->put($documentPath, Crypt::encrypt(file_get_contents($documentContents)));

                    $labDocumentItems = new PatientDocumentItems();

                    $labDocumentItems->test_category_name = $labDocumentsVM->getTestCategoryName();
                    $labDocumentItems->document_name = $labDocumentsVM->getDocumentName();
                    $labDocumentItems->document_path = $documentPath;
                    $labDocumentItems->document_upload_date = (date("Y-m-d H:i:s"));
                    $labDocumentItems->document_filename = $filename;
                    $labDocumentItems->document_extension = $extension;
                    $labDocumentItems->document_upload_status = 1;
                    $labDocumentItems->created_by = $labDocumentsVM->getCreatedBy();
                    $labDocumentItems->modified_by = $labDocumentsVM->getUpdatedBy();
                    $labDocumentItems->created_at = $labDocumentsVM->getCreatedAt();
                    $labDocumentItems->updated_at = $labDocumentsVM->getUpdatedAt();

                    $labDocument->patientdocumentitems()->save($labDocumentItems);


                }
            }
        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            $status = false;
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $exc);
        }

        return $status;
    }

    /**
     * Upload patient lab test documents
     * @param $labDocumentsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientApiLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM)
    {
        $labDocuments = null;
        $status = true;
        $appPath = null;
        $filePath = null;
        $filePathArray = null;

        try
        {
            $patientId = $labDocumentsVM->getPatientId();
            $labId = $labDocumentsVM->getLabId();

            $app_path = storage_path('app');
            //dd($app_path);
            //$labDocuments = $labDocumentsVM->getPatientLabDocuments();
            //dd($labDocuments);

            $labDocuments = $labDocumentsVM->getDoctorUploads();
            $diskStorage = env('DISK_STORAGE');
            $storageBasePath = env('STORAGE_BASE_PATH');
            $i = 0;

            //dd($labDocuments);

            if (!is_null($labDocuments))
            {
                $labDocument = new PatientDocuments();
                $labDocument->patient_id = $patientId;
                $labDocument->lab_id = $labId;
                $labDocument->document_upload_date = $labDocumentsVM->getDocumentUploadDate();
                $labDocument->created_by = $labDocumentsVM->getCreatedBy();
                $labDocument->modified_by = $labDocumentsVM->getUpdatedBy();
                $labDocument->created_at = $labDocumentsVM->getCreatedAt();
                $labDocument->updated_at = $labDocumentsVM->getUpdatedAt();
                $labDocument->save();

                foreach($labDocuments as $key => $value)
                {


                    $filename = $value->getClientOriginalName();
                    $extension = $value->getClientOriginalExtension();
                    //$randomName = $this->generateUniqueFileName();


                    //$documentPath = 'medical_document/' . 'patient_document_'.$filename . '.' . $extension;
                    $documentPath = 'medical_document/' . 'patient_document_'.$patientId.'/'.time().'_'.$filename;

                    //Storage::disk($diskStorage)->put($documentPath, file_get_contents($value));
                    Storage::disk($diskStorage)->put($documentPath, Crypt::encrypt(file_get_contents($value)));

                    $labDocumentItems = new PatientDocumentItems();

                    //$labDocumentItems->test_category_name = $labDocumentsVM->getTestCategoryName();
                    //$labDocumentItems->document_name = $labDocumentsVM->getDocumentName();
                    $labDocumentItems->document_path = $documentPath;
                    //$labDocumentItems->document_upload_date = (date("Y-m-d H:i:s"));
                    $labDocumentItems->document_filename = $filename;
                    $labDocumentItems->document_extension = $extension;
                    $labDocumentItems->document_upload_status = 1;
                    $labDocumentItems->created_by = $labDocumentsVM->getCreatedBy();
                    $labDocumentItems->modified_by = $labDocumentsVM->getUpdatedBy();
                    $labDocumentItems->created_at = $labDocumentsVM->getCreatedAt();
                    $labDocumentItems->updated_at = $labDocumentsVM->getUpdatedAt();

                    $labDocument->patientdocumentitems()->save($labDocumentItems);

                    //$filePath  = Storage::disk($diskStorage)->getDriver()->getAdapter()->getPathPrefix();

                    //$filePath = storage_path('app/'.$documentPath);

                    //$filePath = $storageBasePath.Storage::url('app/'.$documentPath);

                    //$url = Storage::disk($diskStorage)->url('app/'.$documentPath);
                    //$url = Storage::url($documentPath);
                    //$url = storage_path($documentPath);
                    //$filePath = asset('storage/'.$filename);

                    //$filePath = Storage::disk($diskStorage)->url($documentPath);
                    //$filePathArray[$i] = $filePath;
                    //$i = $i + 1;


                }

                //dd('$filePathArray');

            }
        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $status = false;
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $exc);
        }

        //return $filePathArray;
        return $status;
    }

    private function generateUniqueFileName()
    {
        $i = 0;
        $randomString = mt_rand(1, 9);
        do {
            $randomString .= mt_rand(0, 9);
        } while (++$i < 7);

        return $randomString;
    }

    private function generateRandomString($length = 9) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /*2018-02-09 By Prasanth*/
    /*Note: we are generating PID based on Current Month and Year of existed patient Count
      and we are setting 0001 when New month start
    */
    private function generatePID($hospitalId) {
        $count = 0;

        $current_month = date('m');
        $current_year = date('Y');

       $count=DB::table('hospital_patient')->whereMonth('created_at','=',$current_month)->whereYear('created_at','=',$current_year)->where('hospital_id','=',$hospitalId)->select(DB::raw('count(patient_id) as count'))->get();
       //dd($count[0]->count);
        $count=intval($count[0]->count)+1;
       $length=strlen($count);
       switch ($length){
           case 1: $count="000".$count;
           break;
           case 2: $count="00".$count;
               break;
           case 3: $count="0".$count;
               break;
           default :$count;

       }
        return $count;
    }
    /*NEW ADDITION RAMANA*/

    //NEWLY ADDED RAMANA Start 12-01-2018
    public function getExaminationDatesByDate($patientId, $hospitalId,$date)
    {
        $doctorinfo=[];
        try
        {
            $patientUser = User::find($patientId);

            if(is_null($patientUser))
            {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }

            $latestBloodExamQuery = DB::table('patient_blood_examination as pbe');
            $latestBloodExamQuery->join('patient_blood_examination_item as pbei', 'pbei.patient_blood_examination_id', '=', 'pbe.id');
            $latestBloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbei.blood_examination_id');
            $latestBloodExamQuery->join('blood_examination as be1', 'be1.id', '=', 'be.parent_id');
            $latestBloodExamQuery->where('pbe.examination_date','=',$date);


            $latestBloodExamQuery->where('pbe.patient_id', '=', $patientId);
            $latestBloodExamQuery->where('pbei.is_value_set', '=', 1);
            $latestBloodExamQuery->select('pbe.id as examinationId', 'pbei.id as examinationItemId', 'pbe.patient_id',
                'pbe.hospital_id', 'be.examination_name', 'pbe.examination_date','pbei.test_readings','be.default_normal_values','be.is_parent','be.id','be1.examination_name AS parent_examination_name','be.units','pbe.doctor_id','pbe.fee_receipt_id');
            $bloodExaminations = $latestBloodExamQuery->get();


            //dd($latestComplaintsQuery->toSql());

            //dd($latestComplaints);


            $latestUrineExamQuery = DB::table('patient_urine_examination as pue');
            $latestUrineExamQuery->join('patient_urine_examination_item as puei', 'puei.patient_urine_examination_id', '=', 'pue.id');
            $latestUrineExamQuery->join('urine_examination as ue', 'ue.id', '=', 'puei.urine_examination_id');
            $latestUrineExamQuery->join('urine_examination as ue1', 'ue1.id', '=', 'ue.parent_id');
            $latestUrineExamQuery->where('pue.examination_date','=',$date);



            $latestUrineExamQuery->where('pue.patient_id', '=', $patientId);
            $latestUrineExamQuery->where('puei.is_value_set', '=', 1);
            $latestUrineExamQuery->select('pue.id as examinationId', 'puei.id as examinationItemId',
                'pue.patient_id', 'ue.examination_name', 'pue.examination_date','puei.test_readings','ue.normal_default_values','ue.is_parent','ue.id','ue1.examination_name as parent_examination_name','pue.doctor_id','pue.fee_receipt_id');
            $latestUrineExaminations = $latestUrineExamQuery->get();


            $latestMotionExamQuery = DB::table('patient_motion_examination as pme');
            $latestMotionExamQuery->join('patient_motion_examination_item as pmei', 'pmei.patient_motion_examination_id', '=', 'pme.id');
            $latestMotionExamQuery->join('motion_examination as me', 'me.id', '=', 'pmei.motion_examination_id');
            $latestMotionExamQuery->where('pme.examination_date','=',$date);

            $latestMotionExamQuery->where('pme.patient_id', '=', $patientId);
            $latestMotionExamQuery->where('pmei.is_value_set', '=', 1);

            $latestMotionExamQuery->select('pme.id as examinationId', 'pmei.id as examinationItemId',
                'pme.patient_id', 'me.examination_name', 'pme.examination_date','pmei.test_readings','pme.doctor_id','me.id','pme.fee_receipt_id');
            $latestMotionExaminations = $latestMotionExamQuery->get();


            $patientQuery = DB::table('patient as p')->select('p.id', 'p.patient_id', 'p.name', 'p.email', 'p.pid',
                'p.telephone', 'p.relationship', 'p.patient_spouse_name as spouseName', 'p.address','p.gender','p.age');
            $patientQuery->where('p.patient_id', '=', $patientId);
            $patientDetails = $patientQuery->first();

            $hospitalQuery = DB::table('hospital as h')->select('h.id', 'h.hospital_id', 'h.hospital_name', 'h.address', 'c.city_name',
                'co.name');
            $hospitalQuery->join('cities as c', 'c.id', '=', 'h.city');
            $hospitalQuery->join('countries as co', 'co.id', '=', 'h.country');
            $hospitalQuery->where('h.hospital_id', '=', $hospitalId);
            $hospitalDetails = $hospitalQuery->first();

            $D=count($bloodExaminations)>0?$bloodExaminations[0]->doctor_id:null;
            $U=count($latestUrineExaminations)>0?$latestUrineExaminations[0]->doctor_id:null;
            $M=count($latestMotionExaminations)>0?$latestMotionExaminations[0]->doctor_id:null;


            $DID=count($bloodExaminations)>0?$bloodExaminations[0]->fee_receipt_id:null;
            $UID=count($latestUrineExaminations)>0?$latestUrineExaminations[0]->fee_receipt_id:null;
            $MID=count($latestMotionExaminations)>0?$latestMotionExaminations[0]->fee_receipt_id:null;

            $receiptID=null;
            if($DID!=null)$receiptID=$DID;
            if($UID!=null)$receiptID=$UID;
            if($MID!=null)$receiptID=$MID;


            $doctor_id=null;
            if($D!=null)$doctor_id=$D;
            if($U!=null)$doctor_id=$U;
            if($M!=null)$doctor_id=$M;
            if($doctor_id!=null){
                $doctorinfo=Doctor::find($doctor_id);

                //  dd($doctorinfo);
            }
            $receiptStatus="notpaid";
            if($receiptID!=null){
                $LabDetails=LabFeeReceipt::find($receiptID);

                $receiptStatus=(($LabDetails->total_fees-$LabDetails->paid_amount)==0)?"paid":"notpaid";


                //  dd($doctorinfo);
            }

            // dd($doctorinfo);

            $examinationDates['recieptId'] = $receiptID;
            $examinationDates['recieptStatus'] = $receiptStatus;
            $examinationDates['patientDetails'] = $patientDetails;
            $examinationDates['recentBloodTests'] = $bloodExaminations;
            $examinationDates['hospitalDetails'] = $hospitalDetails;
            $examinationDates['recentUrineExaminations'] = $latestUrineExaminations;
            $examinationDates['recentMotionExaminations'] = $latestMotionExaminations;
            $examinationDates['doctorDetails']=$doctorinfo;



            //dd($examinationDates);

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR, $exc);
        }

        //dd($patientLabTests);
        return $examinationDates;
    }

    /**
     * Get lab receipt details for the patient
     * @param $hid,$pid,$rid,$newpaidamount
     * @throws $hospitalException
     * @return String | null
     * @author Ramana
     */

    function updateLabPatientFee($hid,$pid,$rid,$newpaidamount,$paidamount,$paymenttype){
        try
        {

            $updateValues = array('lfr.paid_amount' => $newpaidamount);
            $query = DB::table('lab_fee_receipt as lfr')->where('lfr.id', '=', $rid);
            $query->where('lfr.patient_id','=',$pid);
            $query->where('lfr.hospital_id','=',$hid);
            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
            $status=$query->update($updateValues);



            $patientPaymentHistory = new PatientPaymentHistory();

            $patientPaymentHistory->patient_id = $pid;
            $patientPaymentHistory->receipt_id=$rid;
            $patientPaymentHistory->hospital_id = $hid;
            //$patientPaymentHistory->doctor_id =
            // $patientPaymentHistory->total_fees = $labReceiptsVM->getTotalFees();
            $patientPaymentHistory->paid_amount = $paidamount;
            $patientPaymentHistory->payment_type = $paymenttype;


            $patientPaymentHistory->created_by = "Admin";
            $patientPaymentHistory->modified_by = "Admin";
            $patientPaymentHistory->created_at = date("Y-m-d H:i:s");
            $patientPaymentHistory->updated_at =date("Y-m-d H:i:s");

            $patientPaymentHistory->save();

            return $status;

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $exc);
        }

    }


    /**
     * Get lab receipt details for the patient
     * @param $patientId, $hospitalId, $feeReceiptId
     * @throws $hospitalException
     * @return array | null
     * @author RAMANA
     */

    public function getPaymentHistory($hospitalId, $patientId, $feeReceiptId)
    {
        $paymentHistory = null;

        try
        {
            $patientUser = User::find($patientId);

            if(is_null($patientUser))
            {
                throw new UserNotFoundException(null, ErrorEnum::PATIENT_USER_NOT_FOUND, null);
            }
            //DB::connection()->enableQueryLog();

            $paymentHistoryQuery = DB::table('patient_payment_history as pph');
            //$bloodExamQuery->join('blood_examination as be', 'be.id', '=', 'pbe.blood_examination_id');
            // $bloodExamQuery->join('pbei.patient_motion_examination_id', '=', 'be.id')

            $paymentHistoryQuery->where('pph.patient_id', '=', $patientId);
            $paymentHistoryQuery->where('pph.hospital_id', '=', $hospitalId);
            $paymentHistoryQuery->where('pph.receipt_id', '=', $feeReceiptId);
            $paymentHistoryQuery->select('pph.payment_type','pph.paid_amount','pph.created_at');

            // dd($bloodExamQuery->toSql());
            $paymentHistory = $paymentHistoryQuery->get();


            // $labReceiptDetails['patientDetails'] = $patientDetails;

            //dd($patientLabTests);

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            //dd($userExc);
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_LAB_RECEIPT_DETAILS_ERROR, $exc);
        }

        return $paymentHistory;
    }

    /**
     * Get lab receipt details for the patient
     * @param $labReceiptsVM,$receipt_id
     * @throws $hospitalException
     * @return array | null
     * @author RAMANA
     */

    private function saveLabFeeReceiptHistory(PatientLabReceiptViewModel $labReceiptsVM,$receipt_id)
    {
        $patientPaymentHistory = new PatientPaymentHistory();

        $patientPaymentHistory->patient_id = $labReceiptsVM->getPatientId();
        $patientPaymentHistory->receipt_id = $receipt_id;
        $patientPaymentHistory->hospital_id = $labReceiptsVM->getHospitalId();
        $patientPaymentHistory->doctor_id = $labReceiptsVM->getDoctorId();
        // $patientPaymentHistory->total_fees = $labReceiptsVM->getTotalFees();
        $patientPaymentHistory->paid_amount = $labReceiptsVM->getPaidAmount();
        $patientPaymentHistory->payment_type = $labReceiptsVM->getPaymentType();

        $patientPaymentHistory->created_by = $labReceiptsVM->getCreatedBy();
        $patientPaymentHistory->modified_by = $labReceiptsVM->getUpdatedBy();
        $patientPaymentHistory->created_at = $labReceiptsVM->getCreatedAt();
        $patientPaymentHistory->updated_at = $labReceiptsVM->getUpdatedAt();

        $patientPaymentHistory->save();

        return $patientPaymentHistory;

    }
//RAMANA NEW
    function updatePatientFeeStatus($hid, $did, $pid, $rid)
    {
      //  $updateValues=null;
       // $query=null;

        try {
          //   dd( date("Y-m-d H:i:s"));
            $updateValues = array('p.payment_status' => 1,);
            $query = DB::table('patient as p')->where('p.patient_id', '=', $pid);
            $updateValues1 = array('dp.updated_at' => date("Y-m-d H:i:s"));
            $query1 = DB::table('doctor_appointment as dp')->where('dp.patient_id', '=', $pid);

            $query1->where('dp.patient_id', '=', $pid);
            $query1->update($updateValues1);


            // $query->where('dp.hospital_id', '=', $hid);
           // $query->where('dp.doctor_id', '=', $did);
            //$query->update(array('pbe.fees' => $bloodTest['fees'], 'pbe.is_fees_paid' => 1));
          // dd($query);

//,'doctor_appointment.updated_at' => date("Y-m-d H:i:s")
            $status = $query->update($updateValues);
//dd($pid.$status);

/*
            $patientPaymentHistory = new PatientPaymentHistory();

            $patientPaymentHistory->patient_id = $pid;
            $patientPaymentHistory->receipt_id = $rid;
            $patientPaymentHistory->hospital_id = $hid;
            //$patientPaymentHistory->doctor_id =
            // $patientPaymentHistory->total_fees = $labReceiptsVM->getTotalFees();
            $patientPaymentHistory->paid_amount = $paidamount;
            $patientPaymentHistory->payment_type = $paymenttype;


            $patientPaymentHistory->created_by = "Admin";
            $patientPaymentHistory->modified_by = "Admin";
            $patientPaymentHistory->created_at = date("Y-m-d H:i:s");
            $patientPaymentHistory->updated_at = date("Y-m-d H:i:s");

            $patientPaymentHistory->save();
*/
            return $status;


        } catch (QueryException $queryExc) {
            //dd($queryExc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $queryExc);
        } catch (UserNotFoundException $userExc) {
            throw new HospitalException(null, $userExc->getUserErrorCode(), $userExc);
        } catch (Exception $exc) {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::FEE_RECEIPT_LIST_ERROR, $exc);
        }

    }

    //ramana end 12-01-2018

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
            $query = DB::table('patient_document as pd')->join('patient_document_items as pdi', 'pdi.patient_document_id', '=', 'pd.id');
            $query->where('pd.patient_id', '=', $patientId);
            $query->select('pd.id', 'pd.patient_id', 'pd.document_upload_date', 'pdi.id as document_id',
                'pdi.test_category_name', 'pdi.document_filename');

            $reports = $query->get();
        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
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
            $query = DB::table('patient_document_items as pdi')->where('pdi.id', '=', $documentId);
            $query->select('pdi.id', 'pdi.document_path');

            $document = $query->first();
            //dd($document);
        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_DOWNLOAD_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_DOWNLOAD_ERROR, $exc);
        }

        return $document;
    }

    /**
     * Gets Latest Patient token_Id based on doctor and hospital
     * @param $hospitalId,$doctorId
     * @throws $hospitalException
     * @return count
     * @author Prasanth
     */

    public function getTokenIdByHospitalIdandDoctorId($hospitalId,$doctorId){
        $patientTokenId = null;

        try
        {
            $patientTokenQuery = DB::table('doctor_appointment as dp');
            $patientTokenQuery->where('dp.hospital_id', '=', $hospitalId)->where('dp.doctor_id', '=', $doctorId)->where('dp.appointment_date','=',Carbon::now()->format('Y-m-d'));
            $patientTokenQuery->select(DB::raw('count(token_id) as token_count'))->get();
            $patientTokenId=$patientTokenQuery->first();
            //dd($patientTokenQuery->toSql());
          //  dd($patientTokenQuery->toSql().Carbon::now()->format('Y-m-d'));

            $patientTokenId=intval($patientTokenId->token_count)+1;


        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $exc);
        }
//dd($patientTokenId);
        return $patientTokenId;

    }


    /**
     * To display PatientAppointmentAdmitCard in FrontDesk
     * @param $patientId,$Id
     * @throws $hospitalException
     * @return Array|null
     * @author Prasanth
     */

    public function getPatientAppointmentLabel($patientId,$Id){
        $doctorappointments = null;

        try
        {
            //  dd($patientId.'--'.$Id);
            $query = DB::table('doctor_appointment as dp')->join('doctor as d', 'd.doctor_id', '=', 'dp.doctor_id');
            $query->join('hospital as h', 'h.hospital_id', '=', 'dp.hospital_id');
            $query->join('patient as p', 'p.patient_id', '=', 'dp.patient_id');
            $query->where('dp.patient_id', '=', $patientId);
            $query->where('dp.id', '=', $Id);
            $query->select('d.name', 'd.specialty', 'dp.appointment_date', 'dp.appointment_time as time','dp.token_id',
                'dp.brief_history', 'h.hospital_name', 'h.email', 'h.address as hsaddress', 'h.telephone','p.name as patient_name','p.patient_id as patient_id','p.telephone as telephone','p.gender','p.address')->get();

            $doctorappointments = $query->first();

            // dd($doctorappointments);

        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            throw new HospitalException(null, ErrorEnum::PATIENT_REPORTS_LIST_ERROR, $exc);
        }

        return $doctorappointments;

    }


}