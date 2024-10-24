<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $tipe= $_POST['tipe'];
    $jumlah = $_POST['jumlah'];

    // Validate input
    if (empty($tipe) || empty($jumlah)) {
        echo "Tipe hauler dan jumlah harus diisi.";
        exit;
    }


    $query = "UPDATE muatan SET tipe = $1, jumlah = $2 WHERE id = $3";
    $result = pg_query_params($conn, $query, array($tipe, $jumlah, $id));

    if ($result) {
        echo  "Muatan berhasil diperbarui.";
        header("Location: Muatan.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui muatan.";
    }
} else {
    echo "Invalid request method.";
}