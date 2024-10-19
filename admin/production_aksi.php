<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alat = $_POST['alat'];
    $timbunan = $_POST['timbunan'];
    $material = $_POST['material'];
    $jarak = $_POST['jarak'];
    $tipe = $_POST['tipe'];
    $ritase = $_POST['ritase'];
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $operation_report_id = $_POST['operation_report_id'];

    // Validasi input
    if (!$alat || !$timbunan || !$material || !$jarak || !$tipe || !$ritase || !$operation_report_id) {
        echo json_encode(["error" => "Data produksi tidak lengkap"]);
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO production_report(alat, timbunan, material, jarak, tipe, ritase, operation_report_id, proses_admin, proses_pengawas, proses_kontraktor) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10) RETURNING id";
    $result = pg_query_params($conn, $query, array($alat, $timbunan, $material, $jarak, $tipe, $ritase, $operation_report_id, $proses_admin, $proses_pengawas, $proses_kontraktor));

    if ($result) {
        echo json_encode(["message" => "Production report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data produksi"]);
    }
}
?>