<?php 
session_start(); 
include "../connection/db_conn.php";

// jika tombol login ditekan
if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data) {
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	// validasi nama dan password
	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	// jika nama dan password kosong
	if (empty($uname)) {
		header("Location: ../index.php?error=User Name is required");
	    exit();
	} else if (empty($pass)) {
        header("Location: ../index.php?error=Password is required");
	    exit();
	} else {
		// Menggunakan prepared statement untuk mencegah SQL Injection
		$stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ? AND password = ?");
		$stmt->bind_param("ss", $uname, $pass);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['role'] = $row['role'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: ../dashboard.php");
		        exit();
            } else {
				header("Location: ../index.php?error=Incorrect User name or password");
		        exit();
			}
		} else {
			header("Location: ../index.php?error=Incorrect User name or password");
	        exit();
		}
	}
	
} else {
	header("Location: ../index .php");
	exit();
}
