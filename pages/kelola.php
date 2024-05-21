<?php 
session_start();

// Periksa apakah peran pengguna adalah 'owner'
if ($_SESSION['role'] !== 'owner') {
  // Jika tidak, arahkan pengguna ke halaman lain atau tampilkan pesan kesalahan
  echo "<script>alert('Akses ditolak. Halaman ini hanya untuk pemilik.');window.location='dashboard.php';</script>";
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
          <a class="nav-link text-white " href="../pages/dashboard.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="#">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Kelola</span>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Kelola</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Kelola</h6>
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
        <div class="col-xl-9 col-md-6 mb-3">
          <div class="card h-100">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">account_balance</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Pemasukan</p>
                <h4 class="mb-0 fs-2">Rp. <?php echo number_format($total_pemasukan, 0, ',', '.');?>/Minggu</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ">
              <a href="backend/export-transaksi.php" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Download dalam bentuk excel" data-container="body" data-animation="true"><i class="material-icons">download</i> Download</a>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 ">
          <div class="card h-100">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">group</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Transaksi</p>
                <h4 class="mb-0"><?php echo $total_pelanggan; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-4">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></p>
            </div>
          </div>
        </div>
        
      </div>
      <div class="row" style="max-height: 100%;">
      
     
        <div class="col-md-12 col-xl-6" >
        <div class="  d-flex justify-content-end " >
        <div class="position-absolute ms-5"style="z-index: 100;">
          <a  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary"><i class="material-icons">add</i></a>
        </div>
        
        </div>
          <div class="card p-3" style="height: 350px;">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
              <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Layanan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Layanan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Layanan</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
       
         
        </tr>
      </thead>
      <tbody>
        <?php 
        $limit = 5;
        $no = 1;
        $page = isset($_GET['page']) ? $_GET['page']  : 1;
        $start= ($page - 1) * $limit;

        $query = "SELECT * FROM layanan LIMIT $start, $limit";
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
                <h6 class='text-sm font-weight-normal mb-0' >{$no}</h6>
              </div>
            </td>
            
            <td>
              <div class=''>
                <h6 class='text-sm font-weight-normal mb-0'>{$row['nama_layanan']}</h6>
              </div>
            </td>
            <td>
              <div class=''>
              <h6 class='text-sm font-weight-normal mb-0'>Rp.{$row['harga_layanan']}</h6>
              </div>
            </td>
            <td class=' text-sm'>
              <div class='col d-flex'>
              <form action='backend/proses_delete_layanan.php' class='me-1' method='get' id='deleteForm_{$row['id_layanan']}'>
              <input type='hidden' name='id_layanan' value='{$row['id_layanan']}'>
              </form>
              <button class='btn btn-danger' onClick='showDeleteConfirmation({$row['id_layanan']})'><i class='material-icons'>delete</i></button>
              <a data-bs-toggle='modal' data-bs-target='#staticBackdrop1{$row['id_layanan']}' class='btn btn-warning'><i class='material-icons'>edit</i></a>
            </div>
              </div>
            </td>
           
          </tr>
          ");
          $no++;
        }
      } else {
          // Menampilkan pesan jika data tidak ditemukan
          echo "<tr><td class='text-center' colspan='7'>Data not found.</td></tr>";
      }
     
      
      $conn->close();
        ?>
      </tbody>
              </table>
            </div>
          </div>
          <?php
                      // Include file koneksi database
                      include "connection/db_conn.php";

                      // Query untuk mendapatkan total data
                      $queryTotal = "SELECT COUNT(id_layanan) as total FROM layanan";
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
        <!-- AKUN TABLE -->
        <div class="col-md-12 col-xl-6" >
        <div class="  d-flex justify-content-end " >
        <div class="position-absolute ms-5"style="z-index: 100;">
          <a  data-bs-toggle="modal" data-bs-target="#exampleModal2" class="btn btn-primary"><i class="material-icons">add</i></a>
        </div>
        
        </div>
          <div class="card p-3" style="height: 350px;">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
              <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Users</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama User</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Password User</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role User</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
       
         
        </tr>
      </thead>
      <tbody>
        <?php 
        include ('connection/db_conn.php');
        $no = 1;
        $page = isset($_GET['page']) ? $_GET['page']  : 1;
       

        $query = "SELECT * FROM users";
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
                <h6 class='text-sm font-weight-normal mb-0' >{$no}</h6>
              </div>
            </td>
            <td>
              <div class=''>
                <h6 class='text-sm font-weight-normal mb-0'>{$row['name']}</h6>
              </div>
            </td>
            <td>
              <div class=''>
              <h6 class='text-sm font-weight-normal mb-0'>{$row['password']}</h6>
              </div>
            </td>
            <td>
              <div class=''>
              <h6 class='text-sm font-weight-normal mb-0'>{$row['role']}</h6>
              </div>
            </td>
            <td class=' text-sm'>
              <div class='col d-flex'>
              <form action='backend/proses_delete_user.php' class='me-1' method='get' id='deleteFormUser_{$row['id']}'>
                <input type='hidden' name='id' value='{$row['id']}'>
                </form>
                <a href='#' class='btn btn-danger' onClick='showDeleteConfirmationUser({$row['id']})'><i class='material-icons'>delete</i></a>
              <a data-bs-toggle='modal' data-bs-target='#editModal{$row['id']}' class='btn btn-warning'><i class='material-icons'>edit</i></a>
            </div>
              </div>
            </td>
           
          </tr>
          ");
          $no++;
        }
      } else {
          // Menampilkan pesan jika data tidak ditemukan
          echo "<tr><td class='text-center' colspan='7'>Data not found.</td></tr>";
      }
     
      
      $conn->close();
        ?>
      </tbody>
              </table>
            </div>
          </div>
         
        </div>
      </div>
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
  <!-- MODAL ADD LAYANAN -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary justify-content-center d-flex">
        <h5 class="modal-title fs-3 text-white" id="exampleModalLabel">Tambah Layanan</h5>
      
      </div>
      <div class="modal-body">
        <form action="backend/proses_tambah_layanan.php" method="post" id="tambahLayananForm">
        <div class="input-group input-group-outline my-3">
          <label class="form-label">Nama Layanan</label>
          <input type="text" name="nama_layanan" class="form-control">
        </div>
        <div class="input-group input-group-outline mb-3">
          <label class="form-label">Harga</label>
          <input type="text" name="harga_layanan" class="form-control">
        </div>          
                      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit " form="tambahLayananForm"  class="btn bg-gradient-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <!-- MODAL ADD END -->
  <!-- MODAL ADD USER -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary justify-content-center d-flex">
        <h5 class="modal-title fs-3 text-white" id="exampleModalLabel">Tambah User</h5>
      
      </div>
      <div class="modal-body">
        <form action="backend/proses_tambah_user.php" method="post" id="tambahuserForm">
        <div class="input-group input-group-outline my-3">
          <label class="form-label">Nama User</label>
          <input type="name" name="nama_user" class="form-control">
        </div>
        <div class="input-group input-group-outline my-3">
        <select name="role_user" class="form-control" id="roleuser">
        <option value="" selected disabled>Pilih Jenis Role</option>
        <option value="kasir">Kasir</option>
        <option value="owner">Owner</option>
        </select>
        </div>
               
        <div class="input-group input-group-outline my-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control">
        </div>       
        <div class="input-group input-group-outline my-3">
          <label class="form-label">Password</label>
          <input type="text" name="password" class="form-control">
        </div>       
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit " form="tambahuserForm"  class="btn bg-gradient-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <!-- MODAL ADD END -->

 <!-- MODAL ENTRY FOR  EDIT LAYANAN-->
 <?php
    include ('connection/db_conn.php');
    $result = mysqli_query($conn, "SELECT * FROM layanan");
    while ($d = mysqli_fetch_assoc($result)) {
        echo "
        <div class='modal fade' id='staticBackdrop1{$d['id_layanan']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
        <div class='modal-header bg-primary justify-content-center d-flex'>
        <h1 class='modal-title fs-3 text-white' id='staticBackdropLabel'>Edit Layanan</h1>
        </div>
            <form action='backend/proses_edit_layanan.php' method='post' role='form'>
                <div class='modal-body'>
                    <div class='form-group'>
                        <div class='row'>
                            <input type='hidden' name='id' value='{$d['id_layanan']}'>
                            <div class='input-group input-group-outline my-3'>
                                <input type='text' id='nama' name='nama_layanan' class='form-control' value='{$d['nama_layanan']}' required='' placeholder='' />
                            </div>
                            <div class='input-group input-group-outline my-3'>
                                <input type='text' id='harga' name='harga_layanan' class='form-control' value='{$d['harga_layanan']}' required='' placeholder='' />
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-success'>Submit</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>";
    }
