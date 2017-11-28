<?php
require_once '../../../config.php';
global $DB,$CFG,$SESSION;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

   $limit=$_REQUEST['limit'];
   $offset=$_REQUEST['offset'];
   $table=$_REQUEST['table'];
   $token=$_REQUEST['wstoken'];
   $wstoken= $SESSION->access_token;
   $date=$_REQUEST['filter'];
   $final=explode(' ',$date);
   $f1=$final[0];
   $f2=$final[1];
   $f3=$final[2];
   //timemodified
   //2015-01-02T15:04:05-10:00
 //=============RFC3339 formatted date values convert=================//
 //$new_date_format = date('Y-m-d\TH:i:sP', $timestamp);
  // $url = $CFG->wwwroot.'/local/lingk/mvcswagger/gets.php?table='.$table.'&limit='.$limit.'&offset='.$offset;
 $date = date($f3);
 $modefied=strtotime($date);
$prefix= $CFG->prefix;
if(substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
} 
else{
 $table1=$table;
}
$table_data=$prefix.$table1;
$response=array();


//===========select date field column=================//
if(!empty($date)){

if($token==$wstoken){
     if(!empty($limit)){
       if(empty($offset)){
       $offset=0;
       }
   if($f2=='lt'){
      $getuser = $DB->get_records_sql("SELECT * FROM $table_data WHERE `timemodified`< $modefied LIMIT $limit OFFSET $offset");
   }elseif($f2=='lte'){
       //echo "www";
     $getuser = $DB->get_records_sql("SELECT * FROM $table_data WHERE `timemodified`<= $modefied LIMIT $limit OFFSET $offset"); 
   }elseif($f2=='gt'){
       //echo "eee";
      $getuser = $DB->get_records_sql("SELECT * FROM $table_data WHERE `timemodified`> $modefied LIMIT $limit OFFSET $offset"); 
   }elseif($f2=='gte'){
      // echo "rrr";
       //echo "SELECT * FROM $table_data WHERE `timemodified`>= $modefied LIMIT $limit OFFSET  $offset";
     $getuser = $DB->get_records_sql("SELECT * FROM $table_data WHERE `timemodified`>= $modefied LIMIT $limit OFFSET $offset"); 
    }else{
        $response = array(
        'status' => false,
        'message' => 'Invalid parameter...'
    );
   echo json_encode($response);
    }
  foreach($getuser as $row)
         {
           $data[]=$row;
         }
    echo json_encode($data);
     }else{
     $response = array(
        'status' => false,
        'message' => 'No record found data...'
       ); 
       echo  json_encode($response);
     }
}else{
   $response = array(
        'status' => false,
        'message' => 'Invalid token...'
    );
   echo json_encode($response);
}
//========================date field column not add=========================//
}elseif($token==$wstoken){
    if(!empty($limit)){
        if(empty($offset)){
       $offset=0;
       }
$getuser = $DB->get_records_sql("SELECT * FROM $table_data LIMIT $limit OFFSET $offset ");
      foreach($getuser as $row)
         {
           $data[]=$row;
         }
    echo  json_encode($data);
    }else{
       $response = array(
        'status' => false,
        'message' => 'No record found...'
       ); 
       echo  json_encode($response);
    }
}
else{
   $response = array(
        'status' => false,
        'message' => 'Invalid token list...'
    );
   echo  json_encode($response);
}
