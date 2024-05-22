<?php
include('../connection/db_conn.php');

// Debugging: Tampilkan isi $_GET untuk memeriksa parameter
var_dump($_GET);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_transaksi'])) {
    // Mendapatkan nilai ID dari parameter GET
    $id = $_GET['id_transaksi'];
    
    // Validasi bahwa id_layanan adalah integer
    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
        // Menyiapkan pernyataan SQL untuk menghapus data profil berdasarkan ID
        $sql = "DELETE FROM transaksi WHERE id_transaksi = ?";
        
        // Menyiapkan pernyataan prepared statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameter ke pernyataan prepared statement
        $stmt->bind_param("i", $id);
        
        // Menjalankan pernyataan prepared statement dan menangani kesalahan
        if ($stmt->execute()) {
            // Jika penghapusan berhasil, arahkan kembali ke halaman utama
            echo "<script>alert('Data Berhasil Dihapus.');window.location='../kelola.php';</script>";
            exit(); // Pastikan untuk keluar setelah menggunakan header
        } else {
            // Jika terjadi kesalahan, tampilkan pesan kesalahan
            echo "Error: " . $stmt->error;
        }
        
        // Menutup prepared statement
        $stmt->close();
    } else {
        // Jika id_layanan tidak valid, tampilkan pesan kesalahan
        echo "Parameter ID tidak valid.";
    }
} else {
    // Jika parameter tidak valid atau bukan metode GET, tampilkan pesan kesalahan
    echo "Parameter ID tidak valid atau bukan metode GET.";
}
?>
