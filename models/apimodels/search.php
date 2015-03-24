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
class Search extends CI_Model
{
	
	private $metadataList=array();
	
	function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
	}
	
	//Get total number of objects. Inputs are $coll, array of collections that are selected by the user, $type: type of the object
	//pdf, images, x3d. 
	
	function getNumberOfObjects($coll,$type){
		$i=0;
		$where="";
    
    
		if(!empty($coll)){
				foreach ($coll as $collection){

					if($i==0)$where='(collection="'.$collection.'"';
					else $where.='or collection="'.$collection.'"';
					$i++;
					}
					$where.=')';
		}
		if(count($type)==0) $type = array('pdf', 'images', 'x3d');
      
    $totalNumberOfObjects = 0;
        
    foreach($type as $tp){
        if($where) $this->db->where($where);
        $query = $this->db->get($tp);
        foreach ($query->result() as $row)
        {
          $xmlFile=$row->metadataLocation;
            
          if($tp == 'images'){
             if($xmlFile && $row->collection!='The Church of Ayia Marina') $totalNumberOfObjects++;
         
          } else{
             if($xmlFile && !$row->imageLocation=="" && $row->collection!='The Church of Ayia Marina') $totalNumberOfObjects++;
        
          } 
        }
          
      }
      
    return $totalNumberOfObjects;
        
  }
	
	public function getCollectionList($typeArray){
		$collArray=array();
		if(empty($typeArray) || count($typeArray)==3){
			$query = $this->db->get('images');
			foreach ($query->result() as $row)
			{
				$add=true;
				foreach ($collArray as $el){
				
					if($el==$row->collection) $add=false;
				}
				if($add===true && $row->collection!='The Church of Ayia Marina')$collArray[]=$row->collection;
			}
			
			$query = $this->db->get('pdf');
			foreach ($query->result() as $row)
			{
				$add=true;
				foreach ($collArray as $el){
				
					if($el==$row->collection) $add=false;
				}
				if($add===true && $row->collection!='The Church of Ayia Marina')$collArray[]=$row->collection;
			}

			$query = $this->db->get('x3d');
			foreach ($query->result() as $row)
			{
				$add=true;
				foreach ($collArray as $el){
				
					if($el==$row->collection) $add=false;
				}
				if($add===true && $row->collection!='The Church of Ayia Marina') $collArray[]=$row->collection;
			}
			
		}else{
			$query = $this->db->get($typeArray[0]);
			foreach ($query->result() as $row)
			{
				$add=true;
				foreach ($collArray as $el){
				
					if($el==$row->collection) $add=false;
				}
				if($add===true && $row->collection!='The Church of Ayia Marina' )$collArray[]=$row->collection;
			}
			
		}
		
		
		return $collArray;	
	}
	
	
	
	
	public function getObjects($coll, $type, $currentPage, $perPage ){
		$tempResult = $this->getObjectsByTypeCollection($coll, $type); 
    $result = array();
    for($i=$currentPage; $i<($currentPage+$perPage);$i++){
        if(isset($tempResult[$i])){
            $result[]=$tempResult[$i];
        } 
    }
    return $result;
		
	}

  public function getObjectsByTypeCollection($collections, $types){
  		$i = 0;
  		$tempResult = array();
  		$where="";
		if(!empty($collections)){
			foreach ($collections as $collection){
				if($i==0)$where='(collection="'.$collection.'"';
					else $where.='or collection="'.$collection.'"';
				$i++;
			}
			$where.=')';
		}

		if(empty($types)){
       		$types=array('pdf', 'images', 'x3d');
     	}
     	foreach ($types as $tp){
         					  
		     switch (strtolower($tp)){
		       case "pdf":{
		          if($where) $this->db->where($where);
		          $query=$this->db->get("pdf");
		          foreach ($query->result() as $row)
		          { 
		            $xmlFile=$row->metadataLocation;
		            if($xmlFile && !$row->imageLocation=="" && $row->collection!='The Church of Ayia Marina'){
		            	
		              $arr=array("description"=>$row->description,"lat"=>$row->lat, "lng"=>$row->lng, "docID"=>$row->docID,"fileLocation"=>$row->fileLocation,"imageLocation"=>"http://public.cyi.ac.cy".$row->imageLocation,"width"=>$row->imageWidth,"height"=>$row->imageHeight,"collection"=>$row->collection,"label"=>$row->label,"type"=>"pdf", "location"=>"local");
		              $tempResult[]=$arr;
		            }
		      
		          }
		       }
		       break;
		       case "images":{
		          if($where) $this->db->where($where);
		          $query=$this->db->get("images");
		          foreach ($query->result() as $row)
		          {
		            $arr=array();
		            $xmlFile=$row->metadataLocation;
		            if ($xmlFile && $row->collection!='The Church of Ayia Marina'){
		            	if($row->location == "local") $imageLocation = "http://public.cyi.ac.cy".$row->fileLocation;
		            	else $imageLocation = $row->fileLocation;
		              $arr=array("description"=>$row->description,"lat"=>$row->lat, "lng"=>$row->lng,"docID"=>$row->docID,"imageLocation"=>$imageLocation,"width"=>$row->width,"height"=>$row->height,"collection"=>$row->collection,"label"=>$row->label, "location"=>$row->location,"type"=>"images");
		              $tempResult[]=$arr;
		            }
		      
		          }
		       }
		       break;
		       case "x3d":{
		         if($where) $this->db->where($where);
		          $query=$this->db->get("x3d");
		          foreach ($query->result() as $row)
		          { 
		            $xmlFile=$row->metadataLocation;
		            if($xmlFile && !$row->imageLocation=="" && $row->collection!='The Church of Ayia Marina'){
		            	
		              $arr=array("description"=>$row->description,"lat"=>$row->lat, "lng"=>$row->lng,"docID"=>$row->docID,"fileLocation"=>$row->fileLocation,"imageLocation"=>"http://public.cyi.ac.cy".$row->imageLocation,"width"=>$row->imageWidth,"height"=>$row->imageHeight,"collection"=>$row->collection,"label"=>$row->label,"type"=>"x3d");
		              $tempResult[]=$arr;
		            }
		      
		          }
		       }
		     }
     	}
     	return $tempResult;
  	}


  	function getObjectsByLocation($data, $location) {
  		$latSW = $location[0];
  		$lngSW = $location[1];
  		$latNE = $location[2];
  		$lngNE = $location[3];
  		$result = array();
  		if(empty($location)) {
  			return $data;
  		}else{
  			foreach($data as $object) {
  				if($object['lat'] > $latSW && $object['lat'] < $latNE && $object['lng'] > $lngSW && $object['lng'] < $lngNE){
  					$result[] = $object;
  				}
  			}

  			return $result;
  		}

  	}
  	public function searchObjects($query, $collections, $types, $location){
  		//first get collection wise and type wise, then apply query. 
  		$results = array();

  		$results = $this->getObjectsByTypeCollection($collections, $types);
  		$results = $this->getObjectsByLocation($results, $location);
  		//ok now i can apply query and calculate score of each object with 
  		//respect to the query 
  		$finalObjects = array();
  		foreach ($results as $item) {
  			# code...
  			//first search the label, if it is found, stop the xml, and assign high score, 
  			//it should go first. two types of scores. label score, and xml score. 

  			$height = $item['height'];

  			if($item['width'] > 0){
					$height = (100 / $item['width']) * $item['height'];
	
				}else{
					$height = 20;
				}
				$item['originalHeight'] = $item['height'];

				$item['height'] = $height;

  			if($item['type'] == 'pdf'){
  				$imageLocation = $item['imageLocation'];
					$pos = strpos($imageLocation, '/starcRepo/');

					if($pos === false){
						$imageLocation = str_replace(".jpg","_300.JPG",$imageLocation);
					}else{
						$imageLocation = str_replace(".jpg","_300.jpg",$imageLocation);
						
					}

					$item['imageLocation'] = $imageLocation;


  			}

  			if($item['type'] == 'images'){

  				$imageLocation = $item['imageLocation'];
					if($item['location'] == "local"){
						$pos = strpos($imageLocation, '.JPG');
						if($pos){
							$imageLocation = str_replace(".JPG","_150.JPG",$imageLocation);
						}
						$pos = strpos($imageLocation, '.jpg');
						if($pos){
							$imageLocation = str_replace(".jpg","_300.jpg",$imageLocation);
						}
						$pos = strpos($imageLocation, '.jpeg');
						if($pos){
							$imageLocation = str_replace(".jpeg","_150.jpeg",$imageLocation);
						}
						$pos = strpos($imageLocation, '.JPEG');
						if($pos){
							$imageLocation = str_replace(".JPEG","_150.JPEG",$imageLocation);
						}

					}
					$item['imageLocation'] = $imageLocation;
  				
  			}

  			if($item['type'] == 'x3d'){
  				
  			}
  			if($query!=""){
  				//echo 'we are here';
  				$targetWords = $item['label'];
  				if(!$item['description']==""){
  					//echo 'do i get here?';
  					//echo $item['description'];
	  				$descriptionWords = explode(",", $item['description']);
	  				for($i=0; $i<count($descriptionWords)/2; $i++){
	  					$targetWords = $targetWords.$descriptionWords[2*$i+1];
	  				}
  				}
					$words = explode(" ", $targetWords);
					//$words = explode(" ", $item['label']);
  				
  				$queries = explode(" ", $query );
  				//first search search complete queri with the label 
  				similar_text(strtolower($item['label']), strtolower($query), $percent);

		    	if($percent > 80){
		    			
		    		// Change percentage value to 80,70,60 and see changes
		    		$item['labelScore'] = 2;
		    		//adding the object to the right place
		    		if( count($finalObjects) == 0 ) {
		    				$item['id'] = 0;
							$finalObjects[] = $item;
						}else{
							$i = 0;
							foreach ($finalObjects as $res) {
							# code...
								$item['id'] = $i+1;
								if($res['labelScore'] < 2 ){
									//$item.id = $i;
									array_splice($finalObjects, $i, 0, array($item));
									break 1;
								}

								if( $i == count($finalObjects) - 1 ) {
									//$item.id = $i;
									$finalObjects[] = $item;
									break 1; 
								}

								$i++;
							}
						}
					
					
			
		    	} else{
		    		//echo $item['label']."<br>";
		    		$targetWords = $item['label'];
  					if(!$item['description']==""){
	  					//echo 'do i get here?';
	  					//echo $item['description'];
		  				$descriptionWords = explode(",", $item['description']);
		  				for($i=0; $i<count($descriptionWords)/2; $i++){
		  					$targetWords = $targetWords.$descriptionWords[2*$i+1];
		  				}
  					}
						$words = explode(" ", $targetWords);
		    		//$words = explode(" ", $item['label']);
		    		$queries = explode(" ", $query );
		    		//second search, search word by word query with the label 
		    		foreach ($words as $label) {
		    			# code...
		    			foreach ($queries as $query ) {
		    				# code...
		    				similar_text(strtolower($label), strtolower($query), $percent);
		    				if($percent > 80){
		    					$item['labelScore'] = 1;
		    					if( count($finalObjects) == 0 ) {
					    			$item['id'] = 0;
									$finalObjects[] = $item;
								}else{
									$i = 0;
									foreach ($finalObjects as $res) {
										$item['id'] = $i+1;
										if($res['labelScore'] < 1 ){
											array_splice($finalObjects, $i, 0, array($item));
											break 1;
										}

										if( $i == count($finalObjects) -1 ) {
											$finalObjects[] = $item;
											break 1; 
										}
										$i++;
									}
								}
		    				}else{
		    					//this for later.
		    				}
		    			}
		    		}
		    		
					
	  				
		    	}	
  			}else{
  				$finalObjects[] = $item;
  			}
  			
	    	
		    
		    	 
			
  		}
  		
  		
  		return $finalObjects;
  		
  	}
	
	function addMetadataElement($name,$value){
		$this->metadataList[]=array($name,$value);
	}

	function XMLToArray($xml) 
	{ 
		$return=array();
		
	  	if ($xml instanceof SimpleXMLElement) { 
	    	$children = $xml->children(); 
	   		$return = false; 
	  	} 
	  
	  	foreach ($children as $element => $value) { 
	    	if ($value instanceof SimpleXMLElement) { 
	      		$values = (array)$value->children(); 
		 		if (count($values) > 0) { 
		 		
		 			
		 			if($element=="Object") $this->addMetadataElement("Object","");
		 			if($element=="Digital_resorce_provenance") $this->addMetadataElement("Digital resource provenance","");
		 			if($element=="Digital_resource") $this->addMetadataElement("Digital resource","");
		 			if($element=="Activity") $this->addMetadataElement("Activity","");
	       			
	       			
	       			if($element=="Project_information") $this->addMetadataElement("Project","");
	       			if($element=="General_info") $this->addMetadataElement("General Info","");
	       			//if($element=="Record_Information") $this->addMetadataElement("Record Information","");
	       			if($element=="Descriptive_data") $this->addMetadataElement("Descriptive Data","");
	       			if($element=="RWO_collection") $this->addMetadataElement("Collection","");
	       			if($element=="Digital_resource_provenance") $this->addMetadataElement("Digital Resource","");
	       			if($element=="Activity") $this->addMetadataElement("Activity","");
	       			
	       		//	if($element=="Digital_resource_provenance") $this->addMetadataElement("Activity","");
	       			//echo $element;
	       			
	       			
	       			$return[$element] = $this->XMLToArray($value); 
	       			if($element=="Description"){
	      				if($value!=""){
	      					$this->addMetadataElement($element, (string)$value);
	      				}
	      			}
	      			if($element=="Name"){
	      				if($value!=""){
	      					$this->addMetadataElement($element, (string)$value);
	      				}
	      			}
	      			
	      		} else { 
	      			if(!$value=="")	$this->addMetadataElement($element, (string)$value);
	        		if (!isset($return[$element])) { 
	          			$return[$element] = (string)$value; 
	        		} else { 
	          			if (!is_array($return[$element])) { 
	         		   		$return[$element] = array($return[$element], (string)$value); 
	          			} else { 
	            			$return[$element][] = (string)$value; 
	          			} 
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

/* End of file users.php */
/* Location: ./application/models/auth/users.php */