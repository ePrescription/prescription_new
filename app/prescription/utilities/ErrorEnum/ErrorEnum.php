<?php
namespace App\prescription\utilities\ErrorEnum;

use MyCLabs\Enum\Enum;

class ErrorEnum extends Enum{

    const SUCCESS = 1;
    const FAILURE = 0;
    const USER_NOT_EXIST = 2;
    const VALIDATION_ERRORS = 3;
    const USER_NOT_FOUND = 4;
    const HOSPITAL_USER_NOT_FOUND = 5;
    const PATIENT_USER_NOT_FOUND = 6;
    const UNKNOWN_ERROR = 100;

    //const USER_NOT_FOUND_ERROR = 101;
    
    //Doctor Error code 101 - 150

    const HOSPITAL_LIST_ERROR = 101;
    const HOSPITAL_LIST_SUCCESS = 102;
    const DOCTOR_LOGIN_FAILURE = 103;
    const HOSPITAL_ID_ERROR = 104;

    //Appointments
    const APPOINTMENT_LIST_ERROR = 105;
    const APPOINTMENT_LIST_SUCCESS = 106;
    const HOSPITAL_DOCTOR_LIST_ERROR = 107;
    const HOSPITAL_DOCTOR_LIST_SUCCESS = 108;
    const HOSPITAL_NO_DOCTORS_FOUND = 109;

    //Patient List
    const PATIENT_LIST_ERROR = 110;
    const PATIENT_LIST_SUCCESS = 111;
    const PATIENT_DETAILS_ERROR = 112;
    const PATIENT_DETAILS_SUCCESS = 113;
    const PATIENT_PROFILE_ERROR = 114;
    const PATIENT_PROFILE_SUCCESS = 115;
    const PATIENT_PROFILE_SAVE_ERROR = 116;
    const PATIENT_PROFILE_SAVE_SUCCESS = 117;
    const PATIENT_NEW_APPOINTMENT_ERROR = 118;
    const PATIENT_NEW_APPOINTMENT_SUCCESS = 119;
    const NEW_PATIENT_ERROR = 120;


    //Prescription List

    const PRESCRIPTION_LIST_ERROR = 121;
    const PRESCRIPTION_LIST_SUCCESS = 122;
    const PRESCRIPTION_DETAILS_ERROR = 123;
    const PRESCRIPTION_DETAILS_SUCCESS = 124;
    const PRESCRIPTION_DETAILS_SAVE_ERROR = 125;
    const PRESCRIPTION_DETAILS_SAVE_SUCCESS = 126;

    const NO_PATIENT_LIST_FOUND = 127;
    const NO_HOSPITAL_LIST_FOUND = 128;
    const NO_PATIENT_PROFILE_FOUND = 129;
    const NO_APPOINTMENT_LIST_FOUND = 130;

    //Drug Brands
    const BRAND_LIST_ERROR = 131;
    const BRAND_LIST_SUCCESS = 132;
    const NO_BRAND_LIST_FOUND = 133;
    const FORMULATION_LIST_ERROR = 134;
    const FORMULATION_LIST_SUCCESS = 135;
    const NO_FORMULATION_LIST_FOUND = 136;
    const NO_HOSPITALS_FOUND = 137;



    //Lab Tests List
    const LAB_LIST_ERROR = 141;
    const LAB_LIST_SUCCESS = 142;
    const LAB_DETAILS_ERROR = 143;
    const LAB_DETAILS_SUCCESS = 144;
    const NO_LABTEST_FOUND = 145;
    const LABTESTS_DETAILS_SAVE_ERROR = 146;
    const LABTESTS_DETAILS_SAVE_SUCCESS = 147;
    const NO_LAB_DETAILS_FOUND = 148;

    //User Login 160 - 170

    const USER_LOGIN_SUCCESS = 160;

    //Pharmacy Profile constants 171 to 190

