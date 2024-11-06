<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $executor= $_POST['executor'];

    // Validate input
    if (empty($executor)) {
        echo "Executor harus diisi.";
        exit;
    }


    $query = "UPDATE executor SET executor = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($executor, $id));

    if ($result) {
        echo  "Executor berhasil diperbarui.";
        header("Location: executor.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui executor.";
    }
} else {
    echo "Invalid request method.";
}