<?php
require_once "../app/controllers/BookController.php";

$bookController = new BookController();

// Debug
// echo "REQUEST_URI: " . $_SERVER["REQUEST_URI"] . " | METHOD: " . $_SERVER["REQUEST_METHOD"];
// exit;

if ($_SERVER["REQUEST_URI"] === "/books" && $_SERVER["REQUEST_METHOD"] === "GET") {
    $bookController->index();
} elseif ($_SERVER["REQUEST_URI"] === "/books/create" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->createBook();
} elseif ($_SERVER["REQUEST_URI"] === "/books/update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->updateBook();
} elseif ($_SERVER["REQUEST_URI"] === "/books/delete" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->deleteBook();
} elseif ($_SERVER["REQUEST_URI"] === "/books/undelete" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->undeleteBook();
} elseif (preg_match("/^\/books\/(\d+)$/", $_SERVER["REQUEST_URI"], $matches) && $_SERVER["REQUEST_METHOD"] === "GET") {
    $bookId = $matches[1];
    $bookController->getBookById($bookId);
} else {
    http_response_code(404);
    echo "404 Not Found - Đường dẫn không hợp lệ: " . htmlspecialchars($_SERVER["REQUEST_URI"]);
}
?>