    const PHARMACY_PROFILE_VIEW_ERROR = 171;
    const PHARMACY_PATIENT_LIST_ERROR = 172;
    const PRESCRIPTION_LIST_PRID_ERROR = 173;
    const PHARMACY_SAVE_ERROR = 174;
    const PHARMACY_SAVE_SUCCESS = 175;

    //Lab Profile constants 191 to 210

    const LAB_PROFILE_VIEW_ERROR = 191;
    const LAB_PATIENT_LIST_ERROR = 192;
    const LAB_TESTS_LIST_ERROR = 193;
    const LAB_LIST_LID_ERROR = 194;
    const LAB_SAVE_ERROR = 195;
    const LAB_SAVE_SUCCESS = 196;

    //Helper constants 211 to 220
    const CITIES_LIST_ERROR = 211;
    const ID_GENERATION_ERROR = 212;
    const ID_GENERATION_SUCCESS = 213;

    const DOCTOR_DETAILS_ERROR = 221;
    const DOCTOR_DETAILS_SUCCESS = 222;
    const NO_DOCTOR_DETAILS_FOUND = 223;
    const DOCTOR_NAME_SUCCESS = 224;

    const DOCTOR_TWO_DAY_APPOINTMENTS_ERROR = 225;
    const DOCTOR_TWO_DAY_APPOINTMENTS_SUCCESS = 226;
    const DOCTOR_NO_TWO_DAY_APPOINTMENTS_FOUND = 227;


    //Hospital Profile constants 300 to 399

    const HOSPITAL_PROFILE_VIEW_ERROR = 300;
    const HOSPITAL_PATIENT_LIST_ERROR = 301;
    const HOSPITAL_SAVE_ERROR = 302;
    const HOSPITAL_SAVE_SUCCESS = 303;

    const PATIENT_APPOINTMENT_LIST_ERROR = 304;
    const PATIENT_APPOINTMENT_COUNT_ERROR = 305;
    const PATIENT_APPOINTMENT_COUNT_SUCCESS = 306;
    const PATIENT_APPOINTMENT_LIST_BY_CATEGORY_ERROR = 307;
    const PATIENT_APPOINTMENT_LIST_BY_CATEGORY_SUCCESS = 308;
    const NO_PATIENT_LIST_BY_CATEGORY = 309;
    const PATIENT_APPOINTMENT_DATES_ERROR = 310;
    const PATIENT_APPOINTMENT_DATES_SUCCESS = 311;
    const NO_PATIENT_APPOINTMENT_DATES_FOUND = 312;
    const NO_PATIENT_DASHBOARD_DETAILS_FOUND = 313;
    const PATIENT_APPOINT_DETAILS_ERROR = 314;
    const PATIENT_APPOINTMENT_LIST_SUCCESS = 315;
    const NO_PATIENT_APPOINTMENT_FOUND = 316;

    const ASK_QUESTION_LIST_ERROR = 317;
    const ASK_QUESTION_LIST_SUCCESS = 318;
    const SECOND_OPINION_LIST_ERROR = 319;
    const SECOND_OPINION_LIST_SUCCESS = 320;
    const PHARMACY_PICKUP_LIST_ERROR = 321;
    const PHARMACY_PICKUP_LIST_SUCCESS = 322;

    const NO_PATIENT_DETAILS_FOUND = 400;

    const NO_PRESCRIPTION_LIST_FOUND = 401;
    const NO_PRESCRIPTION_DETAILS_FOUND = 402;

    const PATIENT_PHOTO_UPLOAD_FAILURE = 403;
    const PATIENT_PHOTO_UPLOAD_SUCCESS = 404;

