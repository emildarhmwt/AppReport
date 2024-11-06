<?php
include '../Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $lokasi = $_POST['lokasi'];

    // Validate input
    if (empty($lokasi)) {
        echo "Lokasi kerja harus diisi.";
        exit;
    }

    $query = "UPDATE lokasi SET lokasi = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($lokasi, $id));

    if ($result) {
        echo  "Lokasi kerja berhasil diperbarui.";
        header("Location: lokasi.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui lokasi kerja.";
    }
} else {
    echo "Invalid request method.";
}