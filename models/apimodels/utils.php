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
class Utils extends CI_Model
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
	
	function getDetails($docID){
		$this->load->model('apimodels/details');
		$type = $this->details->getObjectType($docID);
		$this->db->where('docID', $docID);
		$query = $this->db->get($type);
		$row = $query->row();
		$xml = simplexml_load_file($row->metadataLocation);
		
		
		$xmlArray=array();
		$xmlArray=$this->XMLToArray($xml);
		//echo (string) $this->buf1[0];

		//print_r($this->buf1);
		//echo count($this->buf1[0][0][1]);
		
	}

	private $buf1 = array();
	private $depth = 0;
	function XMLToArray($xml) { 
		$return=array();
		
  	if ($xml instanceof SimpleXMLElement) { 
  		$children = $xml->children(); 
  		//$this->buf1[] = array();
   		$return = false; 
  	} 
  	
  	foreach ($children as $element => $value) { 
  		//echo (string) $element;
  		if ($value instanceof SimpleXMLElement) { 
  			$values = (array)$value->children();
  			//echo (string) $element . "--";
  			if (count($values) > 0) { 
  				//echo "++ ". (string) $element . " ++" . $this->depth . "|";
  				echo (string) $element . " -- ";

  				if($value!=""){
	      		//$this->addMetadataElement($element, (string)$value);
	      		//echo (string) $value . "-----";
	      	}
	      	//$this->buf1[] = (string) $element;

  				$return[$element] = $this->XMLToArray($value); 
  			}else{
  				if(!$value=="")	{
  					//print_r($this->buf1);
  					echo (string) $element . " -- ";
  					//echo "". (string) $element . " : " . (string) $value ."--";
  					//$this->buf1 = array();
  					
  				}
      		
      		if (!isset($return[$element])) { 
      			//$this->buf1[] = (string) $element;
        		$return[$element] = (string)$value; 
        		//echo "| " . $element . " |";
      		} 

  			}
  		}
  	}
	  
		if (is_array($return)) { 
	    return $return;
	  } else { 
	    return false; 
	  }  
	  	
	} 



	

	
	
}
