<?php 
include('../connection/db_conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_layanan = $_POST["id_layanan"];
    $nama_layanan = $_POST["nama_layanan"];
    $harga_layanan = $_POST["harga_layanan"];

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("INSERT INTO layanan (id_layanan,nama_layanan, harga_layanan) VALUES (?,?, ?)");

    // Binding parameters
    $query->bind_param("sss",$id_layanan, $nama_layanan, $harga_layanan);

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