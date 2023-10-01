<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db-barang");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data barang
$query = "SELECT * FROM barang";
$result = $koneksi->query($query);

$barangData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $barangData[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($barangData);
?>
