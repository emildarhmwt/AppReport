<?php
include '../Koneksi.php';

$id = $_POST['operation_report_id'];
$proses_pengawas = $_POST['proses_pengawas'];
$proses_kontraktor = $_POST['proses_kontraktor'];
$alasan_reject = $_POST['alasan_reject'];

// Update production_report
$sql_update = "UPDATE production_report SET 
    proses_pengawas = 'Pending',
    proses_kontraktor = NULL, 
    alasan_reject = NULL
    WHERE operation_report_id = $1";

$result_update = pg_query_params($conn, $sql_update, array($id));

if ($result_update) {
    echo "Produksi berhasil diperbarui.";
    header("Location: Preview.php?id=" . $id); 
    exit;
} else {
    echo "Error updating data.";
}
?>