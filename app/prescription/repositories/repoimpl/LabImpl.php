<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/29/2016
 * Time: 10:07 PM
 */

namespace App\prescription\repositories\repoimpl;

use App\Http\ViewModels\LabViewModel;
use App\Http\ViewModels\PatientLabDocumentsViewModel;
use App\prescription\model\entities\Lab;
use App\prescription\model\entities\PatientDocumentItems;
use App\prescription\model\entities\PatientDocuments;
use App\prescription\repositories\repointerface\LabInterface;
use App\prescription\utilities\Exception\HospitalException;
use App\prescription\utilities\Exception\LabException;

use App\prescription\utilities\Exception\UserNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\User;

use App\prescription\utilities\ErrorEnum\ErrorEnum;
use Exception;

use Storage;
use File;
use Crypt;

class LabImpl implements LabInterface
{
    /**
     * Get the profile of the lab
     * @param $labId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */


    public function getProfile($labId)
    {
        $labProfile = null;

        try
        {
            $query = DB::table('lab as l')->join('cities as c', 'c.id', '=', 'l.city');
            $query->join('countries as co', 'co.id', '=', 'l.country');
            $query->where('l.lab_id', '=', $labId);
            $query->select('l.id', 'l.lab_id', 'l.name as lab_name', 'l.address', 'c.id as city_id', 'c.city_name',
                        'co.id as country_id', 'co.name as country', 'l.pincode', 'l.lid', 'l.telephone', 'l.email');

            //dd($query->toSql());
            $labProfile = $query->get();
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_PROFILE_VIEW_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_PROFILE_VIEW_ERROR, $exc);
        }

