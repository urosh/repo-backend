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
class Annotations extends CI_Model
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
	
	
	function save_annotation($data){
		
		$data['creationDate'] = date('Y-m-d H:i:s');
		$ID=uniqid(rand(),true);
		$data['docID']=md5($ID);
		if ($this->db->insert('annotations', $data)) {
			return json_encode(array('result' => 'success'));
		}
		return NULL;
		
	}	

	
	
	
}