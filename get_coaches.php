<?php
include('includes/config.php');

if (isset($_GET['coaching_type_id'])) {
    $alan_id = intval($_GET['coaching_type_id']);

    $query = "SELECT koc_id, CONCAT(ad, ' ', soyad) AS koc_ad FROM tblkoclar WHERE alan_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $alan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $coaches = [];
    while ($row = $result->fetch_assoc()) {
        $coaches[] = $row;
    }

    echo json_encode($coaches);
} else {
    echo json_encode(["error" => "Invalid request."]);
}
?>