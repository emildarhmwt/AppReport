<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $id = $_POST['id'];
    $operation_report_id = $_POST['operation_report_id'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $alasan_reject = $_POST['alasan_reject'];
    $kontraktor = $_POST['kontraktor'];
    $name_pengawas = $_POST['name_pengawas'];
    $file_pengawas = $_POST['file_pengawas'];
    $name_kontraktor = $_POST['name_kontraktor'];
    $file_kontraktor = $_POST['file_kontraktor'];

$query = "UPDATE hourmeter_report SET operation_report_id = $1, proses_pengawas = NULL, proses_kontraktor = NULL, alasan_reject = NULL, kontraktor = NULL, name_pengawas = NULL, file_pengawas = NULL, name_kontraktor = NULL, file_kontraktor = NULL WHERE id = $2";
$result = pg_query_params($conn, $query, array($operation_report_id, $id));

     if ($result) {
        echo "Jam Jalan berhasil diperbarui.";
        header("Location: Preview_hm.php?id=" . $operation_report_id); 
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui produksi.";
    }
} else {
    echo "Invalid request method.";
}