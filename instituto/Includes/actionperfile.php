<?php

if (!isset($_SESSION['id_usuario']) && $_SESSION['id_usuario']==null) {
	header("location: ../");
}
require_once './Includes/load.php';

$login = $_SESSION['id_usuario'];
$email = $_POST['email'];
$pass = $_POST['password'];

if (isset($_POST['token'])) {

	$sql = "UPDATE usuarios SET mail='$email' WHERE usuario='$login'";
	if ($sql) {
		$success = sha1(md5("datos actualizados"));
		header("location: /instituto/Adman/profile.php?success=$success");
	} else {
		// echo "error";
	}

	// CHANGE PASSWORD
	if ($_POST['password'] != "") {

		$password = sha1(md5($_POST['password']));
		$new_password = sha1(md5($_POST['new_password']));
		$confirm_new_password = sha1(md5($_POST['confirm_new_password']));

		if ($_POST['new_password'] == $_POST['confirm_new_password']) {

			$sql = mysqli_query($con, "SELECT * from usuarios where usuario='$login'");
			while ($row = mysqli_fetch_array($sql)) {
				$p = $row['password'];
			}

			if ($p == $password) { //comprobamos que la contraseña sea igual ala anterior

				$update_passwd = mysqli_query($con, "UPDATE usuarios set clave='$password' where usuario='$login'");
				if ($update_passwd) {
					$success_pass = sha1(md5("contrasena actualizada"));
					header("location:/instituto/Adman/profile.php?success_pass=$success_pass");
				}
			} else {
				$invalid = sha1(md5("la contraseña no coincide la contraseña con la anterior"));
				header("location: /instituto/Adman/profile.php?invalid=$invalid");
			}
		} else {
			$error = sha1(md5("las nuevas contraseñas no coinciden"));
			header("location: /instituto/Adman/profile.php?error=$error");
		}
	}
} else {
	header("location: ../");
}

?>