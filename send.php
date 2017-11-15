<?php
 require_once '../../../../../config.php';


 global $DB;
 $token=$_REQUEST['token'];
 $_SESSION['access_token']=$token;
 $query= $DB->get_record_sql("select token FROM mdl_external_tokens WHERE token='$token'");
 $data= $query->token;
 $response=array();
if($data)
{
    $response['status']="true";
    $response['data']=$data;
    $response['msg']="Valid Token";
}
else
{
    $response['status']="false";
    $response['msg']="Invalid Token";
}
echo json_encode($response);