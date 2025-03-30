<?php
require_once "../app/controllers/OrderController.php";

$orderController = new OrderController();

if ($_SERVER["REQUEST_URI"] === "/orders") {
    $orderController->index();
} elseif ($_SERVER["REQUEST_URI"] === "/orders/create" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->create();
} elseif ($_SERVER["REQUEST_URI"] === "/orders/update-status" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->updateStatus();
} elseif (strpos($_SERVER["REQUEST_URI"], "/orders/filter") === 0) {
    $orderController->filterOrders();
} else {
    // Hiển thị lỗi nếu route không khớp
    http_response_code(404);
    echo "404 Not Found - Đường dẫn không hợp lệ: " . htmlspecialchars($_SERVER["REQUEST_URI"]);
}
