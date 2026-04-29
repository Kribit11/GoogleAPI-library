<?php
include_once("connect.php");

if (isset($_POST['submit'])) {

    $reviewText = strip_tags($_POST['reviewText']);
    $userName = strip_tags($_POST['userName']);
    $author = $_GET['author'];
    $publisher = $_GET['publisher'];
    $image = $_GET['image'];
    $bookTitle = $_GET['title'];

    if (empty($reviewText)) { 
        echo "*review field empty";
    } else {

        $stmt = $connection->prepare("INSERT INTO review (reviewText, userName, bookTitle) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $reviewText, $userName, $bookTitle);

        if ($stmt->execute()) {
            echo "Review submitted successfully!";
            header("Location: book.php?title=" . urlencode($bookTitle) . "&author=" . urlencode($author) . "&publisher=" . urlencode($publisher) . "&image=" . urlencode($image));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
