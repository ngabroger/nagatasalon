<?php
include('../connection/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_transaksi'])) {
    // Mendapatkan nilai ID dari parameter GET
    $id = $_GET['id_transaksi'];
    
    // Validasi bahwa id_transaksi adalah integer
    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
        // Mulai transaksi
        $conn->begin_transaction();

        try {
            // Hapus dari detail_transaksi terlebih dahulu
            $sql_detail = "DELETE FROM detail_transaksi WHERE transaksi_id = ?";
            $stmt_detail = $conn->prepare($sql_detail);
            $stmt_detail->bind_param("i", $id);
            
            if (!$stmt_detail->execute()) {
                throw new Exception("Error: " . $stmt_detail->error);
            }
            $stmt_detail->close();

            // Hapus dari transaksi
            $sql_transaksi = "DELETE FROM transaksi WHERE id_transaksi = ?";
            $stmt_transaksi = $conn->prepare($sql_transaksi);
            $stmt_transaksi->bind_param("i", $id);

            if ($stmt_transaksi->execute()) {
                // Commit transaksi jika semuanya berhasil
                $conn->commit();
                echo "<script>alert('Data Berhasil Dihapus.');window.location='../transaksi.php';</script>";
            } else {
                throw new Exception("Error: " . $stmt_transaksi->error);
            }

            $stmt_transaksi->close();
        } catch (Exception $e) {
            // Rollback jika terjadi kesalahan
            $conn->rollback();
            echo $e->getMessage();
        }

        $conn->close();
    } else {
        echo "Parameter ID tidak valid.";
    }
} else {
    echo "Parameter ID tidak valid atau bukan metode GET.";
}
?>
