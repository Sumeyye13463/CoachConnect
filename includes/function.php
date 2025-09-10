<?php
include('config.php');

function koclarGetir($conn) {
    $sql_koclar = "SELECT tblKoclar.ad, tblKoclar.soyad, tblKoclar.aciklama, tblKoclar.url, tblAlan.alan_isim 
                   FROM tblKoclar 
                   JOIN tblAlan ON tblKoclar.alan_id = tblAlan.alan_id";
    $sonuc = mysqli_query($conn, $sql_koclar);
    $koclar_array = mysqli_fetch_all($sonuc, MYSQLI_ASSOC);

    return $koclar_array; 
}
function referansGetir($conn) {
    $sql_referanslar = "SELECT * FROM tblreferanslar";                
    $sonuc = mysqli_query($conn, $sql_referanslar);
    $referanslar_array = mysqli_fetch_all($sonuc, MYSQLI_ASSOC);

    return $referanslar_array; 
}


function kocTurleriniGetir($conn) {
    // Koç türlerini tblalan tablosundan alýyoruz
    $sql = "SELECT alan_id, alan_isim FROM tblalan";
    $result = $conn->query($sql);

    $kocTurleri = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kocTurleri[] = $row;
        }
    }

    return $kocTurleri;
}

function koclariSec($conn, $alan_id) {
    // Koçlarý tblkoclar tablosundan, alan_id'ye göre alýyoruz
    $sql = "SELECT koc_id, koc_ad FROM tblkoclar WHERE alan_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alan_id); // alan_id'yi baðla
    $stmt->execute();
    $result = $stmt->get_result();

    $koclar = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $koclar[] = $row;
        }
    }

    return $koclar;
}
?>