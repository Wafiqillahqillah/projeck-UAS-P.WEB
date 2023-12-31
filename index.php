<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }
        nav {
            background-color: #f2f2f2;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: #333;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            max-width: 500px;
            margin: 20px auto;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <h1>Perpustakaan</h1>
</header>

<nav>
    <a href="#">Beranda</a>
    <a href="#">Buku</a>
    <a href="#">Peminjaman</a>
</nav>

<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mylogin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan data buku dari database
function getBooks($conn) {
    $sql = "SELECT * FROM buku";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["judul"]."</td>";
            echo "<td>".$row["pengarang"]."</td>";
            echo "<td>".$row["penerbit"]."</td>";
            echo "<td>".$row["tahun_terbit"]."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Tidak ada data buku</td></tr>";
    }
}

// Fungsi untuk menambahkan data peminjaman ke database
function addPeminjaman($conn, $buku_id, $anggota_id, $tanggal_peminjaman, $tanggal_kembali) {
    $status = "dipinjam";
    $sql = "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_peminjaman, tanggal_kembali, status) VALUES ('$buku_id', '$anggota_id', '$tanggal_peminjaman', '$tanggal_kembali', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Peminjaman berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buku_id = $_POST["buku_id"];
    $anggota_id = $_POST["anggota_id"];
    $tanggal_peminjaman = $_POST["tanggal_peminjaman"];
    $tanggal_kembali = $_POST["tanggal_kembali"];

    addPeminjaman($conn, $buku_id, $anggota_id, $tanggal_peminjaman, $tanggal_kembali);
}

?>

<h2>Data Buku</h2>

<table>
    <tr>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Penerbit</th>
        <th>Tahun Terbit</th>
    </tr>
    <?php
    // Memanggil fungsi untuk mendapatkan data buku
    getBooks($conn);
    ?>
</table>

<h2>Form Peminjaman</h2>

<form method="post">
    <label for="buku_id">ID Buku:</label>
    <input type="text" name="buku_id" required>

    <label for="anggota_id">ID Anggota:</label>
    <input type="text" name="anggota_id" required>

    <label for="tanggal_peminjaman">Tanggal Peminjaman:</label>
    <input type="date" name="tanggal_peminjaman" required>

    <label for="tanggal_kembali">Tanggal Kembali:</label>
    <input type="date" name="tanggal_kembali" required>

    <button type="submit">Pinjam Buku</button>
</form>

<script>
// Contoh JavaScript (Anda dapat menambahkan lebih banyak fungsionalitas sesuai kebutuhan)
document.addEventListener("DOMContentLoaded", function() {
    // JavaScript code
    console.log("Halaman telah dimuat sepenuhnya.");
});
</script>

</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>