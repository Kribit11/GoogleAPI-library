<?php
include_once("connect.php");

$bookTitle = $_GET['title'] ?? '';

$stmt = $connection->prepare("SELECT * FROM review WHERE bookTitle = ?");
$stmt->bind_param("s", $bookTitle);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    echo "<div class='review' style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
    echo "<p><strong>User:</strong> " . htmlspecialchars($row['userName'] ?: 'Anonymous') . "</p>";
    echo "<p><strong>Review:</strong> " . htmlspecialchars($row['reviewText']) . "</p>";
    echo "</div>";
}

$stmt->close();
?>
