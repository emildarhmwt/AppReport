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
    $proses_pengawas = isset($_POST['proses_pengawas']) ? $_POST['proses_pengawas'] : NULL; 
    $proses_kontraktor= isset($_POST['proses_kontraktor']) ? $_POST['proses_kontraktor'] : NULL; 
    $alasan_reject= isset($_POST['alasan_reject']) ? $_POST['alasan_reject'] : NULL; 
    $excecutor = $_POST['excecutor'];
    $tipe2 = isset($_POST['tipe2']) ? $_POST['tipe2'] : NULL; 
    $ritase2 = isset($_POST['ritase2']) ? $_POST['ritase2'] : 0; // Jika ritase2 tidak diinput, set menjadi 0
    $muatan = $_POST['muatan'];
    $total_ritase = $ritase + $ritase2;
    $volume = $total_ritase * $muatan;
    $operation_report_id = $_POST['operation_report_id'];

    // Validasi input
    if (!$alat || !$timbunan || !$material || !$jarak || !$tipe || !$ritase || !$operation_report_id || !$excecutor || !$muatan) {
        echo json_encode(["error" => "Data produksi tidak lengkap"]);
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO 
    production_report(alat, timbunan, material, jarak, tipe, ritase, operation_report_id, proses_admin, proses_pengawas, proses_kontraktor, alasan_reject, excecutor, tipe2, ritase2, muatan, volume, total_ritase) 
    VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17) RETURNING id";
    $result = pg_query_params($conn, $query, 
    array($alat, $timbunan, $material, $jarak, $tipe, $ritase, $operation_report_id, $proses_admin, $proses_pengawas, $proses_kontraktor, $alasan_reject, $excecutor, $tipe2, $ritase2, $muatan, $volume, $total_ritase));

    if ($result) {
        echo json_encode(["message" => "Production report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data produksi"]);
    }
}
?>