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

// Periksa apakah id data yang akan diedit tersedia
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Ambil data dari tabel berdasarkan id
    $sql = "SELECT * FROM penerima_bansos WHERE id='$id'";
    $result = $conn->query($sql); // Gunakan $conn di sini

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tampilkan form edit data
        echo "<h2>Edit Data Penerima Bansos</h2>";
        echo "<form method='post' action='edit.php?id=$id'>";
        echo "<label for='nik'>NIK:</label>";
        echo "<input type='text' id='nik' name='nik' value='" . $row["nik"] . "' required><br>";
        echo "<label for='nama'>Nama:</label>";
        echo "<input type='text' id='nama' name='nama' value='" . $row["nama"] . "' required><br>";
        echo "<label for='tempat_tanggal_lahir'>Tempat, Tanggal Lahir:</label>";
        echo "<input type='text' id='tempat_tanggal_lahir' name='tempat_tanggal_lahir' value='" . $row["tempat_tanggal_lahir"] . "' required><br>";
        echo "<label for='jenis_kelamin'>Jenis Kelamin:</label>";
        echo "<select id='jenis_kelamin' name='jenis_kelamin' required>";
        echo "<option value='laki-laki'" . ($row["jenis_kelamin"] == "laki-laki" ? "selected" : "") . ">Laki-laki</option>";
        echo "<option value='perempuan'" . ($row["jenis_kelamin"] == "perempuan" ? "selected" : "") . ">Perempuan</option>";
        echo "</select><br>";
        echo "<label for='status'>Status:</label>";
        echo "<select id='status' name='status' required>";
        echo "<option value='reguler'" . ($row["status"] == "reguler" ? "selected" : "") . ">Nikah</option>";
        echo "<option value='kelas_khusus'" . ($row["status"] == "kelas_khusus" ? "selected" : "") . ">Belum Menikah</option>";
        echo "</select><br>";
        echo "<button type='submit' name='edit'>Simpan Perubahan</button>";
        echo "</form>";
    } else {
        echo "Data tidak ditemukan.";
    }
}

// Periksa apakah form edit data sudah disubmit
if (isset($_POST["edit"])) {
    $id = $_GET["id"];
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $tempat_tanggal_lahir = $_POST["tempat_tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $status = $_POST["status"];

    // Update data di tabel
    $sql = "UPDATE penerima_bansos SET nik='$nik', nama='$nama', tempat_tanggal_lahir='$tempat_tanggal_lahir', jenis_kelamin='$jenis_kelamin', status='$status' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diedit";
        header("Location: index.php"); // Redirect ke halaman index.php
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>