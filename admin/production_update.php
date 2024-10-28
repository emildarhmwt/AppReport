<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isset($_POST['id'])) {
        echo "ID is required.";
        exit;
    }
    
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

$query = "UPDATE production_report SET operation_report_id = $1, alat = $2, timbunan = $3, material = $4, jarak = $5, tipe = $6, ritase = $7, proses_admin = $8, proses_pengawas = NULL, proses_kontraktor = NULL, alasan_reject = NULL, excecutor = $9, tipe2 = $10, ritase2 = $11, muatan = $12, volume = $13, total_ritase = $14, kontraktor = NULL, muatan2 = $15, volume2 = $16, total_volume = $17, name_pengawas = NULL, file_pengawas = NULL, name_kontraktor = NULL, file_kontraktor = NULL WHERE id = $18";
    $result = pg_query_params($conn, $query, array($operation_report_id, $alat, $timbunan, $material, $jarak, $tipe, $ritase, $proses_admin, $excecutor, $tipe2, $ritase2, $muatan, $volume, $total_ritase, $muatan2, $volume2, $total_volume, $id));

      if ($result) {
        echo "Produksi berhasil diperbarui.";
        header("Location: Preview.php?id=" . $operation_report_id); 
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui produksi.";
    }
} else {
    echo "Invalid request method.";
}