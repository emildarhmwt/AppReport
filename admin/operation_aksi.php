<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); // Pastikan response dalam format JSON
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $shift = $_POST['shift'];
    $grup = $_POST['grup'];
    $pengawas = $_POST['pengawas'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $pic = $_POST['pic'];

    // Validasi input
    if (!$tanggal || !$shift || !$grup || !$pengawas || !$lokasi || !$status || !$pic) {
        echo json_encode(["error" => "Data operasi tidak lengkap"]);
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO operation_report(tanggal, shift, grup, pengawas, lokasi, status, pic) VALUES($1, $2, $3, $4, $5, $6, $7) RETURNING id";
    $result = pg_query_params($conn, $query, array($tanggal, $shift, $grup, $pengawas, $lokasi, $status, $pic));

    if ($result) {
        $operationReportId = pg_fetch_result($result, 0, 0);
        echo json_encode(["success" => true, "operationReportId" => $operationReportId, "status" => $status]);
    } else {
        $error = pg_last_error($conn);
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data operasi: $error"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>