    //Fee receipt codes 500 - 550
    const FEE_RECEIPT_LIST_ERROR = 500;
    const FEE_RECEIPT_LIST_SUCCESS = 501;
    const FEE_RECEIPT_DETAILS_ERROR = 502;
    const FEE_RECEIPT_DETAILS_SUCCESS = 503;
    const NO_FEE_RECEIPT_DETAILS_FOUND = 504;
    const FEE_RECEIPT_SAVE_ERROR = 505;
    const FEE_RECEIPT_SAVE_SUCCESS = 506;
    const NO_FEE_RECEIPT_LIST = 507;
    const FEERECEIPT_SMS_SUCCESS = 508;
    const FEERECEIPT_SMS_ERROR = 509;
    const FEERECEIPT_EMAIL_SUCCESS = 510;
    const FEERECEIPT_EMAIL_ERROR = 511;

    //SMS and Email codes

    const PRESCRIPTION_SMS_SUCCESS = 1001;
    const PRESCRIPTION_SMS_ERROR = 1002;

    const LABTEST_SMS_SUCCESS = 1003;
    const LABTEST_SMS_ERROR = 1004;

    //Symptoms error codes 701 to 800

    const MAIN_SYMPTOMS_LIST_ERROR = 701;
    const MAIN_SYMPTOMS_LIST_SUCCESS = 702;
    const NO_MAIN_SYMPTOMS_LIST_FOUND = 703;

    const SUB_SYMPTOMS_LIST_ERROR = 704;
    const SUB_SYMPTOMS_LIST_SUCCESS = 705;
    const NO_SUB_SYMPTOMS_LIST_FOUND = 706;

    const SYMPTOMS_LIST_ERROR = 707;
    const SYMPTOMS_LIST_SUCCESS = 708;
    const NO_SYMPTOMS_LIST_FOUND = 709;

    const PERSONAL_HISTORY_ERROR = 710;
    const PERSONAL_HISTORY_SUCCESS = 711;
    const NO_PERSONAL_HISTORY_FOUND = 712;

    const PATIENT_PAST_ILLNESS_DETAILS_ERROR = 713;
    const PATIENT_PAST_ILLNESS_DETAILS_SUCCESS = 714;
    const NO_PATIENT_PAST_ILLNESS_DETAILS_FOUND = 715;

    const PATIENT_FAMILY_ILLNESS_DETAILS_ERROR = 716;
    const PATIENT_FAMILY_ILLNESS_DETAILS_SUCCESS = 717;
    const NO_PATIENT_FAMILY_ILLNESS_DETAILS_FOUND = 718;

    const PATIENT_PERSONAL_HISTORY_SAVE_ERROR = 719;
    const PATIENT_PERSONAL_HISTORY_SAVE_SUCCESS = 720;

    const PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR = 721;
    const PATIENT_GENERAL_EXAMINATION_DETAILS_SUCCESS = 722;
    const NO_PATIENT_GENERAL_EXAMINATION_DETAILS_FOUND = 723;

    const PATIENT_GENERAL_EXAMINATION_SAVE_ERROR = 724;
    const PATIENT_GENERAL_EXAMINATION_SAVE_SUCCESS = 725;

    const PATIENT_PAST_ILLNESS_SAVE_ERROR = 726;
    const PATIENT_PAST_ILLNESS_SAVE_SUCCESS = 727;

    const PATIENT_FAMILY_ILLNESS_SAVE_ERROR = 728;
    const PATIENT_FAMILY_ILLNESS_SAVE_SUCCESS = 729;

    const PATIENT_EXAMINATION_DATES_ERROR = 730;
    const PATIENT_EXAMINATION_DATES_SUCCESS = 731;
    const NO_PATIENT_EXAMINATION_DATES_FOUND = 732;

    const PATIENT_PREGNANCY_DETAILS_ERROR = 733;
    const PATIENT_PREGNANCY_DETAILS_SUCCESS = 734;
    const NO_PATIENT_PREGNANCY_DETAILS_FOUND = 735;

    const PATIENT_PREGNANCY_DETAILS_SAVE_ERROR = 736;
    const PATIENT_PREGNANCY_DETAILS_SAVE_SUCCESS = 737;

