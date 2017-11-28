<?php
//error_reporting(0);
 require_once '../../../config.php';
  global $DB,$CFG;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 

$json = file_get_contents('php://input');
$arr = json_decode($json,TRUE);
 $total=count($arr);
//echo "<pre>";
//print_r($arr);exit;
//echo "<pre>";exit;
 $obj=new stdClass();
 $prefix= $CFG->prefix;
 $table=$_REQUEST['table'];

if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
    
} 
else{
 $table1=$table;
}
// $action=$_REQUEST['action'];
	
if (!empty($arr)){
    foreach ($arr as $row) {
   // print_r($row[0]);exit;
     $key = array_keys($row);
     $values = array_values($row);
    
    @$k11=$key[0];
     $data1= $DB->get_record_sql("select * FROM  ".$prefix.$table1." WHERE $k11='$values[0]' ");
    
       //print_r($data1);exit;
        if(!empty($data1))
        {
        
               //echo "DELETE FROM ".$prefix.$table1 WHERE  $k11='$values[0]';exit;
               $query3= $DB->execute("DELETE FROM  ".$prefix.$table1." WHERE $k11='$values[0]' "); 
               if($query3)
                {
                   $delete++; 
                }
            }
            else
            {
               echo "Id not found";
            }
             
      }
    }
  //$res="Response 200";
  $final=array("totalRecords"=>$total,
                "status"=>"successPartial",
                "deletedRecords"=>$delete
              );
  echo $dale= json_encode($final);

   
?>