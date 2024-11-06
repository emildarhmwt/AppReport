<?php
require '../vendor/autoload.php';
include '../Koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Mulai dari baris kedua jika baris pertama adalah header
        for ($i = 1; $i < count($sheetData); $i++) {
            $lokasi = $sheetData[$i][0];

            $query = "INSERT INTO lokasi (lokasi) VALUES ($1)";
            $result = pg_query_params($conn, $query, array($lokasi));

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