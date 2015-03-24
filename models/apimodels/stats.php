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
class Stats extends CI_Model
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
	

	function getStats(){
		$numberOfObjects = 0;
		$types = array(array('type'=> 'images', 'number' => 0), array('type'=>'pdf', 'number' => 0), array('type'=>'x3d', 'number'=>0));

		$collections = array();
		$personalCollections = array();
		$query = $this->db->get('generalCollections');
		foreach ($query->result() as $row)
		{
			$collections[] = array('collection' => $row->name, 'number'=>0);
			//$collections[$row->name]['number'] = 0;
		}	
		for($i = 0; $i<3; $i++){
			$query = $this->db->get($types[$i]['type']);
			foreach ($query->result() as $row)
			{
				$xmlFile=$row->metadataLocation;

				if($xmlFile){
					$types[$i]['number']++;
					$numberOfObjects++;
					for($j=0; $j<count($collections); $j++){
						if($collections[$j]['collection'] == $row->collection){
								$collections[$j]['number']++;
							
						}
					}	
				}
				
			}	
		}

		$query = $this->db->get('personalCollections');
		foreach ($query->result() as $row)
		{
			$perNumber = 0;
			$items = explode(',', $row->items);
			$perNumber = count($items);
			$personalCollections[] = array('name'=>$row->title, 'number'=>$perNumber);
		}	

		$numObj = array('numberOfObjects'=>$numberOfObjects, 'types'=>$types, 'collections'=>$collections, 'personal'=>$personalCollections);
		return $numObj;

		
	}


	function getTimeDistribution(){
		$collections = array();
		$results = array();
		$types = array('images', 'pdf', 'x3d');
		$query = $this->db->get('generalCollections');
		foreach ($query->result() as $row)
		{
			$collections[] = array('collection' => $row->name, 'number'=>0);
			//$collections[$row->name]['number'] = 0;
		}

		for($i = 0; $i<3; $i++){
			$query = $this->db->get($types[$i]);
			foreach ($query->result() as $row)
			{
				$xmlFile=$row->metadataLocation;
				$data = array();
				if($xmlFile){
					$results[] = array('time' => $row->creationDate, 'docID' => $row->docID);
				}
				
			}	
		}

		return $results;


	}

	

	
	
}
