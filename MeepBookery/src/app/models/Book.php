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

    public function getAllAvailableBooks()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM Book WHERE Status = 1 ORDER BY BookID DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách sách: " . $e->getMessage());
            return [];
        }
    }

    public function getAllAvailableBooksByCategoryId($categoryID=null)
    {
        try {
            if ($categoryID == null) {
                $stmt = $this->conn->query("SELECT * FROM Book WHERE Status = 1 ORDER BY BookID DESC");
            } else {
                $stmt = $this->conn->prepare("SELECT * FROM Book WHERE CategoryID = ? AND Status = 1 ORDER BY BookID DESC");
                $stmt->execute([$categoryID]);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách sách theo danh mục: " . $e->getMessage());
            return [];
        }
    }

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

    public function getAvailableBookById($bookID)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Book WHERE BookID = ?  AND Status = 1");
            $stmt->execute([$bookID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy thông tin sách: " . $e->getMessage());
            return null;
        }
    }

    // Thống kê sách bán chạy nhất kèm số lượt bán
    public function getTopBestSellingBooks($limit = 5)
    {
        try {
            $query = "
                SELECT 
                    b.*, 
                    c.Name AS CategoryName,
                    c.Description AS CategoryDescription,
                    SUM(od.Quantity) AS TotalSold,
                    SUM(od.Quantity * od.Price) AS TotalRevenue
                FROM OrderDetail od
                INNER JOIN `Order` o ON od.OrderID = o.OrderID
                INNER JOIN Book b ON od.ProductID = b.BookID
                INNER JOIN Category c ON b.CategoryID = c.CategoryID
                WHERE o.Status = 'delivered_success' -- Sửa thành trạng thái đúng
                GROUP BY b.BookID
                ORDER BY TotalSold DESC
                LIMIT $limit
            ";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi thống kê sách bán chạy: " . $e->getMessage());
            return [];
        }
    }
    
    
}

