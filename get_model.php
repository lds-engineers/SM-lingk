<?php
  require_once '../../config.php';
  global $CFG,$DB;
    $prefix= $CFG->prefix;
    $host = $_REQUEST['host'];
    $basepath = $_REQUEST['basepath'];
    $table_name = $_REQUEST['table'];
  $default_array = array();
  foreach($table_name as $tn) {
   $tb_col= $tn;
$query= $DB->get_columns($tb_col);
//print_r($query);
$keys = array();
$values = array();
$keys1=array();
$values1=array();
 //print_r($query);
foreach($query as $key => $val)
  {
     if($val->type=='bigint' || $val->type=='tinyint' || $val->type=='smallint' || $val->type=='decimal' || $val->type=='float')
      {
        $text='integer';
        array_push($keys,$key);
        array_push($values,$text);
      }else{
        $text='string';
        array_push($keys,$key);
        array_push($values,$text);
      }
  }
$data = array_combine($keys,$values);
$text1= array();
foreach($data as $key =>$value) {
    
 if($value=='integer'){
     $text1=array("type" =>'integer',"format"=>'int64');
       array_push($keys1,$key);
       array_push($values1,$text1);
    }else{
        $text1=array("type" => 'string');
       array_push($keys1,$key);
       array_push($values1,$text1);
    }
}
$data1 = array_combine($keys1,$values1);
$default_array[$tb_col] =array('type' =>"object",'properties' =>$data1);

  $json = file_get_contents('tpl/swagger.json');
  $json_data = json_decode($json,TRUE); 
  $json_data['definitions']=$default_array;
  $json_data['host'] = remove_http($host);
  $json_data['basePath'] = $basepath;
  
 
}
//$content = json_encode($json_data);
$content=json_encode($json_data, JSON_UNESCAPED_SLASHES);

 //echo "<pre>";
  //print_r(json_encode($json_data));
  //echo "</pre>";
//die;
//echo (dirname(__FILE__));exit;
$fp=fopen(dirname(__FILE__) . '/swagger_all.json', 'w');
//$fp = fopen(dirname(__FILE__)."\swagger_all.json","w");

fwrite($fp,$content);
  if($fp){
   //  file_put_contents('swagger_all.json', $json);
   redirect($CFG->wwwroot.'/local/lingk/');
  }else
  {
      echo "invalid JSON";
  } 
  //echo "<pre>";
  //print_r(json_encode($json_data));
  //echo "</pre>";
//$definition=array("definitions" => $default_array);
//echo json_encode($default_array);

//===============Remove http or https url====================//
 
function remove_http($url) {
   $disallowed = array('http://','https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}

