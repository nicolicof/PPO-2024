<?php
require "./db.php";

$searchTerm = isset($_GET["term"]) ? strtolower(trim($_GET["term"])) : "";

if (empty($searchTerm)) {
    echo json_encode([]);
    exit();
}

$sql =
    "SELECT id, nome_local, rua FROM enderecos WHERE LOWER(nome_local) LIKE ? OR LOWER(rua) LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$searchTermWild = "%$searchTerm%";
$stmt->bind_param("ss", $searchTermWild, $searchTermWild);
$stmt->execute();
$result = $stmt->get_result();

$address_list = [];
while ($row = $result->fetch_assoc()) {
    $address_list[] = $row;
}

header("Content-Type: application/json");

echo json_encode($address_list);
?>
