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
class Metadata extends CI_Model
{
	function __construct()
	{
    parent::__construct();
		$ci =& get_instance();
	}

	private $metadataL			= array();


	function getMetadata($metadataFile,$collection){
		$metadataList=array();
		$xml = simplexml_load_file($metadataFile);
		if($collection=="Byzantine_Museum"){
				
				$metadataList=array();
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectIdentificationWrap//appellationValue');
				$metadataList[]=array("Image title", (string) $result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectIdentificationWrap/repositoryWrap//appellationValue');
				$metadataList[]=array("Copyrights",(string) $result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectIdentificationWrap/objectDescriptionWrap//descriptiveNoteValue');
				$metadataList[]=array("Locations",(string) $result[0]); 		
					
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectIdentificationWrap//objectMeasurementsWrap//displayObjectMeasurements');
				$metadataList[]=array("Dimension",(string) $result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//nameActorSet/appellationValue');
				$metadataList[]=array("Artist",(string) $result[0]); 		
						
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//eventDate//earliestDate');
				$metadataList[]=array("Date",(string) $result[0]); 		
					
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//eventMaterialsTech//term');
				$metadataList[]=array("Technique",(string) $result[0]); 
				
				$result = $xml->xpath('/lidoWrap/lido/administrativeMetadata/recordWrap/recordInfoSet/recordInfoLink');
				$metadataList[]=array("Show at the Byzantine Museum","<a href='".(string) $result[0]."'>".(string) $result[0]."</a>"); 
						
							
		}else if($collection=="Art Gallery"){
				
				$metadataList=array();
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap//appellationValue');
				$metadataList[]=array("Image title",$result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap/repositoryWrap//appellationValue');
				$metadataList[]=array("Copyrights",$result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap/objectDescriptionWrap//descriptiveNoteValue');
				$metadataList[]=array("Locations",$result[0]); 		
					
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap//objectMeasurementsWrap//displayObjectMeasurements');
				$metadataList[]=array("Dimension",$result[0]); 		
				
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//nameActorSet/appellationValue');
				$metadataList[]=array("Artist",$result[0]); 		
						
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventDate//earliestDate');
				$metadataList[]=array("Date",$result[0]); 		
					
				$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventMaterialsTech//term');
				$metadataList[]=array("Technique",$result[0]); 
				
				$result = $xml->xpath('/lidoWrap/lido/administrativeMetadata/recordWrap/recordInfoSet/recordInfoLink');
				$metadataList[]=array("Show at the Byzantine Museum","<a href='".$result[0]."'>".$result[0]."</a>"); 		
							
		}else if($collection=="Der Avedissian-Hawley"){
        
        $metadataList=array();
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap//appellationValue');
        $metadataList[]=array("Image title",$result[0]);    
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap/repositoryWrap//appellationValue');
        $metadataList[]=array("Copyrights",$result[0]);     
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap/objectDescriptionWrap//descriptiveNoteValue');
        $metadataList[]=array("Description",$result[0]);    
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventDate//earliestDate');
        $result1 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventDate//latestDate');
        
        $metadataList[]=array("Date",$result[0]."-".$result1[0]);     
        
          
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectIdentificationWrap//objectMeasurementsWrap//objectMeasurementsSet/displayObjectMeasurements');
        $metadataList[]=array("Dimension",$result[0]);    
        
          
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[1]/eventWrap//eventMaterialsTech//term');
        $result1 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//eventMaterialsTech//term');
        
        $metadataList[]=array("Technique",$result[0]." ".$result1[0]); 
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//nameActorSet/appellationValue');
        $metadataList[]=array("Artist",$result[0]);   
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//roleActor/term');
        $result1 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[1]/eventWrap//roleActor/term');
        
        $metadataList[]=array("Role",$result1[0].", ".$result[0]);     
        
          
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//nationalityActor/term');
        $result1 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[1]/eventWrap//nationalityActor/term');
        
        $metadataList[]=array("Nationality",$result1[0].", ".$result[0]);     
        
        $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//vitalDatesActor/earliestDate');
        $result1 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//vitalDatesActor/latestDate');
        
        $metadataList[]=array("Period",$result[0]."-".$result1[0]);     
        
    }else if($collection == "Ancient Books"){
    	$metadataList=array();
      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap//appellationValue');
      $metadataList[]=array("Title",$result[0]);  

			$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectClassificationWrap//objectWorkType/term');
      $result2 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/objectClassificationWrap//objectWorkType/term');
      
      $metadataList[]=array("Work type",$result[0]." ".$result2[0]);  


      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/objectIdentificationWrap//descriptiveNoteValue');
      $metadataList[]=array("Description",$result[0]);  

      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventActor//nameActorSet/appellationValue');
      //$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata2/eventWrap/eventActor//nameActorSet/appellationValue');
      $result2 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//eventActor//nameActorSet/appellationValue');
      
      
      $metadataList[]=array("Production",$result[0]." - ".$result2[0]); 

      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventDate//date/earliestDate');
      //$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata2/eventWrap/eventActor//nameActorSet/appellationValue');
      $result2 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventDate//date/latestDate');
      
      
      $metadataList[]=array("Object date",$result[0]." - ". $result2[0]); 

      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata/eventWrap//eventMaterialsTech//term');
      //$result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata2/eventWrap/eventActor//nameActorSet/appellationValue');
      $result2 = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]/eventWrap//eventMaterialsTech//term');
      
      
      $metadataList[]=array("Material",$result[0]." ". $result2[0]); 

      
      $result = $xml->xpath('/lidoWrap/lido/descriptiveMetadata[2]//objectMeasurementsWrap//displayObjectMeasurements');
      $metadataList[]=array("Dimension",$result[0]);  


    }else if($collection == "K2R"){
      $metadataList=array();
      $result = $xml->xpath('/vmust/Name');
      $metadataList[]=array("Title",(string) $result[0]);

      $result = $xml->xpath('/vmust/Brief_description');
      $metadataList[]=array("Description",(string) $result[0]);

      //$result = $xml->xpath('/vmust/HeritageAsset/Place/Name');
      //$metadataList[]=array("Place",(string) $result[0]);

      $result = $xml->xpath('/vmust/HeritageAsset/Period');
      $metadataList[]=array("Period",(string) $result[0]);

      $result = $xml->xpath('/vmust/Provenance/epoch_represented');
      $metadataList[]=array("Epoch",(string) $result[0]);
      
      $result = $xml->xpath('/vmust/Provenance/techniques');
      $metadataList[]=array("Techniques",(string) $result[0]);
      
      
      $result = $xml->xpath('/vmust/DigitalAsset/Provider');
      $metadataList[]=array("Provider",(string) $result[0]);

      $result = $xml->xpath('/vmust/DigitalAsset/Contact');
      $metadataList[]=array("Contact",(string) $result[0]);

      $result = $xml->xpath('/vmust/DigitalAsset/IPR');
      $metadataList[]=array("IPR",(string) $result[0]);


      

      

        
    }
    
    else if($collection == "Gramatia"){
    	//$xmlArray=array();
			//$xmlArray=$this->XMLToArray2($xml);
			//$metadataList=$this->metadataL;
			//echo $result[0];
			$mylist = array();

    	$result = $xml->xpath('/Project/Project_information/Admin_data/Name');
    	$mylist['Name'] =  $result[0];
    	
    	$result = $xml->xpath('/Project/Project_information/Admin_data/Principal_investigator');
    	$mylist['Principle investigator'] = $result[0];;
    	
    	$result = $xml->xpath('/Project/Project_information/Admin_data/Collaborators');
    	$mylist['Collaborators'] = $result[0];;

    	$result = $xml->xpath('/Project/Project_information/Admin_data/Rights');
    	$mylist['Rights'] = $result[0];

    	$result = $xml->xpath('/Project/Project_information/Admin_data/Start_date');
    	$mylist['Start date'] = $result[0];

    	$result = $xml->xpath('/Project/Project_information/Admin_data/End_date');
    	$mylist['End date'] = $result[0];

    	$result = $xml->xpath('/Project/Project_information//Country');
    	$mylist['Country'] = $result[0];


    	$result[0] = '<a href="http://www.eagle-network.eu/" >http://www.eagle-network.eu/</a>';
    	$mylist['Project info'] = $result[0];

    	$metadataList['Project'] = $mylist;
    	
    	$mylist = array();

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Administrative_data/Record_Information/Name');
    	$list['Name'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Administrative_data/Record_Information/country');
    	$list['Country'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Administrative_data/Record_Information/language');
    	$list['Language'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Descriptive_data/Type');
    	$list['Type'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Descriptive_data/Description');
    	$list['Description'] = $result[0];


    	$result = $xml->xpath('/Project/RWO_collection/General_info/Descriptive_data//start_Date');
    	$list['Start date'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/General_info/Descriptive_data//end_Date');
    	$list['End date'] = $result[0];

    	$result = $xml->xpath('//Project/RWO_collection/General_info/Administrative_data/Record_Information/rights');
    	$list['Rights'] = $result[0];



    	$metadataList['Collection Information'] = $list;
    	
    	$list = array();

    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Authors');
    	$list['Authors'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Title');
    	$list['Title'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//abstract');
    	$list['Abstract'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription//Date');
    	$list['Date'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Language');
    	$list['Language'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription//Type');
    	$list['Type'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription//Series_title');
    	$list['Series title'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Series_volume');
    	$list['Series volume'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Volume');
    	$list['Volume'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Issue');
    	$list['Issue'] = $result[0];

    	// $result = $xml->xpath('/Project/RWO_collection/Inscription//Number_of_volumes');
    	// $list['Number of volumes'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Pagination');
    	$list['Pagination'] = $result[0];

    	// $result = $xml->xpath('/Project/RWO_collection/Inscription//Number_of_pages');
    	// $list['Number of pages'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Place_of_publication');
    	$list['Place of publication'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription//Publisher');
    	$list['Publisher'] = $result[0];
			
			// $result = $xml->xpath('/Project/RWO_collection/Inscription//Identifiers');
   //  	$list['Identifiers'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Editors');
    	$list['Editors'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Series_editors');
    	$list['Series_editors'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Reprint_edition');
    	$list['Reprint edition'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//digital_library');
    	$list['Digital library'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//web_locators');
    	$list['Library url'] = "<a href='". $result[0] ."'>" .$result[0]. "</a>";

    	$result = $xml->xpath('/Project/RWO_collection/Inscription//Keywords');
    	$list['Keywords'] = $result[0];


    	



    	$metadataList['Bibliography'] = $list;







    	
    	$list = array();

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Author');
    	$list['Author'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Date');
    	$list['Date'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Publication');
    	$list['Publication'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Comments_type');
    	$list['Comments type'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Scholarly_debates');
    	$list['Scholarly debates'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Commentary//Bibliography');
    	$list['Bibliography'] = $result[0];

    	
    	$metadataList['Commentary'] = $list;
    	
    	$list = array();

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Title');
    	$list['Title'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Inventory_number');
    	$list['Inventory_number'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Period_name');
    	$list['Period name'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//terminus_ante_quem');
    	$list['terminus ante quem'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//terminus_post_quem');
    	$list['terminus post quem'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Description');
    	$list['Description'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Main_references');
    	$list['Other soruces'] = $result[0];

    	//$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Link');
    	//$list['Link'] = "<a href='".$result[0]."'>".$result[0]."</a>";

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Title');
    	$list['Title'] = $result[0];

    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Purpose_of_inscription');
    	$list['Purpose of inscription'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Genre');
    	$list['Genre'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Metre');
    	$list['Metre'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Author_of_inscription');
    	$list['Author of inscription'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Honorand');
    	$list['Honorand'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Political_social_status');
    	$list['Political social status'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//AwardedBy_dedicator');
    	$list['Awarded By dedicator'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Other_names');
    	$list['Other names'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Event_of_inscritption');
    	$list['Event of inscritption'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Locations_mentioned');
    	$list['Locations mentioned'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Condition_of_inscription');
    	$list['Condition of inscription'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Restoration');
    	$list['Restoration'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Language');
    	$list['Language'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//double_side');
    	$list['Double side'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Scripture');
    	$list['Scripture'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//writing_direction');
    	$list['Writing direction'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//number_of_signs');
    	$list['Number of signs'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//style_of_writing');
    	$list['Style of writing'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//size_of_letters');
    	$list['Size of letters'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//style_of_letters');
    	$list['Style of letters'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//number_of_lines');
    	$list['Number of lines'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//erasures');
    	$list['Erasures'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//spelling_errors_variations');
    	$list['Spelling errors variations'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//decoration_of_inscription');
    	$list['Decoration of inscription'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//writing_technique');
    	$list['Writing technique'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Transcription/author');
    	$list['Transcription author'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Transcription/date');
    	$list['Transcription date'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Transcription/date_of_publication');
    	$list['Transcription date of publication'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Transcription/references');
    	$list['Transcription references'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Apograph/author');
    	$list['Apograph author'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Apograph/date');
    	$list['Apograph date'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Apograph/date_of_publication');
    	$list['Apograph date of publication'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Apograph/references');
    	$list['Apograph references'] = $result[0];

    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Translation/translator');
    	$list['Translator'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Translation/language');
    	$list['Translation language'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Translation/date');
    	$list['Translation date '] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Translation/publication');
    	$list['Translation publication'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Translation/rights');
    	$list['Translation rights'] = $result[0];

    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Interpretation');
    	$list['Interpretation'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//editorial_additions');
    	$list['Editorial additions'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//other_info');
    	$list['Other info'] = $result[0];



    	$metadataList['Inscription'] = $list;

    	$list = array();


    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//support_type');
    	$list['Support type'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Material_support');
    	$list['Material support'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//condition_support');
    	$list['Condition support'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Height/value');
    	$result1 = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Height/unit');
    		
    	$list['Height'] = $result[0].$result1[0];
    	
    	// $result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Lenght/value');
    	// $result1 = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Lenght/unit');
    		
    	// $list['Length'] = $result[0].$result1[0];
    	

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Thickness/value');
    	$result1 = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Thickness/unit');
    		
    	$list['Thickness'] = $result[0].$result1[0];
    	

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Weight/value');
    	$result1 = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Weight/unit');
    		
    	$list['Weight'] = $result[0].$result1[0];
    	

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//volume/value');
    	$result1 = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//volume/unit');
    		
    	$list['Volume'] = $result[0].$result1[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//Decoration_support');
    	$list['Decoration support'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//reuse_of_support');
    	$list['Reuse of support'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data/Support//support_connection');
    	$list['Support connection'] = $result[0];

    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Conservation_status');
    	$list['Conservation status'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Place_of_conservation');
    	$list['Place of conservation'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Country_of_conservation');
    	$list['Country of conservation'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Place_of_discovery');
    	$list['Place of discovery'] = $result[0];

    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Ancient_name');
    	$list['Ancient name'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Region_District');
    	$list['Region district'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Regio_antiqua');
    	$list['Regio antiqua'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Country');
    	$list['Country'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Discovery_date');
    	$list['Discovery date'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Excavators');
    	$list['Excavators'] = $result[0];

			$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//Condition_of_discovery');
    	$list['Condition of discovery'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//History_of_discovery');
    	$list['History of discovery'] = $result[0];
    	
    	$result = $xml->xpath('/Project/RWO_collection/Inscription/Descriptive_data//First_owner');
    	$list['First owner'] = $result[0];
    	
    	
			
			$metadataList['Support'] = $list;

			$list = array();

			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info//Software');
    	$list['Software'] = $result[0];
    	
    	$res = $xml->xpath('/Project/Digital_Resource_Provenance');
   //  	foreach ($xml->xpath("/Project/Project_information") as $child) {
   //  		echo $child["type"] . "="  . $child->getName()."<br/>";
			// }
			// echo '<br>end</br>';

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info//data_format');
    	$list['Data format'] = $result[0];
    	

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info//data_weight');
    	$list['Data weight'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/orthophoto/horizontal_resolution');
    	$list['Orthophoto horizontal resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/orthophoto/vertical_resolution');
    	$list['Orthophoto vertical resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/orthophoto/width');
    	$list['Orthophoto width'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/orthophoto/height');
    	$list['Orthophoto height'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/orthophoto/data_compression');
    	$list['Orthophoto data_compression'] = $result[0];
    	

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/PDF_3D/horizontal_resolution');
    	$list['3D PDF horizontal resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/PDF_3D/vertical_resolution');
    	$list['3D PDF vertical resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/PDF_3D/width');
    	$list['3D PDF width'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/PDF_3D/height');
    	$list['3D PDF height'] = $result[0];


    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Text/horizontal_resolution');
    	$list['Text horizontal resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Text/vertical_resolution');
    	$list['Text vertical resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Text/width');
    	$list['Text width'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Text/height');
    	$list['Text height'] = $result[0];
    	


    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/height');
    	$list['3D model height'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/length');
    	$list['3D model length'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/width');
    	$list['3D model width'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/units');
    	$list['3D model units'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/shape');
    	$list['3D model shape'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/area');
    	$list['3D model area'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/perimeter');
    	$list['3D model perimeter'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/Dimension/Volume');
    	$list['3D model volume'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/number_of_vertices');
    	$list['Number of vertices'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/number_of_faces');
    	$list['Number of faces'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/textures');
    	$list['Textures'] = $result[0];

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/point_per_vertex');
    	$list['Point per vertex'] = $result[0];

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/threeD_model/rendering_time');
    	$list['Rendering time'] = $result[0];

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Name');
    	$list['Name'] = $result[0];

			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Type');
    	$list['Type'] = $result[0];
			
			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Creation_time');
    	$list['Image creation time'] = $result[0];
			
			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/width');
    	$list['Width'] = $result[0];

			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/height');
    	$list['Height'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Resolution');
    	$list['Resolution'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Size');
    	$list['Size'] = $result[0];
    	
    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Technical_info/File_specs/Image/Compression');
    	$list['Compression'] = $result[0];
    	

    	$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Descriptive_data/Description');
    	$list['Description'] = $result[0];

			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Descriptive_data/IsShownAt');
    	$list['Shown at'] = "<a href='".$result[0]."' >".$result[0]."</a>";

			$result = $xml->xpath('/Project/Digital_Resource_Provenance/Digital_outcomes/Descriptive_data/rights');
    	$list['Rights'] = $result[0];

    	


    	$metadataList['Digital resource provenance'] = $list;
    	
    

			
    }
    else{
					
			$xmlArray=array();
			$xmlArray=$this->XMLToArray($xml);
			$metadataList=$this->metadataL;
									
					
		}
			
		return $metadataList;
		
	
	}
	
	function addMetadataElement($name,$value){
		$this->metadataL[]=array($name,$value);
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
		 		
		 			if($element == "Project_information") $this->addMetadataElement("Project Information", "");
		 			if($element == "RWO_collection") $this->addMetadataElement("Collection Information", "");
					if($element == "Project_information") $this->addMetadataElement("Project Information", "");
					if($element == "Project_information") $this->addMetadataElement("Project Information", "");
					if($element == "Project_information") $this->addMetadataElement("Project Information", "");



		 			if($element=="Object") $this->addMetadataElement("Object","");
		 			if($element=="Digital_resorce_provenance") $this->addMetadataElement("Digital resource provenance","");
		 			if($element=="Digital_resource") $this->addMetadataElement("Digital resource","");
		 			if($element=="Activity") $this->addMetadataElement("Activity","");
	       			
	       			
	       			if($element=="Project_information") $this->addMetadataElement("Project","");
	       			if($element=="General_info") $this->addMetadataElement("General Info","");
	       			//if($element=="Record_Information") $this->addMetadataElement("Record Information","");
	       			if($element=="Descriptive_data") $this->addMetadataElement("Descriptive Data","");
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