<?php
include '../Koneksi.php';

$id = $_POST['operation_report_id'];
$proses_pengawas = $_POST['proses_pengawas'];
$proses_kontraktor = $_POST['proses_kontraktor'];
$alasan_reject = $_POST['alasan_reject'];
$kontraktor = $_POST['kontraktor'];
$name_pengawas = $_POST['name_pengawas'];
$file_pengawas = $_POST['file_pengawas'];

// Update production_report
$sql_update = "UPDATE production_report SET 
    proses_pengawas = 'Rejected Pengawas', 
    proses_kontraktor = NULL, 
    alasan_reject = $1,
    kontraktor = NULL,
    name_pengawas = NULL, 
    file_pengawas = NULL, 
    WHERE operation_report_id = $2";

$result_update = pg_query_params($conn, $sql_update, array($alasan_reject, $id));

if ($result_update) {
    echo "Produksi berhasil diperbarui.";
    header("Location: Preview.php?id=" . $id); 
    exit;
} else {
    echo "Error updating data.";
}
?>