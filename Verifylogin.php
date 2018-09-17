<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verifylogin extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   
 }
 
 function index()
 {
   //This method will have the credentials validation
  // $this->load->library('form_validation');
  // echo'sdf';
   $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
   $this->form_validation->set_rules('email', 'Email', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
	
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
                $this->load->view('templates/loginheader');
                $this->load->view('login');
                $this->load->view('templates/footer');
   }
   else
   {
	   if($this->session->userdata['logged_in']['role'] == 0)
	   {
		redirect('userfrontend/account_information', 'refresh');
		   
		}else{
     //Go to private area
     redirect('user/dashboard', 'refresh');
		}
   }
 
 }
 
 function check_database($password)
 {
 $this->load->model('Verifyloginmodel','',TRUE);
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('email');
   
   $remember_me = $this->input->post('remember_me');
	if(isset($remember_me))
	{
	     setcookie("username", $username, time()+(60*60*1));
         setcookie("password", $password, time()+(60*60*1));  
	} 
	
	//echo $_COOKIE['username'];
	//exit();
   //query the database
   $result = $this->Verifyloginmodel->login($username, $password);
 
   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
        'id' => $row->id,
        'username' => $row->email_address,
        'role'     => $row->role,
        'fname' => $row->first_name,
        'lname' => $row->last_name
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password.');
     return false;
   }
 }
 
 
    function logout() {

        $this->session->unset_userdata('logged_in');
        redirect('/user', 'refresh'); 
    }
}
?>
