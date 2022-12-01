<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['username']) && isset($_POST['email']) &&  isset($_POST['public_key']) && isset($_POST['dataval'])){

		$username = $user_fun->htmlvalidation($_POST['username']);
		$email = $user_fun->htmlvalidation($_POST['email']);
		
		$bod = $user_fun->htmlvalidation($_POST['public_key']);
		$update_id = $user_fun->htmlvalidation($_POST['dataval']);

		if((!preg_match('/^[ ]*$/', $username)) && (!preg_match('/^[ ]*$/', $email)) && ($bod != NULL)){
			$condition['u_id'] = $update_id;
			$field_val['u_name'] = $username;
			$field_val['u_email'] = $email;
			$field_val['public_key'] = $bod;	
			$update = $user_fun->update("user", $field_val, $condition);
			if($update){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Updated";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Updated";
			}
		}
		else{
			if(preg_match('/^[ ]*$/', $username)){
				$json['status'] = 103;
				$json['msg'] = "Please Enter Username";
			}
			if(preg_match('/^[ ]*$/', $email)){
				$json['status'] = 104;
				$json['msg'] = "Please Enter Email";
			}
			
			
			if($bod == NULL){

				$json['status'] = 107;
				$json['msg'] = "Please Enter Public key";

			}

		}

	}
	else{

		$json['status'] = 108;
		$json['msg'] = "Invalid Values Passed";

	}

}
else{

	$json['status'] = 109;
	$json['msg'] = "Invalid Method Found";

}


echo json_encode($json);

?>