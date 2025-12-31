<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Pratama Adhyaksa</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-box h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .login-box input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #34495e;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <span class="logo">Klinik Adhyaksa</span>
        <h2>Silahkan Login</h2>

        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo "<p class='error'>Login gagal! Username/Password salah.</p>";
            }
        }
        ?>

        <form action="cek_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">LOGIN</button>
        </form>

        <div style="margin-top: 15px;">
            <a href="index.php" style="text-decoration: none; color: #7f8c8d; font-size: 14px;">&larr; Kembali ke
                Beranda</a>
        </div>
    </div>

</body>

</html>