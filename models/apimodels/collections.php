<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Collections extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
	}

	/**
	 * Get collection record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	
	function save_collection($data){
		
		$data['creationDate'] = date('Y-m-d H:i:s');
		$ID=uniqid(rand(),true);
		$data['docID']=md5($ID);
		
		if ($this->db->insert('personalCollections', $data)) {
			return 'success';
		}
		return NULL;
		
	}	

	
	
	
	public function get_collection_id($docID,$type){
		
		$this->db->where('docID', $docID);
		$query = $this->db->get('images');
		//echo $query->row()->collection."<br>";
		if ($query->num_rows() == 1) return $query->row()->collection;
		return NULL;
		//echo $type;
	}
	
	

	/**
	 * Get collection record by collection name
	 *
	 * @param	string
	 * @return	object
	 */
	function get_collection_by_name($name)
	{
		$this->db->where('LOWER(name)=', strtolower($name));

		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}
	
	
	/**
	 * Get collection record by creator
	 *
	 * @param	string
	 * @return	object
	 */
	function get_collection_by_creator($name)
	{
		$this->db->where('LOWER(creator)=', strtolower($name));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) return $query->row();
		return NULL;
	}

	/**
	 * Check if collection name is available 
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_name_available($name)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(name)=', strtolower($name));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	

	/**
	 * Create new user record
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_collection($data)
	{
		$data['created'] = date('Y-m-d H:i:s');
		

		if ($this->db->insert($this->table_name, $data)) {
			$collection_id = $this->db->insert_id();
			
			return array('collection_id' => $collection_id, 'collection_name' => $data['name']);
		}
		return NULL;
	}

	/**
	 * Delete collection
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_collection($collection_id)
	{
		$this->db->where('id', $collection_id);
		$this->db->delete($this->table_name);
		if ($this->db->affected_rows() > 0) {
			$this->delete_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	function getCollections()
	{
		$query = $this->db->get($this->table_name);
		//$schemasArray=array();
		foreach ($query->result() as $row)
		{
			$collectionsArray[$row->name]=$row;
			
		}
		if($query->num_rows()==0){
			$collectionsArray['no_schema']='No schema available';
		}
				
		return $collectionsArray;		
				
	}
	
	function getCollectionList()
	{
		$query = $this->db->get($this->table_name);
		//$schemasArray=array();
		foreach ($query->result() as $row)
		{
			$collectionsArray[$row->name]=$row->name;
			
		}
		if($query->num_rows()==0){
			$collectionsArray['no_schema']='No schema available';
		}
				
		return $collectionsArray;		
				
	}

	
	
}