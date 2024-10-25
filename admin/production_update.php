<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $operation_report_id = $_POST['operation_report_id'];
    $alat = $_POST['alat'];
    $timbunan = $_POST['timbunan'];
    $material = $_POST['material'];
    $jarak = $_POST['jarak'];
    $tipe = $_POST['tipe'];
    $ritase = $_POST['ritase'];
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $alasan_reject = $_POST['alasan_reject'];
    $excecutor = $_POST['excecutor'];
    $tipe2 = $_POST['tipe2'];
    $ritase2 = $_POST['ritase2'];
    $muatan = $_POST['muatan'];
    $volume = $_POST['volume'];
    $total_ritase = $_POST['total_ritase'];
    $kontraktor = $_POST['kontraktor'];
    $muatan2 = $_POST['muatan2'];
    $volume2 = $_POST['volume2'];
    $total_volume = $_POST['total_volume'];
    $name_pengawas = $_POST['name_pengawas'];
    $file_pengawas = $_POST['file_pengawas'];
    $name_kontraktor = $_POST['name_kontraktor'];
    $file_kontraktor = $_POST['file_kontraktor'];

    // Validate input
    // if (empty($equipment) || empty($tipe_unit)) {
    //     echo "Equipment dan Tipe Unit harus diisi.";
    //     exit;
    // }

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