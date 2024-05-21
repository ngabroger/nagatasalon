<?php 
include "../connection/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role_user"];

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("UPDATE users SET role=?, user_name=?, password=?, name=? WHERE id=?");
    
    // Binding parameters
    // 's' means the corresponding variable is of type string, 'i' means integer
    $query->bind_param("ssssi", $role, $username, $password, $name, $id);

    if ($query->execute()) {
        // Data edited successfully, redirect to the appropriate page
        echo "<script>window.location='../kelola.php';</script>";
        exit();
    } else {
        // Error in editing data, display error message
        echo "<script>alert('Data Gagal Diedit.');window.location='../kelola.php';</script>";
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
