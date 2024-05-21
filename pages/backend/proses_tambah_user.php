<?php 
include('../connection/db_conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_user = $_POST["nama_user"];
    $role_user = $_POST["role_user"];
    $username = $_POST["username"];
    $password = $_POST["password"];


    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("INSERT INTO users (role, user_name, password, name) VALUES (?, ?, ?, ?)");


    // Binding parameters
    $query->bind_param("ssss", $role_user, $username, $password, $nama_user);

    if ($query->execute()) {
        // Data inserted successfully, redirect to the appropriate page
        echo "<script>window.location='../kelola.php';</script>";
        exit();
    } else {
        // Error in inserting data, display error message
        echo "<script>alert('Data Gagal Ditambahkan.');window.location='../kelola.php';</script>";
        echo "Error: " . $query->error;
    }

    // Close statement
    $query->close();
    // Close connection
    $conn->close();
} else {
    // If not a POST request, redirect to the data page
    header("Location: ../kelola.php");
    exit();
}

?>