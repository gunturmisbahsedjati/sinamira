<?php

// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_sinamira";

// Array untuk menyimpan koneksi database
$connections = [];

// Fungsi untuk mendapatkan koneksi database
function getConnection()
{
  global $connections;
  $host = "localhost";
  $user = "root";
  $password = "";
  $dbname = "db_sinamira";
  // Kita hanya perlu membuat satu koneksi
  if (empty($connections)) {
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $connections[] = $conn;
  }

  // Mengembalikan koneksi yang ada
  return $connections[0];
}

// Contoh penggunaan database pooling
// Untuk Koneksi 1
$conn1 = getConnection();
$result1 = $conn1->query("SELECT * FROM akun_manajemen");

// Untuk Koneksi 2
$conn2 = getConnection(); // Menggunakan koneksi yang sama
$result2 = $conn2->query("SELECT * FROM db_level_akun");

// ... kode lain yang menggunakan koneksi database ...

// Database pooling menghubungkan koneksi dengan fungsi getConnection()
// sehingga hanya ada satu koneksi yang aktif di database di saat yang bersamaan.
//
while ($row = mysqli_fetch_array($result2)) {
  echo $row['id_level_akun'] . " - " . $row['level'] . "<br>";
}
