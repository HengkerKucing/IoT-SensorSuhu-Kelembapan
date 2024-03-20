<?php
// Ambil data dari URL
$humidity = filter_var($_GET['humidity'], FILTER_SANITIZE_NUMBER_FLOAT);
$temperature = filter_var($_GET['suhu'], FILTER_SANITIZE_NUMBER_FLOAT);

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eslolin";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Prepared statement untuk mencegah SQL injection
$sql = "INSERT INTO data_sensor (tglData, suhu, kelembapan) VALUES (NOW(), ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameter ke statement
mysqli_stmt_bind_param($stmt, "dd", $temperature, $humidity);

// Eksekusi statement
mysqli_stmt_execute($stmt);

// Tutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Pesan sukses
echo "Data berhasil disimpan!";
?>
