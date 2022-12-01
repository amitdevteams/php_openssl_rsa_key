<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$res = openssl_pkey_new();
	openssl_pkey_export($res, $privkey, "PassPhrase number 1"); {
		// Get details of public key
		$pubkey = openssl_pkey_get_details($res);
		$pubkey = $pubkey["key"];
		$rsaKey = openssl_pkey_new(
			array(
				'private_key_bits' => 4096,
				'private_key_type' => OPENSSL_KEYTYPE_RSA,
			)
		);
		$privKey = openssl_pkey_get_private($rsaKey);
		openssl_pkey_export($privKey, $pem);
		//download in privatekey.pem file
		file_put_contents('publickey.pem', $pubkey);
		file_put_contents('privatekey.pem', $pem);
		// download function start here
		ob_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/x-pem-file');
		header("Content-Disposition: attachment; filename=privatekey.pem");
		exit(readfile('privatekey.pem'));
		// var_export($pubkey, $return)
		// var_dump($privkey);
		// var_dump($pubkey);
	}
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Rsa key gen with private and public key</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"
		type="text/css">
	<style type="text/css">
		.box-title {
			border-radius: 5px;
			box-shadow: 0px 0px 3px 1px gray;
			padding: 10px 0px;
		}

		.error-msg {
			color: #dc3545;
			font-weight: 600;
		}

		.success-msg {
			color: green;
			font-weight: 600;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="container">
			<!-- <div class="row m-3 text-center">
				<div class="col-lg-12">
					<h1 class="box-title">Generate New TOKEN</h1>
				</div>
			</div> -->
			<div class="row justify-content-center">
				<div class="col-lg-2 mt-5">
					<button type="button" class="btn btn-lg btn-primary btn-sm" data-toggle="modal"
						data-target="#exampleModalCenter">Add Record</button>
					<br><br>
				</div>
				<div class="col-lg-2 mt-5">
					<form action="./rsagen.php" method="POST">
						<button class="btn btn-primary btn-sm">Generate Key</button>
					</form>
					<br><br>
				</div>
				<div class="col-lg-2">
				</div>
				<div class="col-lg-2">
				</div>
				<div class="col-lg-2">
				</div>
				<div class="col-lg-2">
				</div>
				<div class="col-lg-2">
				</div>
			</div>
			<div class="row mt-5" id="tbl_rec">

			</div>
		</div>
	</div>
	<!-- insert data start here -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Add New Record</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" id="ins_rec">
					<div class="modal-body">
						<div class="form-group">
							<label><b>User Name</b></label>
							<input type="text" name="username" class="form-control" placeholder="Username">
							<span class="error-msg" id="msg_1"></span>
						</div>
						<div class="form-group">
							<label><b>Email</b></label>
							<input type="text" name="email" class="form-control" placeholder="YourEmail@email.com">
							<span class="error-msg" id="msg_2"></span>
						</div>
						<div class="form-group">
							<label><b>Public Key</b></label>
							<input type="text" name="public_key" class="form-control">
							<span class="error-msg" id="msg_4"></span>
						</div>
						<div class="form-group">
							<span class="success-msg" id="sc_msg"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="close_click"
							data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Record</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- insert data end here -->
	<!-- amit update start here  -->
	<div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateModalCenterTitle">Update Record</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" id="updata">
					<div class="modal-body">
						<div class="form-group">
							<label><b>User Name</b></label>
							<input type="text" class="form-control" name="username" id="upd_1" placeholder="Username">
							<span class="error-msg" id="umsg_1"></span>
						</div>
						<div class="form-group">
							<label><b>Email</b></label>
							<input type="text" class="form-control" name="email" id="upd_2"
								placeholder="YourEmail@email.com">
							<span class="error-msg" id="umsg_2"></span>
						</div>

						<div class="form-group">
							<label><b>Public Key</b></label>
							<input type="text" class="form-control" id="upd_4" name="public_key">
							<span class="error-msg" id="umsg_4"></span>
						</div>
						<div class="form-group">
							<input type="hidden" name="dataval" id="upd_7">
							<span class="success-msg" id="umsg_6"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"
							id="up_cancle">Cancle</button>
						<button type="submit" class="btn btn-primary">Update Record</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- amit update end  -->
	<!-- amit modal here -->

	<div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalCenterTitle">Are You Sure Delete This Record ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="de_cancle" data-dismiss="modal">Cancle</button>
					<button type="button" class="btn btn-primary" id="deleterec">Delete Now</button>
				</div>
			</div>
		</div>
	</div>

	<!-- End Delete Design Modal -->
	<!-- edit decyrpt modal start here  -->
	<!-- ############################## on edit page token will be find value open #####################  -->
    <div class="modal fade" id="editTokenModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Put your valid id then you will see data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form  open --->
                    <form id="edit_ency_token_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Put Token</label>
                            <!-- <input type="text" class="form-control" id="validation_token_id" name="token"> -->
                            <!-- amit adding start put file  -->
                            <input type="file" class="form-control" id="validation_token_id" name="token">
                            <span id="plasewaitforeditModal" style="color:green;"></span>
                            <span id="noDataMyRecord" style="color:red;"></span>
                            <input type="hidden" name="user_id" id="user_id">

                            <span id="email_address_will_be_get"></span>
                    </form>
                    <!-- form  close -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Check</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ############################## on edit page token will be find value close #####################  -->
	<!-- edit decyrpt modal start here  -->

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
		type="text/javascript"></script>


	<script type="text/javascript">
		$(document).ready(function () {
			$('#tbl_rec').load('record.php');

			


			// on edit token amit add here 
			
			// on edit token amit add here 

			//insert Record

			$('#ins_rec').on("submit", function (e) {
				e.preventDefault();
				$.ajax({

					type: 'POST',
					url: 'insprocess.php',
					data: $(this).serialize(),
					success: function (vardata) {
						var json = JSON.parse(vardata);
						if (json.status == 101) {
							console.log(json.msg);
							$('#tbl_rec').load('record.php');
							$('#ins_rec').trigger('reset');
							$('#close_click').trigger('click');
						} else if (json.status == 102) {
							$('#sc_msg').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 103) {
							$('#msg_1').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 104) {
							$('#msg_2').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 106) {
							$('#msg_4').text(json.msg);
							console.log(json.msg);
						} else {
							console.log(json.msg);
						}

					}

				});

			});

			//select data

			$(document).on("click", "button.editdata", function () {
				$('#umsg_1').text("");
				$('#umsg_2').text("");
				$('#umsg_3').text("");
				$('#umsg_4').text("");
				$('#umsg_5').text("");
				$('#umsg_6').text("");
				$('#umsg_7').text("");
				var check_id = $(this).data('dataid');
				$.getJSON("updateprocess.php", {
					checkid: check_id
				}, function (json) {
					if (json.status == 0) {
						$('#upd_1').val(json.username);
						$('#upd_2').val(json.email);
						$('#upd_4').val(json.public_key);
						$('#upd_7').val(check_id);
						
					} else {
						console.log(json.msg);
					}
				});
			});

			//Update Record

			$('#updata').on("submit", function (e) {
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: 'updateprocess2.php',
					data: $(this).serialize(),
					success: function (vardata) {
						var json = JSON.parse(vardata);
						if (json.status == 101) {
							console.log(json.msg);
							$('#tbl_rec').load('record.php');
							$('#ins_rec').trigger('reset');
							$('#up_cancle').trigger('click');
						} else if (json.status == 102) {
							$('#umsg_6').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 103) {
							$('#umsg_1').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 104) {
							$('#umsg_2').text(json.msg);
							console.log(json.msg);
						}
						// else if(json.status == 105){
						// 	$('#umsg_3').text(json.msg);
						// 	console.log(json.msg);
						// }
						else if (json.status == 107) {
							$('#umsg_4').text(json.msg);
							console.log(json.msg);
						} else if (json.status == 106) {
							$('#umsg_5').text(json.msg);
							console.log(json.msg);
						} else {
							console.log(json.msg);
						}

					}

				});

			});

			//delete record

			var deleteid;

			$(document).on("click", "button.deletedata", function () {
				deleteid = $(this).data("dataid");
			});

			$('#deleterec').click(function () {
				$.ajax({
					type: 'POST',
					url: 'deleteprocess.php',
					data: {
						delete_id: deleteid
					},
					success: function (data) {
						var json = JSON.parse(data);
						if (json.status == 0) {
							$('#tbl_rec').load('record.php');
							$('#de_cancle').trigger("click");
							console.log(json.msg);
						} else {
							console.log(json.msg);
						}
					}
				});
			});


		});
	</script>

</body>

</html>