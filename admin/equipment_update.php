<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $equipment = $_POST['equipment'];
    $tipe_unit = $_POST['tipe_unit'];

    // Validate input
    if (empty($equipment) || empty($tipe_unit)) {
        echo "Equipment dan Tipe Unit harus diisi.";
        exit;
    }

    $query = "UPDATE equipment SET equipment = $1, tipe_unit = $2 WHERE id = $3";
    $result = pg_query_params($conn, $query, array($equipment, $tipe_unit, $id));

    if ($result) {
        echo "Equipment berhasil diperbarui.";
        header("Location: Equipment.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui equipment.";
    }
} else {
    echo "Invalid request method.";
}