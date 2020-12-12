<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){

        parent::__construct();
  			$this->load->helper('url');
  	 		$this->load->model('user_model');
  	 		$this->load->model('Contact_model');
			$this->load->library(array('session', 'Vcard'));
			
	}
	public function index()
	{ 
	    $this->load->view("signup.php");
	}
	
	
	public function register_user(){

      $user=array(
      'user_name'=>$this->input->post('user_name'),
      'user_email'=>$this->input->post('user_email'),
      'user_password'=>md5($this->input->post('user_password')) 
        );
       
	$email_check=$this->user_model->email_check($user['user_email']);
  
	if($email_check){
	  $this->user_model->register_user($user);
	  $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
	  redirect('login_view');

	}
	else{

	  $this->session->set_flashdata('error_msg', 'Email already exits,Try again.');
	  $this->load->view("signup.php");

	}
	}
	
	
	public function login_view(){

	$this->load->view("login.php");

	}

	public function login_user(){ 
	  $user_login=array(

	  'user_email'=>$this->input->post('user_email'),
	  'user_password'=>md5($this->input->post('user_password'))

		); 
	 
		$data['users']=$this->user_model->login_user($user_login);
		   
			$this->session->set_userdata('user_id',$data['users'][0]['user_id']);
			$this->session->set_userdata('user_email',$data['users'][0]['user_email']);
			$this->session->set_userdata('user_name',$data['users'][0]['user_name']);
			  
			if(empty($data)){
			$this->session->set_flashdata('error_msg', 'Invalid Credentails,Try again.');
			redirect('login_view');
			}else{
				redirect('contact_list');
			}
			// $this->load->view('login.php',$data);
 
	}
	
	public function contact_list()
	{
		$data['contacts']=$this->Contact_model->getContact();
		$data['allUsers']=$this->user_model->allUsers(); 
		$data['shareContact']=$this->user_model->shareContact(); 
		$this->load->view('contact_list.php',$data);
	}
	
	public function user_logout(){

	  $this->session->sess_destroy();
	  redirect('login_view', 'refresh');
	}
	
	public function crudContact()
	{
		$contact=array(
      'contact_first_name'=>$this->input->post('contact_first_name'),
      'contact_middle_name'=>$this->input->post('contact_middle_name'),
      'contact_last_name'=>$this->input->post('contact_last_name'), 
      'contact_primary_phone'=>$this->input->post('contact_primary_phone'), 
      'contact_secondary_phone'=>$this->input->post('contact_secondary_phone'), 
      'contact_email'=>$this->input->post('contact_email'), 
      'contact_image'=>$this->input->post('contact_image'),
	  'user_id'=> $this->session->userdata('user_id')
        );
		 
		$data['contacts']=$this->Contact_model->crudContact($contact);
		$data['allUsers']=$this->user_model->allUsers();
		$data['shareContact']=$this->user_model->shareContact(); 
		
		if($data){
		$this->session->set_flashdata('success_msg', 'Contact Created Successfully.');
		$this->load->view('contact_list.php',$data);
		}else{
		$this->session->set_flashdata('error_msg', 'No Contacts found.');
		redirect('contact_list');
		}
	}
	
	public function shareContact()
	{
		$dataArray = array(
		"share_id_to" => $this->input->post('share_id_to'),
		"shared_contact_id" => $this->input->post('shared_contact')
		);
		$data['shareContacts'] = $this->Contact_model->shareContact($dataArray);
		redirect('contact_list');
	}
	

	public function linkvcard()
    {
        $contact_id = $this->input->post('contact_id');
        $datavcard = $this->getvcard($contact_id);
        //var_dump($datavcard);
        if (is_array($datavcard))
        {    
		print_R($datavcard);
            $this->Vcard->Vcard($datavcard);
        }
        else
        {
            $this->Vcard->Vcard();
            
        }
        $this->Vcard->zipdownload();
    }     

    public function getvcard($contact_id)
    {
        $datavcarddata = array();
        
		$datavcarddata = $this->Contact_model->getContacttoExport($contact_id);
       

        return $datavcarddata;
    } 
	
	
}
