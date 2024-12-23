<?php

// Informasi koneksi database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_sinamira');
define('DB_USER', 'root');
define('DB_PASS', '');

function connectDB()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_errno) {
        die("Gagal terhubung ke database: " . $conn->connect_error);
    }

    return $conn;
}

function createPool($poolSize)
{
    $pool = [];
    for ($i = 0; $i < $poolSize; $i++) {
        $pool[] = connectDB();
    }
    return $pool;
}

function getConnection($pool)
{
    return array_shift($pool); // Ambil koneksi pertama dari array
}

function returnConnection($conn, $pool)
{
    $pool[] = $conn; // Simpan kembali koneksi ke akhir array
}
