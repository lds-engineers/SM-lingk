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
//print_r($arr);exit;
$insert=0;
$total=count($arr);
//print_r($total);exit;

$prefix= $CFG->prefix;
 $table=$_REQUEST['table'];

if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
} 
else{
 $table1=$table;
}
$table_data=$prefix.$table1;
if(!empty($arr)){
  
 foreach ($arr as $row) {
   $column = implode(',', array_keys($row));
   $value = implode("','", array_values($row));


  $bulk_qry= $DB->execute("INSERT INTO $table_data ({$column}) VALUES ('{$value}')");
 //print_r($query1);exit;
               if($bulk_qry)
                {
                   //echo "hiii";
                   $insert++; 
                }
    }
}
   $final=array("totalRecords"=>$total,
                "status"=>"successPartial",
                "insertedRecords"=>$insert,
              );
  echo $dale= json_encode($final);
  

?>
