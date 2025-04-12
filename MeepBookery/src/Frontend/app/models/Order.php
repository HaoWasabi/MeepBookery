<?php
require_once __DIR__ . '/../../config/database.php';


class Order
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

    // 1. Hàm tạo đơn hàng
    public function createOrder($userId, $totalAmount, $addressId, $paymentMethodId, $time)
    {
        try {
            $stmt = $this->conn->prepare("
            INSERT INTO `Order` (UserID, TotalAmount, AddressID, PaymentMethodID,OrderDate) 
            VALUES (?, ?, ?, ?,?)
        ");
            $stmt->execute([$userId, $totalAmount, $addressId, $paymentMethodId, $time]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Lỗi tạo đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // 2. Hàm cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $newStatus)
    {
        try {
            // Kiểm tra đơn hàng hiện tại
            $stmt = $this->conn->prepare("SELECT Status FROM `Order` WHERE OrderID = ?");
            $stmt->execute([$orderId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) return false;
            if ($order['Status'] === 'delivered_success' && $newStatus === 'canceled') return false;

            // Cập nhật trạng thái đơn hàng
            $stmt = $this->conn->prepare("UPDATE `Order` SET Status = ? WHERE OrderID = ?");
            return $stmt->execute([$newStatus, $orderId]);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // 3. Hàm lấy tất cả đơn hàng
    public function getAllOrders()
    {
        try {
            $stmt = $this->conn->query("
            SELECT o.*, a.Address, a.City, a.District, a.Ward ,u.Name
            FROM `Order` o
            JOIN Address a ON o.AddressID = a.AddressID
            JOIN User u on u.AddressID=O.AddressId
            ORDER BY o.OrderDate DESC
        ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách đơn hàng: " . $e->getMessage());
            return [];
        }
    }
    public function getAllOrderOfCustomer($userId)
    {
        try {
            $stmt = $this->conn->prepare("
            SELECT o.*, a.Address, a.City, a.District, a.Ward ,u.Name,o.Status
            FROM `Order` o
            JOIN Address a ON o.AddressID = a.AddressID
            JOIN User u on u.AddressID=O.AddressId
            Where o.UserID = ?
            ORDER BY o.OrderDate DESC
        ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    // 4. Hàm lọc đơn hàng theo tiêu chí
    public function filterOrders($status = null, $startDate = null, $endDate = null, $city = null, $district = null)
    {
        try {
            $query = "
            SELECT o.*, a.Address, a.City, a.District, a.Ward ,u.Name
            FROM `Order` o
            JOIN Address a ON o.AddressID = a.AddressID
            JOIN User u on u.AddressID=O.AddressId
            WHERE 1=1
        ";

            $params = [];

            if ($status) {
                $query .= " AND o.Status = ?";
                $params[] = $status;
            }
            if ($startDate && $endDate) {
                $query .= " AND DATE(o.OrderDate) BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
            if ($city) {
                $query .= " AND a.City LIKE ?";
                $params[] = "%{$city}%"; // Thêm ký tự % để tìm kiếm chứa chuỗi
            }
            if ($district) {
                $query .= " AND a.District LIKE ?";
                $params[] = "%{$district}%";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lọc đơn hàng: " . $e->getMessage());
            return [];
        }
    }
    public function getOrdersOfCustomerBetweenStartAndEnd($userId, $startDate, $endDate)
    {
        try {
            $query = "
                SELECT o.OrderID, o.OrderDate, o.TotalAmount,o.Status
                FROM `Order` o
                WHERE o.UserID = ? AND o.status='delivered_success' and DATE(o.OrderDate) BETWEEN ? AND ?
                ORDER BY o.OrderDate DESC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId, $startDate, $endDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy đơn hàng của khách hàng: " . $e->getMessage());
            return [];
        }
    }
    public function getOrderById($orderId)
    {
        try {
            // Lấy thông tin đơn hàng + User
            $stmt = $this->conn->prepare("
                SELECT 
                    o.OrderID, o.OrderDate, o.Status, o.TotalAmount,
                    u.UserID, u.Name AS UserName, u.Email, u.Phone,
                    a.Address, a.City, a.District, a.Ward,
                    pm.Name AS PaymentMethod
                FROM `Order` o
                JOIN User u ON o.UserID = u.UserID
                JOIN Address a ON o.AddressID = a.AddressID
                JOIN PaymentMethod pm ON o.PaymentMethodID = pm.PaymentMethodID
                WHERE o.OrderID = ?
            ");
            $stmt->execute([$orderId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                return null; // Không tìm thấy đơn hàng
            }

            // Lấy danh sách sản phẩm trong đơn hàng
            $stmt = $this->conn->prepare("
                SELECT 
                    od.ProductID, b.Name AS ProductName, 
                    od.Quantity, od.Price 
                FROM OrderDetail od
                JOIN Book b ON od.ProductID = b.BookID
                WHERE od.OrderID = ?
            ");
            $stmt->execute([$orderId]);
            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Gộp thông tin đơn hàng và chi tiết đơn hàng
            $order['OrderDetails'] = $orderDetails;

            return $order;
        } catch (PDOException $e) {
            error_log("Lỗi lấy đơn hàng theo ID: " . $e->getMessage());
            return null;
        }
    }
}
