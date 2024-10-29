<?php
require('../fpdf186/fpdf.php');
include '../Koneksi.php';

$id = $_GET['id'];

// Query untuk mendapatkan data dari database
$sql = "SELECT * FROM operation_report WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
$operation_report = pg_fetch_assoc($result);

$sql_hourmeter = "SELECT * FROM hourmeter_report WHERE operation_report_id = $1";
$result_hourmeter = pg_query_params($conn, $sql_hourmeter, array($id));
$hourmeter_reports = pg_fetch_all($result_hourmeter);

$sql_file = "SELECT DISTINCT ON (operation_report_id) file_pengawas FROM hourmeter_report WHERE operation_report_id = $1";
$result_file = pg_query_params($conn, $sql_file, array($id));
$file_pengawas = pg_fetch_assoc($result_file);

$sql_fileKontraktor = "SELECT DISTINCT ON (operation_report_id) file_kontraktor FROM hourmeter_report WHERE operation_report_id = $1";
$result_fileKontraktor = pg_query_params($conn, $sql_fileKontraktor, array($id));
$file_kontraktor = pg_fetch_assoc($result_fileKontraktor);

// Hitung total
// $total_ritase = 0;
// $total_muatan = 0;
// $total_volume = 0;
// foreach ($production_reports as $report) {
//     $total_ritase += $report['ritase'] + $report['ritase2'];
//     $total_muatan += $report['muatan'];
//     $total_volume += $report['volume'];
// }

// Buat PDF dengan orientasi landscape
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' untuk landscape
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Laporan Jam Jalan', 0, 1, 'C');

// Informasi
$pdf->SetFont('Times', '', 12);
$pdf->Cell(50, 10, 'Hari / Tanggal ', 0, 0); 
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, date('d M Y', strtotime($operation_report['tanggal'])), 0, 1);
$pdf->Cell(50, 10, 'Giliran / Group', 0, 0);
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, $operation_report['grup'], 0, 1);
$pdf->Cell(50, 10, 'Shift', 0, 0);
$pdf->Cell(5, 10, ':', 0, 0); 
$pdf->Cell(0, 10, $operation_report['shift'], 0, 1);

$pdf->Cell(0, 0, '', 'T');
$pdf->Ln(5);

// Tabel
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(7, 12, 'No', 1, 0, 'C');
$pdf->Cell(46, 12, 'Type Unit', 1, 0, 'C');
$pdf->Cell(39, 12, 'Equipment', 1, 0, 'C');
$pdf->Cell(30, 7, 'Hour Meter', 1, 0, 'C');

// Pindahkan posisi Y sebelum MultiCell
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(15, 6, "Total\nHM", 1, 'C');
$pdf->SetXY($x + 15, $y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(15, 6, "Jam\nLain", 1, 'C');
$pdf->SetXY($x + 15, $y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(15, 6, "Jam\nOperasi", 1, 'C');
$pdf->SetXY($x + 15, $y);

// Gabungkan sel untuk "Ritase Alat Angkut"
$pdf->Cell(34, 7, 'Time BD', 1, 0, 'C');
$pdf->Cell(37, 7, 'Time Standby', 1, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

// Mengatur tinggi border
$borderHeight = 12;
$pdf->Cell(40, $borderHeight, '', 1, 0, 'C');

// Mengatur tinggi tulisan
$pdf->SetXY($x, $y + ($borderHeight - 7) / 2); 
$pdf->Cell(40, 7, 'Keterangan', 0, 0, 'C');
$pdf->SetXY($x + 40, $y);
$pdf->Ln();

// Baris kedua untuk "Tipe" dan "Ritase"
$pdf->Cell(92, 0, '', 0); 
$pdf->Cell(15, 5, 'Awal', 1, 0, 'C');
$pdf->Cell(15, 5, 'Akhir', 1, 0, 'C');
$pdf->Cell(45, 0, '', 0); // Sesuaikan posisi X
$pdf->Cell(16, 5, 'BD', 1, 0, 'C');
$pdf->Cell(18, 5, 'NO OPRT', 1, 0, 'C');
$pdf->Cell(16, 5, 'HUJAN', 1, 0, 'C');
$pdf->Cell(21, 5, 'NO ORDER', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Times', '', 8);
foreach ($hourmeter_reports as $index => $report) {
    $maxHeight = 10; // Default tinggi sel

    // Hitung tinggi maksimum dari kolom yang menggunakan MultiCell
    $tipeHeight = $pdf->GetStringWidth($report['tipe_unit']) > 46 ? 20 : 10;
    $equipmentHeight = $pdf->GetStringWidth($report['equipment']) > 46 ? 20 : 10;
    $keteranganHeight = $pdf->GetStringWidth($report['ket']) > 46 ? 20 : 10;

    $maxHeight = max($tipeHeight, $equipmentHeight, $keteranganHeight);

    // Kolom 'No'
    $pdf->Cell(7, $maxHeight, $index + 1, 1, 0,'C');

    // Kolom 'Executor'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(46, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(46, 10, $report['tipe_unit'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 46, $y);

    // Kolom 'Alat'
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(39, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(39, 10, $report['equipment'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan
    $pdf->SetXY($x + 39, $y);

    // Kolom-kolom lain
    $pdf->Cell(15, $maxHeight, $report['hm_awal'], 1, 0, 'C');
    $pdf->Cell(15, $maxHeight, $report['hm_akhir'], 1, 0, 'C');
    $pdf->Cell(15, $maxHeight, $report['total_hm'], 1, 0, 'C');
    $pdf->Cell(15, $maxHeight, $report['jam_lain'], 1, 0, 'C');
    $pdf->Cell(15, $maxHeight, $report['jam_operasi'], 1, 0, 'C');
    $pdf->Cell(16, $maxHeight, $report['breakdown'], 1, 0, 'C');
    $pdf->Cell(18, $maxHeight, $report['no_operator'], 1, 0, 'C');
    $pdf->Cell(16, $maxHeight, $report['hujan'], 1, 0, 'C');
    $pdf->Cell(21, $maxHeight, $report['no_order'], 1, 0, 'C');
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    // Mengatur tinggi border
    $borderHeight = $maxHeight; // Tinggi border sesuai dengan maxHeight
    $pdf->Cell(40, $borderHeight, '', 1, 0, 'C'); // Buat sel dengan border

    // Mengatur tinggi tulisan
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(40, 10, $report['ket'], 0, 'C'); // Ubah border menjadi 0 untuk hanya menampilkan tulisan dan centering
    $pdf->SetXY($x + 40, $y);
    $pdf->Ln();
}

// Total
// $pdf->SetFont('Times', 'B', 10); // Set font to bold for the total
// $pdf->Cell(241, 10, 'Total', 1);
// $pdf->Cell(15, 10, $total_ritase, 1, 0,'C');
// $pdf->Cell(20, 10, $total_volume, 1,0,'C');
// $pdf->Ln();


// TTD
$pdf->Ln(15);
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

$pdf->Output('Laporan Jam Jalan - ' . date('d M Y') . '.pdf', isset($_GET['action']) && $_GET['action'] === 'download' ? 'D' : 'I');
?>