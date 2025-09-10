<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== "superadmin") {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "dbyasamkoc");
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

function clean($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function uploadImage($file) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . uniqid() . "-" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowedTypes)) return false;
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $targetFilePath;
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['ekle'])) {
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $email = $_POST['email'];
        $telefon = $_POST['telefonNo'];
        $alan_id = $_POST['alan_id'];
        $aciklama = $_POST['aciklama'];
        $url = "";

        if (isset($_FILES['resim']) && $_FILES['resim']['error'] === UPLOAD_ERR_OK) {
            $yuklenen = uploadImage($_FILES['resim']);
            if ($yuklenen) $url = $yuklenen;
        }

        $stmt = $conn->prepare("INSERT INTO tblkoclar (ad, soyad, email, telefonNo, alan_id, aciklama, url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $ad, $soyad, $email, $telefon, $alan_id, $aciklama, $url);
        $stmt->execute();
    } elseif (isset($_POST['sil'])) {
        $id = intval($_POST['koc_id']);
        $res = $conn->query("SELECT url FROM tblkoclar WHERE koc_id = $id");
        if ($res && $row = $res->fetch_assoc()) {
            if ($row['url'] && file_exists($row['url'])) unlink($row['url']);
        }
        $conn->query("DELETE FROM tblkoclar WHERE koc_id = $id");
    } elseif (isset($_POST['guncelle'])) {
        $id = intval($_POST['koc_id']);
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $email = $_POST['email'];
        $telefon = $_POST['telefonNo'];
        $alan_id = $_POST['alan_id'];
        $aciklama = $_POST['aciklama'];

        $url = "";
        $res = $conn->query("SELECT url FROM tblkoclar WHERE koc_id = $id");
        if ($res && $row = $res->fetch_assoc()) {
            $url = $row['url'];
        }

        if (isset($_FILES['resim']) && $_FILES['resim']['error'] === UPLOAD_ERR_OK) {
            $yuklenen = uploadImage($_FILES['resim']);
            if ($yuklenen) {
                if ($url && file_exists($url)) unlink($url);
                $url = $yuklenen;
            }
        }

        $stmt = $conn->prepare("UPDATE tblkoclar SET ad = ?, soyad = ?, email = ?, telefonNo = ?, alan_id = ?, aciklama = ?, url = ? WHERE koc_id = ?");
        $stmt->bind_param("ssssissi", $ad, $soyad, $email, $telefon, $alan_id, $aciklama, $url, $id);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT k.koc_id, k.ad, k.soyad, k.email, k.telefonNo, k.alan_id, k.aciklama, k.url, a.alan_isim FROM tblkoclar k LEFT JOIN tblalan a ON k.alan_id = a.alan_id ORDER BY k.koc_id DESC");

$alanlar = $conn->query("SELECT alan_id, alan_isim FROM tblalan ORDER BY alan_isim ASC");
$alan_options = "";
while ($alan = $alanlar->fetch_assoc()) {
    $alan_options .= "<option value=\"" . $alan['alan_id'] . "\">" . clean($alan['alan_isim']) . "</option>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Koç Yönetimi</title>
</head>
<body>
<h2>Koç Yönetimi</h2>
<a href="admin_panel.php">↩ Geri Dön</a>

<h3>Yeni Koç Ekle</h3>
<form method="post" enctype="multipart/form-data">
    <input name="ad" placeholder="Ad" required>
    <input name="soyad" placeholder="Soyad" required>
    <input name="email" placeholder="Email" required>
    <input name="telefonNo" placeholder="Telefon" required>
    <select name="alan_id" required>
        <option value="" disabled selected>Alan Seçiniz</option>
        <?= $alan_options ?>
    </select>
    <input name="aciklama" placeholder="Açıklama">
    <input type="file" name="resim" accept="image/*">
    <input type="submit" name="ekle" value="Ekle">
</form>

<h3>Koç Listesi</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Ad</th><th>Soyad</th><th>Email</th><th>Telefon</th><th>Alan</th><th>Açıklama</th><th>Resim</th><th>Resim Yükle</th><th>İşlem</th></tr>
<?php while ($koc = $result->fetch_assoc()): ?>
<tr>
<form method="post" enctype="multipart/form-data" style="margin:0;">
<td><?= $koc['koc_id'] ?></td>
<td><input type="text" name="ad" value="<?= clean($koc['ad']) ?>" required></td>
<td><input type="text" name="soyad" value="<?= clean($koc['soyad']) ?>" required></td>
<td><input type="email" name="email" value="<?= clean($koc['email']) ?>" required></td>
<td><input type="text" name="telefonNo" value="<?= clean($koc['telefonNo']) ?>" required></td>
<td>
<select name="alan_id" required>
    <option value="" disabled>Alan Seçiniz</option>
    <?php
    $current_alan_id = $koc['alan_id'];
    $alanlar = $conn->query("SELECT alan_id, alan_isim FROM tblalan ORDER BY alan_isim ASC");
    while ($alan = $alanlar->fetch_assoc()):
    ?>
        <option value="<?= $alan['alan_id'] ?>" <?= ($alan['alan_id'] == $current_alan_id) ? 'selected' : '' ?>>
            <?= clean($alan['alan_isim']) ?>
        </option>
    <?php endwhile; ?>
</select>
</td>
<td><input type="text" name="aciklama" value="<?= clean($koc['aciklama']) ?>"></td>
<td>
    <?php if ($koc['url'] && file_exists($koc['url'])): ?>
        <img src="<?= clean($koc['url']) ?>" alt="Resim" style="max-width:50px; max-height:50px;">
    <?php else: ?>
        -
    <?php endif; ?>
</td>
<td><input type="file" name="resim" accept="image/*"></td>
<td>
    <input type="hidden" name="koc_id" value="<?= $koc['koc_id'] ?>">
    <button type="submit" name="guncelle">Güncelle</button>
    <button type="submit" name="sil" onclick="return confirm('Silinsin mi?');">Sil</button>
</td>
</form>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
