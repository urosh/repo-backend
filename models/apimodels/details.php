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
class Details extends CI_Model
{
	
	function __construct(){
		parent::__construct();
		$ci =& get_instance();
	}
	
	function getObjectType($docID) {

		$this->db->where('docID', $docID);
		$query = $this->db->get('images');
		if ($query->num_rows() == 1)	return 'images';
		
		$this->db->where('docID', $docID);
		$query = $this->db->get('pdf');
		if($query->num_rows == 1) return 'pdf';
		
		$this->db->where('docID', $docID);
		$query = $this->db->get('x3d');
		if($query->num_rows == 1) return 'x3d';

		$this->db->where('docID', $docID);
		$query = $this->db->get('videos');
		if($query->num_rows == 1) return 'videos';

	
	}

	function getObjectDetails($docID){
		$type=$this->getObjectType($docID);
		$this->load->model('apimodels/metadata');

		$data=array();
		$data['metadataExist']=false;
		$data['metadataList']=array();
		$data['id']=$docID;
		$data['imLocation']="";
		$data['imageWidth'] = "";
		$data['imageHeight'] = "";
		$data['annotations'] = array();
		
		$this->db->where('source', $docID);
		$query = $this->db->get('annotations');

		foreach ($query->result() as $row) {
    	$coordinates = explode(',',$row->coordinates);

    	$data['annotations'][] = array(
    		'title' => $row->title, 
    		"description" => $row->description, 
    		"coordinates" => array(
    			'top' => $coordinates[0], 
    			'left' => $coordinates[1], 
    			'width' => $coordinates[2], 
    			'height' => $coordinates[3]
    			)
    		) ;
    }

    if($this->tank_auth->is_logged_in()){
			$data['loged']=TRUE;
		}else{
			$data['loged']=FALSE;
		}

		$this->db->where('docID', $docID);
		$query = $this->db->get($type);
		$data['objectType']=$type;
		$row = $query->row();
		$data['collection'] = $row->collection;
		$data['location'] = $row->location;
		if($type == 'images'){
			$data['imageWidth'] = $row->width;
			$data['imageHeight'] = $row->height;
		}else{
			$data['imageWidth'] = $row->imageWidth;
			$data['imageHeight'] = $row->imageHeight;
		}
		
		/* Pdf */
		if($type=='pdf'){
			
			$arr=array("docID"=>$row->docID,"fileLocation"=>$row->fileLocation,"location"=>$row->location,"imageLocation"=>$row->imageLocation,"width"=>$row->imageWidth,"height"=>$row->imageHeight,"collection"=>$row->collection,"objectType"=>"pdf","metadataLocation"=>$row->metadataLocation);
			
			$data['title']=$row->label;
			if (strpos($row->imageLocation, "starcRepo")===false){
				$data['imLocation']=str_replace(".jpg","_600.JPG",$row->imageLocation);
				$data['fileLocation']=$row->fileLocation;
			}else{
				//image is in new repository
				$data['imLocation']=str_replace(".","_450.",$row->imageLocation);
				$data['fileLocation']=$row->fileLocation;
			}			
			$metadataFile=$row->metadataLocation;
			if(file_exists($metadataFile)){
				$data['metadataExist']=true;
				$data['metadataList']=$this->metadata->getMetadata($metadataFile,$row->collection);
			}
		}
		/* Images */
		if($type=='images'){
			$arr=array("docID"=>$row->docID,"fileLocation"=>$row->fileLocation,"location"=>$row->location,"width"=>$row->width,"height"=>$row->height,"collection"=>$row->collection,"label"=>$row->label,"objectType"=>"images","metadataLocation"=>$row->metadataLocation);
			$data['objectType']="images";
			$data['title']=$row->label;
			
			if (strpos($row->fileLocation, "starcRepo")===false){
				if($row->location=="local"){
					$data['imLocation']=str_replace(".jpg","_600.JPG",$row->fileLocation);
					$data['fileLocation']=$data['imLocation'];
				}else{
					$data['imLocation']=$row->fileLocation;
					$data['fileLocation']=$row->fileLocation;
				}
			}else{
				if($row->location=="local"){
					$data['imLocation']=str_replace(".","_450.",$row->fileLocation);
					$data['fileLocation']=$data['imLocation'];
				}else{
					$data['imLocation']=$row->fileLocation;
					$data['fileLocation']=$row->fileLocation;
				}
			}
				
			$metadataFile=$row->metadataLocation;
			if(file_exists($metadataFile)){
				$data['metadataExist']=true;
				$data['metadataList']=$this->metadata->getMetadata($metadataFile,$row->collection);
			}
			
		}
		/* X3D */
		if($type=='x3d'){
			$arr=array("docID"=>$row->docID,"fileLocation"=>$row->fileLocation,"location"=>$row->location,"imageLocation"=>$row->imageLocation,"width"=>$row->imageWidth,"height"=>$row->imageHeight,"collection"=>$row->collection,"objectType"=>"x3d","metadataLocation"=>$row->metadataLocation);
			$data['title']=$row->label;
			$data['docID']=$row->docID;
			$data['imageLocation']=str_replace(".","_450.",$row->imageLocation);
			$data['fileLocation']=$row->fileLocation;
			$metadataFile=$row->metadataLocation;
			if(file_exists($metadataFile)){
				$data['metadataExist']=true;
				$data['metadataList']=$this->metadata->getMetadata($metadataFile,$row->collection);
			}
			//$data['fileLocation']="";
		}
		/* Videos */
		if($type == 'videos') {
			$data['title']='some title';
			$data['docID']=$row->docID;
			$data['imageLocation']=str_replace(".","_450.",$row->imageLocation);
			$metadataFile='/home/uros/starcRepo/db/metadata/d1e672aa06ae7ea468b86164b03443c1.xml';
			if(file_exists($metadataFile)){
				$data['metadataExist']=true;
				$data['metadataList']=$this->getMetadata($metadataFile,'The church of Ayia Marina in Dherinia, Terrestrial laser scanning');
			}
			$data['fileLocation']="";

		}
		



		return $data;
	
	}
	
	
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */