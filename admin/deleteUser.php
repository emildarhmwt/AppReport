<?php
include '../Koneksi.php';

$id = null; // Initialize ID variable

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Mendapatkan ID dari request body
    $data = json_decode(file_get_contents("php://input"), true); // Use json_decode to parse JSON
    $id = $data['id'] ?? null; // Use null coalescing operator

    // Debugging: Log the received ID
    error_log("Received ID: " . $id);

    if ($id === null) {
        http_response_code(400); // Bad request
        echo json_encode(['message' => 'ID is required.']);
        exit;
    }

    // Menyiapkan query untuk menghapus admin
    $query = "DELETE FROM user_report WHERE id = $1";
    $result = pg_query_params($conn, $query, array($id));

    if ($result) {
        http_response_code(200); // Berhasil
        echo json_encode(['message' => 'Pengawas deleted successfully.']);
    } else {
        http_response_code(500); // Kesalahan server
        echo json_encode(['message' => 'Failed to delete admin.']);
    }
} else {
    http_response_code(405); // Metode tidak diizinkan
    echo json_encode(['message' => 'Method not allowed.']);
}

// Debugging: Log any errors
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("ID: " . $id);
?>