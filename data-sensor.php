<?php
// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eslolin";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Pengecekan koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data terbaru dari database
$sql = "SELECT suhu, kelembapan FROM data_sensor ORDER BY tglData DESC LIMIT 1";

// Mendapatkan hasil query
$result = mysqli_query($conn, $sql);

// Menampilkan data dalam satu baris
$row = mysqli_fetch_assoc($result);
echo "Suhu: " . $row["suhu"] . " °C | Kelembapan: " . $row["kelembapan"] . " %";

// Menutup koneksi database
mysqli_close($conn);
?>
