<?php
// Fungsi untuk melakukan koneksi ke database
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mylogin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}

// Fungsi untuk memeriksa username dan password
function checkCredentials($conn, $username, $password) {
    $hashedPassword = md5($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true; // Autentikasi berhasil
    } else {
        return false; // Autentikasi gagal
    }
}

// Jika ada data yang dikirimkan melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Memeriksa autentikasi
    if (checkCredentials($conn, $username, $password)) {
        // Autentikasi berhasil, arahkan ke index.php
        header("Location: index.php");
        exit();
    } else {
        // Autentikasi gagal, tampilkan pesan error atau lakukan tindakan lain
        echo "Autentikasi gagal. Periksa kembali username dan password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
        }
        label, input {
            display: block;
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
        }
        button {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

</body>
</html>

