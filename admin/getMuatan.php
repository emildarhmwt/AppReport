<?php
include '../Koneksi.php';

$query = "SELECT tipe, jumlah FROM muatan";
$result = pg_query($conn, $query);

if (!$result) {
    error_log('Query gagal dijalankan.');
    die(json_encode(["error" => "Query gagal dijalankan."]));
}

$muatanData = [];
while ($row = pg_fetch_assoc($result)) {
    $muatanData[] = $row;
}

echo json_encode($muatanData);
?>