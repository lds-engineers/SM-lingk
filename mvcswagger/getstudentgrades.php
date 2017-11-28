<?php
require_once '../../../config.php';
global $DB,$CFG,$SESSION;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
      $rolename=$_REQUEST['rolename'];
        $limit=$_REQUEST['limit'];
        $offset=$_REQUEST['offset'];
        $token=$_REQUEST['wstoken'];
        $wstoken= $SESSION->access_token;
       // $rolename = 'student';
         // echo "select id FROM mdl_role WHERE shortname='$rolename'";
      $response=array();
      if($token==$wstoken){
        $rolequery= $DB->get_record_sql("select id FROM mdl_role WHERE shortname='$rolename'");
        
       // echo $rolequery->id;
     	$jsonkey = array('userid','username','firstname','lastname','email','rolename','coursefullname','courseid','finalgrade');
		$data = array();
        $getuserdetails = $DB->get_records_sql("SELECT u.id as userid,u.username,u.firstname,u.lastname,u.email,
        r.shortname as rolename,c.fullname as coursefullname ,c.id as courseid,gg.finalgrade FROM mdl_user as u 
        LEFT JOIN mdl_role_assignments as rag ON rag.userid=u.id
        LEFT JOIN mdl_role as r ON r.id=rag.roleid 
        LEFT JOIN mdl_context as cx ON cx.id=rag.contextid 
        LEFT JOIN mdl_course as c ON c.id=cx.instanceid
        LEFT  JOIN mdl_grade_items as gi ON  gi.courseid=c.id
        LEFT JOIN mdl_grade_grades as gg ON gg.itemid=gi.id AND gg.userid=rag.userid AND gi.itemtype='course' WHERE r.id=$rolequery->id  LIMIT $limit OFFSET $offset ");

	foreach($getuserdetails as $getuserdetailsdata){

            		$jsonarr = array();
            		$jsonarr[] = $getuserdetailsdata->userid;
            		$jsonarr[] = $getuserdetailsdata->username;
            		$jsonarr[] = $getuserdetailsdata->firstname;
            		$jsonarr[] = $getuserdetailsdata->lastname;
            		$jsonarr[] = $getuserdetailsdata->email;
            		$jsonarr[] = $getuserdetailsdata->rolename;
            		$jsonarr[] = $getuserdetailsdata->coursefullname;
           	        $jsonarr[] = $getuserdetailsdata->courseid;
            		$jsonarr[] = $getuserdetailsdata->finalgrade;
         			
            		$data[] = array_combine($jsonkey,$jsonarr);

    	
    }
        
           $json_data = $data;
    echo json_encode($json_data);
      }else{
           $response = array(
            'status' => false,
            'message' => 'Invalid token...'
        );
     echo  json_encode($response);
          
      }   
