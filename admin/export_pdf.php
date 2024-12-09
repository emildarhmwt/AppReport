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

$sql_file = "SELECT DISTINCT ON (operation_report_id) file_pengawas FROM production_report WHERE operation_report_id = $1";
$result_file = pg_query_params($conn, $sql_file, array($id));
$file_pengawas = pg_fetch_assoc($result_file);

$sql_fileKontraktor = "SELECT DISTINCT ON (operation_report_id) file_kontraktor FROM production_report WHERE operation_report_id = $1";
$result_fileKontraktor = pg_query_params($conn, $sql_fileKontraktor, array($id));
$file_kontraktor = pg_fetch_assoc($result_fileKontraktor);


// Hitung total
$total_ritase = 0;
$total_muatan = 0;
$total_volume = 0;
foreach ($production_reports as $report) {
    $total_ritase += $report['ritase'] + $report['ritase2'];
    $total_muatan += $report['muatan'];
    $total_volume += $report['volume'];
}
// Buat PDF dengan orientasi landscape
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' untuk landscape
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Laporan Produksi', 0, 1, 'C');

// Informasi
$pdf->SetFont('Times', '', 12);
$pdf->Cell(50, 10, 'Hari / Tanggal ', 0, 0); 
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, date('d M Y', strtotime($operation_report['tanggal'])), 0, 1);
$pdf->Cell(50, 10, 'Giliran / Group', 0, 0);
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, $operation_report['grup'], 0, 1);
$pdf->Cell(50, 10, 'Lokasi Kerja', 0, 0);
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, $operation_report['lokasi'], 0, 1);

$pdf->Cell(0, 0, '', 'T');
$pdf->Ln(5);

// Tabel
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(7, 12, 'No', 1, 0, 'C');
$pdf->Cell(43, 12, 'Executor', 1, 0, 'C');
$pdf->Cell(43, 12, 'Alat Gali/Muat', 1, 0, 'C');
$pdf->Cell(43, 12, 'Timbunan', 1, 0, 'C');

// Pindahkan posisi Y sebelum MultiCell
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(20, 6, "Material\nTanah", 1, 'C');
$pdf->SetXY($x + 20, $y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(15, 6, "Jarak\nAngkut", 1, 'C');
$pdf->SetXY($x + 15, $y);

// Gabungkan sel untuk "Ritase Alat Angkut"
$pdf->Cell(85, 7, 'Ritase Alat Angkut', 1, 0, 'C');
$x = $pdf->GetX();
$y = $pdf->GetY();

// Mengatur tinggi border
$borderHeight = 12;
$pdf->Cell(20, $borderHeight, '', 1, 0, 'C');

// Mengatur tinggi tulisan
$pdf->SetXY($x, $y + ($borderHeight - 7) / 2); 
$pdf->Cell(20, 7, 'Volume', 0, 0, 'C');
$pdf->SetXY($x + 20, $y);
$pdf->Ln();

// Baris kedua untuk "Tipe" dan "Ritase"
$pdf->Cell(171, 0, '', 0); // Sesuaikan posisi X
$pdf->Cell(27.5, 5, 'Tipe', 1, 0, 'C');
$pdf->Cell(15, 5, 'Jumlah', 1, 0, 'C');
$pdf->Cell(27.5, 5, 'Tipe', 1, 0, 'C');
$pdf->Cell(15, 5, 'Jumlah', 1, 0, 'C');
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
    $pdf->Cell(43, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(43, 10, $report['excecutor'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 43, $y);

    // Kolom 'Alat'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(43, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(43, 10, $report['alat'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 43, $y);

    // Kolom 'Timbunan'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(43, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(43, 10, $report['timbunan'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 43, $y);

    // Kolom-kolom lain
    $pdf->Cell(20, $maxHeight, $report['material'], 1, 0, 'C');
    $pdf->Cell(15, $maxHeight, $report['jarak'], 1, 0, 'C');

    //kolom tipe
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(27.5, $borderHeight, '', 1, 0, 'c'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(27.5, 10, $report['tipe'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 27.5, $y);
    
    $pdf->Cell(15, $maxHeight, $report['ritase'], 1, 0, 'C');

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(27.5, $borderHeight, '', 1, 0, 'L'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(27.5, 10, $report['tipe2'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 27.5, $y);
    
    $pdf->Cell(15, $maxHeight, $report['ritase2'], 1, 0, 'C');
    $pdf->Cell(20, $maxHeight, number_format($report['volume'], 2), 1, 0, 'C'); 
    $pdf->Ln();
}

// Total
$pdf->SetFont('Times', 'B', 10); // Set font to bold for the total
$pdf->Cell(241, 10, 'Total', 1);
$pdf->Cell(15, 10, $total_ritase, 1, 0,'C');
$pdf->Cell(20, 10, $total_volume, 1,0,'C');
$pdf->Ln();


// TTD
$pdf->SetFont('Times', '', 12);
$pdf->Cell(100, 30, 'Pengawas', 0, 0, 'C');
$pdf->Cell(200, 30, 'Kontraktor', 0, 0, 'C');
$pdf->Ln(); 

// Check if file_pengawas is empty
$fixedY = $pdf->GetY() + 50; // Adjust this value as needed for spacing

if (empty($file_pengawas['file_pengawas'])) {
    $pdf->Cell(100, 20, 'Pending', 0, 1, 'C');
} else {
    $pdf->Ln(-10);
    $y = $pdf->GetY();
    $imageWidth = 30; 
    $x = 45;

    $pdf->Image($file_pengawas['file_pengawas'], $x, $y, $imageWidth);
    $pdf->Ln(50);
}

// Move to the fixed Y position for kontraktor
$pdf->SetY($fixedY);

if (empty($file_kontraktor['file_kontraktor'])) {
    $pdf->Cell(400, -80, 'Pending', 0, 1, 'C'); // Adjust height if needed
} else {
    $pdf->Ln(-60);
    $y = $pdf->GetY();
    $imageWidth = 30; 
    $x = 195;

    $pdf->Image($file_kontraktor['file_kontraktor'], $x, $y, $imageWidth);
    $pdf->Ln(50);
}

$pdf->Output('Laporan Produksi - ' . date('d M Y', strtotime($operation_report['tanggal'])) . '.pdf', isset($_GET['action']) && $_GET['action'] === 'download' ? 'D' : 'I');
?>