<?php
require_once __DIR__ . '/../models/Book.php';

class BookController
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    // Hiển thị danh sách sách
    public function index()
    {
        $books = $this->bookModel->getAllBooks();
        require_once __DIR__ . '/../views/admin-books.php';  // ✅ Đúng
    }

    // Tạo sách mới
    public function createBook()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookId = $_POST['bookId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $imageURL = $_POST['imageURL'];
            $categoryId = $_POST['categoryId'];
            $length = $_POST['length'];
            $weight = $_POST['weight'];
            $dimensions = $_POST['dimensions'];
            $language = $_POST['language'];
            $format = $_POST['format'];
            $publisher = $_POST['publisher'];
            $releaseDate = $_POST['releaseDate'];
            $status = $_POST['status'];

            if ($this->bookModel->createBook($bookId, $name, $description, $price, $stock, $imageURL, $categoryId, $length, $weight, $dimensions, $language, $format, $publisher, $releaseDate, $status)) {
                header("Location: /books"); // Chuyển hướng về trang danh sách đơn hàng
                echo ("Thêm thành công");
            } else {
                echo ("Thêm thất bại");
            }
            exit();
        }
    }

    // Cập nhật sách
    public function updateBook()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookId = $_POST['bookId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $imageURL = $_POST['imageURL'];
            $categoryId = $_POST['categoryId'];
            $length = $_POST['length'];
            $weight = $_POST['weight'];
            $dimensions = $_POST['dimensions'];
            $language = $_POST['language'];
            $format = $_POST['format'];
            $publisher = $_POST['publisher'];
            $releaseDate = $_POST['releaseDate'];
            $status = $_POST['status'];

            if ($this->bookModel->updateBook($bookId, $name, $description, $price, $stock, $imageURL, $categoryId, $length, $weight, $dimensions, $language, $format, $publisher, $releaseDate, $status)) {
                header("Location: /books"); // Chuyển hướng về trang danh sách đơn hàng
                echo("Cập nhật thành công");
            } else {
                echo("Cập nhật thất bại");
            }
            exit();
        }
    }

    // Xóa sách
    public function deleteBook()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookId = $_POST['bookId'];

            if ($this->bookModel->deleteBook($bookId)) {
                header("Location: /books"); // Chuyển hướng về trang danh sách đơn hàng
                echo ("Xóa thành công");
            } else {
                echo ("Xóa thất bại");
            }
            exit();
        }
    }

    public function getAllBooks()
    {
        return $this->bookModel->getAllBooks();
    }
    
    public function getBookById($bookId)
    {
        return $this->bookModel->getBookById($bookId);
    }
}
