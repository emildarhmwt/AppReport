<?php
include '../Koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql = "SELECT jabatan, nip, encode(ttd, 'base64') as ttd FROM barcode_pengawas WHERE id = $1";
    $result = pg_query_params($conn, $sql, array($id));

    if ($result) {
        $data = pg_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['jabatan' => '', 'nip' => '', 'ttd' => '']);
    }
} else {
    echo json_encode(['jabatan' => '', 'nip' => '', 'ttd' => '']);
}
?>