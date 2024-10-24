<?php
require '../vendor/autoload.php'; // Pastikan path ini sesuai dengan lokasi autoload.php Anda
include '../Koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Mulai dari baris kedua jika baris pertama adalah header
        for ($i = 1; $i < count($sheetData); $i++) {
            $tipe = $sheetData[$i][0];
            $jumlah = $sheetData[$i][1];

            $query = "INSERT INTO muatan (tipe, jumlah) VALUES ($1, $2)";
            $result = pg_query_params($conn, $query, array($tipe, $jumlah));

            if (!$result) {
                // Jika ada kesalahan, tampilkan pesan di konsol dan hentikan eksekusi
                echo "<script>console.error('Terjadi kesalahan saat menyimpan data.');</script>";
                exit;
            }
        }

        echo "Data berhasil di import";
          
    } catch (Exception $e) {
        echo "<script>console.error('Error loading file: " . $e->getMessage() . "');</script>";
    }
}