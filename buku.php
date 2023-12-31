<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
    </style>
</head>
<body>

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