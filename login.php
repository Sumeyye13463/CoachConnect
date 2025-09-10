<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_panel.php");
    exit;
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";
    if ($username === "admin" && $password === "1234") {
        $_SESSION['admin_logged_in'] = "admin";
        header("Location: admin_panel.php");
        exit;
    } elseif ($username === "superadmin" && $password === "12345") {
        $_SESSION['admin_logged_in'] = "superadmin";
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "Hatalı giriş.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Admin Girişi</title></head>
<body>
<h2>Giriş</h2>
<form method="post" action="">
    <label>Kullanıcı Adı:<br><input type="text" name="username" required></label><br><br>
    <label>Şifre:<br><input type="password" name="password" required></label><br><br>
    <input type="submit" value="Giriş Yap">
</form>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
