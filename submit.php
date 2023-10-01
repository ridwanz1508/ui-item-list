<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari form
    $namaBarang = $_POST["nama_barang"];
    $hargaBarang = $_POST["harga_barang"];

    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "db-barang");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Cek jumlah data yang sudah ada dalam database
    $query = "SELECT COUNT(*) as jumlah FROM barang";
    $result = $koneksi->query($query);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $jumlahData = $row["jumlah"];
        
        // Tentukan batas maksimum
        $batasMaksimum = 5;

        // Cek apakah jumlah data sudah mencapai atau melebihi batas maksimum
        if ($jumlahData >= $batasMaksimum) {
            echo "Message over limit"; // Pesan jika jumlah data melebihi batas maksimum
        } else {
            // Menyimpan data barang ke database
            $query = "INSERT INTO barang (nama_barang, harga_barang) VALUES ('$namaBarang', $hargaBarang)";
            if ($koneksi->query($query) === TRUE) {
                echo "Data barang berhasil disimpan.";
            } else {
                echo "Error: " . $query . "<br>" . $koneksi->error;
            }
        }
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
