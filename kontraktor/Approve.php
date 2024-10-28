<?php
include '../Koneksi.php';

$id = $_POST['operation_report_id'];
$name_kontraktor = $_POST['name_kontraktor'];
$file_kontraktor = $_POST['file_kontraktor'];

// Update production_report
$sql_update = "UPDATE production_report SET 
    proses_kontraktor = 'Approved Kontraktor', 
    name_kontraktor = $1, 
    file_kontraktor = $2 
    WHERE operation_report_id = $3";

$result_update = pg_query_params($conn, $sql_update, array( $name_kontraktor, $file_kontraktor, $id));

if ($result_update) {
    echo "Data updated successfully.";
} else {
    echo "Error updating data.";
}
?>