?>
 <!-- MODAL END FOR EDIT LAYANAN -->

 <!-- MODAL ENTRY FOR  EDIT USER-->
 <?php
    include ('connection/db_conn.php');
    $result = mysqli_query($conn, "SELECT * FROM users");
    while ($d = mysqli_fetch_assoc($result)) {
        echo "
        <div class='modal fade' id='editModal{$d['id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
        <div class='modal-header bg-primary justify-content-center d-flex'>
        <h1 class='modal-title fs-3 text-white' id='staticBackdropLabel'>Edit User</h1>
        </div>
            <form action='backend/proses_edit_users.php' method='post' role='form'>
                <div class='modal-body'>
                    <div class='form-group'>
                        <div class='row'>
                            <input type='hidden' name='id' value='{$d['id']}'>
                            <div class='input-group input-group-outline my-3'>
                                <input type='text' id='name' name='name' class='form-control' value='{$d['name']}' required='' placeholder='' />
                            </div>
                            <div class='input-group input-group-outline my-3'>
                                <input type='text' id='username' name='username' class='form-control' value='{$d['user_name']}' required='' placeholder='' />
                            </div>
                            <div class='input-group input-group-outline my-3'>
                                <input type='text' id='password' name='password' class='form-control' value='{$d['password']}' required='' placeholder='' />
                            </div>
                            <div class='input-group input-group-outline my-3'>
                              <select name='role_user' class='form-control' id='roleuser'>
                               
                                <option value='kasir'>Kasir</option>
                                <option value='owner'>Owner</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-success'>Submit</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>";
    }
?>
 <!-- MODAL END FOR EDIT USER -->
 
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