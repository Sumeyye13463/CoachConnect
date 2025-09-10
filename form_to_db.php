<?php
include('includes/function.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ad_soyad = $_POST['name'];
    $email = $_POST['email'];
    $telefon = $_POST['phone'];
    $koc_alan = $_POST['coaching_type']; 
    $koc_isim = $_POST['coach']; 
    $olusturulma_tarihi = date('Y-m-d H:i:s'); 
    $musteri_notu = $_POST['notes'];
    $randevu_tarihi = $_POST['date']; 

   
    $query = "INSERT INTO tblrandevu (ad_soyad, email, telefon, koc_alan, koc_isim, olusturulma_tarihi, musteri_notu, randevu_tarihi) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssssss", $ad_soyad, $email, $telefon, $koc_alan, $koc_isim, $olusturulma_tarihi, $musteri_notu, $randevu_tarihi);

     
   if ($stmt->execute()) {
  
    echo "<p>Koçumuz ile +90 0212 654 78 79 kurumsal numaramızdan sizinle haftaiçi iletişime geçeceğiz. Bizi tercih ettiğiniz için teşekkür ederiz. Yönlendiriliyorsunuz...</p>";
    
    
    echo "<script>
            setTimeout(function() {
                window.location.href = 'contact.php'; 
            }, 5000); 
          </script>";
} else {
    
    echo "Veri kaydedilemedi.";
}

        $stmt->close();
    } else {
        echo "Sorgu hazırlama hatası: " . $conn->error;
    }
} else {
    echo "Lütfen formu doğru şekilde doldurun.";
}
?>