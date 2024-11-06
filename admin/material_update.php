<?php
include '../Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $material = $_POST['material'];

    // Validate input
    if (empty($material)) {
        echo "Material tanah harus diisi.";
        exit;
    }

    $query = "UPDATE material SET material = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, array($material, $id));

    if ($result) {
        echo  "Material tanah berhasil diperbarui.";
        header("Location: material.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui material tanah.";
    }
} else {
    echo "Invalid request method.";
}