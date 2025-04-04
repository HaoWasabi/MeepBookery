<?php
require_once "../app/controllers/BookController.php";

$bookController = new BookController();

// Hiển thị danh sách sách (GET /books)
if ($_SERVER["REQUEST_URI"] === "/books" && $_SERVER["REQUEST_METHOD"] === "GET") {
    $bookController->index();
}

// Tạo sách mới (POST /books/create)
elseif ($_SERVER["REQUEST_URI"] === "/books/create" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->createBook();
}

// Cập nhật sách (POST /books/update)
elseif ($_SERVER["REQUEST_URI"] === "/books/update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->updateBook();
}

// Xóa sách (POST /books/delete)
elseif ($_SERVER["REQUEST_URI"] === "/books/delete" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $bookController->deleteBook();
}

// Chi tiết sách (GET /books/{id})
elseif (preg_match("/^\/books\/(\d+)$/", $_SERVER["REQUEST_URI"], $matches) && $_SERVER["REQUEST_METHOD"] === "GET") {
    $bookId = $matches[1];
    $bookController->getBookById($bookId);
}

// Nếu không tìm thấy đường dẫn hợp lệ
else {
    http_response_code(404);
    echo "404 Not Found - Đường dẫn không hợp lệ: " . htmlspecialchars($_SERVER["REQUEST_URI"]);
}
?>
