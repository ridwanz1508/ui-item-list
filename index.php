<!DOCTYPE html>
<html>

<head>
    <title>Input Barang</title>
    <style>
        /* Tambahkan CSS sesuai kebutuhan Anda */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px; /* Sesuaikan lebar maksimum sesuai kebutuhan Anda */
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            max-width: 200px; /* Sesuaikan lebar maksimum sel sesuai kebutuhan Anda */
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Input Barang</h1>

    <form id="inputForm" action="submit.php" method="POST">
        <label for="namaBarang">Nama Barang:</label>
        <input type="text" id="namaBarang" name="nama_barang" required><br><br>

        <label for="hargaBarang">Harga Barang:</label>
        <input type="number" id="hargaBarang" name="harga_barang" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <h1>Daftar Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="barangList">
            <!-- Daftar barang akan ditampilkan di sini -->
        </tbody>
    </table>

    <script>
        // Tambahkan JavaScript sesuai kebutuhan Anda
        function tampilkanDaftarBarang() {
            fetch('get_data.php')
                .then(response => response.json())
                .then(data => {
                    const barangList = document.getElementById('barangList');
                    barangList.innerHTML = ''; // Bersihkan daftar sebelum menambahkan data baru
                    data.forEach(barang => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${barang.nama_barang}</td>
                            <td>${barang.harga_barang}</td>
                            <td>
                                <button onclick="updateBarang(${barang.id})">Update</button>
                                <button onclick="hapusBarang(${barang.id})">Delete</button>
                            </td>
                        `;
                        barangList.appendChild(tr);
                    });
                });
        }

        // Panggil fungsi tampilkanDaftarBarang untuk pertama kali
        tampilkanDaftarBarang();

        // Fungsi untuk mengirim data barang ke server
        document.getElementById('inputForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const namaBarang = document.getElementById('namaBarang').value;
            const hargaBarang = document.getElementById('hargaBarang').value;

            fetch('submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `nama_barang=${namaBarang}&harga_barang=${hargaBarang}`,
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Tampilkan pesan dari server di konsol
                    document.getElementById('namaBarang').value = ''; // Kosongkan input setelah submit
                    document.getElementById('hargaBarang').value = ''; // Kosongkan input setelah submit
                    tampilkanDaftarBarang(); // Refresh daftar setelah menambahkan
                });
        });

        // Fungsi untuk mengirim permintaan hapus barang ke server
        function hapusBarang(id) {
            fetch(`delete.php?id=${id}`)
                .then(() => {
                    tampilkanDaftarBarang(); // Refresh daftar setelah menghapus
                });
        }

        // Fungsi untuk menampilkan form update barang
        function updateBarang(id) {
            // Ambil data barang yang akan diupdate
            fetch(`get_data.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    const namaBarangInput = document.getElementById('namaBarang');
                    const hargaBarangInput = document.getElementById('hargaBarang');
                    namaBarangInput.value = data[0].nama_barang;
                    hargaBarangInput.value = data[0].harga_barang;

                    // Ubah form submit untuk mengirim pembaruan
                    const form = document.getElementById('inputForm');
                    form.removeEventListener('submit', submitForm);
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();
                        const namaBarang = document.getElementById('namaBarang').value;
                        const hargaBarang = document.getElementById('hargaBarang').value;

                        // Kirim data pembaruan ke server
                        fetch(`update.php?id=${id}&nama_barang=${namaBarang}&harga_barang=${hargaBarang}`)
                            .then(() => {
                                tampilkanDaftarBarang(); // Refresh daftar setelah mengupdate
                                form.removeEventListener('submit', updateBarang);
                                form.addEventListener('submit', submitForm); // Kembali ke fungsi submitForm
                                form.reset(); // Bersihkan formulir setelah pembaruan
                            });
                    });
                });
        }

        // Fungsi untuk mengirim data barang ke server
        function submitForm(event) {
            event.preventDefault();
            const namaBarang = document.getElementById('namaBarang').value;
            const hargaBarang = document.getElementById('hargaBarang').value;

            fetch('submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `nama_barang=${namaBarang}&harga_barang=${hargaBarang}`,
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Tampilkan pesan dari server di konsol
                    document.getElementById('namaBarang').value = ''; // Kosongkan input setelah submit
                    document.getElementById('hargaBarang').value = ''; // Kosongkan input setelah submit
                    tampilkanDaftarBarang(); // Refresh daftar setelah menambahkan
                });
        }

    </script>
</body>

</html>
