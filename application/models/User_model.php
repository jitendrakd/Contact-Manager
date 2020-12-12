<?php
class User_model extends CI_model{
 
 
 
public function register_user($user){
  
$this->db->insert('users', $user);
 
}
 
public function login_user($user_login){
 //$email,$pass
 
  $this->db->select('*');
  $this->db->from('users');
  $this->db->where('user_email',$user_login['user_email']);
  $this->db->where('user_password',$user_login['user_password']);
 
	  if($query=$this->db->get())
	  {
		  
		return $query->result_array();
	  }
	  else{
		return false;
	  }
 
 
}

public function allUsers()
{
	$this->db->select('*');
	$this->db->from('users');
	// $this->db->where('user_id',$this->session->userdata('user_id'));
	$query=$this->db->get();
	return $query->result_array();
}

public function shareContact()
{
	$this->db->select('*');
	$this->db->from('shared_contacts');
	$this->db->where('share_to',$this->session->userdata('user_id'));
	$query=$this->db->get();
	return $query->result_array();
}

public function email_check($email){
 
  $this->db->select('*');
  $this->db->from('users');
  $this->db->where('user_email',$email);
  $query=$this->db->get();
 
  if($query->num_rows()>0){
    return false;
  }else{
    return true;
  }
 
}
 
 
}
 
 
?>