<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller {

   /**
    * Index Page for this controller.
    *
    * Maps to the following URL
    *       http://example.com/index.php/welcome
    * - or -  
    *       http://example.com/index.php/welcome/index
    * - or -
    * Since this controller is set as the default controller in 
    * config/routes.php, it's displayed at http://example.com/
    *
    * So any other public methods not prefixed with an underscore will
    * map to /index.php/welcome/<method_name>
    * @see http://codeigniter.com/user_guide/general/urls.html
    */
   public $rest_format = 'json';

   function __construct(){
      parent::__construct();
      $ci =& get_instance();
      header('content-type: application/json; charset=utf-8');
      header("access-control-allow-origin: *");

      $this->load->model('apimodels/stats');
      $this->load->model('apimodels/collections');
      $this->load->model('apimodels/annotations');
      $this->load->model('apimodels/details');
      $this->load->model('apimodels/search');
      $this->load->model('apimodels/ingest');
      $this->load->model('apimodels/utils');
   }

   public function index()
   {
      //$this->objects();
      echo APPPATH.'libraries/REST_Controller.php';
      echo 'ok';
      $this->load->view('index_out');

   }
   
   /*
      * Search experiments. 
      * 
   */
   


   function time_get(){
      $result = $this->stats->getTimeDistribution();
      echo json_encode($result);

   }

   function stats_get(){
      $result = $this->stats->getStats();
      echo json_encode($result);

   }


   function savecollection_post(){
      $this->load->model('search/srch');
      $input_data = json_decode(trim(file_get_contents('php://input')), true);

      $title = $input_data['title'];
      $description = $input_data['text'];
      $items = $input_data['items'];

      $data['title'] = $title;
      $data['description'] = $description;
      $data['items'] = $items;

      echo json_encode(array('result' => $this->collections->save_collection($data)));

   }



   function saveannotation_post(){
      $this->load->model('search/srch');
      $input_data = json_decode(trim(file_get_contents('php://input')), true);


      $data['title'] = $input_data['title'];
      $data['description'] = $input_data['description'];
      $data['source'] = $input_data['docID'];
      $data['coordinates'] = $input_data["top"].",".$input_data["left"].",".$input_data["w"].",".$input_data["h"];
      echo $this->annotations->save_annotation($data);

   }



   function details_get(){
      $docID = $this->get('docID');
      // ok so i need to get the details of the object. I already have the function that will the necessery things for me
      // so lets use them.
   
      
      $result = $this->details->getObjectDetails($docID);
      $smallMetadata =array();
      $bigMetadata = array();
      $smallIndicator = true;
      $descriptionIndicator = true;

      

      //print_r($result);
      if( !$result['collection'] == 'Gramatia' || !$result['collection']=="Art Gallery" || !$result['collection']=="Byzantine_Museum" || !$result['collection']=="Der Avedissian-Hawley"){
         foreach($result['metadataList'] as $item){
            if($item[0] == "Object"){
               $smallIndicator = false;
            }
           
            if($item[0] == "Description"){
               if($descriptionIndicator) {
                  $smallMetadata[] = array("Description" => (string)$item[1] );
               }
               $descriptionIndicator = false;
            }
            
            if($smallIndicator){
               if($item[1]!=""){
                  if($item[0] == "Title"){
                     $smallMetadata[] = array("Collection" => (string)$item[1]);
                  }else{
                     $smallMetadata[] = array($item[0] => (string)$item[1]);   
                  }
                     
               }
            }
         
         }
         

      }else if($result['collection'] == 'Gramatia'){
         $smallMetadata = array();
        // print_r($result['metadataList']);
         foreach ($result['metadataList'] as $key => $value) {
            //echo $key;
            foreach ($result['metadataList'][$key] as $ky =>$vl ) {
               //echo $ky;
               //echo $vl;
               $bf = $key. " " . $ky;
               if(!(string)$vl == "")
               $smallMetadata[] = array( $ky => (string)$vl);
               //echo $ky[0];
               # code...
            }
            //echo $value[0] . " " . $value[1];
         }
                 
      }else if($result['collection'] == "K2R"){
         $smallMetadata = array();
         foreach($result['metadataList'] as $item){
             
            $smallMetadata[] = array($item[0] =>  $item[1]);
         }


      }else{
            $smallMetadata = array();
            //print_r($result['metadataList']);

            foreach($result['metadataList'] as $item){
               
               $smallMetadata[] = array($item[0] =>  (string) $item[1]);
            }

      }
      $result['metadataList'] = $smallMetadata;
      //$result['metadataList'] = array();

      
      if($result['objectType'] == 'pdf'){
         $result['imageLocation'] = "http://public.cyi.ac.cy".$result['imLocation'];
      }
      if($result['objectType'] == 'images'){

         $result['imageLocation'] = $result['imLocation'];
         if($result['location'] == "local"){
            $result['imageLocation'] = "http://public.cyi.ac.cy".$result['imageLocation'];
         }
      }
      if($result['objectType'] == 'x3d'){
         $result['imageLocation'] = "http://public.cyi.ac.cy".$result['imageLocation'];
      }
      //print_r($result);
      
      

      
      echo json_encode($result);
   }

   function list_post(){
      $input_data = json_decode(trim(file_get_contents('php://input')), true);

      $items = $input_data['items'];
      $rawResults = $this->search->searchObjects("", array(), array(), array());
      $finalResults = array();

      foreach ($items as $item) {
         foreach ($rawResults as $res ) {
            if($item === $res['docID']){
              $finalResults[] = $res;
            }
         }
         # code...
      }

      echo json_encode($finalResults);

      //$data['title'] = $input_data['title'];
   }

   function search_get(){
      $types = $this->get('types');
      $collections = $this->get('collections');
      $locations = $this->get('locations');

      $query = $this->get('search');
      
      $result = $this->search->searchObjects($query, $collections, $types, $locations);
      $res = array();
      foreach ($result as $obj ) {
         $imLocation = $obj['imageLocation'];
         //echo $imLocation;
         $pos = strpos($imLocation, 'https://hpc-forge.cineca.it/files');
         if($pos > 0){
            //echo $pos."-------    ";
            $obj['imageLocation'] = substr($obj['imageLocation'], 23);

         }
         //$obj['imageLocation'] = 'none';
         $res[] = $obj;
      }
      echo json_encode($res);
   }
   
   function init_get(){
      //$i = $this->get('name');
      // i want all the collections. I already have this model in explore?
   
      $collections=$this->search->getCollectionList(array());
      
      $types = array(array('type'=>'images', 'title'=>'Images'), array('type'=>'pdf', 'title'=> '3D Pdf'),array('type'=>'X3D', 'title'=>'X3DOM'));

      echo json_encode(array('collections'=>$collections, 'types' => $types));
   }

   function testdetails_get(){
      $docID = $this->get('docID');
      $this->load->model('apimodels/details');
      echo json_encode($this->details->getObjectDetails($docID));
      
   }

   function ndcollections_get(){
   
      $this->load->model('ingest/apimodel');
      //echo json_encode ($this->apimodel->getCollectionList());
      echo 'jea jea jea';
   }

   function ingest_post() {
      $xmlLocation =  $this->input->post('xml');

      //echo $xmlLocation;
      $this->ingest->readInfo($xmlLocation);
      
      //print_r($input_data);
   }
   function test_get() {
      $docID = $this->input->get('docID');
      //echo $docID;
      //$this->utils->getDetails($docID);
      echo json_encode($this->utils->getDetails($docID));
      
   }



  
   
   
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */