<?php 
session_start();

// Periksa apakah peran pengguna adalah 'owner'
if ($_SESSION['role'] !== 'owner') {
  // Jika tidak, arahkan pengguna ke halaman lain atau tampilkan pesan kesalahan
  echo "<script>alert('Akses ditolak. Halaman ini hanya untuk pemilik.');window.location='kasir.php';</script>";
  exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan pengguna
}

// Periksa apakah pengguna sudah login
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
  include('connection/db_conn.php');
  $sql = "SELECT SUM(total) AS total_pemasukan FROM transaksi WHERE tanggal_transaksi >= NOW() - INTERVAL 7 DAY";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $total_pemasukan = $row['total_pemasukan'];
  } else {
      $total_pemasukan = 0;
  }
  $sql = "SELECT COUNT(DISTINCT id_transaksi) AS total_pelanggan FROM transaksi";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $total_pelanggan = $row['total_pelanggan'];
  } else {
      $total_pelanggan = 0;
  }
} else {
  // Jika pengguna belum login, arahkan mereka kembali ke halaman login
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../resources/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../resources/img/favicon.png">
  <title>
  Nagata Salon | Transaksi
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../resources/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../resources/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../resources/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
 
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>
<style>
        /* Untuk Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Untuk Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    .card.h-100 {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
    </style>
<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
       
        <span class="ms-1 font-weight-bold text-white te-center">Barbershop Salon Nagata</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white " href="../pages/kasir.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Kasir</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/kelola.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Kelola</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="#">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Transaksi</span>
          </a>
        </li>
       
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Transaksi</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Transaksi</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
           
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          
            <li class="nav-item d-flex align-items-center">
              <a href="backend/logout.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Log Out</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
    <div class="row ">
       
    <div class="mt-4" >
        <div class="  d-flex justify-content-end " >
       
        </div>
          <div class="card p-3" >
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
              <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Layanan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Transaksi</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama  Pelanggan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Layanan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
       
         
        </tr>
      </thead>
      <tbody>
    <?php 
    include('connection/db_conn.php');
    $no = 1;
    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page']  : 1;
    $start = ($page - 1) * $limit;

    // Query untuk mengambil data dari transaksi dan detail_transaksi
    $query = "SELECT transaksi.id_transaksi, transaksi.tanggal_transaksi, transaksi.nama_pelanggan, transaksi.total,
                     GROUP_CONCAT(CONCAT(detail_transaksi.nama_layanan, ' (', detail_transaksi.jumlah, ')') SEPARATOR ', ') as layanan
              FROM transaksi
              LEFT JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.transaksi_id
              GROUP BY transaksi.id_transaksi
              LIMIT $start, $limit";
    $result = $conn->query($query);

    if ($result === false) {
        die('Error: ' . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo ("
            <tr>
                <td>
                    <div class=''>
                        <h6 class='text-sm font-weight-normal mb-0'>{$no}</h6>
                    </div>
                </td>
                <td>
                    <div class=''>
                        <h6 class='text-sm font-weight-normal mb-0'>{$row['tanggal_transaksi']}</h6>
                    </div>
                </td>
                <td>
                    <div class=''>
                        <h6 class='text-sm font-weight-normal mb-0'>{$row['nama_pelanggan']}</h6>
                    </div>
                </td>
                <td>
                    <div class=''>
                        <h6 class='text-sm font-weight-normal mb-0'>{$row['layanan']}</h6>
                    </div>
                </td>
                <td>
                    <div class=''>
                        <h6 class='text-sm font-weight-normal mb-0'>Rp " . number_format($row['total'], 0, ',', '.') . "</h6>
                    </div>
                </td>
                <td class='text-sm'>
                    <div class='col d-flex'>
                        <form action='backend/proses_delete_transaksi.php' class='me-1' method='get'>
                            <input type='hidden' name='id_transaksi' value='{$row['id_transaksi']}'>
                            <button class='btn btn-danger' type='submit'><i class='material-icons'>delete</i></button>
                        </form>
              
                    </div>
                </td>
            </tr>
            ");
            $no++;
        }
    } else {
        // Menampilkan pesan jika data tidak ditemukan
        echo "<tr><td class='text-center' colspan='6'>Data not found.</td></tr>";
    }

    $conn->close();
    ?>
</tbody>



              </table>
            </div>
            <div class="justify-content-center m-0 w-full p-0">
            <?php
                      // Include file koneksi database
                      include "connection/db_conn.php";

                      // Query untuk mendapatkan total data
                      $queryTotal = "SELECT COUNT(id_transaksi) as total FROM transaksi";
                      $resultTotal = $conn->query($queryTotal);
                      $dataTotal = $resultTotal->fetch_assoc();
                      $totalPages = ceil($dataTotal['total'] / $limit);

                      // Menentukan halaman saat ini
                      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                      // Menampilkan tombol "Previous" jika halaman saat ini lebih dari 1
                      echo '<ul class="pagination justify-content-center">';
                      if ($current_page > 1) {
                          echo '<li class="page-item"><a class="page-link " href="?page=' . ($current_page - 1) . '"><i class="material-icons">arrow_back_ios</i></a></li>';
                      }

                      // Menampilkan nomor-nomor halaman
                      for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<li class="page-item ' . ($current_page == $i ? 'active ' : '') . '"><a class="page-link " href="?page=' . $i . '">' . $i . '</a></li>';
                      }
                      // Menampilkan tombol "Next" jika halaman saat ini kurang dari total halaman
                      if ($current_page < $totalPages) {
                          echo '<li class="page-item"><a class="page-link " href="?page=' . ($current_page + 1) . '"><i class="material-icons">arrow_forward_ios</i></a></li>';
                      }

                      echo '</ul>';

                      $conn->close();
                      ?>
               </div>
          </div>
      
        </div>

      <!-- TABLE TRANSAKSI -->
      
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Welcome  <?php echo $_SESSION['name'];?></h5>
        </div>
        <div class="float-end mt-4">
          <button class="b btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <!--   Core JS Files   -->

  <script src="../resources/js/core/popper.min.js"></script>
  <script src="../resources/js/core/bootstrap.min.js"></script>
  <script src="../resources/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../resources/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../resources/js/plugins/chartjs.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
        function showDeleteConfirmation(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus?',
                text: 'Anda yakin ingin Menghapus Data ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan submit formulir jika konfirmasi diterima
                    document.getElementById('deleteForm_'+ id).submit();
                }
            });
        }
       
    </script>
  <script>
        function showDeleteConfirmationTransaksi(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus?',
                text: 'Anda yakin ingin Menghapus Data ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan submit formulir jika konfirmasi diterima
                    document.getElementById('deleteFormTransaksi_'+ id).submit();
                }
            });
        }
       
    </script>
  
  <script>
        function showDeleteConfirmationUser(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus?',
                text: 'Anda yakin ingin Hapus Data ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan submit formulir jika konfirmasi diterima
                    document.getElementById('deleteFormUser_'+ id).submit();
                }
            });
        }
       
    </script>
    
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../resources/js/material-dashboard.min.js?v=3.1.0"></script>
  
</body>

</html>
 <?php 

     ?>