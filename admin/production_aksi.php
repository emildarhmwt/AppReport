<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alat = $_POST['alat'];
    $timbunan = $_POST['timbunan'];
    $material = $_POST['material'];
    $jarak = $_POST['jarak'];
    $tipe = $_POST['tipe'];
    $ritase = isset($_POST['ritase']) ? $_POST['ritase'] : 0;
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = isset($_POST['proses_pengawas']) ? $_POST['proses_pengawas'] : NULL; 
    $proses_kontraktor= isset($_POST['proses_kontraktor']) ? $_POST['proses_kontraktor'] : NULL; 
    $alasan_reject= isset($_POST['alasan_reject']) ? $_POST['alasan_reject'] : NULL; 
    $excecutor = $_POST['excecutor'];
    $tipe_kedua = isset($_POST['tipe2']) ? $_POST['tipe2'] : NULL; 
    $ritase_kedua = isset($_POST['ritase2']) ? $_POST['ritase2'] : 0; // Jika ritase2 tidak diinput, set menjadi 0
    $muatan = $_POST['muatan'];
    $volume = $ritase * $muatan;
    $total_ritase = $ritase + $ritase_kedua;
    $ttd = isset($_POST['ttd']) ? $_POST['ttd'] : NULL; 
    $kontraktor = isset($_POST['kontraktor']) ? $_POST['kontraktor'] : NULL; 
    $ttd_kontraktor = isset($_POST['ttd_kontraktor']) ? $_POST['ttd_kontraktor'] : NULL; 
    $muatan_kedua = $_POST['muatan2'];
    $volume_kedua = $ritase_kedua * $muatan_kedua;
    $total_volume = $volume + $volume_kedua;
    $operation_report_id = $_POST['operation_report_id'];

    // Validasi input
    if (!$alat || !$timbunan || !$material || !$jarak || !$tipe || !$ritase || !$operation_report_id || !$excecutor) {
        echo json_encode(["error" => "Data produksi tidak lengkap"]);
        exit;
    }

    // Simpan data ke database
$query = "INSERT INTO 
production_report(alat, timbunan, material, jarak, tipe, ritase, operation_report_id, proses_admin, proses_pengawas, proses_kontraktor, alasan_reject, excecutor, tipe2, ritase2, muatan, volume, total_ritase, ttd, kontraktor, ttd_kontraktor, muatan2, volume2, total_volume) 
VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23) RETURNING id";
    $result = pg_query_params($conn, $query, 
    array($alat, $timbunan, $material, $jarak, $tipe, $ritase, $operation_report_id, $proses_admin, $proses_pengawas, $proses_kontraktor, $alasan_reject, $excecutor, $tipe_kedua, $ritase_kedua, $muatan, $volume, $total_ritase, $ttd, $kontraktor, $ttd_kontraktor, $muatan_kedua, $volume_kedua, $total_volume));

    if ($result) {
        echo json_encode(["message" => "Production report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data produksi"]);
    }
}
?>