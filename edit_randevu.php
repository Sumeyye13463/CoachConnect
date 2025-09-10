<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include('includes/config.php');

if (!isset($_GET['kullanici_id'])) {
    header("Location: admin_panel.php");
    exit;
}

$kullanici_id = intval($_GET['kullanici_id']);
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $randevu_tarihi = $_POST['randevu_tarihi'] ?? '';

    if (!$randevu_tarihi) {
        $error = "Randevu tarihi boş bırakılamaz.";
    } else {
        $girilentarih = date('Y-m-d H:i:s', strtotime($randevu_tarihi));
        $baslangic = date('Y-m-d H:i:s', strtotime($girilentarih . ' -60 minutes'));
        $bitis = date('Y-m-d H:i:s', strtotime($girilentarih . ' +60 minutes'));

        $stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM tblrandevu WHERE randevu_tarihi BETWEEN ? AND ? AND kullanici_id != ?");
        $stmt_check->bind_param("ssi", $baslangic, $bitis, $kullanici_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $stmt_check->close();

        if ($row_check['count'] > 0) {
            $error = "Bu saatte zaten bir randevunuz var.";
        } else {
            $stmt = $conn->prepare("UPDATE tblrandevu SET randevu_tarihi = ? WHERE kullanici_id = ?");
            $stmt->bind_param("si", $girilentarih, $kullanici_id);
            if ($stmt->execute()) {
                $success = "Randevu tarihi başarıyla güncellendi.";
            } else {
                $error = "Güncelleme sırasında hata oluştu.";
            }
            $stmt->close();
        }
    }
}

$stmt = $conn->prepare("SELECT ad_soyad, randevu_tarihi FROM tblrandevu WHERE kullanici_id = ?");
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: admin_panel.php");
    exit;
}
$row = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Randevu Düzenle</title>
</head>
<body>
<h2><?php echo htmlspecialchars($row['ad_soyad']); ?> - Randevu Düzenle</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="post" action="">
    <label for="randevu_tarihi">Randevu Tarihi ve Saati:</label><br>
    <input type="datetime-local" id="randevu_tarihi" name="randevu_tarihi" 
    value="<?php echo date('Y-m-d\TH:i', strtotime($row['randevu_tarihi'])); ?>" required><br><br>
    <input type="submit" value="Güncelle">
</form>

<p><a href="admin_panel.php">Geri Dön</a></p>
</body>
</html>
