<?php
session_start();
include './koneksi.php';

$username = $_POST['username'];
$password = $_POST['password']; // Ambil password tanpa hashing
$akses = $_POST['akses'];

// Debugging: Log input
error_log("Username: $username, Akses: $akses");

// Cek kredensial pengguna
if ($akses == "admin") {
    $query = "SELECT * FROM admin_report WHERE username=$1";
    $result = pg_query_params($conn, $query, array($username));
} elseif ($akses == "user"){
    $query = "SELECT * FROM user_report WHERE username=$1";
    $result = pg_query_params($conn, $query, array($username));
} else {
     $query = "SELECT * FROM kontraktor_report WHERE username=$1";
    $result = pg_query_params($conn, $query, array($username));
}

// Debugging: Log query result
if (!$result) {
    error_log("Query failed: " . pg_last_error($conn));
} else {
    error_log("Query succeeded");
}

$cek = pg_num_rows($result);

if ($cek > 0) {
    $data = pg_fetch_assoc($result);
    // Verifikasi password
    if (password_verify($password, $data['password'])) {
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['akses'] = $akses;

        if ($akses == "admin") {
            header("location:./admin/dashboard_admin.php");
        } elseif ($akses == "user") {
            header("location:./pengawas/dashboard_pengawas.php");
        } else {
            header("location:./kontraktor/dashboard_kontraktor.php");
        }
    } else {
        // Kirim pesan kesalahan ke halaman login
        header("location:index.php?alert=gagal&message=Invalid username or password");
    }
} else {
    // Kirim pesan kesalahan ke halaman login
    header("location:index.php?alert=gagal&message=Invalid username or password");
}
?>