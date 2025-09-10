<?php 
$servername = "localhost"; 
$username = "root";        
$password = "";          
$dbname = "dbyasamkoc"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    
    error_log("Bağlantı başarısız: " . $conn->connect_error);
    die("Veritabanı bağlantısı sağlanamadı.");
}
?>