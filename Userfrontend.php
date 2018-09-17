<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Userfrontend extends CI_Controller {

	public $documentIds;
    public function __construct() {

        parent::__construct();
        $this->load->model('Userfrontendmodel');
		$this->documentIds = [2=>2,4=>3,5=>9,6=>10,1=>8,3=>7];
    }

    public function index() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        if ($this->usersession->logged_in) {

            redirect('Userfrontend/account_dashboard');
        } else {

            $this->load->view('templates/frontendheader');
            $this->load->view('login');
            $this->load->view('templates/footer');
        }
    }

    public function account_dashboard() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        } else {

            $this->account_information();
        }
    }

    //Required Documentation
    public function front_upload_doc($formFilled = false) {

        //Check if user loggedin
        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        $arrTableData   = $this->db->select("*")->from("download_docs")->where('u_id', $this->session->userdata('logged_in')['id'])->get()->result();
        foreach($arrTableData as $arrTable) {

            $arrDocument[$arrTable->doc_number]    = $arrTable->doc_title;
        }
		
        //Use of PDF Filler Steps
        //Step-1 Get API Authentication, You can skip this if you are passing authentication API key with hardcode value
        //Step-2 listAllDocumentFillRequests
        $data['forms_previous']     = $this->listAllDocumentFillRequests();
      // echo'<pre>';print_r($data['forms_previous']);die;
        $data['documentsToShow']    = 
									[
										'Credit Application',
										'Hold Harmless Agreement',
										'W9',
										'NDA',
										'Transparency Survey',
										'Onboarding'
									];
	/* 	array(
		"NDA", 
		"Credit Application", 
		"W9", 
		"Hold Harmless Agreement", 
		"Transparency Survey", 
		"Onboarding"
		); */
		
		$formArray = [];
        for($documentOrderIndex=0; $documentOrderIndex<=count($data['documentsToShow']); $documentOrderIndex++) {
			
            foreach($data['forms_previous'] as $forms) {
                if($data['documentsToShow'][$documentOrderIndex]   == explode('.', $forms->document_name)[0]) {
					if(!in_array($forms->document_id,$formArray))
					{
						
						$data['forms'][]  = $forms;
					}
                }
            }
			
        }
		
		
        //If loggedin get user data
        $info = $this->session->userdata('logged_in');

        //Get all uploaded documents of loggedin user
        $this->db->select('*');
        $this->db->from('uploaded_docs');
        $this->db->where('uploaded_docs.u_id', $info['id']);

        $query          = $this->db->get();
        $upload_infos   = $query->result_array();
        
        if (isset($upload_infos[0])) {

            $uploads = ($upload_infos[0]);
			
            if ($uploads['nda'] == 1) {

                $data['documents'][1]            = array('name' => 'nda', 'doc_number' => 8, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[8]), 'status' => $this->doc_status($info['id'], 8));
                $data['documentPermission'][]   = "NDA";
            }
            if ($uploads['credit_application'] == 1) {

                $data['documents'][2]            = array('name' => 'credit_application',  'doc_number' => 2, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[2]), 'status' => $this->doc_status($info['id'], 2));
                $data['documentPermission'][]   = "Credit Application";
            }
            if ($uploads['w9'] == 1) {

                $data['documents'][3]            = array('name' => 'w9', 'doc_number' => 7, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[7]), 'status' => $this->doc_status($info['id'], 7));
                $data['documentPermission'][]   = "W9";
            }
            if ($uploads['hold_harmless_agreement'] == 1) {

                $data['documents'][4]            = array('name' => 'hold_harmless_agreement', 'doc_number' => 3, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[3]), 'status' => $this->doc_status($info['id'], 3));
                $data['documentPermission'][]   = "Hold Harmless Agreement";
            }
            if ($uploads['transparency'] == 1) {

                $data['documents'][5]            = array('name' => 'transparency', 'doc_number' => 9, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[9]), 'status' => $this->doc_status($info['id'], 9));
                $data['documentPermission'][]   = "Transparency Survey";
            }
            if ($uploads['onboarding'] == 1) {

                $data['documents'][6]            = array('name' => 'onboarding', 'doc_number' => 10, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[10]), 'status' => $this->doc_status($info['id'], 10));
                $data['documentPermission'][]   = "Onboarding";
            }
            if ($uploads['certificate_liability_insurance'] == 1) {

                $data['certificate_liability_insurance'] = array('certificate_liability_insurance' => 1, 'doc_number' => 1, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[1]), 'status' => $this->doc_status($info['id'], 1));
            }
            if ($uploads['msds'] == 1) {

                $data['msds']                   = array('msds' => 1, 'doc_number' => 4, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[4]), 'status' => $this->doc_status($info['id'], 4));
            }
            if ($uploads['specification_sheet'] == 1) {

                $data['specification_sheet']    = array('specification_sheet' => 1, 'doc_number' => 6, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[6]), 'status' => $this->doc_status($info['id'], 6));
            }
			
			
