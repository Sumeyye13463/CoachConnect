<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
$is_superadmin = $_SESSION['admin_logged_in'] === 'superadmin';

$host = "localhost";
$user = "root";
$pass = "";
$db = "dbyasamkoc";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

function clean($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM tblrandevu WHERE kullanici_id = $delete_id");
    header("Location: admin_panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Admin Paneli - Randevular</title>
<style>
body { font-family: Arial; margin: 20px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; }
th { background: #eee; }
a.delete-btn { color: red; }
</style>
</head>
<body>
<h1>Admin Paneli</h1>
<p><a href="logout.php">Çıkış Yap</a></p>

<?php if ($is_superadmin): ?>
<p><a href="koc_yonet.php">Koçları Yönet</a></p>
<?php endif; ?>

<table>
<tr>
<th>ID</th><th>Ad Soyad</th><th>Email</th><th>Telefon</th>
<th>Koç Alan</th><th>Koç İsim</th><th>Oluşturulma</th><th>Randevu</th><th>Not</th><th>İşlem</th>
</tr>
<?php
$sql = "SELECT * FROM tblrandevu ORDER BY olusturulma_tarihi DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . intval($row['kullanici_id']) . "</td>";
        echo "<td>" . clean($row['ad_soyad']) . "</td>";
        echo "<td>" . clean($row['email']) . "</td>";
        echo "<td>" . clean($row['telefon']) . "</td>";
        echo "<td>" . clean($row['koc_alan']) . "</td>";
        echo "<td>" . clean($row['koc_isim']) . "</td>";
        echo "<td>" . clean($row['olusturulma_tarihi']) . "</td>";
        echo "<td>" . clean($row['randevu_tarihi']) . "</td>";
        echo "<td>" . clean($row['musteri_notu']) . "</td>";
        echo "<td>";
        echo "<a href='edit_randevu.php?kullanici_id=" . intval($row['kullanici_id']) . "'>Düzenle</a> | ";
        echo "<a class='delete-btn' href='admin_panel.php?delete_id=" . intval($row['kullanici_id']) . "' onclick='return confirm(\"Silinsin mi?\");'>Sil</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>Kayıt yok.</td></tr>";
}
$conn->close();
?>
</table>
</body>
</html>
