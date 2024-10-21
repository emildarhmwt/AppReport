<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jabatan = $_POST['jabatan'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $ttd = $_FILES['ttd']['tmp_name'];

    // Validasi input
    if (!$jabatan || !$nama || !$nip || !$ttd) {
        echo json_encode(["error" => "Data barcode pengawas tidak lengkap"]);
        exit;
    }

    // Baca file dan konversi ke bytea
    $ttdData = file_get_contents($ttd);
    
    // Encode the binary data to ensure it's valid
    $ttdData = pg_escape_bytea($ttdData);

    // Simpan data ke database
    $query = "INSERT INTO barcode_pengawas(jabatan, nama, nip, ttd) VALUES($1, $2, $3, $4) RETURNING id";
    $result = pg_query_params($conn, $query, array($jabatan, $nama, $nip, $ttdData));

    if ($result) {
    header("Location: barcode.php");
    exit;
} else {
    echo json_encode(["error" => pg_last_error($conn)]);
}
}
?>