<?php
require_once __DIR__ . '/../../config/database.php';

class Book
{
    private $conn;

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
        } catch (PDOException $e) {
            error_log("Lỗi kết nối DB: " . $e->getMessage());
            die("Không thể kết nối đến cơ sở dữ liệu.");
        }
    }

    // Thêm sách mới
    public function createBook($name, $description, $price, $stock, $imageURL, $categoryID, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO Book (Name, Description, Price, Stock, ImageURL, CategoryID, Length, Weight, Dimensions, Language, Format, Author, Publisher, ReleaseDate, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$name, $description, $price, $stock, $imageURL, $categoryID, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status]);
        } catch (PDOException $e) {
            error_log("Lỗi thêm sách: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật sách
    public function updateBook($bookID, $name, $description, $price, $stock, $imageURL, $categoryID, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE Book SET Name = ?, Description = ?, Price = ?, Stock = ?, ImageURL = ?, CategoryID = ?, Length = ?, Weight = ?, Dimensions = ?, Language = ?, Format = ?, Author = ?, Publisher = ?, ReleaseDate = ?, Status = ? WHERE BookID = ?  AND Status <> 0");
            return $stmt->execute([$name, $description, $price, $stock, $imageURL, $categoryID, $length, $weight, $dimensions, $language, $format, $author, $publisher, $releaseDate, $status, $bookID]);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật sách: " . $e->getMessage());
            return false;
        }
    }

    // Xóa sách
    public function deleteBook($bookID)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE Book SET Status = 0 WHERE BookID = ? AND Status <> 0");
            return $stmt->execute([$bookID]);
        } catch (PDOException $e) {
            error_log("Lỗi xóa sách: " . $e->getMessage());
            return false;
        }
    }

        // Hủy xóa sách
        public function undeleteBook($bookID)
        {
            try {
                $stmt = $this->conn->prepare("UPDATE Book SET Status = 1 WHERE BookID = ? AND Status = 0");
                return $stmt->execute([$bookID]);
            } catch (PDOException $e) {
                error_log("Lỗi hủy xóa sách: " . $e->getMessage());
                return false;
            }
        }

    // Lấy danh sách tất cả sách
    public function getAllBooks()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM Book WHERE Status <> 0 ORDER BY BookID DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách sách: " . $e->getMessage());
            return [];
        }
    }


    // Lấy thông tin sách theo ID
    public function getBookById($bookID)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Book WHERE BookID = ?  AND Status <> 0");
            $stmt->execute([$bookID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy thông tin sách: " . $e->getMessage());
            return null;
        }
    }
}
