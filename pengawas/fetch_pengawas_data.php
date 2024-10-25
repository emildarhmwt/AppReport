<?php
include '../Koneksi.php';

// Fetch kontraktor data
$sql_kontraktor = "SELECT username FROM kontraktor_report";
$result_kontraktor = pg_query($conn, $sql_kontraktor);
$kontraktor_options = pg_fetch_all($result_kontraktor);

// Fetch pengawas data
$sql_pengawas = "SELECT * FROM barcode_pengawas";
$result_pengawas = pg_query($conn, $sql_pengawas);
$pengawas_data = pg_fetch_all($result_pengawas);

echo json_encode([
    'kontraktor' => $kontraktor_options,
    'pengawas' => $pengawas_data
]);
?>