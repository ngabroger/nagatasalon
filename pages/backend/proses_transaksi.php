<?php
include('../connection/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_layanan_ids = $_POST['jenis_layanan'];
    $jumlahs = $_POST['jumlah'];
    $total_harga = $_POST['total_harga'];
    $uang_customer = $_POST['uang_customer'];

    // Cek jika jumlah layanan dan jumlah cocok
    if (count($jenis_layanan_ids) !== count($jumlahs)) {
        echo "Jumlah layanan dan jumlah tidak cocok.";
        exit();
    }

    $total_harga_sementara = 0;
    $transaksi_details = [];

    foreach ($jenis_layanan_ids as $index => $jenis_layanan_id) {
        $jumlah = $jumlahs[$index];

        // Ambil data layanan dari database
        $sql = "SELECT nama_layanan, harga_layanan FROM layanan WHERE id_layanan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $jenis_layanan_id);
        $stmt->execute();
        $stmt->bind_result($nama_layanan, $harga_layanan);
        $stmt->fetch();
        $stmt->close();

        if ($nama_layanan) {
            $total_harga_sementara += $harga_layanan * $jumlah;
            $transaksi_details[] = [
                'nama_layanan' => $nama_layanan,
                'jumlah' => $jumlah,
                'harga' => $harga_layanan * $jumlah
            ];
        } else {
            echo "Jenis layanan ID $jenis_layanan_id tidak ditemukan.";
            exit();
        }
    }

    if ($uang_customer >= $total_harga_sementara) {
        $tanggal_transaksi = date('Y-m-d H:i:s');

        // Simpan data transaksi ke database
        $sql = "INSERT INTO transaksi (nama_pelanggan, tanggal_transaksi, total) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama_pelanggan, $tanggal_transaksi, $total_harga_sementara);

        if ($stmt->execute()) {
            $transaksi_id = $stmt->insert_id;

            // Simpan detail transaksi ke database
            $sql = "INSERT INTO detail_transaksi (transaksi_id, nama_layanan, jumlah, harga) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            foreach ($transaksi_details as $detail) {
                $stmt->bind_param("isid", $transaksi_id, $detail['nama_layanan'], $detail['jumlah'], $detail['harga']);
                $stmt->execute();
            }

            $stmt->close();

            // Redirect ke receipt.php dengan data transaksi
            header("Location: ../receipt.php?id_transaksi=" . urlencode($transaksi_id) .
                    "&nama_pelanggan=" . urlencode($nama_pelanggan) . 
                    "&tanggal_transaksi=" . urlencode($tanggal_transaksi) . 
                    "&total_harga=" . urlencode($total_harga_sementara) . 
                    "&uang_customer=" . urlencode($uang_customer));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Uang tidak cukup untuk membayar.";
    }
}

$conn->close();
?>
