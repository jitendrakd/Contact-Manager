<?php
class Contact_model extends CI_Model {

        public function crudContact($contact)
		{ 
			$this->db->where('user_id',$this->session->userdata('user_id')); 
			if($query=$this->db->get('contact_list'))
			  {  
				$dataReturn = $query->result_array();
			  }
			  else{
				$dataReturn = false;
			  }
			$this->db->where('contact_primary_phone',$contact['contact_primary_phone']);
			$q = $this->db->get('contact_list');

			if ( $q->num_rows() > 0 )
			{
			$this->db->where('contact_primary_phone',$contact['contact_primary_phone']);
			$this->db->update('contact_list',$contact);
			$this->db->where('user_id',$this->session->userdata('user_id')); 
			return $dataReturn;
			} else {
			$this->db->insert('contact_list', $contact);
			$this->db->where('user_id',$this->session->userdata('user_id')); 
			 return $dataReturn;
			}
		}
		
		public function getContact()
		{
			$this->db->where('user_id',$this->session->userdata('user_id')); 
			if($query=$this->db->get('contact_list'))
			  { 
				return $query->result_array();
			  }
			  else{
				return false;
			  }
		}
		
		public function shareContact($dataArray)
		{
			$this->db->from('contact_list');
			$this->db->where('contact_id',$dataArray['shared_contact_id']);
			$query=$this->db->get();
			$shareContact = $query->result_array();
			$shareContact[0]['share_from'] = $this->session->userdata('user_id');
			$shareContact[0]['share_to'] = $dataArray['share_id_to'];
			unset($shareContact[0]['contact_id']);
			unset($shareContact[0]['user_id']);
			$this->db->insert('shared_contacts',$shareContact[0]);
			return true;
		}
		
		public function getContacttoExport($contact_id)
		{
			$this->db->from('contact_list');
			$this->db->where('contact_id',$contact_id);
			$query=$this->db->get();
			return $query->result_array();
		}
}