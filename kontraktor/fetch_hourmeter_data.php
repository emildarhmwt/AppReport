<?php
session_start();
include '../Koneksi.php';

if (isset($_POST['year'])) {
    $year = $_POST['year'];

    // Fetch production data for the specified year
    $sql_hourmeter_data = "
        SELECT 
            EXTRACT(MONTH FROM o.tanggal) AS month,
            COUNT(CASE WHEN h.proses_admin = 'Uploaded' THEN 1 END) AS uploaded,
            COUNT(CASE WHEN h.proses_pengawas = 'Approved Pengawas' THEN 1 END) AS approved_pengawas,
            COUNT(CASE WHEN h.proses_pengawas = 'Rejected Pengawas' THEN 1 END) AS rejected_pengawas,
            COUNT(CASE WHEN h.proses_kontraktor = 'Approved Kontraktor' THEN 1 END) AS approved_kontraktor,
            COUNT(CASE WHEN h.proses_kontraktor = 'Rejected Kontraktor' THEN 1 END) AS rejected_kontraktor
        FROM 
            operation_report o
        JOIN 
            hourmeter_report h ON o.id = h.operation_report_id
        WHERE 
            EXTRACT(YEAR FROM o.tanggal) = $1
        GROUP BY 
            month
        ORDER BY 
            month;
    ";
    $result_hourmeter_data = pg_query_params($conn, $sql_hourmeter_data, array($year));

    // Prepare data for the chart
    $data = [
        'uploaded' => array_fill(0, 12, 0),
        'approved_pengawas' => array_fill(0, 12, 0),
        'rejected_pengawas' => array_fill(0, 12, 0),
        'approved_kontraktor' => array_fill(0, 12, 0),
        'rejected_kontraktor' => array_fill(0, 12, 0),
    ];

    while ($row = pg_fetch_assoc($result_hourmeter_data)) {
        $month = (int)$row['month'] - 1; // Adjust for zero-based index
        $data['uploaded'][$month] = (int)$row['uploaded'];
        $data['approved_pengawas'][$month] = (int)$row['approved_pengawas'];
        $data['rejected_pengawas'][$month] = (int)$row['rejected_pengawas'];
        $data['approved_kontraktor'][$month] = (int)$row['approved_kontraktor'];
        $data['rejected_kontraktor'][$month] = (int)$row['rejected_kontraktor'];
    }

    echo json_encode($data);
}
?>