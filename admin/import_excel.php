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
        $equipment = $sheetData[$i][0];
        $tipe_unit = $sheetData[$i][1];

        $query = "INSERT INTO equipment (equipment, tipe_unit) VALUES ($1, $2)";
        $result = pg_query_params($conn, $query, array($equipment, $tipe_unit));

        if (!$result) {
            // Jika ada kesalahan, tampilkan pesan di konsol dan hentikan eksekusi
            echo "<script>console.error('Terjadi kesalahan saat menyimpan data.');</script>";
            exit;
        }
    }

    // Jika berhasil, arahkan ke equipment.php dan tampilkan pesan di konsol
    echo "<script>
            console.log('Data berhasil diimpor.');
            window.location.href = 'equipment.php';
          </script>";
} catch (Exception $e) {
    echo "<script>console.error('Error loading file: " . $e->getMessage() . "');</script>";
}
}
?>