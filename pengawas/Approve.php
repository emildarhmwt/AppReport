<?php
include '../Koneksi.php';

$id = $_POST['operation_report_id'];
$kontraktor = $_POST['kontraktor'];
$name_pengawas = $_POST['name_pengawas'];
$file_pengawas = $_POST['file_pengawas'];

// Update production_report
$sql_update = "UPDATE production_report SET 
    proses_pengawas = 'Approved Pengawas', 
    kontraktor = $1, 
    name_pengawas = $2, 
    file_pengawas = $3 
    WHERE operation_report_id = $4";

$result_update = pg_query_params($conn, $sql_update, array($kontraktor, $name_pengawas, $file_pengawas, $id));

if ($result_update) {
    echo "Data updated successfully.";
} else {
    echo "Error updating data.";
}
?>