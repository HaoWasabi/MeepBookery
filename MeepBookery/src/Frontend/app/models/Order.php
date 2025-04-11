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
    public function createOrder($userId, $totalAmount, $addressId, $paymentMethodId)
    {
        try {
            $stmt = $this->conn->prepare("
            INSERT INTO `Order` (UserID, TotalAmount, AddressID, PaymentMethodID) 
            VALUES (?, ?, ?, ?)
        ");
            $stmt->execute([$userId, $totalAmount, $addressId, $paymentMethodId]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Lỗi tạo đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // 2. Hàm cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $newStatus, $userId = null)
    {
        try {
            // Kiểm tra đơn hàng hiện tại (có điều kiện user nếu có)
            $query = "SELECT Status FROM `Order` WHERE OrderID = ?";
            $params = [$orderId];

            if ($userId !== null) {
                $query .= " AND UserID = ?";
                $params[] = $userId;
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order)
                return false;

            if ($order['Status'] === 'delivered_success' && $newStatus === 'canceled')
                return false;

            // Cập nhật trạng thái đơn hàng
            $stmt = $this->conn->prepare("UPDATE `Order` SET Status = ? WHERE OrderID = ?" . ($userId !== null ? " AND UserID = ?" : ""));
            $params = [$newStatus, $orderId];
            if ($userId !== null)
                $params[] = $userId;

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            return false;
        }
    }


    // 3. Hàm lấy tất cả đơn hàng
    public function getAllOrders()
    {
        try {
            $stmt = $this->conn->prepare("
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
    public function getOrderById($orderId, $userId = null)
    {
        try {
            // Lấy thông tin đơn hàng + User
            $sql = "
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
                    ";

            $params = [$orderId];

            // Nếu có userId thì thêm điều kiện
            if ($userId) {
                $sql .= " AND o.UserID = ?";
                $params[] = $userId;
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                return null; // Không tìm thấy đơn hàng
            }

            // Lấy danh sách sản phẩm trong đơn hàng
            $stmt = $this->conn->prepare("
                SELECT 
                    od.ProductID, b.Name AS ProductName, b.Author, b.ImageURL,
                    od.Quantity, od.Price , c.Name AS Category
                FROM OrderDetail od
                JOIN Book b ON od.ProductID = b.BookID
                JOIN Category c ON b.CategoryID = c.CategoryID
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

    public function getFilteredOrdersOfCustomer($userId)
    {
        // Set up filters
        $filters = [
            'orderID' => $_GET['orderID'] ?? '',
            'Status' => $_GET['Status'] ?? '',
            'startDate' => $_GET['startDate'] ?? date('Y-m-d', strtotime('-30 days')),
            'endDate' => $_GET['endDate'] ?? date('Y-m-d'),
        ];

        try {
            $query = "SELECT o.*, a.Address, a.City, a.District, a.Ward, u.Name
                      FROM `Order` o
                      JOIN Address a ON o.AddressID = a.AddressID
                      JOIN User u ON u.UserID = o.UserID
                      WHERE o.UserID = ?";

            $params = [$userId];

            // Filter by order ID if provided
            if (!empty($filters['orderID'])) {
                $query .= " AND o.OrderID LIKE ?";
                $params[] = "%" . $filters['orderID'] . "%";
            }

            // Filter by status if provided
            if (!empty($filters['Status'])) {
                $query .= " AND o.Status = ?";
                $params[] = $filters['Status'];
            }

            // Filter by date range if provided
            if (!empty($filters['startDate'])) {
                $query .= " AND o.OrderDate >= ?";
                $params[] = $filters['startDate'] . " 00:00:00";
            }

            if (!empty($filters['endDate'])) {
                $query .= " AND o.OrderDate <= ?";
                $params[] = $filters['endDate'] . " 23:59:59";
            }

            // Order by most recent first
            $query .= " ORDER BY o.OrderDate DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching filtered orders: " . $e->getMessage());
            return [];
        }
    }
}
