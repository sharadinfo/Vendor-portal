<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller
{
	
	public function __construct()
       {
            parent::__construct();
            $this->load->model('UserModel');
                        
                          //print_r( $this->session->userdata('logged_in'));
                    //echo  is_logged_in();
			
       }
    public function view_form(){


		$this->load->view('templates/loginheader');

		$type=$this->uri->segment(3);

		switch ($type) {
			case 'credit_agreement':
			 
			$this->load->view('templates/frontendheader');
			$this->load->view('credit_agreement');	
			$this->load->view('templates/footer');
			break;

			case 'nda':
			$this->load->view('templates/frontendheader');
			$this->load->view('nda');	
			$this->load->view('templates/footer');
			break;

			case 'hold_harmless_agreement':
			$this->load->view('templates/frontendheader');
			$this->load->view('hold_harmless_agreement');	
			$this->load->view('templates/footer');
			break;

			case 'onboarding':
			$this->load->view('templates/frontendheader');
			$this->load->view('onboarding');	
			$this->load->view('templates/footer');
			break;

			case 'transparency_survey':
			$this->load->view('templates/frontendheader');
			$this->load->view('transparency_survey');	
			$this->load->view('templates/footer');
			break;
		}

		$this->load->view('templates/footer');

	}


	public function create_pdf(){

		if (!$this->usersession->logged_in)
			{
				redirect('user');
			}
			/*$this->load->view('templates/header');
			$this->load->view('templates/footer');*/
		/*if($this->session->userdata('credit_agreement'))
			{
				$this->session->unset_userdata('credit_agreement');

			}*/

		$type=$this->uri->segment(3);
		switch ($type) {
			case 'credit_agreement':
						
		/**Start validation rule**/
	$this->form_validation->set_rules('name', 'Name', 'required|callback_customAlpha');
	$this->form_validation->set_rules('phone', 'Phone', 'numeric|min_length[10]|max_length[10]');
	$this->form_validation->set_rules('address', 'Address', 'required|callback_customAlpha');
	$this->form_validation->set_rules('city', 'City', 'required|callback_customAlpha');
	$this->form_validation->set_rules('state', 'State', 'required|callback_customAlpha');
	$this->form_validation->set_rules('zip', 'Zip', 'required|numeric|min_length[5]|max_length[6]');
	$this->form_validation->set_rules('statezip', 'Zip', 'numeric|min_length[5]|max_length[6]');
	$this->form_validation->set_rules('statezip1', 'Zip', 'numeric|min_length[5]|max_length[6]');
	$this->form_validation->set_rules('statezip2', 'Zip', 'numeric|min_length[5]|max_length[6]');
	$this->form_validation->set_rules('refphone', 'Phone', 'numeric|min_length[10]|max_length[10]');
	$this->form_validation->set_rules('refphone1', 'Phone', 'numeric|min_length[10]|max_length[10]');
	$this->form_validation->set_rules('refphone2', 'Phone', 'numeric|min_length[10]|max_length[10]');
		
		/**End validation rule**/


		/**Getting form input values**/
		$session=$this->session->userdata('logged_in');
				
		
		$data['name'] 	 = $this->input->post('name');
		$data['phone'] 	 = $this->input->post('phone');
		$data['address'] 	 = $this->input->post('address');
		$data['city'] 	 = $this->input->post('city');
		$data['state'] 	 = $this->input->post('state');
		$data['zip'] 	 = $this->input->post('zip');
		$data['parentcompany'] 	 = $this->input->post('name');
		$data['partnername1'] 	 = $this->input->post('partnername1');
		$data['homeaddress1'] 	 = $this->input->post('homeaddress1');
		$data['socsec1'] 	 = $this->input->post('socsec1');
		$data['partnername2'] 	 = $this->input->post('partnername2');
		$data['homeaddress2'] 	 = $this->input->post('homeaddress2');
		$data['socsec2'] 	 = $this->input->post('socsec2');
		$data['license'] 	 = $this->input->post('license');
		$data['business'] 	 = $this->input->post('business');
		$data['yearestablished'] 	 = $this->input->post('yearestablished');
		$data['location'] 	 = $this->input->post('location');
		$data['isbusinessincorporated'] 	 = $this->input->post('isbusinessincorporated');
		$data['laws'] 	 = $this->input->post('laws');
		$data['bank'] 	 = $this->input->post('bank');
		$data['acno'] 	 = $this->input->post('acno');
		$data['refphone'] 	 = $this->input->post('refphone');
		$data['streetaddress'] 	 = $this->input->post('streetaddress');
		$data['refcity'] 	 = $this->input->post('refcity');
		$data['statezip'] 	 = $this->input->post('statezip');
		$data['refname1'] 	 = $this->input->post('refname1');
		$data['refphone1'] 	 = $this->input->post('refphone1');
		$data['streetaddress1'] 	 = $this->input->post('streetaddress1');
		$data['refcity1'] 	 = $this->input->post('refcity1');
		$data['statezip1'] 	 = $this->input->post('statezip1');
		$data['refname2'] 	 = $this->input->post('refname2');
		$data['refphone2'] 	 = $this->input->post('refphone2');
		$data['streetaddress2'] 	 = $this->input->post('streetaddress2');
		$data['refcity2'] 	 = $this->input->post('refcity2');
		$data['statezip2'] 	 = $this->input->post('statezip2');
		$data['sign'] 	 = $this->input->post('sign');
		$data['title1'] 	 = $this->input->post('title1');
		$data['printname'] 	 = $this->input->post('printname');
		$data['date'] 	 = $this->input->post('date');
		//$data['u_id']    = 	$session['id']; 
		$data['companytype'] 	 = $this->input->post('companytype');



		
		/*$data['corporation'] 	 = $this->input->post('corporation');
		$data['partnership'] 	 = $this->input->post('partnership');
		$data['soleproprietor'] 	 = $this->input->post('soleproprietor');*/
						
		/**Getting form input values**/
		//$this->UserModel->credit_agreement($data);
		/*if ($this->form_validation->run() == FALSE)
				{
				    

				}
				else
				{
    
				$info = array();
				$info['u_id']      = $this->input->post('u_id');
				$info['name'] = $this->input->post('name');
				$info['phone']  = $this->input->post('phone');
				$info['address'] = $this->input->post('address');
				$info['city']      = $this->input->post('city');

				$this->UserModel->credit_agreement($info);	
				

				}*/

			break;
			case 'nda':
		$this->form_validation->set_rules('name', 'Name', 'required|callback_customAlpha');
		$this->form_validation->set_rules('address', 'Address', 'required|callback_customAlpha');
		$this->form_validation->set_rules('vendorname', 'Vendor name', 'required|callback_customAlpha');


		/**Getting form input values**/
		$data['name'] 	 = $this->input->post('name');
		$data['address'] 	 = $this->input->post('address');
		$data['vendorname'] 	 = $this->input->post('vendorname');
		$data['sign'] 	 = $this->input->post('sign');
		$data['title1'] 	 = $this->input->post('title1');
		$data['printname'] 	 = $this->input->post('printname');
		$data['date'] 	 = $this->input->post('date');
						
		/**Getting form input values**/

			break;
			case 'hold_harmless_agreement':

			$this->form_validation->set_rules('name', 'Name', 'required|callback_customAlpha');
		    $this->form_validation->set_rules('address', 'Address', 'required|callback_customAlpha');
		    $this->form_validation->set_rules('seller', 'Seller', 'required|callback_customAlpha');
		    $this->form_validation->set_rules('sellername', 'Name of Seller', 'required|callback_customAlpha');
		   /* $this->form_validation->set_rules('name', 'name', 'required|callback_customAlpha');
		    $this->form_validation->set_rules('address', 'Address', 'required|callback_customAlpha');*/

			$data['name'] 	 		= $this->input->post('name');
			$data['address'] 	 	= $this->input->post('address');
			$data['seller'] 		= $this->input->post('seller');
			$data['sellername'] 	= $this->input->post('sellername');
			$data['sign'] 	 		= $this->input->post('sign');
			$data['title1'] 	 	= $this->input->post('title1');
			$data['printname'] 	 	= $this->input->post('printname');
			$data['date'] 	 		= $this->input->post('date');

			break;

			case 'onboarding':

			$this->form_validation->set_rules('suppliername', 'suppliername', 'required|callback_customAlpha');
		    /*$this->form_validation->set_rules('address', 'Address', 'required|callback_customAlpha');*/
		    $this->form_validation->set_rules('phone', 'Phone', 'numeric|min_length[10]|max_length[10]');
		    $this->form_validation->set_rules('econtact', 'Phone', 'numeric|min_length[10]|max_length[10]');
		    $this->form_validation->set_rules('generalcontact', 'Phone', 'numeric|min_length[10]|max_length[10]');
		    $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');

			$data['suppliername'] 	 		= $this->input->post('suppliername');
			$data['address'] 	 			= $this->input->post('address');
			$data['phone'] 					= $this->input->post('phone');
			$data['econtact'] 				= $this->input->post('econtact');
			$data['generalcontact'] 	 	= $this->input->post('generalcontact');
			$data['telephone'] 				= $this->input->post('telephone');
			$data['fax'] 					= $this->input->post('fax');
			$data['email'] 					= $this->input->post('email');
			$data['companytype'] 			= $this->input->post('companytype');

/*if(!empty($this->input->post('companytype'))) {
    foreach($this->input->post('companytype') as $check) {
           $data['companytype'] = $check; 
    }
}*/

			$data['q1'] 	 			= $this->input->post('q1');
			$data['q13'] 				= $this->input->post('q13');
			$data['q14'] 				= $this->input->post('q14');
			$data['q141'] 	 			= $this->input->post('q141');
			$data['supname1'] 	 		= $this->input->post('supname1');
			$data['supname2'] 	 		= $this->input->post('supname2');
			$data['supname3'] 	 		= $this->input->post('supname3');
			$data['q211'] 				= $this->input->post('q211');
			$data['q222'] 				= $this->input->post('q222');
			$data['q2221'] 	 			= $this->input->post('q2221');
			$data['q2222'] 	 			= $this->input->post('q2222');
			$data['q2223'] 	 			= $this->input->post('q2223');
			$data['q31'] 	 			= $this->input->post('q31');
			$data['q321'] 				= $this->input->post('q321');
			$data['q33'] 				= $this->input->post('q33');
			$data['q331'] 	 			= $this->input->post('q331');
			$data['q332'] 	 			= $this->input->post('q332');
			$data['q41'] 	 		    = $this->input->post('q41');
			$data['q42'] 	 			= $this->input->post('q42');
			$data['q421'] 				= $this->input->post('q421');
			$data['q422'] 				= $this->input->post('q422');
			$data['q43'] 	 			= $this->input->post('q43');
			$data['q5'] 	 			= $this->input->post('q5');
			$data['q52'] 	 			= $this->input->post('q52');
			$data['q53'] 	 			= $this->input->post('q53');
			$data['q54'] 				= $this->input->post('q54');
			$data['q55'] 				= $this->input->post('q55');
			$data['q56'] 	 			= $this->input->post('q56');
			$data['q57'] 	 			= $this->input->post('q57');
			$data['q58'] 	 			= $this->input->post('q58');
			$data['q59'] 	 			= $this->input->post('q59');
			$data['q510'] 	 			= $this->input->post('q510');
			$data['q511'] 				= $this->input->post('q511');
			$data['q512'] 				= $this->input->post('q512');
			$data['q513'] 	 			= $this->input->post('q513');
			$data['q514'] 	 			= $this->input->post('q514');
			$data['q515'] 	 			= $this->input->post('q515');
			$data['q516'] 	 			= $this->input->post('q516');

			$data['q61'] 				= $this->input->post('q61');
			$data['q62'] 				= $this->input->post('q62');
			$data['q63'] 	 			= $this->input->post('q63');
			$data['q64'] 	 			= $this->input->post('q64');
			$data['q65'] 	 			= $this->input->post('q65');
			$data['q61t'] 				= $this->input->post('q61t');
			$data['q62t'] 				= $this->input->post('q62t');
			$data['q64t'] 	 			= $this->input->post('q64t');

			$data['q66'] 				= $this->input->post('q66');
			$data['q67'] 				= $this->input->post('q67');
			$data['q68'] 	 			= $this->input->post('q68');
			$data['q69'] 	 			= $this->input->post('q69');
			$data['q610'] 	 			= $this->input->post('q610');
			$data['q71'] 	 			= $this->input->post('q71');
			$data['q72'] 				= $this->input->post('q72');
			$data['q73'] 				= $this->input->post('q73');
			$data['q75'] 	 			= $this->input->post('q75');
			$data['q77'] 	 			= $this->input->post('q77');
			$data['q78'] 	 			= $this->input->post('q78');
			$data['q81'] 	 			= $this->input->post('q81');
			$data['q82'] 	 			= $this->input->post('q82');
			$data['q83'] 	 			= $this->input->post('q83');
			$data['q84'] 	 			= $this->input->post('q84');
			$data['q9'] 				= $this->input->post('q9');
			$data['q911'] 				= $this->input->post('q911');
			$data['q912'] 	 			= $this->input->post('q912');
			$data['q101'] 	 			= $this->input->post('q101');
			$data['q102'] 	 			= $this->input->post('q102');
			$data['q111'] 	 			= $this->input->post('q111');
			$data['q112'] 	 			= $this->input->post('q112');
			$data['q113'] 	 			= $this->input->post('q113');
			$data['q114'] 	 			= $this->input->post('q114');
			$data['q115'] 	 			= $this->input->post('q115');
			$data['q121'] 	 			= $this->input->post('q121');
			$data['q122'] 	 			= $this->input->post('q122');
			$data['q123'] 	 			= $this->input->post('q123');
			$data['on13'] 				= $this->input->post('on13');
			$data['day13'] 	 			= $this->input->post('day13');
			$data['supp13'] 	 		= $this->input->post('supp13');
			$data['qn14'] 				= $this->input->post('qn14');
			$data['q151'] 	 			= $this->input->post('q151');
			$data['q152'] 	 			= $this->input->post('q152');
			
			$data['title1'] 	 	= $this->input->post('title1');
			$data['printname'] 	 	= $this->input->post('printname');
			$data['date'] 	 		= $this->input->post('date');
			$data['satsuprec'] 		= $this->input->post('satsuprec');
			break;

			case 'transparency_survey':

			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		    $this->form_validation->set_rules('yourname', 'Name', 'required|callback_customAlpha');
		     $this->form_validation->set_rules('esign', 'Name', 'required|callback_customAlpha');
		     $this->form_validation->set_rules('phone', 'Phone', 'numeric|min_length[10]|max_length[10]');


			$data['survey'] 	 		= $this->input->post('survey');
			$data['q1'] 	 			= $this->input->post('q1');
			$data['program'] 	 		= $this->input->post('program');
			$data['q2'] 				= $this->input->post('q2');
			$data['q2ta'] 				= $this->input->post('q2ta');
			$data['q3'] 	 			= $this->input->post('q3');
			$data['q3ta'] 	 			= $this->input->post('q3ta');
			$data['q3a'] 	 			= $this->input->post('q3a');
			$data['q3ata'] 	 			= $this->input->post('q3ata');
			$data['q3b'] 				= $this->input->post('q3b');
			$data['q3bta'] 				= $this->input->post('q3bta');
			$data['q3c'] 	 			= $this->input->post('q3c');
			$data['q3cta'] 	 			= $this->input->post('q3cta');
			$data['q3d'] 	 			= $this->input->post('q3d');
			$data['q3dta'] 	 			= $this->input->post('q3dta');
			$data['q4'] 	 			= $this->input->post('q4');
			$data['q4ta'] 	 			= $this->input->post('q4ta');
			$data['q5'] 	 			= $this->input->post('q5');
			$data['q5ta'] 				= $this->input->post('q5ta');
			$data['q5a'] 				= $this->input->post('q5a');
			$data['q5ata'] 	 			= $this->input->post('q5ata');
			$data['q5b'] 	 			= $this->input->post('q5b');
			$data['q5bta'] 	 			= $this->input->post('q5bta');
			$data['q5c'] 	 			= $this->input->post('q5c');
			$data['q5cta'] 	 			= $this->input->post('q5cta');
			$data['q6'] 	 			= $this->input->post('q6');
			$data['q6ta'] 	 			= $this->input->post('q6ta');
			$data['declaration'] 	 	= $this->input->post('declaration');
			$data['esign'] 	 			= $this->input->post('esign');
			$data['companyname'] 	 	= $this->input->post('companyname');
			$data['yourname'] 	 		= $this->input->post('yourname');
			$data['companyposition'] 	= $this->input->post('companyposition');
			$data['email'] 	 			= $this->input->post('email');
			$data['phone'] 	 			= $this->input->post('phone');


			break;
					
					
		}



		if ($this->form_validation->run() == FALSE)
			{
				//echo 'wrong input';
				$this->view_form();
				
			}
		else
			{
				
		//$pdfFilePath = "assets/save_pdf_form/userid11_nda.pdf";

		$session=$this->session->userdata('logged_in');
		$user_id=$session['id']; 
		$type=$this->uri->segment(3);

		$filename='assets/save_pdf_form/'.$type.$user_id.'.pdf';

		//echo $filename;

		if (file_exists($filename)) {
			    unlink($filename);
			}
			
		$loadpdf=$this->load->view('pdf_template/'.$type,$data,true);
		$this->m_pdf->pdf->WriteHTML($loadpdf);	
		$this->m_pdf->pdf->Output($filename, "F"); 
		$this->session->set_flashdata('form_submitted', 'PDF saved in user profile successfully.');
		redirect('user/create_pdf/'.$type);
	}
	}
		public function index() {
			
			 if ($this->usersession->logged_in)
				{
				redirect('user/dashboard');
				}
				else
				{
					//redirect('http://demoecommerce.com/vendorportal/index.php/user');
					$username = '';
					$password = '';
					
					  if (isset($_COOKIE['username'])) {
						$username = $_COOKIE['username'];
					  }
					
					  if (isset($_COOKIE['password'])) {
						$password = $_COOKIE['password'];
					  }
					  $usercredential = array('username' => $username, 'password' => $password );
					//print_r($usercredential);
					$this->load->view('templates/loginheader');
					$this->load->view('login',$usercredential);
					$this->load->view('templates/footer');
				}
		}
	
		public function upload_documentation() {
			
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
				
			if(empty($this->session->userdata['register']['edit_id']))
							{
								
								$this->session->set_flashdata('error_message', 'Account information should be filled first.');
								redirect('user/register','refresh');
								
								//exit;
							}
							else{
							  $edit_id=$this->session->userdata['register']['edit_id'];
							
							  $query = $this->db->query("select * from user where id=$edit_id");
								if ($query->num_rows() == 0)
								{
									 $this->session->set_flashdata('delete_message', 'No vendor record found.');
									 redirect( 'user/dashboard','refresh' );
								}
								$this->load->view('templates/header');
								$this->load->view('upload_documentation');
								$this->load->view('templates/footer');
							}
		}


		public function upload_documentation_demo() {
			
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
				
			if(empty($this->session->userdata['register']['edit_id']))
				{
					
					$this->session->set_flashdata('error_message', 'Account information should be filled first.');
					redirect('user/register','refresh');
					
					//exit;
				}
				else{
                    $edit_id=$this->session->userdata['register']['edit_id'];

                    $arrTableData   = $this->db->select("*")->from("download_docs")->where('u_id', $edit_id)->get()->result();
                        foreach($arrTableData as $arrTable) {

                            $arrDocument[$arrTable->doc_number]    = $arrTable->doc_title;
                        }

                      
                         $data['forms_previous']     = $this->listAllDocumentFillRequests();
                    //        echo'<pre>';print_r($data['forms_previous']);die;
                            $data['documentsToShow']    = array("NDA", "Credit Application", "W9", "Hold Harmless Agreement", "Transparency Survey", "Onboarding");
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

                        $this->db->select('*');
                        $this->db->from('uploaded_docs');
                        $this->db->where('uploaded_docs.u_id', $edit_id);

                        $query          = $this->db->get();
                        $upload_infos   = $query->result_array();

                        if (isset($upload_infos[0])) {

                        $uploads = ($upload_infos[0]);
                        if ($uploads['nda'] == 1) {

                            $data['documents'][1]            = array('name' => 'nda', 'doc_number' => 1, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[1]), 'status' => $this->doc_status($info['id'], 1));
                            $data['documentPermission'][]   = "NDA";
                        }
                        if ($uploads['credit_application'] == 1) {

                            $data['documents'][2]            = array('name' => 'credit_application',  'doc_number' => 2, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[2]), 'status' => $this->doc_status($info['id'], 2));
                            $data['documentPermission'][]   = "Credit Application";
                        }
                        if ($uploads['w9'] == 1) {

                            $data['documents'][3]            = array('name' => 'w9', 'doc_number' => 3, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[3]), 'status' => $this->doc_status($info['id'], 3));
                            $data['documentPermission'][]   = "W9";
                        }
                        if ($uploads['hold_harmless_agreement'] == 1) {

                            $data['documents'][4]            = array('name' => 'hold_harmless_agreement', 'doc_number' => 4, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[4]), 'status' => $this->doc_status($info['id'], 4));
                            $data['documentPermission'][]   = "Hold Harmless Agreement";
                        }
                        if ($uploads['transparency'] == 1) {

                            $data['documents'][5]            = array('name' => 'transparency', 'doc_number' => 5, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[5]), 'status' => $this->doc_status($info['id'], 5));
                            $data['documentPermission'][]   = "Transparency Survey";
                        }
                        if ($uploads['onboarding'] == 1) {

                            $data['documents'][6]            = array('name' => 'onboarding', 'doc_number' => 6, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[6]), 'status' => $this->doc_status($info['id'], 6));
                            $data['documentPermission'][]   = "Onboarding";
                        }
                        if ($uploads['certificate_liability_insurance'] == 1) {

                            $data['certificate_liability_insurance'] = array('certificate_liability_insurance' => 1, 'doc_number' => 7, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[7]), 'status' => $this->doc_status($info['id'], 7));
                        }
                        if ($uploads['msds'] == 1) {

                            $data['msds']                   = array('msds' => 1, 'doc_number' => 8, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[8]), 'status' => $this->doc_status($info['id'], 8));
                        }
                        if ($uploads['specification_sheet'] == 1) {

                            $data['specification_sheet']    = array('specification_sheet' => 1, 'doc_number' => 9, 'document_path' => base_url("/assets/save_pdf_form/" . $arrDocument[9]), 'status' => $this->doc_status($info['id'], 9));
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
                    //sahu code end here    
                    // print_r($data); die;
                                     
					$this->load->view('templates/header');
					$this->load->view('upload_documentation_demo',$data);
					$this->load->view('templates/footer');
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
	            "Authorization: Bearer p3cqyV21JtUM4Acqc4oaXAMSZoMPWK1DQeWlU5yw"
	        ));

	        $response = json_decode(curl_exec($ch));
	        curl_close($ch);

	        return $response->items;
	    }		
		
		public function dashboard() {
			$info = $this->session->userdata('logged_in');
				 if ($this->usersession->logged_in)
				{
					if($info['role']==1){ 
					$this->load->view('templates/header');
					$this->load->view('dashboard');
					$this->load->view('templates/footer');
					 }
					else
					{
					redirect('Userfrontend/account_dashboard');
					}
				}
				else
				{
					redirect('user');
				}
				   
			
		}
	
		public function reset_password() {
					$this->load->view('templates/header');
					$this->load->view('reset_password');
					$this->load->view('templates/footer');
			
		}

		public function forget_password() {
		           if(isset($_POST['forget_password']))
				{
					//echo'ad';
	
 				$this->form_validation->set_rules('email_id', 'Email Address', 'valid_email|required|callback_check_emailid_present');
			
				}
				if ($this->form_validation->run() == FALSE)
				   {
				
					$this->load->view('templates/loginheader');
					$this->load->view('forget_password');
					$this->load->view('templates/footer');
					}
				else
				{
				
				    $email = $this->input->post('email_id');
					
					$password['pass']=$this->UserModel->forget_password($email);	
					$temp_type='forget';
					$mail_status=$this->sendMail($password['pass'],$email,$temp_type);
					
					//var_dump($mail_status);
					
				     if(!$mail_status)
					 {
					 $this->session->set_flashdata('delete_message_changes', 'E-mail sent successfully.');
					 redirect('user/forget_password');
					 
					}
				
					
					$this->load->view('templates/loginheader');
					$this->load->view('forget_password');
					$this->load->view('templates/footer');
			
		}
		}
		  public function check_emailid_present($email_id)
			 {
				
				 	$this->db->select('*');
					$this->db->from('user');
					$this->db->where('email_address', $email_id );
					$query = $this->db->get();
					
						if ($query->num_rows()== 0)
							{
								/*$this->form_validation->set_message('check_emailid_present', 'dgfdfgdfg');
								return FALSE;*/
								$this->form_validation->set_message('check_emailid_present', 'This email id is not registered.');
								return FALSE;
							}
							else
							{
								return TRUE;
							}
				
				
			 }
	
	
		//Add new vendor
		public function register() {
			
                    if (!$this->usersession->logged_in) {
                        redirect('user');
                    }
		
                    if($this->session->userdata('register')) {
                            $this->session->unset_userdata('register');

                    }
		
                    if(isset($_POST['register'])) {

                        $this->form_validation->set_rules('companynamecheck', 'Company Name', 'required|callback_customAlpha');


                        $this->form_validation->set_message('customAlpha', 'This field may only contain characters or numbers.');
                        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');

                        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');

                        $this->form_validation->set_rules('officenum', 'Office Number', 'numeric|min_length[10]|max_length[10]');

                        $this->form_validation->set_rules('faxnum', 'Fax Number', 'numeric|min_length[10]|max_length[10]');
                        $this->form_validation->set_rules('phonenum', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
                        $this->form_validation->set_rules('zipcode', 'Zip Code', 'required|numeric|min_length[5]|max_length[6]');
                        $this->form_validation->set_rules('emailaddress', 'Email Address', 'required|valid_email|is_unique[user.email_address]');
                        $this->form_validation->set_rules('password', 'Password', 'required');

                        $this->form_validation->set_rules('altfirstname', 'First Name', 'required|alpha');
                        $this->form_validation->set_rules('altlastname', 'Last Name', 'required|alpha');
                        $this->form_validation->set_rules('altphonenum', 'Office Number', 'required|numeric|min_length[10]|max_length[10]');
                        $this->form_validation->set_rules('altemailadd', 'Email Address', 'valid_email');
                    }

                    if ($this->form_validation->run() == FALSE) {
                        $this->load->view('templates/header');
                        $this->load->view('register');
                        $this->load->view('templates/footer');
                    } else {
				
                        $info = array();
                        //primary contact
                        $info['comp_name']  = $this->input->post('companynamecheck');
                        $info['first_name'] = $this->input->post('firstname');
                        $info['last_name']  = $this->input->post('lastname');
                        $info['office_num'] = $this->input->post('officenum');
                        $info['phone_num']  = $this->input->post('phonenum');
                        $info['fax_num']    = $this->input->post('faxnum');
                        $info['address']    = $this->input->post('address');
                        $info['city']       = $this->input->post('city');
                        $info['state']      = $this->input->post('state');
                        $info['zip']        = $this->input->post('zipcode');
                        $info['web']        = $this->input->post('webaddress');
                        $info['email']      = $this->input->post('emailaddress');
                        $info['password']   = $this->input->post('password');

                        //secondary contact
                        $info['first_name_alt']  = $this->input->post('altfirstname');
                        $info['last_name_alt']   = $this->input->post('altlastname');
                        $info['phone_alt']       = $this->input->post('altphonenum');
                        $info['emailalt']       = $this->input->post('altemailadd');

                        $temp_type='register';
                        $this->sendMail($info['password'],$info['email'],$temp_type);
                        $this->UserModel->register($info);
                    }
   		}
		// callback function
                public function customAlpha($str) {
                    if ( !preg_match('/[a-zA-Z0-9,]+/',$str) ) {
                        return false;
                    } else {
                        return true;
                    }
                }
		 
		 /**function alpha123($str)
			{
			$this->form_validation->set_message('alpha123', 'This field may only contain characters.');
		    return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
			}*/ 
		 
		 
		//Edit vendor
		public function edit($id) {
		
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
			                $this->db->select('*');
					$this->db->from('user');
					$this->db->where('id', $id);
					$query = $this->db->get();
		
					foreach ($query->result() as $row)
					{	
						$data = array();
						$data['id'] = $row->id;
						$data['comp_name'] = $row->comp_name;
                                                
                                              
						
					}
		
			if(isset($_POST['update']))
				{
					
				$this->form_validation->set_rules('companynamecheck', 'Company Name', 'required|callback_customAlpha');
				$this->form_validation->set_message('customAlpha', 'This field may only contain characters or numbers.');
				
				$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
				$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
				$this->form_validation->set_rules('officenum', 'Office Number', 'numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('faxnum', 'Fax Number', 'numeric');
				$this->form_validation->set_rules('phonenum', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('zipcode', 'Zip Code', 'required|numeric');
				$this->form_validation->set_rules('emailaddress', 'Email Address', 'required|valid_email|callback_check_existing_email');
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('altfirstname', 'First Name', 'required|alpha_numeric');
				$this->form_validation->set_rules('altlastname', 'Last Name', 'required|alpha_numeric');
				$this->form_validation->set_rules('altphonenum', 'Office Number', 'required|numeric');
                                $this->form_validation->set_rules('altemailadd', 'Email Address', 'valid_email');
				}
                                  if(empty($data))
                                                {
                                                  $this->session->set_flashdata('delete_message', 'No vendor record found.');
				                  redirect( 'user/dashboard','refresh' );
                                                }
				if ($this->form_validation->run() == FALSE)
				   {
                                    
					   
					$this->load->view('templates/header');
					$this->load->view('register',$data);
					$this->load->view('templates/footer');
					}
				else{
			       // $rid = $_GET['rid'];
					$this->UserModel->edit_vendor($id);	
				
				}
				
				
   		 }
                 
                 
                 //Edit Admin
		public function adminedit($id) {
		
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
			                $this->db->select('*');
					$this->db->from('user');
					$this->db->where('id', $id);
					$query = $this->db->get();
		
					foreach ($query->result() as $row)
					{	
						$data = array();
						$data['id'] = $row->id;
						$data['comp_name'] = $row->comp_name;
                                                
                                              
						
					}
		
			if(isset($_POST['update']))
				{
					
				$this->form_validation->set_rules('companynamecheck', 'Company Name', 'required|callback_customAlpha');
				$this->form_validation->set_message('customAlpha', 'This field may only contain characters or numbers.');
				
				$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
				$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
				$this->form_validation->set_rules('officenum', 'Office Number', 'numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('faxnum', 'Fax Number', 'numeric');
				$this->form_validation->set_rules('phonenum', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('zipcode', 'Zip Code', 'required|numeric');
				$this->form_validation->set_rules('emailaddress', 'Email Address', 'valid_email|callback_check_existing_email');
				$this->form_validation->set_rules('password', 'Password', 'required');
//				$this->form_validation->set_rules('altfirstname', 'First Name', 'required|alpha_numeric');
//				$this->form_validation->set_rules('altlastname', 'Last Name', 'required|alpha_numeric');
//				$this->form_validation->set_rules('altphonenum', 'Office Number', 'required|numeric');
//                                $this->form_validation->set_rules('altemailadd', 'Email Address', 'valid_email');
				}
                                  if(empty($data))
                                                {
                                                  $this->session->set_flashdata('delete_message', 'No vendor record found.');
				                  redirect( 'user/dashboard','refresh' );
                                                }
				if ($this->form_validation->run() == FALSE)
				   {
                                    
					   
					$this->load->view('templates/header');
					$this->load->view('register',$data);
					$this->load->view('templates/footer');
					}
				else{
			       // $rid = $_GET['rid'];
					$this->UserModel->edit_admin($id);	
				
				}
				
				
   		 }
		 
		 public function check_existing_email()
			 {
				 if(isset($_POST['update']))
				{
				$id = $this->uri->segment(3);
				
				 	$this->db->select('*');
					$this->db->from('user');
					$this->db->where('id!=', $id );
					$query = $this->db->get();
					/*echo "<pre>";
					print_r($query->result());
					exit;*/
						$i = 0;
						foreach($query->result() as $row)
						{
							$existing_email = $row->email_address;
							
							if($existing_email != $this->input->post('emailaddress'))
							{
								
								if($query->num_rows() == $i)
								 {
									 return true;
									 }
									 else{ $i++;}
								}
								else
								{
									$this->form_validation->set_message('check_existing_email', 'Email address field must contain a unique value.');
									return false;
									}
						}
		 
				 }
			 }
		 
		 public function delete($id)
			 {
				
				$deleteuser = "delete from user where id=".$id;
				$this->db->query($deleteuser);
				
                                $deletedownload_docs = "delete from download_docs where u_id=".$id;
				$this->db->query($deletedownload_docs);
                                
                                 $deleteuploaded_docs = "delete from uploaded_docs where u_id=".$id;
				$this->db->query($deleteuploaded_docs);
				
				$this->session->set_flashdata('delete_message', 'Vendor has been deleted successfully.');
				redirect( 'user/dashboard','refresh' );
					
			 }
			 

		 public function required_documentation() {
			
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
                                if(!empty($this->session->userdata['register']['edit_id'])){
                                $edit_id=$this->session->userdata['register']['edit_id'];
                                                            $query = $this->db->query("select * from user where id=$edit_id");
                                                            if ($query->num_rows() == 0)
                                                            {
                                                                 $this->session->set_flashdata('delete_message', 'No vendor record found.');
                                                                 redirect( 'user/dashboard','refresh' );
                                                            }
                  }
			
			if(empty($this->session->userdata['register']['edit_id']))
							{
								$this->session->set_flashdata('error_message', 'Account information should be filled first.');
								redirect('user/register','refresh');
								//exit;
							}
							elseif(isset($_POST['required']))
								{
                                                            
                                                            
                                                            
                                                            
							
							$checkedbox = array();
							//primary contact
							$checkedbox['certificate']    = $this->input->post('insurance');
							$checkedbox['credit']         = $this->input->post('creditapp');
							$checkedbox['hold_harmless']  = $this->input->post('agreement');
							$checkedbox['msds']           = $this->input->post('msds');
							
							$checkedbox['nda']           = $this->input->post('nda');
							
							$checkedbox['request']        = $this->input->post('requestForm');
							$checkedbox['spec_sheet']     = $this->input->post('specification');
							$checkedbox['w9']             = $this->input->post('w9');
				$checkedbox['tranparency']    = $this->input->post('tranparency');
				$checkedbox['onboarding']     = $this->input->post('onboarding');
				$checkedbox['resellers']     = $this->input->post('resellers');
							
												
							$this->UserModel->add_required_doc($checkedbox);	
									}
							else{
								$this->load->view('templates/header');
								$this->load->view('required_documentation');
								$this->load->view('templates/footer');
							}
		}
	
		 
		//Edit uploded doc
		public function edit_required_doc($eid) {
		
			if (!$this->usersession->logged_in)
				{
				redirect('user');
				}
		
		if(isset($_POST['edit_required']))
				{
				//$eid = $_GET['ed'];
				$this->UserModel->edit_req_doc($eid);	
				}
					
				else{
					
			        $this->db->select('*');
					$this->db->from('uploaded_docs');
					$this->db->where('u_id', $eid);
					$query = $this->db->get();
		
					foreach ($query->result() as $row)
					{	
						$data = array();
						$data['doc_id'] = $row->up_doc_id;
						$data['credit'] = $row->credit_application;
						$data['libility'] = $row->certificate_liability_insurance;
						$data['hold_harmless'] = $row->hold_harmless_agreement;
						$data['msds'] = $row->msds;
						$data['nda'] = $row->nda;
						
						$data['new_vendor'] = $row->new_vendor_request_form;
						$data['sp_sheet'] = $row->specification_sheet;
						$data['w9'] = $row->w9;
						$data['tranparency'] = $row->tranparency;
						$data['onboarding'] = $row->onboarding;
						$data['resellers'] = $row->resellers;
						
						
					
					$this->load->view('templates/header');
					$this->load->view('required_documentation',$data);
					$this->load->view('templates/footer');
					}
				}
				
   		 }
		 
		 //Reset password
		 public function reset_pass()
			 {
				 
			 if(isset($_POST['reset_pass']))
				{
					$this->form_validation->set_rules('newpassword', 'New Password', 'required');
				    $this->form_validation->set_rules('verifypassword', ' Verify Password', 'required|matches[newpassword]');
				}	
					if ($this->form_validation->run() == FALSE)
				   {
					$this->load->view('templates/header');
					$this->load->view('reset_password');
					$this->load->view('templates/footer');
					}
				else
				{
				$reset = $_GET['id'];
				$this->UserModel->reset_password($reset);
				}
					
			 }
                         
                         function sendMail($pass,$email,$temp_type)
                            {
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

                          
								$userEmail=$email;
								$subject='Vendor Portal ';
								   $this->load->library('email');
									$this->email->set_newline("\r\n");
								   
										$this->email->from($this->adminemail());
										
										$this->email->to($userEmail);  // replace it with receiver mail id
									        $this->email->subject($subject); // replace it with relevant subject
                                                                                if($temp_type=='forget'){
                                                                                      $user_details=array('email'=>$email,'password'=>$pass);
                                                                                        $body = $this->load->view('mail_templates/forgot_password',$user_details,TRUE);
                                                                                    }
										if($temp_type=='register')
										{
										
										$user_details=array('email'=>$email,'password'=>$pass);
										$body = $this->load->view('mail_templates/new_register',$user_details,TRUE);
										}
										$this->email->message($body);  
										$this->email->send();
										 if($this->email->send())
										 {
											return true;
											
										 }else
										 {
										 return false;
										 }

                            }
                             public function holdharmlessagreement() {
                                  $this->db->select('*');
                                  $this->db->from('uploaded_docs');
                                  $this->db->join('user', 'user.id=uploaded_docs.u_id');
                                  
                                  $get_hold_document_status=  $this->db->get();
                            
                                  foreach ($get_hold_document_status->result() as $vales) {
                                    
                                      if($vales->hold_harmless_agreement==1)
                                      { 
                                       /*echo '<pre>';
                                       print_r($vales);
                                       echo '</pre>';*/
                                       if($vales->mailchk!=2){
                                           $this->db->select('*');
                                           $this->db->from('download_docs');
                                           $this->db->where('download_docs.doc_number',3);
                                            $this->db->where('download_docs.u_id',$vales->u_id);
                                           $doc=$this->db->get();
                                           $doc_details=$doc->row();
                                          // print_r($doc_details);
                                           if(!isset($doc_details)):
                                           //echo $vales->email_address;
                                           // $modify_date1=$val->modify_date;
                                           $now =  strtotime(date("Y-m-d")) ; // or your date as well
                                            $your_modify_date1 = strtotime($vales->modify_date);
                                            $datediff1 = $your_modify_date1-$now;
                                            $days_remain1 = floor($datediff1 / (60 * 60 * 24));
                                           echo'seven day over'.$days_remain1;
                                            if($days_remain1==-7)
                                            { 
                                               echo 'seven day over';
                                                $expirty_type1='hold_harmless_agreement';
                                                $document_name1='Hold Harmless Agreement';
                                                $this->sendMailExpire($document_name1, $vales, $expirty_type1, $days_remain1);
                                               	 $data = array('mailchk' =>2);
                                                $this->db->where('uploaded_docs.u_id', $vales->u_id);
                                                $this->db->update('uploaded_docs', $data);
                                            }
                                            
                                           
                                           endif;
                                           
                                      }
                                      }
                                    
                                  }
                                  
                                 
                                  
                            }
                             public function nda() {
                                  $this->db->select('*');
                                  $this->db->from('uploaded_docs');
                                  $this->db->join('user', 'user.id=uploaded_docs.u_id');
                                  
                                  $get_hold_document_status=  $this->db->get();
                            
                                  foreach ($get_hold_document_status->result() as $vales) {
                                    
                                      if($vales->hold_harmless_agreement==1)
                                      { 
                                       /*echo '<pre>';
                                       print_r($vales);
                                       echo '</pre>';*/
                                       if($vales->mailchk!=2){
                                           $this->db->select('*');
                                           $this->db->from('download_docs');
                                           $this->db->where('download_docs.doc_number',8);
                                            $this->db->where('download_docs.u_id',$vales->u_id);
                                           $doc=$this->db->get();
                                           $doc_details=$doc->row();
                                          // print_r($doc_details);
                                           if(!isset($doc_details)):
                                           //echo $vales->email_address;
                                           // $modify_date1=$val->modify_date;
                                           $now =  strtotime(date("Y-m-d")) ; // or your date as well
                                            $your_modify_date1 = strtotime($vales->modify_date);
                                            $datediff1 = $your_modify_date1-$now;
                                            $days_remain1 = floor($datediff1 / (60 * 60 * 24));
                                           echo'seven day over'.$days_remain1;
                                            if($days_remain1==-7)
                                            { 
                                               echo 'seven day over';
                                                $expirty_type1='nda';
                                                $document_name1='NDA';
                                                $this->sendMailExpire($document_name1, $vales, $expirty_type1, $days_remain1);
                                               	 $data = array('mailchk' =>2);
                                                $this->db->where('uploaded_docs.u_id', $vales->u_id);
                                                $this->db->update('uploaded_docs', $data);
                                            }
                                            
                                           
                                           endif;
                                           
                                      }
                                      }
                                    
                                  }
                                  
                                 
                                  
                            }
                            
                            
                                                    function documentExpiration() {
                                                        $this->holdharmlessagreement();
                                                        $this->nda();

                                $this->db->select('*');
                                $this->db->from('download_docs');
                                $this->db->join('user', 'user.id=download_docs.u_id');
                                $this->db->order_by('down_doc_id', 'Desc');
                                $get_all_document = $this->db->get();
//                                echo '<pre>';
//                                print_r($get_all_document->result());
//                                echo '</pre>';
                                foreach ($get_all_document->result() as $single_document) {
                                    
                                 
                                    if($single_document->expr_date!=NULL){
                                    if($single_document->status!=3 ):
                                    $today = date("Y-m-d");
                                    $today_date = strtotime($today);
                                    $expire_date = strtotime($single_document->expr_date);
                                    
                                     
                                    
                                     
                                    
                                    
                                    if ($today_date >= $expire_date) {
                                        $data = array('status' => 3);
                                        $this->db->where('down_doc_id', $single_document->down_doc_id);
                                        $this->db->update('download_docs', $data);


                                        switch ($single_document->doc_number) {
                                            case 1:

                                                $document_name = 'Certificate of Liability Insurance';
                                                break;
                                            case 2:
                                                $document_name = 'Credit Application';

                                                break;
                                            case 3:
                                                $document_name = 'Hold Harmless Agreement';

                                                break;
                                            case 4:

                                                $document_name = 'MSDS';
                                                break;
                                            case 5:
                                                $document_name = 'New Vendor Request Form';

                                                break;
                                            case 6:

                                                $document_name = 'Specifications Sheet';
                                                break;
                                            case 7:

                                                $document_name = 'W9';
                                                break;
                                                case 8:

                                                $document_name = 'NDA';
                                                break;
                                                case 9:

                       					$document_name = 'Transparency Survey Form';
                       					break;
                       					case 10:

                       					$document_name = 'Onboarding';
                       					break;
                       					case 11:

                       					$document_name = 'Resellers Certificate';
                       					break;
                                        }
                                        $expirty_type = 'expiry';
                                        $days_remain = 0;
                                        $this->sendMailExpire($document_name, $single_document, $expirty_type, $days_remain);
                                        $this->sendMailExpire_admin($document_name, $single_document, $expirty_type, $days_remain);
                                    }

                                    if ($today_date < $expire_date) {
                                        switch ($single_document->doc_number) {
                                            case 1:

                                                $document_name = 'Certificate of Liability Insurance';
                                                break;
                                            case 2:
                                                $document_name = 'Credit Application';

                                                break;
                                            case 3:
                                                $document_name = 'Hold Harmless Agreement';

                                                break;
                                            case 4:

                                                $document_name = 'MSDS';
                                                break;
                                            case 5:
                                                $document_name = 'New Vendor Request Form';

                                                break;
                                            case 6:

                                                $document_name = 'Specifications Sheet';
                                                break;
                                            case 7:

                                                $document_name = 'W9';
                                                break;
                                                case 8:

                                                $document_name = 'NDA';
                                                break;
                                                 case 9:

                       					$document_name = 'Transparency Survey Form';
                       					break;
                       					case 10:

                       					$document_name = 'Onboarding';
                       					break;
                       					case 11:

                       					$document_name = 'Resellers Certificate';
                       					break;
                                        }
                                        
                                       
                                        $now =  strtotime(date("Y-m-d")) ; // or your date as well
                                       // print_r($now);
                                      // echo date("Y-m-d");
                                     //   echo $single_document->expr_date;
                                        $your_date = strtotime($single_document->expr_date);
                                        $datediff = $your_date-$now;
                                        $days_remain = floor($datediff / (60 * 60 * 24));
                                       // echo'document name'.$single_document->u_id.'<br>';
                                      //  echo'document name'.$document_name.'<br>';
                                      //   echo'remainig day'.$days_remain.'<br>';
                                         if($single_document->before_day!=2){
                                         if( $single_document->seven_day!=2){
                                            
                                        if ($days_remain==60 || $days_remain==30) {
                                            
                                            if($days_remain==60)
                                            {
                                            
                                                $data = array('seven_day' =>2);
                                                $this->db->where('down_doc_id', $single_document->down_doc_id);
                                                $this->db->update('download_docs', $data);
                                            }else{
                                            echo'30';
                                                $data = array('before_day' => 2);
                                                $this->db->where('down_doc_id', $single_document->down_doc_id);
                                                $this->db->update('download_docs', $data);
                                            }
                                            $expirty_type = 'notyetexpiry';
                                            $this->sendMailExpire($document_name, $single_document, $expirty_type, $days_remain);
                                             $this->sendMailExpire_admin($document_name, $single_document, $expirty_type, $days_remain);
                                         }
                                             }
                                            
                                        }
                                        
                                    }
                                    endif;
                                }  else {
                                    
                                    $this->db->select('*,LEAST(`GeneralLiability`,`AutomobileLiability`,`UmbrellaLiability`,`WorkersCompensation`) as expr_date');
                                    $this->db->from('download_docs');
                                     $this->db->where('down_doc_id', $single_document->down_doc_id);
                                    $get_all_document_finest_date = $this->db->get();
                                    $single_date=$get_all_document_finest_date->row();
                                    
                                    if($single_date->expr_date!=NULL){
                                    $this->db->select('*');
                                    $this->db->from('user');
                                    $this->db->where('id',$single_date->u_id);
                                    $detail=$this->db->get();
                                    $user_detail=$detail->row();
                                    
                                    
                                    
                                    if($single_date->status!=3):
                                    $today = date("Y-m-d");
                                    $today_date = strtotime($today);
                                    $expire_date = strtotime($single_date->expr_date);
                                    $single_document->expr_date=$single_date->expr_date;
                                    
                                    
                                    
                                    // echo 'doc id'. $single_date->down_doc_id.'<br>';
                                    // echo 'titl'. $single_date->doc_title.'<br>';
                                   //  echo 'today'.$today_date.'<br>';
                                 //  echo'expirey'.$expire_date.'<br>';
                                    
                                    
                                    if ($today_date >= $expire_date) {
                                        $data = array('status' => 3);
                                        $this->db->where('down_doc_id', $single_date->down_doc_id);
                                        $this->db->update('download_docs', $data);


                                        switch ($single_date->doc_number) {
                                            case 1:

                                                $document_name = 'Certificate of Liability Insurance';
                                                break;
                                            case 2:
                                                $document_name = 'Credit Application';

                                                break;
                                            case 3:
                                                $document_name = 'Hold Harmless Agreement';

                                                break;
                                            case 4:

                                                $document_name = 'MSDS';
                                                break;
                                            case 5:
                                                $document_name = 'New Vendor Request Form';

                                                break;
                                            case 6:

                                                $document_name = 'Specifications Sheet';
                                                break;
                                            case 7:

                                                $document_name = 'W9';
                                                break;
                                                case 8:

                                                $document_name = 'NDA';
                                                break;
                                                 case 9:

                       					$document_name = 'Transparency Survey Form';
                       					break;
                       					case 10:

                       					$document_name = 'Onboarding';
                       					break;
                       					case 11:

                       					$document_name = 'Resellers Certificate';
                       					break;
                                        }
                                        $expirty_type = 'expiry';
                                        $days_remain = 0;
                                       // $this->sendMailExpire($document_name, $single_document, $expirty_type, $days_remain);
                                        
                                        $this->sendMailExpireCoi($document_name, $single_document, $expirty_type, $days_remain);
                                         $this->sendMailExpire_admin($document_name, $single_document, $expirty_type, $days_remain);
                                    }

                                    if ($today_date < $expire_date) {
                                        switch ($single_date->doc_number) {
                                            case 1:

                                                $document_name = 'Certificate of Liability Insurance';
                                                break;
                                            case 2:
                                                $document_name = 'Credit Application';

                                                break;
                                            case 3:
                                                $document_name = 'Hold Harmless Agreement';

                                                break;
                                            case 4:

                                                $document_name = 'MSDS';
                                                break;
                                            case 5:
                                                $document_name = 'New Vendor Request Form';

                                                break;
                                            case 6:

                                                $document_name = 'Specifications Sheet';
                                                break;
                                            case 7:

                                                $document_name = 'W9';
                                                break;
                                                case 8:

                                                $document_name = 'NDA';
                                                break;
                                                 case 9:

                       					$document_name = 'Transparency Survey Form';
                       					break;
                       					case 10:

                       					$document_name = 'Onboarding';
                       					break;
                       					case 11:

                       					$document_name = 'Resellers Certificate';
                       					break;
                                        }
                                        $now =  strtotime(date("Y-m-d")) ; // or your date as well
                                     //   echo'now'. $now.'<br>';
                                        $your_date = $expire_date;
                                      //  echo'ex'. $your_date.'<br/>';
                                        $datediff = $your_date-$now;
                                        $days_remain = floor($datediff / (60 * 60 * 24));
                                       // echo $days_remain;
                                      //   echo'remainig day'.$days_remain.'<br>';
                                         if($single_date->before_day!=2){
                                         if($single_date->seven_day!=2){
                                             
                                        if ($days_remain==28 || $days_remain==14) {
                                            
                                            if($days_remain==28)
                                            {
                                           
                                                $data = array('seven_day' =>2);
                                                $this->db->where('down_doc_id', $single_date->down_doc_id);
                                                $this->db->update('download_docs', $data);
                                            }else{
                                               
                                                $data = array('before_day' => 2);
                                                $this->db->where('down_doc_id', $single_date->down_doc_id);
                                                $this->db->update('download_docs', $data);
                                            }
                                            $expirty_type = 'notyetexpiry';
                                            //$this->sendMailExpire($document_name, $single_document, $expirty_type, $days_remain);
                                             $this->sendMailExpireCoi($document_name, $single_document, $expirty_type, $days_remain);
                                            
                                             $this->sendMailExpire_admin($document_name, $single_document, $expirty_type, $days_remain);
                                         }
                                             }
                                            }
                                        
                                        
                                    }
                                    endif;
                                   
                                    }
                                    
                                }
                                    
                                 
                                }
                                
                                
                                
                                
                            }
                            
                             function sendMailExpireCoi($document_name,$userdetails,$expiry_type,$days)
                            {
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

                          
								//$userEmail=$email;
                                                                if($expiry_type=='expiry'){
								$subject='Notification:Document Expiration ';
                                                                }
                                                                    
                                                                else{
                                                                    $subject='Notification: Document Expiration Date';
                                                                }
								   $this->load->library('email');
									$this->email->set_newline("\r\n");
								   
										$this->email->from($this->adminemail());
										
                                                                                $admin=$this->adminemail();
                                                                              //  echo $userdetails->email_address;
										$this->email->to($userdetails->email_address,$admin);  // replace it with receiver mail id
									        $this->email->subject($subject); // replace it with relevant subject
                                                                              
                                                                                if ($expiry_type =='expiry') {
                                                                                    $user_details = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                    $body = $this->load->view('mail_templates/VendorPortalCOIExpiredEmailLetter', $user_details, TRUE);
                                                                                }
                                                                              
                                                                                else {
                                                                                    $user_details_second = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date, 'days_remain' => $days,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                   
                                                                                   // print_r($user_details_second);
                                                                                    $body = $this->load->view('mail_templates/VendorPortalCOIRenewalEmailLetter', $user_details_second, TRUE);
                                                                                }


                                                                               // print_r($body);
                                                                                $this->email->message($body);  
										 $sendma=$this->email->send();
										 if($sendma==1)
										 {
											return true;
											
										 }else
										 {
										 return false;
										 }

                            }

                            function sendMailExpire($document_name,$userdetails,$expiry_type,$days)
                            {
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

                          
								//$userEmail=$email;
                                                                if($expiry_type=='expiry'){
								$subject='Notification:Document Expiration ';
                                                                }
                                                                    elseif ($expiry_type=='hold_harmless_agreement') {
                                                                        $subject='Notification:Hold Harmless Agreement Not Uploaded Yet ';
                                                                   }
                                                                    elseif ($expiry_type=='nda') {
                                                                        $subject='Notification:NDA Not Uploaded Yet ';
                                                                   }
                                                                else{
                                                                    $subject='Notification: Document Expiration Date';
                                                                }
								   $this->load->library('email');
									$this->email->set_newline("\r\n");
								   
										$this->email->from($this->adminemail());
										
                                                                                $admin=$this->adminemail();
										$this->email->to($userdetails->email_address,$admin);  // replace it with receiver mail id
									        $this->email->subject($subject); // replace it with relevant subject
                                                                              
                                                                                if ($expiry_type =='expiry') {
                                                                                    $user_details = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date);
                                                                                    $body = $this->load->view('mail_templates/document_expiry_date', $user_details, TRUE);
                                                                                }
                                                                                elseif($expiry_type=='hold_harmless_agreement'){
                                                                                     $user_details_third= array('document_name' => $document_name, 'expiry_date' => $userdetails->modify_date, 'days_remain' => $days,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                    $body = $this->load->view('mail_templates/hold_harmless_agreement', $user_details_third, TRUE);
                                                                                }
                                                                                elseif($expiry_type=='nda'){
                                                                                     $user_details_third= array('document_name' => $document_name, 'expiry_date' => $userdetails->modify_date, 'days_remain' => $days,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                    $body = $this->load->view('mail_templates/nda', $user_details_third, TRUE);
                                                                                }
                                                                                
                                                                                else {
                                                                                    $user_details_second = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date, 'days_remain' => $days);
                                                                                    $body = $this->load->view('mail_templates/document_expiry_date_before', $user_details_second, TRUE);
                                                                                }



                                                                                $this->email->message($body);  
										$docex=$this->email->send();
                                                                                
										 if($docex==1)
										 {
											return true;
											
										 }else
										 {
										 return false;
										 }

                            }
                            
                            
                             function sendMailExpire_admin($document_name,$userdetails,$expiry_type,$days)
                            {
                                 
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

                          
								//$userEmail=$email;
                                                                if($expiry_type=='expiry'){
								$subject='Notification:Document Expiration ';
                                                                }
                                                                else{
                                                                    $subject='Notification: Document Expiration Date';
                                                                }
								   $this->load->library('email');
									$this->email->set_newline("\r\n");
								   
										$this->email->from($this->adminemail());
										
                                                                                $admin=$this->adminemail();
										$this->email->to($admin);  // replace it with receiver mail id
									        $this->email->subject($subject); // replace it with relevant subject
                                                                              
                                                                                if ($expiry_type =='expiry') {
                                                                                    $user_details = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                    $body = $this->load->view('mail_templates/document_expiry_date_admin', $user_details, TRUE);
                                                                                } else {
                                                                                    $user_details_second = array('document_name' => $document_name, 'expiry_date' => $userdetails->expr_date, 'days_remain' => $days,'first_name'=>$userdetails->first_name,'last_name'=>$userdetails->last_name);
                                                                                    $body = $this->load->view('mail_templates/document_expiry_date_before_admin', $user_details_second, TRUE);
                                                                                }



                                                                                $this->email->message($body);  
										$this->email->send();
										 if($this->email->send())
										 {
											return true;
											
										 }else
										 {
										 return false;
										 }

                            }
                            
                            
	function doument_is_allready_uploaded($user_id,$doc_number,$file_name)
    {
        
 
            $this->db->where('u_id',$user_id);
            $this->db->where('doc_number',$doc_number);
            $q = $this->db->get('download_docs');
			$this->db->set('upload_type',2);
            if ( $q->num_rows() > 0 ) 
            {
               // $data = array('doc_title' => $file_name);
               $this->db->set('doc_title', $file_name);
			   $this->db->set('status',2);
			   
			   $this->db->set('seven_day',0);
               $this->db->set('before_day',0);
               $this->db->where('doc_number',$doc_number);
               $this->db->where('u_id',$user_id);
               $this->db->update('download_docs');
            } else {
                $this->db->set('u_id', $user_id);
			    $this->db->set('doc_title', $file_name);
                $this->db->set('status',2);
                $this->db->set('doc_number', $doc_number);
                $this->db->insert('download_docs');

         }
    }
          function sendMailAdmin($userdetail)
                            {
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
                                                

                                                
                                   
								$subject=' Vendor Portal: New Document Uploaded';
                                                               
                                                                
								   $this->load->library('email');
									$this->email->set_newline("\r\n");
								   
										$this->email->from($this->adminemail());
										
										$this->email->to($this->adminemail());  // replace it with receiver mail id
									        $this->email->subject($subject); // replace it with relevant subject
                                                                              
                                                                                
                                                                                    
                                                                                    $body = $this->load->view('mail_templates/document_uploaded', $userdetail, TRUE);
                                                                               



                                                                                $this->email->message($body);  
										$this->email->send();
										 if($this->email->send())
										 {
											return true;
											
										 }else
										 {
										 return false;
										 }

                            }                   
    function move_upload_file_dest()
    {
        
        
         //$_POST['number'];
        //get document number
         
        $document_number=$_POST['number'];
          $info = $this->session->userdata('logged_in');
         //get user_id
          $userid=$this->session->userdata['register']['edit_id'];
        $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'assets/';
        //echo $destination_path;
         $file = explode(".", $_FILES["file"]["name"]);
         //print_r($file);
        $extensions = array("pdf");        
            if(in_array($file[1],$extensions )=== false){
                 $error='Only PDF is allowed.';
            }
			if ($_FILES["file"]["size"] >= 2000000) {
				 $error='Max file size limit is 2MB.';
				//$uploadOk = 0;
			} 
       
         if(empty($error)==true){
        $date = new DateTime();
        $additional_variable = $date->getTimestamp();

        $file_name = $file[0] . $additional_variable . '.' . $file[1];

        $target_path = $destination_path . basename($file_name);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
            
        $this->doument_is_allready_uploaded($userid,$document_number,$file_name);
             
         $this->session->set_flashdata('error_message', 'File uploaded successfully.');
         
         switch ($document_number) {
                                            case 1:

                                                $document_name = 'Certificate of Liability Insurance';
                                                break;
                                            case 2:
                                                $document_name = 'Credit Application';

                                                break;
                                            case 3:
                                                $document_name = 'Hold Harmless Agreement';

                                                break;
                                            case 4:

                                                $document_name = 'MSDS';
                                                break;
                                            case 5:
                                                $document_name = 'New Vendor Request Form';

                                                break;
                                            case 6:

                                                $document_name = 'Specifications Sheet';
                                                break;
                                            case 7:

                                                $document_name = 'W9';
                                                break;
                                            case 8:

                                                $document_name = 'NDA';
                                                break;
                                                 case 9:

                       					$document_name = 'Transparency Survey Form';
                       					break;
                       					case 10:

                       					$document_name = 'Onboarding';
                       					break;
                       					case 11:

                       					$document_name = 'Resellers Certificate';
                       					break;
                                        }
          
             $userdetail=array('documentname'=>$document_name,'username'=>$info['fname'].' '.$info['lname']);
           $this->sendMailAdmin($userdetail);
                 
      
        }else{
          
            $this->session->set_flashdata('error_message', $error);
        }
        
        
    }

    
     public function adminemail() {
        
        $this->db->select('email_address');
        $this->db->from('user');
        $this->db->where('role',1);
        
        $q=$this->db->get();
        $e = $q->row();
        
        return $e->email_address;
    }
     public function ndaa() {


		if (!$this->usersession->logged_in)
			{
				redirect('user');
			}

		if($this->session->userdata('nda'))
			{
				$this->session->unset_userdata('nda');

			}

		if(isset($_POST['nda']))
			{
				$this->form_validation->set_rules('name', 'Name', 'required|alpha');
				$this->form_validation->set_rules('phone', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
									    	}
		if ($this->form_validation->run() == FALSE)
				{
				    $this->load->view('templates/header');
				   	$this->load->view('nda');
					$this->load->view('templates/footer');

				}
				else
				{

				$info = array();

				$info['name'] = $this->input->post('name');
				$info['phone']  = $this->input->post('phone');
				$info['address'] = $this->input->post('address');
				$info['city']      = $this->input->post('city');

				$this->UserModel->credit_agreement($info);	

				}

				}
}