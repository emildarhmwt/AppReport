<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $grup= $_POST['grup'];

    // Validate input
    if (empty($grup)) {
        echo "Giliran / group harus diisi.";
        exit;
    }


    $query = "UPDATE grup SET grup = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($grup, $id));

    if ($result) {
        echo  "Giliran / group berhasil diperbarui.";
        header("Location: Grup.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui giliran / group.";
    }
} else {
    echo "Invalid request method.";
}