<?php
include './Koneksi.php';

// Ambil data biner dari database
$result = pg_query($conn, "SELECT ttd FROM barcode_pengawas WHERE id = 21");
$ttd_supervisor = pg_fetch_result($result, 0, 'ttd');

if ($ttd_supervisor) {
    // Cek panjang data
    $length = strlen($ttd_supervisor);
    echo "Panjang data: $length<br>"; // Debugging: tampilkan panjang data

    // Cek beberapa byte pertama
    $header = substr($ttd_supervisor, 0, 8); // Ambil 8 byte pertama
    echo "Header: " . bin2hex($header) . "<br>"; // Debugging: tampilkan header dalam format hex

    // Cek format gambar
    if ($header === "\x89PNG\r\n\x1a\n") {
        echo "Format: PNG";
    } elseif (substr($header, 0, 3) === "\xFF\xD8\xFF") {
        echo "Format: JPEG";
    } elseif (substr($header, 0, 6) === "GIF89a" || substr($header, 0, 6) === "GIF87a") {
        echo "Format: GIF";
    } else {
        echo "Format tidak dikenali";
    }
} else {
    echo "Gambar tidak ditemukan";
}
?>