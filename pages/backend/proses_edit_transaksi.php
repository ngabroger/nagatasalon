<?php 
include "../connection/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $tanggal_transaksi = $_POST["tanggal_transaksi"];
    $nama_pelanggan = $_POST["nama_pelanggan"];
    $jenis_layanan = $_POST["jenis_layanan"];
    $total = $_POST["total"];

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("UPDATE transaksi SET nama_pelanggan=?, tanggal_transaksi=?, jenis_layanan=?, total=?  WHERE id_transaksi=?");
    
    // Binding parameters
    $query->bind_param("ssssi", $nama_pelanggan, $tanggal_transaksi,$jenis_layanan, $total,$id);

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
