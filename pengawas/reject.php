<?php
include '../Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operationReportId = $_POST['operation_report_id'];
    $alasanReject = $_POST['alasan_reject'];

    $query = "UPDATE production_report 
              SET alasan_reject = $1, proses_pengawas = 'Rejected (Pengawas)' 
              WHERE operation_report_id = $2";

    $result = pg_query_params($conn, $query, array($alasanReject, $operationReportId));

    if ($result) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan saat memperbarui data.";
    }
}
?>