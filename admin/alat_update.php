<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $alat = $_POST['alat'];

    // Validate input
    if (empty($alat)) {
        echo "Alat harus diisi.";
        exit;
    }


    $query = "UPDATE alat SET alat = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($alat, $id));

    if ($result) {
        echo  "Alat gali / muat berhasil diperbarui.";
        header("Location: alat.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui alat gali / muat.";
    }
} else {
    echo "Invalid request method.";
}