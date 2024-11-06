<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $shift= $_POST['shift'];

    // Validate input
    if (empty($shift)) {
        echo "Shift harus diisi.";
        exit;
    }


    $query = "UPDATE shift SET shift = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($shift, $id));

    if ($result) {
        echo  "Shift berhasil diperbarui.";
        header("Location: Shift.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui shift.";
    }
} else {
    echo "Invalid request method.";
}