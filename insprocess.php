<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['username']) && isset($_POST['email'])  && isset($_POST['public_key'])){

		$username = $user_fun->htmlvalidation($_POST['username']);
		$email = $user_fun->htmlvalidation($_POST['email']);
		$bod = $user_fun->htmlvalidation($_POST['public_key']);

		if((!preg_match('/^[ ]*$/', $username)) && (!preg_match('/^[ ]*$/', $email))  && ($bod != NULL)){

			$field_val['u_name'] = $username;
			$field_val['u_email'] = $email;
			$field_val['public_key'] = $bod;
			// $f = fopen($iv, 'r');
			// $publicKey = fread($f, 8192);
			// openssl_public_encrypt($bod, $crypted, $publicKey, OPENSSL_PKCS1_PADDING);



			$insert = $user_fun->insert("user", $field_val);

			if($insert){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Inserted";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Inserted";
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