    const PATIENT_SCAN_DETAILS_ERROR = 738;
    const PATIENT_SCAN_DETAILS_SUCCESS = 739;
    const NO_PATIENT_SCAN_DETAILS_FOUND = 740;

    const PATIENT_SCAN_SAVE_ERROR = 741;
    const PATIENT_SCAN_SAVE_SUCCESS = 742;

    const PATIENT_SYMPTOM_DETAILS_ERROR = 743;
    const PATIENT_SYMPTOM_DETAILS_SUCCESS = 744;
    const NO_PATIENT_SYMPTOM_DETAILS_FOUND = 745;

    const PATIENT_SYMPTOM_SAVE_ERROR = 746;
    const PATIENT_SYMPTOM_SAVE_SUCCESS = 747;

    const PATIENT_DRUG_HISTORY_ERROR = 748;
    const PATIENT_DRUG_HISTORY_SUCCESS = 749;
    const NO_PATIENT_DRUG_HISTORY_FOUND = 750;

    const PATIENT_DRUG_HISTORY_SAVE_ERROR = 751;
    const PATIENT_DRUG_HISTORY_SAVE_SUCCESS = 752;

    const FAMILY_ILLNESS_ERROR = 753;
    const FAMILY_ILLNESS_SUCCESS = 754;
    const NO_FAMILY_ILLNESS_LIST_FOUND = 755;

    const PAST_ILLNESS_ERROR = 756;
    const PAST_ILLNESS_SUCCESS = 757;
    const NO_PAST_ILLNESS_LIST_FOUND = 758;

    const GENERAL_EXAMINATIONS_ERROR = 759;
    const GENERAL_EXAMINATIONS_SUCCESS = 760;
    const NO_GENERAL_EXAMINATIONS_LIST_FOUND = 761;

    const PERSONAL_HISTORY_LIST_ERROR = 762;
    const PERSONAL_HISTORY_LIST_SUCCESS = 763;
    const NO_PERSONAL_HISTORY_LIST_FOUND = 764;

    const PREGNANCY_LIST_ERROR = 765;
    const PREGNANCY_LIST_SUCCESS = 766;
    const NO_PREGNANCY_LIST_FOUND = 767;

    const SCAN_LIST_ERROR = 768;
    const SCAN_LIST_SUCCESS = 769;
    const NO_SCAN_LIST_FOUND = 770;

    const PATIENT_URINE_DETAILS_ERROR = 771;
    const PATIENT_URINE_DETAILS_SUCCESS = 772;
    const NO_PATIENT_URINE_DETAILS_FOUND = 773;

    const PATIENT_MOTION_DETAILS_ERROR = 774;
    const PATIENT_MOTION_DETAILS_SUCCESS = 775;
    const NO_PATIENT_MOTION_DETAILS_FOUND = 776;

    const PATIENT_URINE_DETAILS_SAVE_ERROR = 777;
    const PATIENT_URINE_DETAILS_SAVE_SUCCESS = 778;

    const PATIENT_MOTION_DETAILS_SAVE_ERROR = 779;
    const PATIENT_MOTION_DETAILS_SAVE_SUCCESS = 780;

    const PATIENT_BLOOD_DETAILS_ERROR = 781;
    const PATIENT_BLOOD_DETAILS_SUCCESS = 782;
    const NO_PATIENT_BLOOD_DETAILS_FOUND = 783;

    const PATIENT_BLOOD_DETAILS_SAVE_ERROR = 784;
    const PATIENT_BLOOD_DETAILS_SAVE_SUCCESS = 785;

    const PATIENT_ULTRASOUND_DETAILS_ERROR = 786;
    const PATIENT_ULTRASOUND_SUCCESS = 787;
    const NO_PATIENT_ULTRASOUND_DETAILS_FOUND = 788;

    const PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR = 789;
    const PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS = 790;

