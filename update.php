<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil data yang dikirimkan melalui parameter GET
    $id = $_GET["id"];
    $namaBarang = $_GET["nama_barang"];
    $hargaBarang = $_GET["harga_barang"];

    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "db-barang");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Mengupdate data barang dalam database
    $query = "UPDATE barang SET nama_barang='$namaBarang', harga_barang=$hargaBarang WHERE id=$id";
    if ($koneksi->query($query) === TRUE) {
        echo "Data barang berhasil diupdate.";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
