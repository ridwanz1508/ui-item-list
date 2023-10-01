<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil data yang dikirimkan melalui parameter GET
    $id = $_GET["id"];

    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "db-barang");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Menghapus data barang dari database
    $query = "DELETE FROM barang WHERE id=$id";
    if ($koneksi->query($query) === TRUE) {
        echo "Data barang berhasil dihapus.";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
