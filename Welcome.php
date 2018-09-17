<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        
    }

    function read_xls() {
        $getvendors = json_decode(file_get_contents('php://input'), true);


        $this->load->library('Excel_reader');


        // is_readable($filename);
        $ext = pathinfo($_FILES['file']['tmp_name'], PATHINFO_EXTENSION);
        $pathinfo = pathinfo($_FILES["file"]["name"]);
        if ($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls') {

            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            count($allDataInSheet);
            print_r($allDataInSheet);
            //exit();
            foreach ($allDataInSheet as $key => $singledata) {
                if ($key > 1) {
                    //$this->mail_exists($singledata['L']);
                    
                    //if($this->mail_exists($singledata['L'])=='true'){
                    
                    if(isset($singledata['L']))
                    {
                        $email_status=$this->mail_exists($singledata['L']);
                    }
                    if($email_status==FALSE)
                    {
                    if(isset($singledata['L'])){
                    $user['comp_name']=$singledata['A'] ? $singledata['A'] : NULL;
                    $user['first_name']=$singledata['B'] ? $singledata['B'] : NULL;
                    $user['last_name']=$singledata['C'] ? $singledata['C'] : NULL;
                    $user['office_num']=$singledata['D'] ? $singledata['D'] : NULL;
                    $user['phone_num']=$singledata['E'] ? $singledata['E'] : NULL;
                    $user['fax_num']=$singledata['F'] ? $singledata['F'] : NULL;
                    $user['address']=$singledata['G'] ? $singledata['G'] : NULL;
                    $user['state']=$singledata['H'] ? $singledata['H'] : NULL;
                    $user['city']=$singledata['I'] ? $singledata['I'] : NULL;
                    $user['zip_code']=$singledata['J'] ? $singledata['J'] : NULL;
                    $user['web_address']=$singledata['K'] ? $singledata['K'] : NULL;
                    $user['email_address']=$singledata['L'] ? $singledata['L'] : NULL;
                    $user['plain_password']=$singledata['M'] ? $singledata['M'] : NULL;
                    $user['password']=$singledata['M'] ? md5($singledata['M']) : NULL;
                    $user['first_name_alt']=$singledata['N'] ? $singledata['N'] : NULL;
                    $user['last_name_alt']=$singledata['O'] ? $singledata['O'] : NULL;
                    $user['phone_alt']=$singledata['P'] ? $singledata['P'] : NULL;
                    $user['email_alt']=$singledata['Q'] ? $singledata['Q'] : NULL;
                    $user['role'] = 0;
                    
                        $this->db->set($user);
                        $this->db->insert('user', $user);
                        $this->db->insert_id();
                        $this->session->set_flashdata('import_message', 'Record imported successfully.');
                        $temp_type = 'register';
                 
                        $this->sendMail($user['plain_password'], $user['email_address'], $temp_type);

                    }
                    }
                }
            }
        } else {

            $this->session->set_flashdata('import_message', 'Only .xlsx or .xls file format allowed.');
        }
    }

    function sendMail($pass, $email, $temp_type) {
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


        $userEmail = $email;
        $subject = 'Vendor Portal ';
        $this->load->library('email');
        $this->email->set_newline("\r\n");

        $this->email->from($this->adminemail());

        $this->email->to($userEmail);  // replace it with receiver mail id
        $this->email->subject($subject); // replace it with relevant subject
        if ($temp_type == 'forget') {
            $user_details = array('email' => $email, 'password' => $pass);
            $body = $this->load->view('mail_templates/forgot_password', $user_details, TRUE);
        }
        if ($temp_type == 'register') {

            $user_details = array('email' => $email, 'password' => $pass);
            $body = $this->load->view('mail_templates/new_register', $user_details, TRUE);
        }
        $this->email->message($body);
        $this->email->send();
        if ($this->email->send()) {
            return true;
        } else {
            return false;
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
    function mail_exists($key)
{
    $this->db->where('email_address',$key);
    $query = $this->db->get('user');
    if ($query->num_rows() > 0){
        return TRUE;
    }
    else{
        return FALSE;
    }
}

}
