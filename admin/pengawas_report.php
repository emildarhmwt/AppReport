<?php
include '../Koneksi.php';

try {
    // Query untuk mendapatkan data username
    $result = pg_query($conn, "SELECT nama FROM barcode_pengawas");

    if (!$result) {
        throw new Exception('Query gagal dijalankan.');
    }

    $users = [];
    while ($row = pg_fetch_assoc($result)) {
        $users[] = $row;
    }

    // Mengembalikan data dalam format JSON
    echo json_encode($users);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["error" => "Terjadi kesalahan saat mengambil data."]);
}
?>