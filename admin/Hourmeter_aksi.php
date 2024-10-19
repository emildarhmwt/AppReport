<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation_report_id = $_POST['operation_report_id'];
    $equipment = $_POST['equipment'];
    $hm_awal = $_POST['hm_awal'];
    $hm_akhir = $_POST['hm_akhir'];
    $jam_lain = $_POST['jam_lain'];
    $breakdown = $_POST['breakdown'];
    $no_operator = $_POST['no_operator'];
    $hujan = $_POST['hujan'];
    $ket = $_POST['ket'];

    // Validasi input
    if (!$operation_report_id || !$equipment || !$hm_awal || !$hm_akhir || !$jam_lain || !$breakdown || !$no_operator || !$hujan || !$ket) {
        echo json_encode(["error" => "Data hour meter tidak lengkap"]);
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO hourmeter_report(operation_report_id, equipment, hm_awal, hm_akhir, jam_lain, breakdown, no_operator, hujan, ket) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9) RETURNING id";
    $result = pg_query_params($conn, $query, array($operation_report_id, $equipment, $hm_awal, $hm_akhir, $jam_lain, $breakdown, $no_operator, $hujan, $ket));

    if ($result) {
        echo json_encode(["message" => "Hour Meter report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data hour meter"]);
    }
}
?>