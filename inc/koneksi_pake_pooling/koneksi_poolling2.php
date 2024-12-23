<?php

// Konfigurasi database
$db_host = 'localhost';
$db_name = 'nama_database';
$db_user = 'username';
$db_pass = 'password';

// Array untuk menyimpan koneksi database
$connections = [];

function get_connection() {
  global $connections;
  if (empty($connections)) {
    // Buat koneksi baru
    $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);

    // Cek koneksi

    if (!$conn) {
      die('Koneksi database gagal: ' . mysqli_connect_error());
    }

    $connections[$conn->connect_id] = $conn;
  }

  // Return koneksi
  return $connections[key($connections)];
}

// Contoh penggunaan
$conn = get_connection();

// Lakukan query
$result = mysqli_query($conn, 'SELECT * FROM tabel');

// Iterasi dan tampilkan data
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo $row['kolom1'] . " - " . $row['kolom2'] . "<br>";
  }
} else {
  echo 'Error: ' . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);

?>
