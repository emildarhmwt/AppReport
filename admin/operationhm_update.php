<?php
include '../Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isset($_POST['id'])) {
        echo "ID is required.";
        exit;
    }
    
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $shift = $_POST['shift'];
    $grup = $_POST['grup'];
    $pengawas = $_POST['pengawas'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $pic = $_POST['pic'];

    // Simpan data ke database
    $query = "UPDATE operation_report SET tanggal = $1, shift = $2, grup = $3, pengawas = $4, lokasi = $5, status = $6, pic = $7 WHERE id = $8";
    $result = pg_query_params($conn, $query, array($tanggal, $shift, $grup, $pengawas, $lokasi, $status, $pic, $id));

     if ($result) {
        echo "Produksi berhasil diperbarui.";
        header("Location: report_hourmeter.php"); 
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui produksi.";
    }
} else {
    echo "Invalid request method.";
}
?>