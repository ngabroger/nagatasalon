<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=data_transaksi.xls");
	?>
	<h3>Data Transaksi</h3>    
	<table border="1" cellpadding="5"> 
	<tr>    
	<th>ID Transaksi</th>
    <th>Tanggal Transaksi</th>
    <th>Nama Pelanggan</th>    
	<th>Jenis Layanan</th> 
	<th>Total</th> 
	
	</tr>  
	<?php  
	// Load file koneksi.php  
	include "../connection/db_conn.php";    
	// Buat query untuk menampilkan semua data siswa 
$query = mysqli_query($conn, "SELECT * FROM transaksi");
	// Untuk penomoran tabel, di awal set dengan 1 
	while($data = mysqli_fetch_array($query)){ 
	// Ambil semua data dari hasil eksekusi $sql 
	echo "<tr>";    
	echo "<td>".$data['id_transaksi']."</td>";   
	echo "<td>".$data['tanggal_transaksi']."</td>";    
	echo "<td>".$data['nama_pelanggan']."</td>";    
	echo "<td>".$data['jenis_layanan']."</td>";    
	echo "<td>".$data['total']."</td>";      
	echo "</tr>";        
	}  ?></table>