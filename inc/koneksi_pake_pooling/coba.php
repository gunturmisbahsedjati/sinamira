<?php

require_once("config.php");

//  Ukuran pool koneksi (bisa disesuaikan)
$poolSize = 5;
// Membangun pool koneksi
$dbPool = createPool($poolSize);

//  Contoh penggunaan koneksi dari pool:
$conn = getConnection($dbPool);

//  Eksekusi query pada koneksi
$result = $conn->query("SELECT * FROM db");

//  Kembalikan koneksi ke pool:
returnConnection($conn, $dbPool);

// Tutup koneksi yang dipinjam
while