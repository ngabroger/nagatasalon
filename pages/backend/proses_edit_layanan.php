<?php 
include "../connection/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama_layanan = $_POST["nama_layanan"];
    $harga = $_POST["harga_layanan"];

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("UPDATE layanan SET nama_layanan=?, harga_layanan=? WHERE id_layanan=?");
    
    // Binding parameters
    $query->bind_param("ssi", $nama_layanan, $harga, $id);

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
