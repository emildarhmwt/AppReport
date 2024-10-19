<?php
// Detail koneksi
$host = "localhost";
$port = "5432";
$dbname = "Aplikasi";
$user = "postgres";
$password = "emilda123";

// Membuat koneksi
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

// Mengecek koneksi
if (!$conn) {
    error_log('Terjadi kesalahan koneksi ke PostgreSQL.');
    die(json_encode(["error" => "Terjadi kesalahan koneksi ke database."]));
}
?>