    const PATIENT_LABTEST_FEES_STATUS_ERROR = 791;
    const PATIENT_LABTEST_FEES_STATUS_SUCCESS = 792;
    const NO_PATIENT_LABTEST_FEES_FOUND = 793;

    const DENTAL_LIST_ERROR = 794;
    const DENTAL_LIST_SUCCESS = 795;
    const NO_DENTAL_LIST_FOUND = 796;

    const PATIENT_DENTAL_TESTS_SAVE_ERROR = 797;
    const PATIENT_DENTAL_TESTS_SAVE_SUCCESS = 798;

    const PATIENT_DENTAL_TESTS_DETAILS_ERROR = 799;
    const PATIENT_DENTAL_TESTS_DETAILS_SUCCESS = 800;
    const NO_PATIENT_DENTAL_TESTS_DETAILS_FOUND = 801;

    const XRAY_LIST_ERROR = 802;
    const XRAY_LIST_SUCCESS = 803;
    const NO_XRAY_LIST_FOUND = 804;

    const PATIENT_XRAY_TESTS_DETAILS_ERROR = 805;
    const PATIENT_XRAY_TESTS_DETAILS_SUCCESS = 806;
    const NO_PATIENT_XRAY_TESTS_DETAILS_FOUND = 807;

    const PATIENT_XRAY_TESTS_SAVE_ERROR = 808;
    const PATIENT_XRAY_TESTS_SAVE_SUCCESS = 809;

    const BLOODTEST_LIST_ERROR = 810;
    const BLOODTEST_LIST_SUCCESS = 811;
    const NO_BLOODTEST_LIST_FOUND = 812;

    const URINETEST_LIST_ERROR = 813;
    const URINETEST_LIST_SUCCESS = 814;
    const NO_URINETEST_LIST_FOUND = 815;

    const MOTIONTEST_LIST_ERROR = 816;
    const MOTIONTEST_LIST_SUCCESS = 817;
    const NO_MOTIONTEST_LIST_FOUND = 818;

    const ULTRASOUND_LIST_ERROR = 819;
    const ULTRASOUND_LIST_SUCCESS = 820;
    const NO_ULTRASOUND_LIST_FOUND = 821;

    const PATIENT_EXAMINATION_HISTORY_ERROR = 822;
    const PATIENT_EXAMINATION_HISTORY_SUCCESS = 823;
    const NO_PATIENT_EXAMINATION_HISTORY_FOUND = 824;

    //Specialties Codes 850 - 875
    const SPECIALTIES_LIST_ERROR = 851;
    const SPECIALTIES_LIST_SUCCESS = 852;
    const NO_SPECIALTIES_LIST_FOUND = 853;

    const REFERRAL_DOCTOR_LIST_ERROR = 854;
    const REFERRAL_DOCTOR_LIST_SUCCESS = 855;
    const NO_REFERRAL_DOCTOR_LIST_FOUND = 856;

    const REFERRAL_DOCTOR_SAVE_ERROR = 857;
    const REFERRAL_DOCTOR_SAVE_SUCCESS = 858;

    const REFERRAL_DOCTOR_DETAILS_ERROR = 859;
    const REFERRAL_DOCTOR_DETAILS_SUCCESS = 860;
    const REFERRAL_DOCTOR_DETAILS_NOT_FOUND = 861;

    const APPOINTMENT_DATE_ERROR = 862;
    const APPOINTMENT_DATE_NOT_FOUND = 863;
    const APPOINTMENT_DATE_SUCCESS = 864;

    const LAB_TEST_LIST_FOR_RECEIPT_ERROR = 865;
    const LAB_TEST_LIST_FOR_RECEIPT_SUCCESS = 866;
    const NO_LAB_TEST_LIST_FOUND = 867;

    const PATIENT_LAB_RECEIPTS_SAVE_ERROR = 868;
    const PATIENT_LAB_RECEIPTS_SAVE_SUCCESS = 869;
    const PATIENT_LAB_RECEIPTS_LIST_ERROR = 870;

