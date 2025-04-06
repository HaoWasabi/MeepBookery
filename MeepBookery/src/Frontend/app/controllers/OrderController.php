<?php
require_once __DIR__ . '/../models/Order.php';

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = $this->orderModel->getAllOrders();
        // require_once __DIR__ . '/../views/admin-orders.php';  // ✅ Đúng
    }

    // Tạo đơn hàng mới
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userId = $_POST['userId'];
            $totalAmount = $_POST['totalAmount'];
            $addressId = $_POST['addressId'];
            $paymentMethodId = $_POST['paymentMethodId'];

            if ($this->orderModel->createOrder($userId, $totalAmount, $addressId, $paymentMethodId)) {
                header("Location: /orders");
            }
            exit();
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $orderId = $_POST['orderId'];
            $status = $_POST['status'];

            if ($this->orderModel->updateOrderStatus($orderId, $status)) {
                echo json_encode(["message" => "Cập nhật trạng thái thành công"]);
            } else {
                echo json_encode(["message" => "Cập nhật thất bại"]);
            }
            exit();
        }
    }


    // Lọc đơn hàng theo tiêu chí
    public function filterOrders()
    {
        $status = $_GET['status'] ?? null;
        $startDate = $_GET['startDate'] ?? null;
        $endDate = $_GET['endDate'] ?? null;
        $city = $_GET['city'] ?? null;
        $district = $_GET['district'] ?? null;
        echo ($startDate . $endDate);
        $orders = $this->orderModel->filterOrders($status, $startDate, $endDate, $city, $district);
        require_once __DIR__ . '/../views/admin-orders.php';  // ✅ Sửa đường dẫn

    }
    public function getOrderDetailById()
    {
        $orderId = intval($_GET['orderId']);
        $orderData = $this->orderModel->getOrderById($orderId);
        require_once __DIR__ . '/../views/orderdetail.php';
    }
}
