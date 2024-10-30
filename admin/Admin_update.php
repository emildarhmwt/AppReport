<?php
include '../Koneksi.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($nama) || empty($username)) {
        echo "Nama dan Username harus diisi.";
        exit;
    }

    if (!empty($_FILES['file_path']['name'])) {
        $filePath = '../barcode/' . basename($_FILES['file_path']['name']);
        move_uploaded_file($_FILES['file_path']['tmp_name'], $filePath);
    } else {
        // Get existing file path if no new file is uploaded
        $query = "SELECT file_admin FROM admin_report WHERE id = $1";
        $result = pg_query_params($conn, $query, array($id));
        $row = pg_fetch_assoc($result);
        $filePath = $row['file_admin'];
    }

    // Prepare the update query
    if (!empty($password)) {
        // Hash the password for security if provided
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin_report SET nama = $1, username = $2, password = $3, file_admin = $4 WHERE id = $5";
        $result = pg_query_params($conn, $query, array($nama, $username, $hashedPassword, $filePath, $id));
    } else {
        // Update without changing the password
        $query = "UPDATE admin_report SET nama = $1, username = $2, file_admin = $3 WHERE id = $4";
        $result = pg_query_params($conn, $query, array($nama, $username, $filePath, $id));
    }

    if ($result) {
        echo "Admin berhasil diperbarui.";
        header("Location: Admin.php"); // Redirect to the admin list page
        exit;
    } else {
        echo "Terjadi kesalahan saat memperbarui admin.";
    }
} else {
    echo "Invalid request method.";
}
?>