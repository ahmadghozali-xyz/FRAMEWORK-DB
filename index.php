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

// Fungsi untuk menambahkan data
function tambahData($conn, $nik, $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status) {
    $sql = "INSERT INTO penerima_bansos (nik, nama, tempat_tanggal_lahir, jenis_kelamin, status) 
            VALUES ('$nik', '$nama', '$tempat_tanggal_lahir', '$jenis_kelamin', '$status')";

    if ($conn->query($sql) === TRUE) {
        return true; // Kembalikan true jika data berhasil disimpan
    } else {
        return false; // Kembalikan false jika terjadi error
    }
}

// Fungsi untuk menampilkan data
function tampilkanData($conn) {
    $sql = "SELECT * FROM penerima_bansos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data dalam bentuk tabel
        echo "<table border='1'>";
        echo "<tr><th>NIK</th><th>Nama</th><th>Tempat, Tanggal Lahir</th><th>Jenis Kelamin</th><th>Status</th><th>Aksi</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nik"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["tempat_tanggal_lahir"] . "</td>";
            echo "<td>" . $row["jenis_kelamin"] . "</td>";
            // Ubah kode di sini
            if ($row["status"] == "reguler") {
                echo "<td>Nikah</td>";
            } else if ($row["status"] == "kelas_khusus") {
                echo "<td>Belum Menikah</td>";
            }
            echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete.php?id=" . $row["id"] . "'>Hapus</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data.";
    }
}

// Fungsi untuk mengedit data
function editData($conn, $id, $nik, $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status) {
    $sql = "UPDATE penerima_bansos SET nik='$nik', nama='$nama', tempat_tanggal_lahir='$tempat_tanggal_lahir', 
            jenis_kelamin='$jenis_kelamin', status='$status' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diedit";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fungsi untuk menghapus data
function hapusData($conn, $id) {
    $sql = "DELETE FROM penerima_bansos WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menambahkan data baru dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $tempat_tanggal_lahir = $_POST["tempat_tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $status = $_POST["status"];

    if (tambahData($conn, $nik, $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status)) {
        echo "<p>Data kamu sudah tersimpan ke dalam database.</p>";
    } else {
        // Jika terjadi error, dapatkan pesan error dari database
        $error_message = $conn->error; 

        // Tampilkan pesan error yang lebih spesifik
        echo "<p>Maaf, terjadi kesalahan saat menyimpan data. Silahkan coba lagi nanti. ($error_message)</p>";
    }
} // Kurung kurawal ditambahkan di sini

// Mengedit data
if (isset($_GET["id"]) && isset($_POST["edit"])) {
    $id = $_GET["id"];
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $tempat_tanggal_lahir = $_POST["tempat_tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $status = $_POST["status"];

    editData($conn, $id, $nik, $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status);
}

// Menghapus data
if (isset($_GET["id"]) && isset($_GET["delete"])) {
    $id = $_GET["id"];
    hapusData($conn, $id);
}

// Tampilkan data
tampilkanData($conn);

$conn->close();
?>