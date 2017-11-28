<?php
 require_once '../../config.php';
 global $CFG,$DB;

 $prefix= $CFG->prefix;
 $table=$_REQUEST['table'];


if (substr($table, 0, strlen($prefix)) == $prefix) {
    $table1 = substr($table, strlen($prefix));
} 
else{
   $table1=$table;
}

$new = new stdClass();
$query= $DB->get_columns($table1);

$keys = array();
$values = array();
foreach($query as $key => $val)
  {
 		array_push($keys,$key);
 		array_push($values,$val->type);
  }

$data = array_combine($keys,$values);

echo json_encode([$data]);


