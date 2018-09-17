<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadeddocument extends CI_Controller {

//    public function index() {
//         $user_id=  $this->session->userdata['register']['edit_id'];
//         //print_r($user_id);
//        $this->db->select('*');
//        $this->db->from('download_docs');
//         $this->db->where('u_id',$user_id);
//        $uploaded_doc = $this->db->get();
//
//        
//        if (!empty($uploaded_doc)) {
//            echo json_encode($uploaded_doc->result());
//        } else {
//            return FALSE;
//        }
//    }
    
    
       public function index() {
         $user_id=  $this->session->userdata['register']['edit_id'];
         //print_r($user_id);
        $this->db->select('*');
        $this->db->from('download_docs');
		//$this->db->from('uploaded_docs');
         $this->db->where('u_id',$user_id);
        $uploaded_docs = $this->db->get();

        $results=$uploaded_docs->result();
       
       
        
        foreach ($results as $uploaded_doc) {
            
            
              
           
            //$final_result[]=(array)$uploaded_doc;
            switch ($uploaded_doc->doc_number) {
                case 1:
                    
                    $uploaded_doc->status1=$this->doc_status('certificate_liability_insurance',$user_id);
                    
                    break;
                 case 2:
                     $uploaded_doc->status1=$this->doc_status('credit_application',$user_id);

                    break;
                 case 3:
                      $uploaded_doc->status1=$this->doc_status('hold_harmless_agreement',$user_id);

                    break; 
                case 4:
                    $uploaded_doc->status1=$this->doc_status('msds',$user_id);

                    break;
                 case 5:
                     $uploaded_doc->status1=$this->doc_status('new_vendor_request_form',$user_id);

                    break;
                 case 6:
                      $uploaded_doc->status1=$this->doc_status('specification_sheet',$user_id);

                    break;
                 case 7:

                     $uploaded_doc->status1=$this->doc_status('w9',$user_id);
                    break;
                      case 8:

                     $uploaded_doc->status1=$this->doc_status('nda',$user_id);
                    break;
                    case 9:

                     $uploaded_doc->status1=$this->doc_status('transparency',$user_id);
                    break;
                    case 10:

                     $uploaded_doc->status1=$this->doc_status('onboarding',$user_id);
                    break;
                    case 11:

                     $uploaded_doc->status1=$this->doc_status('resellers',$user_id);
                    break;
                
                default:
                    break;
            }
             $final_result[]=(array)$uploaded_doc;
            
           
            
        }
        
       
        
        if (!empty($final_result)) {
            echo json_encode($final_result);
        } else {
            return FALSE;
        }
    }
    
    
    public function doc_status($document_name,$user_id) {
        
        $this->db->select("$document_name");
        $this->db->from('uploaded_docs');
         $this->db->where('u_id',$user_id);
         $query = $this->db->get();
  
      if ( $query->num_rows() > 0 ) 
                    {
                    $uploaded_file_status = $query->row();
                     return $uploaded_file_status->$document_name;
                   }
        
    }
    
     public function change_status(){
            
                $postdata = json_decode(file_get_contents('php://input'), true);
                
                
                    if (isset($postdata['checkoxvalue']) && !empty($postdata['checkoxvalue'])) {
                 
                       if($postdata['dateandnote']['doc_number']==1){ 
                $postdata['dateandnote']['GeneralLiability'] =  $postdata['dateandnote']['GeneralLiability_old'];
                $postdata['dateandnote']['AutomobileLiability'] = $postdata['dateandnote']['AutomobileLiability_old'];
                $postdata['dateandnote']['UmbrellaLiability'] = $postdata['dateandnote']['UmbrellaLiability_old'];
                $postdata['dateandnote']['WorkersCompensation'] = $postdata['dateandnote']['WorkersCompensation_old'];
                       }else{
                $postdata['dateandnote']['expr_date'] = $postdata['dateandnote']['expr_date_old'];
                       }
                
                unset($postdata['dateandnote']['expr_date_old']);
                unset($postdata['dateandnote']['GeneralLiability_old']);
                unset($postdata['dateandnote']['AutomobileLiability_old']);
                unset($postdata['dateandnote']['UmbrellaLiability_old']);
                unset($postdata['dateandnote']['WorkersCompensation_old']);
                
                unset($postdata['dateandnote']['status1']);
               
                $this->db->where('down_doc_id', $postdata['dateandnote']['down_doc_id']);
                $this->db->where('doc_number', $postdata['dateandnote']['doc_number']);
                $this->db->update('download_docs', $postdata['dateandnote']);
                echo json_encode($postdata);
            } else {
                // $postdata['expr_date']=$postdata['expr_date_old'];
		   $postdata['dateandnote']['expr_date'] = NULL;
                   $postdata['dateandnote']['GeneralLiability'] = NULL;
                   $postdata['dateandnote']['AutomobileLiability'] = NULL;
                   $postdata['dateandnote']['UmbrellaLiability'] = NULL;
                   $postdata['dateandnote']['WorkersCompensation'] = NULL;
                unset($postdata['dateandnote']['expr_date_old']);
                unset($postdata['dateandnote']['GeneralLiability_old']);
                unset($postdata['dateandnote']['AutomobileLiability_old']);
                unset($postdata['dateandnote']['UmbrellaLiability_old']);
                unset($postdata['dateandnote']['WorkersCompensation_old']);
                
                unset($postdata['dateandnote']['status1']);
                 $this->db->where('down_doc_id', $postdata['dateandnote']['down_doc_id']);
                 $this->db->where('doc_number', $postdata['dateandnote']['doc_number']);
                $this->db->update('download_docs', $postdata['dateandnote']);
                echo json_encode($postdata);
            }
        }
}