    const PATIENT_LAB_RECEIPT_DETAILS_ERROR = 871;
    const PATIENT_LAB_RECEIPT_DETAILS_SUCCESS = 872;

    const COMPLAINT_TYPES_LIST_ERROR = 873;
    const COMPLAINT_TYPES_LIST_SUCCESS = 874;
    const NO_COMPLAINT_TYPES_LIST_FOUND = 875;

    const COMPLAINTS_LIST_ERROR = 876;
    const COMPLAINTS_LIST_SUCCESS = 877;
    const NO_COMPLAINTS_LIST_FOUND = 878;

    const PATIENT_COMPLAINT_SAVE_ERROR = 879;
    const PATIENT_COMPLAINT_SAVE_SUCCESS = 880;

    const PATIENT_DIAGNOSIS_SAVE_ERROR = 881;
    const PATIENT_DIAGNOSIS_SAVE_SUCCESS = 882;

    const PATIENT_CANCEL_APPOINTMENT_ERROR = 883;
    const PATIENT_CANCEL_APPOINTMENT_SUCCESS = 884;

    const PATIENT_APPOINTMENT_TRANSFERRED_ERROR = 885;
    const PATIENT_APPOINTMENT_TRANSFERRED_SUCCESS = 886;

    const PATIENT_COMPLAINT_DETAILS_ERROR = 887;
    const PATIENT_COMPLAINT_DETAILS_SUCCESS = 888;
    const NO_PATIENT_COMPLAINT_DETAILS_FOUND = 889;

    const PATIENT_INVESTIGATION_DETAILS_ERROR = 890;
    const PATIENT_INVESTIGATION_DETAILS_SUCCESS = 891;
    const NO_PATIENT_INVESTIGATION_DETAILS_FOUND = 892;

    const PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR = 893;
    const PATIENT_LAB_DOCUMENTS_UPLOAD_SUCCESS = 894;

    const PATIENT_LAB_DOCUMENT_DOWNLOAD_ERROR = 895;
    const PATIENT_LAB_DOCUMENT_DOWNLOAD_SUCCESS = 896;

    const PATIENT_TEST_RESULTS_ERROR = 897;
    const PATIENT_TEST_RESULTS_SUCCESS = 898;

    const PATIENT_REPORTS_DOWNLOAD_ERROR = 899;
    const PATIENT_REPORTS_DOWNLOAD_SUCCESS = 900;

    const PATIENT_REPORTS_LIST_ERROR = 901;
    const PATIENT_REPORTS_LIST_SUCCESS = 902;
    const PATIENT_NO_REPORTS_FOUND = 903;


    /**/
    const HOSPITAL_PATIENT_TOKEN_ID_ERROR = 904;
    const PATIENT_FEE_STATUS_ERROR = 905;
    const PATIENT_TOTAL_COUNT_ERROR = 906;

    const PATIENT_LAB_RECEIPTS_LIST_SUCCESS = 907;
    const NO_PATIENT_LAB_RECEIPTS_FOUND = 908;

    const PATIENT_PRESCRIPTION_UPLOAD_ERROR = 909;
    const PATIENT_PRESCRIPTION_UPLOAD_SUCCESS = 910;

    const PATIENT_PRESCRIPTION_ATTACHMENT_LIST_ERROR = 911;
    const PATIENT_PRESCRIPTION_ATTACHMENT_LIST_SUCCESS = 912;
    const PATIENT_NO_PRESCRIPTION_ATTACHMENT_LIST = 913;

    const PATIENT_PRESCRIPTION_ATTACHMENT_DOWNLOAD_ERROR = 914;
    const PATIENT_PRESCRIPTION_ATTACHMENT_DOWNLOAD_SUCCESS = 915;

    /**/

    //const PATIENT_LAB_


}
