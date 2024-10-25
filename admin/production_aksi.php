<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation_report_id = $_POST['operation_report_id'];
    $alat = $_POST['alat'];
    $timbunan = $_POST['timbunan'];
    $material = $_POST['material'];
    $jarak = $_POST['jarak'];
    $excecutor = $_POST['excecutor'];
    
    $tipe = $_POST['tipe'];
    $ritase = isset($_POST['ritase']) ? $_POST['ritase'] : 0;
    $muatan = isset($_POST['muatan']) ? $_POST['muatan'] : 0;
    $volume = isset($_POST['volume']) ? $_POST['volume'] : 0;
    $tipeKedua = $_POST['tipe2'];
    $ritaseKedua = isset($_POST['ritase2']) ? $_POST['ritase2'] : 0;
    $muatanKedua = isset($_POST['muata2n']) ? $_POST['muata2n'] : 0;
    $volumeKedua = isset($_POST['volume2']) ? $_POST['volume2'] : 0;
    $total_ritase  = $_POST['total_ritase'];
    $total_volume = $_POST['total_volume'];
    
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $alasan_reject = $_POST['alasan_reject'];
    $kontraktor = $_POST['kontraktor'];
    $name_pengawas = $_POST['name_pengawas'];
    $file_pengawas = $_POST['file_pengawas'];
    $name_kontraktor = $_POST['name_kontraktor'];
    $file_kontraktor = $_POST['file_kontraktor'];

    $query = "INSERT INTO production_report
    (operation_report_id, alat, timbunan, material, jarak, tipe, ritase, proses_admin, proses_pengawas, proses_kontraktor, alasan_reject, excecutor, tipe2, ritase2, muatan, volume, total_ritase, kontraktor, muatan2, volume2, total_volume, name_pengawas, file_pengawas, name_kontraktor, file_kontraktor)
    VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23, $24, $25) RETURNING id";
    $result = pg_query_params($conn, $query, array($operation_report_id, $alat, $timbunan, $material, $jarak, $tipe, $ritase, $proses_admin, $proses_pengawas, $proses_kontraktor, $alasan_reject, $excecutor, $tipeKedua, $ritaseKedua, $muatan, $volume, $total_ritase, $kontraktor, $muatanKedua, $volumeKedua, $total_volume, $name_pengawas, $file_pengawas, $name_kontraktor, $file_kontraktor ));
    
    if ($result) {
        echo json_encode(["message" => "Production report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data produksi"]);
    }
}
?>