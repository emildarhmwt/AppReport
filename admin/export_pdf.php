<?php
require('../fpdf186/fpdf.php');
include '../Koneksi.php';

$id = $_GET['id'];

// Query untuk mendapatkan data dari database
$sql = "SELECT * FROM operation_report WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
$operation_report = pg_fetch_assoc($result);

$sql_production = "SELECT * FROM production_report WHERE operation_report_id = $1";
$result_production = pg_query_params($conn, $sql_production, array($id));
$production_reports = pg_fetch_all($result_production);

// Hitung total
$total_ritase = 0;
$total_muatan = 0;
$total_volume = 0;
foreach ($production_reports as $report) {
    $total_ritase += $report['ritase'] + $report['ritase2'];
    $total_muatan += $report['muatan'];
    $total_volume += $report['volume'];
}

// Ambil ttd dari database
$ttd_supervisor = $production_reports[0]['ttd'] ?? null; // Pastikan ini sesuai dengan kolom di database
// $ttd_kontraktor = $production_reports[0]['ttd_kontraktor'] ?? null;

// Buat PDF dengan orientasi landscape
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' untuk landscape
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Report', 0, 1, 'C');

// Informasi
$pdf->SetFont('Times', '', 12);
$pdf->Cell(50, 10, 'Hari / Tanggal: ' . date('d M Y', strtotime($operation_report['tanggal'])), 0, 1);
$pdf->Cell(50, 10, 'Giliran / Group: ' . $operation_report['grup'], 0, 1);
$pdf->Cell(50, 10, 'Lokasi Kerja: ' . $operation_report['lokasi'], 0, 1);

// Tabel
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(7, 15, 'No', 1, 0, 'C');
$pdf->Cell(35, 15, 'Executor', 1, 0, 'C');
$pdf->Cell(35, 15, 'Alat Gali/Muat', 1, 0, 'C');
$pdf->Cell(35, 15, 'Timbunan', 1, 0, 'C');

// Pindahkan posisi Y sebelum MultiCell
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(20, 7.5, "Material\nTanah", 1, 'C');
$pdf->SetXY($x + 20, $y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(20, 7.5, "Jarak\nAngkut", 1, 'C');
$pdf->SetXY($x + 20, $y);

// Gabungkan sel untuk "Ritase Alat Angkut"
$pdf->Cell(80, 10, 'Ritase Alat Angkut', 1, 0, 'C');
$pdf->Cell(20, 15, 'Muatan', 1, 0, 'C');
$pdf->Cell(20, 15, 'Volume', 1, 0, 'C');
$pdf->Ln();

// Baris kedua untuk "Tipe" dan "Ritase"
$pdf->Cell(152, 0, '', 0); // Sesuaikan posisi X
$pdf->Cell(25, 5, 'Tipe', 1, 0, 'C');
$pdf->Cell(15, 5, 'Ritase', 1, 0, 'C');
$pdf->Cell(25, 5, 'Tipe', 1, 0, 'C');
$pdf->Cell(15, 5, 'Ritase', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Times', '', 8);
foreach ($production_reports as $index => $report) {
    $maxHeight = 10; // Default tinggi sel

    // Hitung tinggi maksimum dari kolom yang menggunakan MultiCell
    $executorHeight = $pdf->GetStringWidth($report['excecutor']) > 30 ? 20 : 10;
    $alatHeight = $pdf->GetStringWidth($report['alat']) > 30 ? 20 : 10;
    $timbunanHeight = $pdf->GetStringWidth($report['timbunan']) > 30 ? 20 : 10;

    $maxHeight = max($executorHeight, $alatHeight, $timbunanHeight);

    // Kolom 'No'
    $pdf->Cell(7, $maxHeight, $index + 1, 1, 0,'C');

    // Kolom 'Executor'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(35, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(35, 7, $report['excecutor'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 35, $y);

    // Kolom 'Alat'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(35, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(35, 7, $report['alat'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 35, $y);

    // Kolom 'Timbunan'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(35, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(35, 7, $report['timbunan'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 35, $y);

    // Kolom-kolom lain
    $pdf->Cell(20, $maxHeight, $report['material'], 1, 0, 'C');
    $pdf->Cell(20, $maxHeight, $report['jarak'], 1, 0, 'C');

    //kolom tipe
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(25, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(25, 7, $report['tipe'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 25, $y);
    
    $pdf->Cell(15, $maxHeight, $report['ritase'], 1, 0, 'C');

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(25, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(25, 7, $report['tipe2'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 25, $y);
    
    $pdf->Cell(15, $maxHeight, $report['ritase2'], 1, 0, 'C');
    $pdf->Cell(20, $maxHeight, $report['muatan'], 1, 0, 'C');
    $pdf->Cell(20, $maxHeight, $report['volume'], 1, 0, 'C');
    $pdf->Ln();
}

// Total
$pdf->Cell(217, 10, 'Total', 1);
$pdf->Cell(15, 10, $total_ritase, 1, 0,'C');
$pdf->Cell(20, 10, $total_muatan, 1,0,'C');
$pdf->Cell(20, 10, $total_volume, 1,0,'C');
$pdf->Ln();

// TTD
$pdf->SetFont('Times', '', 12);
$pdf->Cell(100, 40, 'Pengawas', 0, 0, 'C');
// $pdf->Cell(200, 40, 'Kontraktor', 0, 1, 'C');

if ($ttd_supervisor) {
    $imageData = pg_unescape_bytea($ttd_supervisor);
    
    // Debugging: Check the length of the binary data
    if (strlen($imageData) > 0) {
        // Check the first few bytes to identify the format
        $header = substr($imageData, 0, 4);
        if ($header === "\x89PNG" || substr($header, 0, 3) === "\xFF\xD8\xFF") {
            // It's a PNG or JPEG image
            $image = imagecreatefromstring($imageData);
        } else {
            $pdf->Cell(100, 10, 'Unsupported image format', 0, 1, 'C');
            $image = false;
        }
        
        if ($image !== false) {
            // Save the image to a temporary file
            $tempImagePath = tempnam(sys_get_temp_dir(), 'ttd_') . '.png';
            imagepng($image, $tempImagePath);
            imagedestroy($image); // Free up memory

            // Add the image to the PDF
            $pdf->Image($tempImagePath, $pdf->GetX() + 10, $pdf->GetY() - 30, 30); // Sesuaikan posisi dan ukuran
            
            // Optionally delete the temporary file
            unlink($tempImagePath);
        } else {
            // Handle error if image creation fails
            $pdf->Cell(100, 10, 'Error loading image', 0, 1, 'C');
        }
    } else {
        $pdf->Cell(100, 10, 'No image data found', 0, 1, 'C');
    }
}

$pdf->Output();
?>