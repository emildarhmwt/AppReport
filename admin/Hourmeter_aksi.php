<?php
include '../Koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation_report_id = $_POST['operation_report_id'];
    $equipment = $_POST['equipment'];
    $hm_awal = isset($_POST['hm_awal']) ? $_POST['hm_awal'] : 0;
    $hm_akhir = isset($_POST['hm_akhir']) ? $_POST['hm_akhir'] : 0;
    $jam_lain = isset($_POST['jam_lain']) ? $_POST['jam_lain'] : 0;
    $breakdown = isset($_POST['breakdown']) ? $_POST['breakdown'] : 0;
    $no_operator = isset($_POST['no_operator']) ? $_POST['no_operator'] : 0;
    $hujan = isset($_POST['hujan']) ? $_POST['hujan'] : 0;
    $ket = $_POST['ket'];
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $alasan_reject = $_POST['alasan_reject'];
    $tipe_unit = $_POST['tipe_unit'];
    $total_hm = isset($_POST['total_hm']) ? $_POST['total_hm'] : 0;
    $jam_operasi = isset($_POST['jam_operasi']) ? $_POST['jam_operasi'] : 0;
    $no_order = isset($_POST['no_order']) ? $_POST['no_order'] : 0;
    $kontraktor = $_POST['kontraktor'];
    $name_pengawas = $_POST['name_pengawas'];
    $file_pengawas = $_POST['file_pengawas'];
    $name_kontraktor = $_POST['name_kontraktor'];
    $file_kontraktor = $_POST['file_kontraktor'];

    // // Validasi input
    // if (!$operation_report_id || !$equipment || !$hm_awal || !$hm_akhir || !$jam_lain || !$breakdown || !$no_operator || !$hujan || !$ket) {
    //     echo json_encode(["error" => "Data hour meter tidak lengkap"]);
    //     exit;
    // }

    // Simpan data ke database
    $query = "INSERT INTO hourmeter_report
    (operation_report_id, equipment, hm_awal, hm_akhir, jam_lain, breakdown, no_operator, hujan, ket, proses_admin, proses_pengawas, proses_kontraktor, alasan_reject, tipe_unit, total_hm, jam_operasi, no_order, kontraktor, name_pengawas, file_pengawas, name_kontraktor, file_kontraktor) 
    VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, NULL, NULL, NULL, $11, $12, $13, $14, NULL, NULL, NULL, NULL, NULL) RETURNING id";
    $result = pg_query_params($conn, $query, array($operation_report_id, $equipment, $hm_awal, $hm_akhir, $jam_lain, $breakdown, $no_operator, $hujan, $ket, $proses_admin, $tipe_unit, $total_hm, $jam_operasi, $no_order));

    if ($result) {
        echo json_encode(["message" => "Hour Meter report created successfully"]);
    } else {
        echo json_encode(["error" => "Terjadi kesalahan saat menyimpan data hour meter"]);
    }
}
?>