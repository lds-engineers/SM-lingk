<?php

 require_once '../../../config.php';
global $DB,$CFG,$SESSION;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 

$json = file_get_contents('php://input');
$arr = json_decode($json,TRUE);
$total=count($arr);

 $prefix= $CFG->prefix;
 $table=$_REQUEST['table'];
$token=$_REQUEST['wstoken'];
 $wstoken= $SESSION->access_token;
   echo $token=$_REQUEST['wstoken'];
   echo  $wstoken=$_SESSION['access_token'];
if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
    
} 
else{
 $table1=$table;
}
$table_data=$prefix.$table1;
  $response=array();
   if($token==$wstoken){
if (!empty($arr)){
    foreach ($arr as $row) {
 
     $key = array_keys($row);
     $values = array_values($row);
    
     @$k11=$key[0];
     $data1= $DB->get_record_sql("SELECT * FROM  $table_data WHERE $k11='$values[0]' ");

        if(!empty($data1))
        {
        
               //echo "DELETE FROM ".$prefix.$table1 WHERE  $k11='$values[0]';exit;
               $query3= $DB->execute("DELETE FROM  $table_data WHERE $k11='$values[0]' "); 
               if($query3)
                {
                   $delete++; 
                }
            }
            else
            {
               echo "Action not found";
            }
             
      }
    }
  //$res="Response 200";
  $final=array("totalRecords"=>$total,
                "status"=>"successPartial",
                "deletedRecords"=>$delete
              );
   echo $dale= json_encode($final);
   }else{
      $response=array(
        'status' => false,
        'message' => 'Invalid token...'
      ); 
   echo $dale= json_encode($response);
   }
?>