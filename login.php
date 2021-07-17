<?php
    include "conf.php";

	if(isLoggedin() === true) {
		header("Location: index.php");
		die();
	}

	if (isset($_POST['login'])) {
		$curl = curl_init($model_url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($_POST));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		if ($response->status === 200) {
			$_SESSION['user_id'] = $response->user_id;
			$_SESSION['is_loggedin'] = true;
			header("Location: index.php");
		} else {
			if (!empty($response->message)) {
				$message = $response->message;
			} else {
				$message = 'Login gagal!';
			}
			echo '<script language="javascript">';
			echo 'alert("'.$message.'")';
			echo '</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
	<div class="container col-md-6 mt-4">
		<div class="card">
			<div class="card-header bg-success text-white">
				Form Login Peserta
			</div>
			<div class="card-body">
				<form action="" method="post" role="form">
					<div class="form-group">
						<label>Username</label>
						<input class="form-control" type="text" name="username" placeholder="Masukan Username" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input class="form-control" type="password" name="password" placeholder="Masukan Password" required>
					</div>
					<button type="submit" class="btn btn-success" name="login" value="simpan">Login</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>