<?php
session_start();
include '../Koneksi.php';

$admin_id = $_SESSION['id'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$file_path = $_FILES['file_path']; // Ensure this matches the input name in profile.php

// Update query
$sql = "UPDATE admin_report SET nama = $1, username = $2 WHERE id = $3";

// Check if password is provided
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE admin_report SET nama = $1, username = $2, password = $3 WHERE id = $4";
    $params = array($nama, $username, $hashed_password, $admin_id);
} else {
    $params = array($nama, $username, $admin_id);
}

// Execute query
$result = pg_query_params($conn, $sql, $params);

if ($result) {
    // Handle file upload if a new file is provided
    if ($file_path['size'] > 0) {
        $target_dir = "../barcode/";
        $target_file = $target_dir . basename($file_path["name"]);
        move_uploaded_file($file_path["tmp_name"], $target_file);

        // Update file path in database
        $sql_file = "UPDATE admin_report SET file_admin = $1 WHERE id = $2";
        pg_query_params($conn, $sql_file, array($target_file, $admin_id));
    }

    echo "<script>console.log('Data berhasil disimpan.'); window.location.href='profile.php';</script>";
} else {
    echo "<script>console.log('Data gagal disimpan');</script>";
}

pg_close($conn);
?>