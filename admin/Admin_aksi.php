<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin_report (nama, username, password) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($nama, $username, $hashed_password));

    if ($result) {
        header("Location: admin.php"); // Redirect to admin page after successful insertion
        exit;
    } else {
        echo "Terjadi kesalahan saat menambahkan data.";
    }
}
?>