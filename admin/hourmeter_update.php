<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isset($_POST['id'])) {
        echo "ID is required.";
        exit;
    }
    
    $id = $_POST['id'];
    $operation_report_id = $_POST['operation_report_id'];
    $equipment = $_POST['equipment'];
    $hm_awal = $_POST['hm_awal'];
    $hm_akhir = $_POST['hm_akhir'];
    $jam_lain = $_POST['jam_lain'];
    $breakdown = $_POST['breakdown'];
    $no_operator = $_POST['no_operator'];
    $hujan = $_POST['hujan'];
    $ket = $_POST['ket'];
    $proses_admin = $_POST['proses_admin'];
    $proses_pengawas = $_POST['proses_pengawas'];
    $proses_kontraktor = $_POST['proses_kontraktor'];
    $alasan_reject = $_POST['alasan_reject'];
    $tipe_unit = $_POST['tipe_unit'];
    $total_hm = $_POST['total_hm'];
    $jam_operasi = $_POST['jam_operasi'];
    $no_order = $_POST['no_order'];
    $kontraktor = $_POST['kontraktor'];
    $name_pengawas = $_POST['name_pengawas'];
    $file_pengawas = $_POST['file_pengawas'];
    $name_kontraktor = $_POST['name_kontraktor'];
    $file_kontraktor = $_POST['file_kontraktor'];
    

    $query = "UPDATE hourmeter_report SET operation_report_id = $1, equipment = $2, hm_awal = $3, hm_akhir = $4, jam_lain = $5, breakdown = $6, no_operator = $7, hujan = $8, ket = $9, proses_admin = $10, proses_pengawas = NULL, proses_kontraktor = NULL, alasan_reject = NULL, tipe_unit = $11, total_hm = $12, jam_operasi = $13, no_order = $14, kontraktor = NULL, name_pengawas = NULL, file_pengawas = NULL, name_kontraktor = NULL, file_kontraktor = NULL WHERE id = $15";
    $result = pg_query_params($conn, $query, array($operation_report_id, $equipment, $hm_awal,  $hm_akhir,  $jam_lain, $breakdown, $no_operator, $hujan,  $ket,  $proses_admin,  $tipe_unit,  $total_hm, $jam_operasi, $no_order, $id));

      if ($result) {
        echo "Jam Jalan berhasil diperbarui.";
        header("Location: Preview_hm.php?id=" . $operation_report_id); 
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui produksi.";
    }
} else {
    echo "Invalid request method.";
}