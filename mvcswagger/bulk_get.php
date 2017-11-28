 <?php
require_once '../../../config.php';
global $DB,$CFG,$SESSION;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

   $prefix= $CFG->prefix;

   $table=$_REQUEST['table'];
   $limit=$_REQUEST['limit'];
   $offset=$_REQUEST['offset'];
   $token=$_REQUEST['wstoken'];
   $wstoken= $SESSION->access_token;
 if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
    
} 
else{
 $table1=$table;
}
  $response=array();
   if($token==$wstoken){
   $bulkdata = $DB->get_records_sql("select * FROM  ".$prefix.$table1."  LIMIT $limit OFFSET $offset  ");
      foreach($bulkdata as $row)
         {
           $data[]=$row;
         }
      
      echo  $json_data=json_encode($data);
       
   }else{
      $response=array(
        'status' => false,
        'message' => 'Invalid token...'
      ); 
   echo $dale= json_encode($response);
   }
?>