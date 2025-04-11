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
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $imageURL = $_POST['imageURL'] ?? '';
            $categoryId = $_POST['categoryId'] ?? 0;
            $length = $_POST['length'] ?? 0;
            $weight = $_POST['weight'] ?? 0;
            $dimensions = $_POST['dimensions'] ?? '';
            $language = $_POST['language'] ?? '';
            $format = $_POST['format'] ?? '';
            $author = $_POST['author'] ?? '';
            $publisher = $_POST['publisher'] ?? '';
            $releaseDate = $_POST['releaseDate'] ?? '';
            $status = $_POST['status'] ?? 0;
    
            return $this->bookModel->createBook($name, $description, $price, $stock, $imageURL, $categoryId, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status);
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
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $releaseDate = $_POST['releaseDate'];
            $status = $_POST['status'];

            return $this->bookModel->updateBook($bookId, $name, $description, $price, $stock, $imageURL, $categoryId, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status);
        }
    }

    // Xóa sách
    public function deleteBook()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookId = $_POST['bookId'];

            return $this->bookModel->deleteBook($bookId);
        }
    }

    // Hủy xóa sách
    public function undeleteBook()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookId = $_POST['bookId'];

            return $this->bookModel->undeleteBook($bookId);
        }
    }

    public function getAllBooks()
    {
        return $this->bookModel->getAllBooks();
    }

    public function getAllAvailableBooks()
    {
        return $this->bookModel->getAllAvailableBooks();
    }

    public function getAllAvailableBooksByCategoryId($categoryId = null)
    {
        return $this->bookModel->getAllAvailableBooksByCategoryId($categoryId);
    }
    
    public function getBookById($bookId)
    {
        return $this->bookModel->getBookById($bookId);
    }

    public function getAvailableBookById($bookId)
    {
        return $this->bookModel->getAvailableBookById($bookId);
    }

    public function getTopBestSellingBooks($limit = 5)
    {
        return $this->bookModel->getTopBestSellingBooks($limit);
    }
}

// $bookController = new BookController();
// $books = $bookController->getAllAvailableBooksByCategoryId(); // Lấy danh sách sách theo ID

// if (!$books) {
//     echo "<p>Không có sách nào trong danh mục này.</p>";
//     exit;
// } else {
//     foreach ($books as $book) {
//         echo "<h2>{$book['Name']}</h2>";
//         echo "<p>Thể loại: {$book['CategoryName']}</p>";
//         echo "<p>Nội dung thể loại: {$book['CategoryDescription']}</p>";
//         echo "<p>Giá: " . number_format($book['Price'], 0, ',', '.') . "đ</p>";
//         echo "<p>Đã bán: {$book['TotalSold']} lượt</p>";
//         echo "<p>Tổng doanh thu: " . number_format($book['TotalRevenue'], 0, ',', '.') . "đ</p>";
//         echo "<img src='{$book['ImageURL']}' alt='{$book['Name']}' style='width: 200px; height: auto;'>";
//         echo "<hr>";
//     }
// }

// foreach ($books as $book) {      
// $limit = 4;
// $topBooks = $bookController->getTopBestSellingBooks($limit);

// if (empty($topBooks)) {
//     echo "Không có sách nào được bán.";
// } else {
//     echo "Top $limit sách bán chạy nhất:<br>";
// }

// foreach ($topBooks as $book) {
//     echo "Tên sách: {$book['Name']}<br>";
//     echo "Thể loại: {$book['CategoryName']}<br>";
//     echo "Nội dung thể loại: {$book['CategoryDescription']}<br>";
//     echo "Đã bán: {$book['TotalSold']} lượt<br>";
//     echo "Tổng doanh thu: " . number_format($book['TotalRevenue'], 0, ',', '.') . "đ<br><br>";
// }