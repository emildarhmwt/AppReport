<?php
include '../Koneksi.php';

// Fetch pengawas data
$sql_kontraktor = "SELECT * FROM barcode_kontraktor";
$result_kontraktor = pg_query($conn, $sql_kontraktor);
$kontraktor_data = pg_fetch_all($result_kontraktor);

echo json_encode([
    'kontraktor' => $kontraktor_data
]);
?>