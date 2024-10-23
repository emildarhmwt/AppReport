<?php
include '../Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operationReportId = $_POST['operation_report_id'];
    $kontraktor = $_POST['kontraktor'];
    $pengawasId = $_POST['pengawas']; // Get the selected pengawas ID

    // Fetch TTD from barcode_pengawas table
    $sql_ttd = "SELECT encode(ttd, 'base64') as ttd FROM barcode_pengawas WHERE id = $1";
    $result_ttd = pg_query_params($conn, $sql_ttd, array($pengawasId));

    if ($result_ttd) {
        $ttdData = pg_fetch_result($result_ttd, 0, 'ttd'); // Get the base64 encoded TTD
    } else {
        $ttdData = null;
    }

    // Update the production_report table
    $sql = "UPDATE production_report SET kontraktor = $1, ttd = $2, proses_pengawas = 'Approved Pengawas' WHERE operation_report_id = $3";
    $result = pg_query_params($conn, $sql, array($kontraktor, $ttdData, $operationReportId));

    if ($result) {
        echo "Data produksi berhasil di approve";
    } else {
        echo "Error updating data: " . pg_last_error($conn);
    }
}
?>