//            if ($uploads['new_vendor_request_form'] == 1) {
//
//                $data['new_vendor_request_form'] = array('name' => 'new_vendor_request_form', 'status' => $this->doc_status($info['id'], 5));
//            }
//            if ($uploads['resellers'] == 1) {
//
//                $data['resellers']              = array('resellers' => 1, 'status' => $this->doc_status($info['id'], 11));
//                $data['documentPermission'][]   = "Resellers Certificate";
//            }
        } else {

            $data = '';
        }

        $data['formFilled'] = $formFilled;
        if (true == $formFilled) {

            $data['success'] = "Your document is submitted successfully!";
        }

        $this->load->view('templates/frontendheader');
        $this->load->view('frontend_upload_documentation_1', $data);
        $this->load->view('templates/footer');
    }

    //PDF Filler API code starts here
    //Step-1
    //obtainsAnAuthenticationToken using API 2
//    public function obtainsAnAuthenticationToken() {
//
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v2/oauth/token");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_HEADER, FALSE);
//
//        curl_setopt($ch, CURLOPT_POST, TRUE);
//
//        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
//            \"grant_type\": \"password\",
//            \"client_id\": \"ec28fec029e6e09e\",
//            \"client_secret\": \"JvNUmKybeTZ6KQtNjTyhB0vSQwS0x1ZC\",
//            \"username\": \"maka@gwfg.com\",
//            \"password\": \"Dharne.2600\"
//        }");
//
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//          "Content-Type: application/json"
//        ));
//
//        $response = json_decode(curl_exec($ch));
//        curl_close($ch);
//
//        echo 'obtainsAnAuthenticationToken using API 2<br>';
//        echo'<pre>';
//        print_r($response);
//        echo'</pre>';//die;
//    }

    //Step-2
    //listAllDocumentFillRequests using API 1
    public function listAllDocumentFillRequests() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/fill_request");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response->items;
    }

    //Step-3
    //Create User Token to Fille form using short URL and Token 
    public function createUserToken($templateId) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        //Information about a created fill request item
        $data['fillRequest'] = $this->createdFillRequest($templateId);

        $id = $_SESSION['logged_in']['id'];
        $username = $_SESSION['logged_in']['username'];
        $role = $_SESSION['logged_in']['role'];
        $fname = $_SESSION['logged_in']['fname'];
        $lname = $_SESSION['logged_in']['lname'];

        //Creates a new token for user.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"data\": {
                \"id\": \"$id\",
                \"username\": \"$username\",
                \"role\": \"$role\",
                \"fname\": \"$fname\",
                \"lname\": \"$lname\",
                \"templateId\": \"$templateId\"
            }
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response = json_decode(curl_exec($ch));

        curl_close($ch);
        redirect($data['fillRequest']->url . '?token=' . $response->hash);
    }

    //Step-4
    //createdFillRequest
    public function createdFillRequest($templateId) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/fill_request/" . $templateId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    //Step-5
    //Callback redirect after fill online form
    public function callBackUrl($intDocumentId  = NULL) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        //Using List of all tokens. Get latest token data of loggedin user.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        $flagLatestTokenID = true;
        foreach ($response->items as $responseData) {

            if ($_SESSION['logged_in']['id'] == $responseData->data->id) {

                $fillRequestId = $responseData->data->templateId;
                $flagLatestTokenID = false;
            }

            if (false == $flagLatestDocumentID) {

                break;
            }
        }

        //Get filled forms by loggedin user using fill request id took from latest token.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/fill_request/" . $fillRequestId . "/filled_form");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        $latestRecordIndex = 0;
        $index = 0;
        $flagLatestDocumentID = true;
        foreach ($response as $key => $responseData) {

            do {
                if (false == empty($responseData[$index]->id)) {

                    if ($_SESSION['logged_in']['id'] == $responseData[$index]->id) {

                        $filledFormId = $responseData[$latestRecordIndex]->id;
                        $flagLatestDocumentID = false;
                    }
                }
                $index++;
                if (false == $flagLatestDocumentID) {

                    break;
                }
            } while ($index <= count($responseData));
        }

        //         foreach ($response as $key => $responseData) {

        //     do {
        //         if (false == empty($responseData[$index]->token)) {

        //             if ($_SESSION['logged_in']['id'] == $responseData[$index]->token->data->id) {

        //                 $filledFormId = $responseData[$latestRecordIndex]->id;
        //                 $flagLatestDocumentID = false;
        //             }
        //         }
        //         $index++;
        //         if (false == $flagLatestDocumentID) {

        //             break;
        //         }
        //     } while ($index <= count($responseData));
        // }

        //Download PDF API call
        $this->downloadPdf($fillRequestId, $filledFormId, $this->documentIds[$intDocumentId]);
    }

    //Step-6
    //Download PDF API after fill online form
    public function downloadPdf($fillRequestId = NULL, $filledFormId, $intDocumentId) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }

        //Download pdf using API version 1
        $ch = curl_init();

        //curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/fill_request/122404553/filled_form/".$filledFormId."/download");
        curl_setopt($ch, CURLOPT_URL, "https://api.pdffiller.com/v1/fill_request/" . $fillRequestId . "/filled_form/" . $filledFormId . "/download");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer si79hFprJjzIahruAdp0rIDlko7noVf76KHhhzfY"
        ));

        $response   = curl_exec($ch);
        $filename   = $_SERVER['DOCUMENT_ROOT'] . '/portal/assets/save_pdf_form/' . $filledFormId . '.pdf';

        file_put_contents($filename, $response);
        curl_close($ch);

        $arrWhere   = array (

            'u_id'          => $this->session->userdata('logged_in')['id'],
            'doc_number'    => $intDocumentId            
        );
        $isDocumentExists   = $this->db->select('down_doc_id')->from('download_docs')->where($arrWhere)->get()->result();

        if(true == $isDocumentExists) {

            $arrWhere   = array (

                'down_doc_id'   => $isDocumentExists[0]->down_doc_id
            );
            $arrData    = array (

                "doc_title"     => $filledFormId . '.pdf',
                "status"        => '2',
				'upload_type'    => 1
            );
            $this->db->where($arrWhere);
            $this->db->update('download_docs', $arrData);
        } elseif(false  == $isDocumentExists) {

            $arrData    = array (

                "u_id"          => $this->session->userdata('logged_in')['id'],
                "doc_title"     => $filledFormId . '.pdf',
                "doc_number"    => $intDocumentId,
                "status"        => '2',
				'upload_type'    => 1
            );
            if(true != $this->db->insert('download_docs', $arrData)) {

                echo 'Unable to save document path. Please contact developer.';die;
            }
        }

        $formFilled = true;
        $this->front_upload_doc($formFilled);
    }
    //PDF Filler API code ends here

    public function useredit($id) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $id);

        $query = $this->db->get();
        foreach ($query->result() as $row) {

            $data = array();
            $data['id'] = $row->id;
            $data['comp_name'] = $row->comp_name;
        }
        if (empty($data)) {

            $this->session->set_flashdata('delete_message', 'No vendor record found.');
            redirect('verifylogin/logout');
        }
        if (isset($_POST['update'])) {
            if (empty($data)) {

                $this->session->set_flashdata('delete_message', 'No vendor record found.');
                redirect('verifylogin/logout');
            }
            $this->form_validation->set_rules('companynamecheck', 'Company Name', 'required|callback_customAlpha');
            $this->form_validation->set_message('customAlpha', 'This field may only contain characters or numbers.');
            $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
            $this->form_validation->set_rules('officenum', 'Office Number', 'numeric|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('faxnum', 'Fax Number', 'numeric');
            $this->form_validation->set_rules('phonenum', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('zipcode', 'Zip Code', 'required|numeric');
            $this->form_validation->set_rules('emailaddress', 'Email Address', 'valid_email|callback_check_existing_email');
            $this->form_validation->set_rules('altfirstname', 'First Name', 'required|alpha_numeric');
            $this->form_validation->set_rules('altlastname', 'Last Name', 'required|alpha_numeric');
            $this->form_validation->set_rules('altphonenum', 'Office Number', 'required|numeric');
            $this->form_validation->set_rules('altemailadd', 'Email Address', 'valid_email');
        }
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/frontendheader');
            $this->load->view('useredit', $data);
            $this->load->view('templates/footer');
        } else {

            $this->Userfrontendmodel->edit_vendor($id);
        }
    }

    public function customAlpha($str) {

        if (!preg_match('/^[a-z \-]+$/i', $str)) {

            return false;
        } else {

            return true;
        }
    }

    function check_existing_email() {

        if (isset($_POST['update'])) {

            $id = $this->uri->segment(3);

            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id!=', $id);

            $query = $this->db->get();
            $i = 0;
            foreach ($query->result() as $row) {

                $existing_email = $row->email_address;
                if ($existing_email != $this->input->post('emailaddress')) {
                    if ($query->num_rows() == $i) {

                        return true;
                    } else {

                        $i++;
                    }
                } else {

                    $this->form_validation->set_message('check_existing_email', 'Email address field must contain a unique value.');
                    return false;
                }
            }
        }
    }

    public function account_information() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        $info = $this->session->userdata('logged_in');

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $info['id']);

        $query = $this->db->get();
        $account_info = $query->result();
        if (empty($account_info)) {

            $this->session->set_flashdata('delete_message', 'No vendor record found.');
            redirect('verifylogin/logout');
        }
        foreach ($account_info as $singleaccountinfo) {

            $finalresult['id'] = $singleaccountinfo->id;
            $finalresult['comp_name'] = $singleaccountinfo->comp_name;
            $finalresult['first_name'] = $singleaccountinfo->first_name;
            $finalresult['last_name'] = $singleaccountinfo->last_name;
            $finalresult['office_num'] = $singleaccountinfo->office_num;
            $finalresult['phone_num'] = $singleaccountinfo->phone_num;
            $finalresult['fax_num'] = $singleaccountinfo->fax_num;
            $finalresult['address'] = $singleaccountinfo->address;
            $finalresult['state'] = $singleaccountinfo->state;
            $finalresult['city'] = $singleaccountinfo->city;
            $finalresult['zip_code'] = $singleaccountinfo->zip_code;
            $finalresult['web_address'] = $singleaccountinfo->web_address;
            $finalresult['email_address'] = $singleaccountinfo->email_address;
            $finalresult['first_name_alt'] = $singleaccountinfo->first_name_alt;
            $finalresult['last_name_alt'] = $singleaccountinfo->last_name_alt;
            $finalresult['phone_alt'] = $singleaccountinfo->phone_alt;
            $finalresult['email_alt'] = $singleaccountinfo->email_alt;
        }

        $this->load->view('templates/frontendheader');
        $this->load->view('account_information', $finalresult);
        $this->load->view('templates/footer');
    }

    public function front_download_doc() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        $info = $this->session->userdata('logged_in');
        if ($this->input->post()) {

            $document_numbers = $this->input->post('filetype');
            if (!empty($document_numbers)) {

                foreach ($document_numbers as $document_number) {

                    $this->db->select('document_name');
                    $this->db->from('default_template');
                    $this->db->where('document_number', $document_number);

                    $file_name = $this->db->get();
                    $row = $file_name->row();
                    $files[] = getcwd() . DIRECTORY_SEPARATOR . 'assets/default_templates/' . $row->document_name;
                }
                $this->download_selected_document($files);
                $this->session->set_flashdata('error_message', 'Download successfully.');
            } else {

                $this->session->set_flashdata('error_message', 'Please make sure  at least one checkbox checked.');
                redirect('userfrontend/front_download_doc', 'refresh');
            }
        }
        $info = $this->session->userdata('logged_in');

        $this->db->select('*');
        $this->db->from('uploaded_docs');
        $this->db->where('uploaded_docs.u_id', $info['id']);

        $query = $this->db->get();
        $upload_infos = $query->result_array();
        if (isset($upload_infos[0])) {

            $uploads = ($upload_infos[0]);
            if ($uploads['certificate_liability_insurance'] == 1) {

                $data['certificate_liability_insurance'] = array('certificate_liability_insurance' => 1, 'status' => $this->doc_status($info['id'], 1));
            }
            if ($uploads['credit_application'] == 1) {

                $data['credit_application'] = array('credit_application' => 1, 'status' => $this->doc_status($info['id'], 2));
            }
            if ($uploads['hold_harmless_agreement'] == 1) {

                $data['hold_harmless_agreement'] = array('hold_harmless_agreement' => 1, 'status' => $this->doc_status($info['id'], 3));
            }
            if ($uploads['msds'] == 1) {

                $data['msds'] = array('msds' => 1, 'status' => $this->doc_status($info['id'], 4));
            } if ($uploads['new_vendor_request_form'] == 1) {

                $data['new_vendor_request_form'] = array('new_vendor_request_form' => 1, 'status' => $this->doc_status($info['id'], 5));
            }
            if ($uploads['specification_sheet'] == 1) {

                $data['specification_sheet'] = array('specification_sheet' => 1, 'status' => $this->doc_status($info['id'], 6));
            }
            if ($uploads['w9'] == 1) {

                $data['w9'] = array('w9' => 1, 'status' => $this->doc_status($info['id'], 7));
            }
            if ($uploads['nda'] == 1) {

                $data['nda'] = array('nda' => 1, 'status' => $this->doc_status($info['id'], 8));
            }
            if ($uploads['transparency'] == 1) {

                $data['transparency'] = array('transparency' => 1, 'status' => $this->doc_status($info['id'], 9));
            }
            if ($uploads['onboarding'] == 1) {

                $data['onboarding'] = array('onboarding' => 1, 'status' => $this->doc_status($info['id'], 10));
            }
            if ($uploads['resellers'] == 1) {

                $data['resellers'] = array('resellers' => 1, 'status' => $this->doc_status($info['id'], 11));
            }
            if (empty($uploads['w9']) && empty($uploads['specification_sheet']) && empty($uploads['new_vendor_request_form']) && empty($uploads['msds']) && empty($uploads['hold_harmless_agreement']) && empty($uploads['credit_application']) && empty($uploads['certificate_liability_insurance']) && empty($uploads['w9']) && empty($uploads['w9']) && empty($uploads['resellers']) && empty($uploads['transparency']) && empty($uploads['onboarding'])) {

                $data = '';
            }
        } else {

            $data = '';
        }

        $this->load->view('templates/frontendheader');
        $this->load->view('frontend_download_documentation', $data);
        $this->load->view('templates/footer');
    }

    function download_selected_document($names) {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        foreach ($names as $name) {

            $this->zip->read_file($name);
        }
        $this->zip->download('files_backup.zip');
    }

    function uploadFilledDocument() {

        // Check if file is a pdf
        if (isset($_POST["Submit"])) {

            $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/portal/assets/save_pdf_form/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 0;
            $config['file_name'] = $_FILES['filled_form']['name'];
            $_SESSION['filled_form_path'] = base_url() . '/assets/save_pdf_form/' . $_FILES['filled_form']['name'];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (true == $this->upload->do_upload('filled_form')) {

                $this->upload->data();

                $success = "Your file uploaded Successfully!";
                $error = NULL;

                $this->front_upload_doc($success);
            } else {

                $success = NULL;
                $error = "Invalid file type, Only .pdf files are allowed.";

                $this->front_upload_doc($success, $error);
            }
        } else {

            $this->front_upload_doc();
        }
    }

    function doc_status($user_id, $docnumber) {

        $this->db->select('*');
        $this->db->from('download_docs');
        $this->db->where('u_id', $user_id);
        $this->db->where('doc_number', $docnumber);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $uploaded_file_status = $query->row();
            return $uploaded_file_status;
        }
    }

    function move_upload_file_dest() {

        $document_number = $_POST['number'];
        $info   = $this->session->userdata('logged_in');

        //get user_id
        $userid             = $info['id'];
        $destination_path   = getcwd() . DIRECTORY_SEPARATOR . 'assets/';
        $file               = explode(".", $_FILES["file"]["name"]);
        $extensions         = array("pdf");
        if (in_array($file[1], $extensions) === false) {

            $error = 'Only PDF is allowed.';
        }
        if ($_FILES["file"]["size"] >= 2000000) {

            $error = 'Max file size limit is 2MB.';
        }

        if (empty($error) == true) {

            $date                   = new DateTime();
            $additional_variable    = $date->getTimestamp();
            $file_name              = $file[0] . $additional_variable . '.' . $file[1];
            $target_path            = $destination_path . basename($file_name);

            move_uploaded_file($_FILES['file']['tmp_name'], $target_path);

            $this->doument_is_allready_uploaded($userid, $document_number, $file_name);
            $this->session->set_flashdata('error_message', 'File uploaded successfully.');

            $arrWhere   = array (

                'u_id'          => $this->session->userdata('logged_in')['id'],
                'doc_number'    => $document_number
            );
            $isDocumentExists   = $this->db->select('down_doc_id')->from('download_docs')->where($arrWhere)->get()->result();
            if(true == $isDocumentExists) {

                $arrWhere   = array (

                    'down_doc_id'   => $isDocumentExists[0]->down_doc_id
                );
                $arrData    = array (

                    "doc_title"     => $file_name,
					"upload_type"        => 2,
                    "status"        => '2'
                );
                $this->db->where($arrWhere);
                $this->db->update('download_docs', $arrData);
            } elseif(false  == $isDocumentExists) {

                $arrData    = array (

                    "u_id"          => $this->session->userdata('logged_in')['id'],
                    "doc_title"     => $file_name,
                    "doc_number"    => $document_number,
                    "upload_type"        => 2,
                    "status"        => '2'
                );
                if(true != $this->db->insert('download_docs', $arrData)) {

                    echo 'Unable to save document path. Please contact developer.';die;
                }
            }

            $userdetail = array('documentname' => $document_name, 'username' => $info['fname'] . ' ' . $info['lname']);
            $this->sendMailAdmin($userdetail);
        } else {

            $this->session->set_flashdata('error_message', $error);
        }
    }

    function sendMailAdmin($userdetail) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 25,
            'smtp_user' => 'rjones690@gmail.com', // change it to yours
            'smtp_pass' => 'dharne@123', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $this->db->select('email_address');
        $this->db->from('user');
        $this->db->where('role =', 1);

        $q = $this->db->get();
        $e = $q->row();

        $subject = ' Vendor Portal: New Document Uploaded';

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->adminemail());

        $this->email->to($e->email_address);  // replace it with receiver mail id
        $this->email->subject($subject); // replace it with relevant subject

        $body = $this->load->view('mail_templates/document_uploaded', $userdetail, TRUE);

        $this->email->message($body);
        $this->email->send();
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    function doument_is_allready_uploaded($user_id, $doc_number, $file_name) {

        $this->db->where('u_id', $user_id);
        $this->db->where('doc_number', $doc_number);
        $q = $this->db->get('download_docs');

        if ($q->num_rows() > 0) {

            $this->db->set('doc_title', $file_name);
            $this->db->set('status', 2);
            $this->db->where('doc_number', $doc_number);
            $this->db->where('u_id', $user_id);
            $this->db->update('download_docs');
        } else {

            $this->db->set('u_id', $user_id);
            $this->db->set('doc_title', $file_name);
            $this->db->set('status', 2);
            $this->db->set('doc_number', $doc_number);
            $this->db->insert('download_docs');
        }
    }

    function get_document_name($userid, $document_name) {

        $this->db->select('*');
        $this->db->from('download_docs');
        $this->db->where('u_id', $userid);
        $this->db->like('doc_title', $document_name);

        $query = $this->db->get();
        $ret = $query->result();
        if (empty($ret)) {
            
        } else {

            return $ret;
        }
    }

    public function front_reset_pass() {

        if (!$this->usersession->logged_in) {

            redirect('user');
        }
        if (isset($_POST['front_reset_pass'])) {

            $this->form_validation->set_rules('currentpassword', 'Current Password', 'required|callback_check_current_pass');
            $this->form_validation->set_rules('front_newpassword', ' New Password', 'required');
            $this->form_validation->set_rules('front_verifypassword', ' Verify Password', 'required|matches[front_newpassword]');
        }
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('templates/frontendheader');
            $this->load->view('frontend_reset_password');
            $this->load->view('templates/footer');
        } else {

            $reset = $_GET['id'];
            $this->Userfrontendmodel->frontend_reset_password($reset);
        }
    }

    public function check_current_pass() {

        if (isset($_POST['front_reset_pass'])) {

            $id = $_GET['id'];

            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id', $id);

            $query = $this->db->get();

            foreach ($query->result() as $row) {

                $current_pass = $row->password;
                if ($current_pass == md5($this->input->post('currentpassword'))) {

                    return true;
                } else {

                    $this->form_validation->set_message('check_current_pass', 'The password you have entered is wrong.');
                    return false;
                }
            }
        }
    }

    public function validuser() {

        $loginuserid = $this->session->userdata('id');

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $loginuserid);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {

            $this->session->set_flashdata('delete_message', 'No vendor record found.');
            redirect('verifylogin/logout');
        } else {

            return true;
        }
    }

    public function adminemail() {

        $this->db->select('email_address');
        $this->db->from('user');
        $this->db->where('role', 1);

        $q = $this->db->get();
        $e = $q->row();

        return $e->email_address;
    }

}
