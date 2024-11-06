<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $timbunan = $_POST['timbunan'];

    // Validate input
    if (empty($timbunan)) {
        echo "Timbunan harus diisi.";
        exit;
    }


    $query = "UPDATE timbunan SET timbunan = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($timbunan, $id));

    if ($result) {
        echo  "Timbunan berhasil diperbarui.";
        header("Location: Timbunan.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui timbunan.";
    }
} else {
    echo "Invalid request method.";
}