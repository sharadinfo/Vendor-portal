<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct()
       {
            parent::__construct();
			//$this->load->model('UserModel');
                        
                          //print_r( $this->session->userdata('logged_in'));
                   // echo  is_logged_in();
                      
                           
                            
                      
			
       }
       
       
       /*public function index() {
           
           
           $this->db->select('*');
           $this->db->from('user');
		 //  $this->db->from('user');
		   $this->db->order_by("id","desc");
           
           $all_user=$this->db->get();
            if (!empty($all_user)) {
            echo json_encode($all_user->result());
        } else {
            return FALSE;
        }
           
       }*/
	   
	   /*override the index function to get the status*/
	   public function index()
	   {
	   //$all_data=array();
	   $this->db->select('*');
	   $this->db->from('user');
	   $this->db->where('role !=',1);
	   $this->db->order_by('id','desc');
	   
	   $all_user_with_status=$this->db->get();
	   foreach($all_user_with_status->result_array() as $single_user)
	   {
	   

	   $single_user['status']=$this->get_user_status($single_user['id']);
	
	   $all_data[]=$single_user;
	   
	   }
//	   echo '<pre>';
//	   print_r($all_data);
//	   echo '</pre>';
           
	    if (!empty($all_data)) {
            echo json_encode($all_data);
        } else {
            return FALSE;
        }
	   
	   }
	   
	     public function get_user_status($user_id)
	   {
	   /*
	   
	   $this->db->select('status');
	   $this->db->from('download_docs');
	   $this->db->where('u_id',$user_id);
	   
	   $all_get_status=$this->db->get();
	   
	   $all_status=$all_get_status->result();
	   if(!empty($all_status)){
	   foreach($all_status as $single_status)
	   {
            if($single_status->status==2 || $single_status->status==3)
				{
				  return  $the_final_status=1;
				  
				}
				
		}
	
			}else
			{
			return $the_final_status=1;
			}
                        */
                           /*change the logic of company status*/
                      
                            $this->db->select('credit_application,certificate_liability_insurance,hold_harmless_agreement,msds,nda,new_vendor_request_form,specification_sheet,w9,transparency,onboarding,resellers');
                            $this->db->from('uploaded_docs');
                            $this->db->where('u_id',$user_id);

                            $all_get=$this->db->get();

                            $all=$all_get->result();
                          
                     //print_r($all);
                            if(!empty($all)){
                            //if(!empty($all-> credit_application)|| !empty($all->certificate_liability_insurance) ||!empty($all->hold_harmless_agreement) || !empty($all->msds) || !empty($all->new_vendor_request_form)||!empty($all->specification_sheet)||!empty($all->w9)){
                            
                            
                            foreach ($all  as  $value ) {
                                
                               
                          
                                
                                if(isset($value->credit_application))
                                {
                                    $doc['one']=$this->docnumberstatus($user_id,2);
                                            
                                }
                                 if(isset($value->certificate_liability_insurance))
                                {
                                    $doc['two']=$this->docnumberstatus($user_id,1);
                                }
                                 if(isset($value->hold_harmless_agreement))
                                {
                                    $doc['three']=$this->docnumberstatus($user_id,3);
                                }
                                 if(isset($value->msds))
                                {
                                   $doc['four']=$this->docnumberstatus($user_id,4);
                                } if(isset($value->new_vendor_request_form))
                                {
                                    $doc['five']=$this->docnumberstatus($user_id,5);
                                }
                                 if(isset($value->specification_sheet))
                                {
                                   $doc['six']= $this->docnumberstatus($user_id,6);
                                }
                                 if(isset($value->w9))
                                {
                                   $doc['seven']= $this->docnumberstatus($user_id,7);
                                }
                                if(isset($value->nda))
                                {
                                   $doc['eight']= $this->docnumberstatus($user_id,8);
                                }
                                if(isset($value->transparency))
                                {
                                   $doc['nine']= $this->docnumberstatus($user_id,9);
                                }
                                if(isset($value->foodsafety))
                                {
                                   $doc['ten']= $this->docnumberstatus($user_id,10);
                                }
                                if(isset($value->resellers))
                                {
                                   $doc['ten']= $this->docnumberstatus($user_id,11);
                                }
                                if(empty($value-> credit_application) && empty($value->certificate_liability_insurance) && empty($value->hold_harmless_agreement) && empty($value->msds) && empty($value->nda) && empty($value->new_vendor_request_form) && empty($value->specification_sheet) && empty($value->w9)&& empty($value->transparency) && empty($value->foodsafety) && empty($value->resellers))
                                {
                                    $doc=array();
                                }
                                
                            }
                            
                            
                           //print_r($doc);
                            if(!empty($doc)){
                                if(count(array_unique($doc)) == 1 &&  end($doc) ==1) {
                                    
                                    //echo 'ya ya';
                                    return 1;

                                    }  else {
                                  //     echo 'no';
                                        return 0;    
                                    }
                                
//                             foreach($doc as  $value)
//                            {
//                                 
//                                if($value==2 || $value==3 || $value==4 )
//                                {
//                                    echo 'ga ga';
//                                    $final= 0;
//                                }
//                                else
//                                {
//                                    $final= 1;
//                                }
//                                
//                              
//                            }
//                             return $final;
                              
                            }else{
                                $final=0;
                                return $final;
                            }
                            }else{
                                $final=0;
                           return $final; 
                            }

                           //  print_r($final); 
 	   
	   }
	   
	   
	   
	   
	   
	   /**/
       
           
           public function docnumberstatus($user_id,$doc_id)
           {
               
            //   $this->db->query("select * from download_docs where u_id=$user_id AND doc_number=$doc_id");
               
               $this->db->select('*');
               $this->db->from('download_docs');
               $this->db->where('u_id',$user_id);
               $this->db->where('doc_number',$doc_id);
               
               $result=$this->db->get()->result_array();
               
               if(empty($result)){
                   
                   return 4;
                   
               }  else {
                   
                   foreach ($result as $value) {
               
                     return  $value['status'];
                       
                   }
               
                   
               }
               
               //return $final_status;
               
           }


         /*  public function createcsv()
               
       {
           
           $getvendors = json_decode(file_get_contents('php://input'), true);
         
           if(!empty($getvendors)){
               $final_result_csv[] = array('Company Name', 'First Name', 'Last Name','Office Number','Cell Number','Fax Number','Address','City','State','Zip Code','Web Address','Email-id','Alertnative First Name','Alertnative Last Name'
					,'Alernative Phone Number','Alernative Email-id');
           foreach ($getvendors as $vendor) {

                 $this->db->select('*');
                 $this->db->from('user');
                 $this->db->where('id',$vendor);
				 $this->db->order_by('id','desc');
                 $vendor_details=$this->db->get();
			
					
                    foreach ($vendor_details->result() as $row) {
                   
                        $each=array("$row->comp_name","$row->first_name","$row->last_name","$row->office_num","$row->phone_num","$row->fax_num","$row->address","$row->city",
						"$row->state","$row->zip_code","$row->web_address","$row->email_address","$row->first_name_alt","$row->last_name_alt","$row->phone_alt","$row->email_alt");
                        $final_result_csv[]=$each;
                    }
             }
			 
			 
             
                $list = $final_result_csv;

               $fp = fopen('file.csv', 'w');

               foreach ($list as $fields) {

                   fputcsv($fp, $fields);
               }

               fclose($fp);
               
           }
           else
           {
               
               
               
                 $this->db->select('*');
                 $this->db->from('user');
                  $this->db->where('role !=',1);
				 $this->db->order_by('id','desc');
                
                 $vendor_details=$this->db->get();
				 $final_result_csv[] = array('Company Name', 'First Name', 'Last Name','Office Number','Cell Number','Fax Number','Address','City','State','Zip Code','Web Address','Email-id','Alertnative First Name','Alertnative Last Name'
					,'Alernative Phone Number','Alernative Email-id');
                
                    foreach ($vendor_details->result() as $row) {
                   
                       $each=array("$row->comp_name","$row->first_name","$row->last_name","$row->office_num","$row->phone_num","$row->fax_num","$row->address","$row->city",
						"$row->state","$row->zip_code","$row->web_address","$row->email_address","$row->first_name_alt","$row->last_name_alt","$row->phone_alt","$row->email_alt");
                        $final_result_csv[]=$each;
                    }
                    $list = $final_result_csv;

               $fp = fopen('file.csv', 'w');

               foreach ($list as $fields) {

                   fputcsv($fp, $fields);
               }

               fclose($fp);
               
           }
           

       }*/
       public function createcsv()
               
       {
           
           $getvendors = json_decode(file_get_contents('php://input'), true);
         
           if(!empty($getvendors)){
               $final_result_csv[] = array('Company Name', 'First Name', 'Last Name','Office Number','Mobile Number','Fax Number','Address','State','City','Zip Code','Web Address','Email Address','Password','Secondary First Name','Secondary Last Name'
					,'Secondary Office Number','Secondary Email Address');
           foreach ($getvendors as $vendor) {

                 $this->db->select('*');
                 $this->db->from('user');
                 $this->db->where('id',$vendor);
				 $this->db->order_by('id','desc');
                 $vendor_details=$this->db->get();
			
					
                    foreach ($vendor_details->result() as $row) {
                   
                        $each=array("$row->comp_name","$row->first_name","$row->last_name","$row->office_num","$row->phone_num","$row->fax_num","$row->address","$row->state","$row->city",
						"$row->zip_code","$row->web_address","$row->email_address","$row->plain_password","$row->first_name_alt","$row->last_name_alt","$row->phone_alt","$row->email_alt");
                        $final_result_csv[]=$each;
                    }
             }
			 
			 
             
                $list = $final_result_csv;

               $fp = fopen('file.csv', 'w');

               foreach ($list as $fields) {

                   fputcsv($fp, $fields);
               }

               fclose($fp);
               
           }
           else
           {
               
               
               
                 $this->db->select('*');
                 $this->db->from('user');
                  $this->db->where('role !=',1);
				 $this->db->order_by('id','desc');
                
                 $vendor_details=$this->db->get();
				$final_result_csv[] = array('Company Name', 'First Name', 'Last Name','Office Number','Mobile Number','Fax Number','Address','State','City','Zip Code','Web Address','Email Address','Password','Secondary First Name','Secondary Last Name'
					,'Secondary Office Number','Secondary Email Address');
                
                    foreach ($vendor_details->result() as $row) {
                   
                         $each=array("$row->comp_name","$row->first_name","$row->last_name","$row->office_num","$row->phone_num","$row->fax_num","$row->address","$row->state","$row->city",
						"$row->zip_code","$row->web_address","$row->email_address","$row->plain_password","$row->first_name_alt","$row->last_name_alt","$row->phone_alt","$row->email_alt");
                         $final_result_csv[]=$each;
                    }
                    $list = $final_result_csv;

               $fp = fopen('file.csv', 'w');

               foreach ($list as $fields) {

                   fputcsv($fp, $fields);
               }

               fclose($fp);
               
           }
           

       }
}