<?php

require_once '../../../config.php';
global $DB,$CFG;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

$json = file_get_contents('php://input');
 $arr = json_decode($json,TRUE);
 $total=count($arr);

 $update=0;
 $prefix= $CFG->prefix;
 $table=$_REQUEST['table'];

if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
    
} 
else{
 $table1=$table;
}
$table_data=$prefix.$table1;
//echo $table_data;exit;
$cols=array();
 
     foreach($arr as $data){
    
        foreach($data as $key=>$val) {
        if($key !='id'){
        $cols[] = "$key = '$val'";
        }else{
        $where = "$key = '$val'";
        }
     }
     
     //$query = "UPDATE $table_data SET " . implode(', ', $cols) . " WHERE $where";
      $query= $DB->execute("UPDATE $table_data SET " . implode(', ', $cols) . " WHERE $where "); 
     if($query){
       $update++;
     }
     }
      
  $final=array("totalRecords"=>$total,
                "status"=>"successPartial",
                "updatedRecords"=>$update
              );
   echo  $json_data=json_encode($data);
       
  
?>