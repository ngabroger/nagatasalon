<?php
include('../connection/db_conn.php');

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Debugging: Tampilkan isi $_GET untuk memeriksa parameter (hapus setelah debugging)
// var_dump($_GET);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_layanan'])) {
    // Mendapatkan nilai ID dari parameter GET
    $id = $_GET['id_layanan'];
    
    // Validasi bahwa id_layanan adalah string atau tipe data lain yang sesuai
    if (is_string($id) && !empty($id)) {
        // Menyiapkan pernyataan SQL untuk menghapus data profil berdasarkan ID
        $sql = "DELETE FROM layanan WHERE id_layanan = ?";
        
        // Menyiapkan pernyataan prepared statement
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // Bind parameter ke pernyataan prepared statement
            $stmt->bind_param("s", $id); // Gunakan "s" untuk string
            
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
            // Jika persiapan pernyataan gagal, tampilkan pesan kesalahan
            echo "Error: " . $conn->error;
        }
    } else {
        // Jika id_layanan tidak valid, tampilkan pesan kesalahan
        echo "Parameter ID tidak valid.";
    }
} else {
    // Jika parameter tidak valid atau bukan metode GET, tampilkan pesan kesalahan
    echo "Parameter ID tidak valid atau bukan metode GET.";
}

// Menutup koneksi
$conn->close();
?>
