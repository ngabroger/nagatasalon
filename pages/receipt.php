<?php
if (isset($_GET['nama_pelanggan']) && isset($_GET['tanggal_transaksi']) && 
    isset($_GET['jenis_layanan']) && isset($_GET['total_harga']) && isset($_GET['uang_customer'])) {

    $nama_pelanggan = $_GET['nama_pelanggan'];
    $tanggal_transaksi = $_GET['tanggal_transaksi'];
    $jenis_layanan = $_GET['jenis_layanan'];
    $total_harga = $_GET['total_harga'];
    $uang_customer = $_GET['uang_customer'];
    $kembalian = $uang_customer - $total_harga;
} else {
    echo "Data transaksi tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="apple-touch-icon" sizes="76x76" href="../resources/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../resources/img/favicon.png">
  <title>

  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../resources/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../resources/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- this is for pdf print -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../resources/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->

  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>
<body>
    <style>
         .card-custom {
            width: 50%; /* Lebar kartu */
            max-width: 600px; /* Maksimal lebar kartu */
            padding: 30px; /* Padding di dalam kartu */
            font-size: 1.2rem;
             /* Ukuran teks */
         /* Bayangan */
        }
    </style>
    
<div class="d-flex justify-content-center p-5 m-0" id="cobaprintini">
    <div class="card card-custom m-0 border" >
        <p class="text-bold fs-4 text-center">Thank You</p>
        <hr class="border border-info border-1 opacity-50 m-0" >
        <p class="text-end m-0 "><?php echo  $tanggal_transaksi; ?></p>
        <p class="text-end m-0 "><?php echo  $nama_pelanggan; ?></p>
        <hr class="border border-info border-1 opacity-50  m-0">
        <p class="text-center mt-3">Transaksi</p>
        <div class="row">
            <div class="col-7">
            <p class="text-start m-0"> <?php echo htmlspecialchars($jenis_layanan); ?> </p>
            </div>
            <div class="col-5 m-0">
           <p class="text-end">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
            <p class="text-start m-0"> Uang Customer  </p>
            </div>
            <div class="col-6">
           <p class="text-end">Rp <?php echo number_format($uang_customer, 0, ',', '.'); ?></p>
            </div>
        </div>
        <hr class="border border-info border-1 opacity-50 m-0 ">
        <div class="row">
            <div class="col-6">
            <p class="text-start m-0"> kembalian  </p>
            </div>
            <div class="col-6">
           <p class="text-end">Rp <?php echo number_format($kembalian, 0, ',', '.'); ?></p>
            </div>
        </div>
        <button id="downloadButton" class="btn btn-primary"  onclick="printPageAsPDF()">Unduh Halaman</button>
    </div>
    
</div>

<script>
      function printPageAsPDF() {
        const doc = new jsPDF();
        const element = document.getElementById("cobaprintini");
        const downloadButton = document.getElementById("downloadButton");
        downloadButton.style.display = "none";
       if (element) {
                html2canvas(element, { scale: 2 }).then(function (canvas) {
                    const imageData = canvas.toDataURL("image/jpeg", 1.0);
                    const pdf = new jsPDF('p', 'pt', 'a4');
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = canvas.width;
                    const imgHeight = canvas.height;
                    const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                    const imgX = (pdfWidth - imgWidth * ratio) / 2;
                    const imgY = (pdfHeight - imgHeight * ratio) / 2;

                    pdf.addImage(imageData, "JPEG", imgX, imgY, imgWidth * ratio, imgHeight * ratio);
                    pdf.save("Your_Bill_Sir.pdf");

                    // Arahkan ke halaman baru setelah mencetak
                    window.location.href = "dashboard.php";
                });
            } else {
                console.error("Element with id 'cobaprintini' not found.");
            }
      }
    </script>

<script src="../resources/js/core/popper.min.js"></script>
  <script src="../resources/js/core/bootstrap.min.js"></script>
  <script src="../resources/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../resources/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../resources/js/plugins/chartjs.min.js"></script>
</body>
</html>