        return $labProfile;
    }

    /**
     * Get the list of patients for the selected lab
     * @param $labId, $hospitalId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getPatientListForLab($labId, $hospitalId)
    {
        $patients = null;

        try
        {
            /*$query = DB::table('patient as p')->join('patient_prescription as pp', 'pp.patient_id', '=', 'p.patient_id');
            $query->join('hospital_pharmacy as hp', 'hp.hospital_id', '=', 'pp.hospital_id');
            $query->where('hp.hospital_id', '=', $hospitalId);
            $query->where('hp.pharmacy_id', '=', $pharmacyId);
            $query->distinct()->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone','p.age', 'p.gender');*/

            $query = DB::table('patient as p')->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->join('hospital_lab as hl', 'hl.hospital_id', '=', 'pl.hospital_id');
            $query->where('hl.hospital_id', '=', $hospitalId);
            $query->where('hl.lab_id', '=', $labId);
            /*$query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone','p.age', 'p.gender',
                'pl.unique_id as labTestCode','pl.labtest_date');*/
            $query->distinct()->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone','p.age', 'p.gender');
            //$query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'p.telephone','p.age', 'p.gender');

            //dd($query->toSql());
            $patients = $query->get();
            //dd($patients);
        }
        catch(QueryException $queryExc)
        {
            //dd($queryExc);
            throw new LabException(null, ErrorEnum::LAB_PATIENT_LIST_ERROR, $queryExc);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get the list of lab tests for the selected lab
     * @param $labId, $hospitalId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getTestsForLab($labId, $hospitalId)
    {
        $labTests = null;

        try
        {

            $query = DB::table('patient as p')->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->join('hospital_lab as hl', 'hl.hospital_id', '=', 'pl.hospital_id');
            $query->where('hl.hospital_id', '=', $hospitalId);
            $query->where('hl.lab_id', '=', $labId);
            $query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'pl.id as labtest_id', 'pl.unique_id as plid', 'pl.labtest_date');

            //dd($query->toSql());
            $labTests = $query->get();
            //dd($prescriptions);
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Get lab tests by LID
     * @param $lid
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsByLid($lid)
    {
        $labTests = null;

        try
        {
            $query = DB::table('patient as p')->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->where('pl.unique_id', '=', $lid);
            $query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'pl.id as labtest_id',
                'pl.unique_id as plid', 'pl.labtest_date');

            //dd($query->toSql());
            $labTests = $query->get();
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_LIST_LID_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_LIST_LID_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Edit Lab Details
     * @param $labVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function editLab(LabViewModel $labVM)
    {
        $status = true;
        $lab = null;

        try
        {
            $user = User::find($labVM->getLabId());

            if(!is_null($user))
            {
                $lab = Lab::where('lab_id', '=', $labVM->getLabId())->first();
                //dd($lab);

                if(!is_null($lab))
                {
                    $lab->name = $labVM->getName();
                    $lab->address = $labVM->getAddress();
                    $lab->city = $labVM->getCity();
                    $lab->country = $labVM->getCountry();
                    $lab->pincode = $labVM->getPincode();
                    //$lab->lid = "LA".$labVM->getLabId().time();
                    $lab->lid = 'LID'.crc32(uniqid(rand()));
                    $lab->telephone = $labVM->getTelephone();
                    //$lab->email = $labVM->getEmail();
                    //$lab->lab_photo = $labVM->getLabPhoto();
                    $lab->created_by = $labVM->getCreatedBy();
                    $lab->updated_by = $labVM->getUpdatedBy();
                    $lab->created_at = $labVM->getCreatedAt();
                    $lab->updated_at = $labVM->getUpdatedAt();

                    $user->lab()->save($lab);
                }


            }
        }
        catch(QueryException $queryEx)
        {
            //dd($queryEx);
            $status = false;
            throw new LabException(null, ErrorEnum::LAB_SAVE_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $status = false;
            throw new LabException(null, ErrorEnum::LAB_SAVE_ERROR, $exc);
        }

        return $status;
    }


    /**
     * Get the list of lab tests for the selected lab
     * @param $patientId
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function getTestsForLabForPatient($patientId)
    {
        $labTests = null;

        try
        {

            $query = DB::table('patient as p')->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->join('hospital_lab as hl', 'hl.hospital_id', '=', 'pl.hospital_id');
            $query->where('p.patient_id', '=', $patientId);
            $query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'pl.id as labtest_id', 'pl.unique_id as plid', 'pl.labtest_date');

            $labTests = $query->get();
            //dd($prescriptions);
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }


    public function getTestsForDoctor($doctorId, $hospitalId)
    {
        $labTests = null;

        try
        {

            $query = DB::table('patient as p')->join('patient_labtest as pl', 'pl.patient_id', '=', 'p.patient_id');
            $query->join('hospital_doctor as hl', 'hl.hospital_id', '=', 'pl.hospital_id');
            $query->where('hl.hospital_id', '=', $hospitalId);
            $query->where('hl.doctor_id', '=', $doctorId);
            $query->select('p.id', 'p.patient_id', 'p.name', 'p.pid', 'pl.id as labtest_id', 'pl.unique_id as plid', 'pl.labtest_date');

            $labTests = $query->get();
            //dd($labTests);
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Upload patient lab test documents
     * @param $labDocumentsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM)
    {
        //dd($labDocumentsVM);
        $labDocuments = null;
        $status = true;
        //dd('Inside lab impl');

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
                    $uploadCategory = $document['test_category_name'];
                    $uploadName = $document['document_name'];
                    $uploadPath = $document['document_upload_path'];
                    $documentContents = File::get($uploadPath);

                    $filename = $uploadPath->getClientOriginalName();
                    $extension = $uploadPath->getClientOriginalExtension();

                    $randomName = $this->generateUniqueFileName();

                    $documentPath = 'medical_document/' . 'patient_document_' . $patientId . '/' . 'patient_document_' . $patientId . '_' . $randomName . '.' . $extension;
                    //Storage::disk('local')->put($documentPath, Crypt::encrypt(file_get_contents($documentContents)));
                    Storage::disk('local')->put($documentPath, Crypt::encrypt(file_get_contents($uploadPath)));

                    $labDocumentItems = new PatientDocumentItems();

                    $labDocumentItems->test_category_name = $uploadCategory;
                    $labDocumentItems->document_name = $uploadName;
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

                }
            }
        }
        catch(QueryException $queryEx)
        {
            dd($queryEx);
            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $queryEx);
        }
        catch(UserNotFoundException $userExc)
        {
            dd($userExc);
            $status = false;
            throw new LabException(null, $userExc->getUserErrorCode(), $userExc);
        }
        catch(Exception $exc)
        {
            dd($exc);
            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $exc);
        }

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

    /**
     * Get patient documents
     * @param $patientId
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function getPatientDocuments($patientId)
    {
        $labReports = null;

        try
        {

            $query = DB::table('patient_document as pd')->join('patient_document_items as pdi', 'pdi.patient_document_id', '=', 'pd.id');
            //$query->join('hospital_doctor as hl', 'hl.hospital_id', '=', 'pl.hospital_id');
            $query->where('pd.patient_id', '=', $patientId);
            $query->select('pd.id', 'pd.patient_id', 'pd.document_upload_date', 'pdi.id as document_item_id',
                'pdi.test_category_name', 'pdi.document_name', 'pdi.document_path');

            $labReports = $query->get();
            //dd($labTests);
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labReports;
    }

    /**
     * Download document item
     * @param $documentItemId
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function downloadPatientDocument($documentItemId)
    {
        $documentItem = null;

        try
        {
            $query = DB::table('patient_document_items as pd1');
            $query->where('pdi.id', '=', $documentItemId);
            $query->select('pdi.id',
                'pdi.test_category_name', 'pdi.document_name', 'pdi.document_path', 'pdi.document_filename', 'pdi.document_extension');

            $documentItem = $query->get();
        }
        catch(QueryException $queryEx)
        {
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENT_DOWNLOAD_ERROR, $queryEx);
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENT_DOWNLOAD_ERROR, $exc);
        }

        return $documentItem;
    }
}