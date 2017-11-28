 <?php
require_once '../../../config.php';
global $DB,$CFG,$SESSION;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
$token=$_REQUEST['wstoken'];
 $wstoken= $SESSION->access_token;
 $response=array();
   if($token==$wstoken){
  $getplugin = $DB->get_records_sql("SELECT plugin,name,value FROM mdl_config_plugins WHERE plugin like '%local_moodle_api_plug%' LIMIT 0,1");
      foreach($getplugin as $row)
         {
           $data[]=$row;
         }
      
        $json_data=json_encode($data);
        echo $json_data;
   }else{
       $response=array(
        'status' => false,
        'message' => 'Invalid token...'
      ); 
   echo $dale= json_encode($response);
   }
?>