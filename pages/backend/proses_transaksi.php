<?php
include('../connection/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_layanan_id = $_POST['jenis_layanan'];
    $total_harga = $_POST['total_harga'];
    $uang_customer = $_POST['uang_customer'];

    // Ambil data layanan dari database
    $sql = "SELECT nama_layanan, harga_layanan FROM layanan WHERE id_layanan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jenis_layanan_id);
    $stmt->execute();
    $stmt->bind_result($nama_layanan, $harga_layanan);
    $stmt->fetch();
    $stmt->close();

    if ($nama_layanan) {
        if ($uang_customer >= $total_harga) {
            $tanggal_transaksi = date('Y-m-d H:i:s');

            // Simpan data transaksi ke database
            $sql = "INSERT INTO transaksi (nama_pelanggan, tanggal_transaksi, jenis_layanan, total) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nama_pelanggan, $tanggal_transaksi, $nama_layanan, $total_harga);

            if ($stmt->execute()) {
                // Redirect ke receipt.php dengan data transaksi
                header("Location: ../receipt.php?nama_pelanggan=" . urlencode($nama_pelanggan) . 
                                            "&tanggal_transaksi=" . urlencode($tanggal_transaksi) . 
                                            "&jenis_layanan=" . urlencode($nama_layanan) . 
                                            "&total_harga=" . urlencode($total_harga) . 
                                            "&uang_customer=" . urlencode($uang_customer));
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Uang tidak cukup untuk membayar.";
        }
    } else {
        echo "Jenis layanan tidak ditemukan.";
    }
}

$conn->close();
?>
