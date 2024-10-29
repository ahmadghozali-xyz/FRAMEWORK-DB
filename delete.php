<?php

// Koneksi ke database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bansos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah id data yang akan dihapus tersedia
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Hapus data dari tabel
    $sql = "DELETE FROM penerima_bansos WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
        header("Location: index.php"); // Redirect ke halaman index.php
    } else {
        // Periksa apakah error karena data tidak ditemukan
        if ($conn->errno === 1451) { // Kode error untuk constraint violation
            echo "Data tidak dapat dihapus karena terkait dengan data lain.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();

?>