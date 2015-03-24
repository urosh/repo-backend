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
class Ingest extends CI_Model
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
	function readInfo($xmlUrlLocation){

		

		$xmlLocation = $this->getFile($xmlUrlLocation, '/home/uros/starcRepo/db/ingestion_new.xml');
		
		$xml = simplexml_load_file($xmlLocation);
		
		$date = $xml->xpath('/Ingestion/date');
		$date = $date[0];
		
		$inst = $xml->xpath('/Ingestion/institution');
		$institution = (string) $inst[0];
		//echo $institution;
		
		
		$collections = $xml->xpath('/Ingestion/collections/collection');
		$collection = (string) $collections[0];
		
		$objects = $xml->xpath('//Ingestion/Objects/object');
		foreach ($objects as $object) {
			$this->saveObject($object, $collection, $institution, $date);
		}


	}

	function getFile($url, $newfilename){

		//$newfilename = '/home/uros/starcRepo/db/ingestion_new.xml';
		$url = htmlspecialchars_decode($url);
		$newfilename = htmlspecialchars_decode($newfilename);
		
		$file = fopen ($url, "rb");
  	if ($file) {
    	$newfile = fopen ($newfilename, "wb");

    	if ($newfile)
    	while(!feof($file)) {
      	fwrite($newfile, fread($file, 1024 * 8 ), 1024 * 8 );
    	}
  	}

	  if ($file) {
	    fclose($file);
	  }
	  if ($newfile) {
	    fclose($newfile);
	  }

	  return $newfilename;	
	}

	function saveObject($object, $collection, $institution, $date) {
		$data = array();
		$objType = 'images';
		$data['creationDate'] = date('Y-m-d H:i:s');
		$ID=uniqid(rand(),true);
		$data['docID']=md5($ID);
		$data['collection'] = $collection;
		$data['creator'] = $institution;
		$data['metadataSchema'] = 'vmust';
		$data['collection'] = 'K2R';
		$xmlLocation = '/home/uros/starcRepo/db/metadata/' . $data['docID'] .'.xml';
		$checkLocation = $this->getFile($object->location, $xmlLocation);
		$data['metadataLocation'] = $xmlLocation;
		
		$xml = simplexml_load_file($xmlLocation);

		$collections = $xml->xpath('//Ingestion/collections/collection');
		
		$lat = $xml->xpath('/vmust/HeritageAsset/Place/Geographical_information/Coordinates//y');
		$lng = $xml->xpath('/vmust/HeritageAsset/Place/Geographical_information/Coordinates//x');
		
		$data['lng'] =  (string) $lat[0];
		$data['lat'] =  (string) $lng[0];

		$label = $xml->xpath('/vmust/Name');
		$data['label'] = (string) $label[0];

		$objectType = $object->type;
		if($objectType == "x3d") {
			$data['location'] = 'url';
			
			$width = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/width');
			$data['imageWidth'] = (string) $width[0];
			
			$height = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/height');
			$data['imageHeight'] = (string) $height[0];
			$data['x3d'] = 'true';
			$fileLocation  = $xml->xpath('/vmust/DigitalAsset/X3d/path');
			$data['fileLocation'] = (string) $fileLocation[0];
			$thumbLocation = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/path');
			$data['imageLocation'] = (string) $thumbLocation[0];
			$this->db->insert('x3d', $data);
		}

		if($objectType == "image") {
			$objectType = "images";

			$data['location'] = 'url';
		
			$fileLocation = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/path');
			$data['fileLocation'] = (string) $fileLocation[0];
			
			$width = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/width');
			$data['width'] = (string) $width[0];
			
			$height = $xml->xpath('/vmust/DigitalAsset/Thumbnail_image/height');
			$data['height'] = (string) $height[0];
		
			$this->db->insert($objType, $data);

		}
	}




	
	
	
	
	
	

	
	
}