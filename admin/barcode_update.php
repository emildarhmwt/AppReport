<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $nip = $_POST['nip'];

    // Validate input
    if (empty($nama) || empty($jabatan) || empty($nip)) {
        echo "Nama, Jabatan, NIP harus diisi.";
        exit;
    }

    // Handle file upload
    if (!empty($_FILES['file_path']['name'])) {
        $filePath = '../barcode/' . basename($_FILES['file_path']['name']);
        move_uploaded_file($_FILES['file_path']['tmp_name'], $filePath);
    } else {
        // Get existing file path if no new file is uploaded
        $query = "SELECT file_path FROM barcode_pengawas WHERE id = $1";
        $result = pg_query_params($conn, $query, array($id));
        $row = pg_fetch_assoc($result);
        $filePath = $row['file_path'];
    }

    $query = "UPDATE barcode_pengawas SET nama = $1, jabatan = $2, nip = $3, file_path = $4 WHERE id = $5";
    $result = pg_query_params($conn, $query, array($nama, $jabatan, $nip, $filePath, $id));

    if ($result) {
        echo "Barcode pengawas berhasil diperbarui.";
        header("Location: Barcode.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui barcode pengawas.";
    }
} else {
    echo "Invalid request method.";
}