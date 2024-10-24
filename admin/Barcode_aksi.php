<?php
// Konfigurasi koneksi ke PostgreSQL
$host = 'localhost';
$dbname = 'Aplikasi';
$user = 'postgres';
$password = 'emilda123';

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Koneksi ke database gagal.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan informasi dari form
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $nip = $_POST['nip'];

    // Mendapatkan informasi file
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    // Cek apakah file adalah PNG atau JPG
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // Batasi ukuran file hingga 5MB
                // Menentukan path untuk menyimpan file di server
                $uploadDir = '../barcode/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
                }
                $newFileName = uniqid('', true) . "." . $fileExt; // Mengganti nama file untuk menghindari konflik
                $fileDestination = $uploadDir . $newFileName;

                // Pindahkan file ke folder uploads
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Simpan data ke database
                    $query = "INSERT INTO barcode_pengawas (nama, jabatan, nip, name, file_path, mime_type) VALUES ($1, $2, $3, $4, $5, $6)";
                    $result = pg_query_params($conn, $query, [$nama, $jabatan, $nip, $fileName, $fileDestination, $fileType]);

                    if ($result) {
                        // Redirect to barcode.php
                        echo "<script>console.log('Data berhasil disimpan dan gambar diunggah.'); window.location.href='barcode.php';</script>";
                    } else {
                        echo "<script>console.log('Gagal menyimpan data ke database.');</script>";
                    }
                } else {
                    echo "<script>console.log('Gagal memindahkan file.');</script>";
                }
            } else {
                echo "<script>console.log('Ukuran file terlalu besar.');</script>";
            }
        } else {
            echo "<script>console.log('Ada masalah saat mengunggah file.');</script>";
        }
    } else {
        echo "<script>alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan.');</script>"; // Notifikasi untuk file yang tidak didukung
    }
}
?>