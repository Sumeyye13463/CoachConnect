<?php
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_soyad = $_POST['name'];
    $email = $_POST['email'];
    $telefon = $_POST['phone'];
    $koc_alan_id = $_POST['coaching_type'];
    $koc_id = $_POST['coach'];
    $randevu_tarihi = $_POST['date'];
    $musteri_notu = $_POST['notes'];

    // Koç adını alın (ad + soyad olarak)
    $stmt = $conn->prepare("SELECT CONCAT(ad, ' ', soyad) AS koc_ad FROM tblkoclar WHERE koc_id = ?");
    $stmt->bind_param("i", $koc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $koc_isim = $row['koc_ad'];

    // Randevu zaman aralığı belirle (randevu saati +/- 59 dakika)
    $datetime = new DateTime($randevu_tarihi);
    $start = clone $datetime;
    $end = clone $datetime;
    $start->modify('-59 minutes');
    $end->modify('+59 minutes');

    $startStr = $start->format('Y-m-d H:i:s');
    $endStr = $end->format('Y-m-d H:i:s');

    // Aynı koç için aynı 60 dakika içinde randevu kontrolü
    $kontrol = $conn->prepare("SELECT kullanici_id FROM tblrandevu WHERE randevu_tarihi BETWEEN ? AND ? AND koc_isim = ?");
    $kontrol->bind_param("sss", $startStr, $endStr, $koc_isim);
    $kontrol->execute();
    $sonuc = $kontrol->get_result();

    if ($sonuc->num_rows > 0) {
        header("Location: randevu_hata.php");
        exit;
    } else {
        $ekle = $conn->prepare("INSERT INTO tblrandevu (ad_soyad, email, telefon, koc_alan, koc_isim, olusturulma_tarihi, randevu_tarihi, musteri_notu) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
        $ekle->bind_param("sssssss", $ad_soyad, $email, $telefon, $koc_alan_id, $koc_isim, $randevu_tarihi, $musteri_notu);
        $ekle->execute();
        header("Location: randevu_basari.php");
        exit;
    }
} else {
    header("Location: contact.php");
    exit;
}
?>
