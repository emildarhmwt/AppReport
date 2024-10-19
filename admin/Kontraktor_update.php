<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($nama) || empty($username)) {
        echo "Nama dan Username harus diisi.";
        exit;
    }

    // Prepare the update query
    if (!empty($password)) {
        // Hash the password for security if provided
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE kontraktor_report SET nama = $1, username = $2, password = $3 WHERE id = $4";
        $result = pg_query_params($conn, $query, array($nama, $username, $hashedPassword, $id));
    } else {
        // Update without changing the password
        $query = "UPDATE kontraktor_report SET nama = $1, username = $2 WHERE id = $3";
        $result = pg_query_params($conn, $query, array($nama, $username, $id));
    }

    if ($result) {
        echo "Kontraktor berhasil diperbarui.";
        header("Location: Kontraktor.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui kontraktor.";
    }
} else {
    echo "Invalid request method.";
}
?>