<?php
require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/StaticController.php";

$orderController = new OrderController();
$statictisController = new StatisticsController();
if ($_SERVER["REQUEST_URI"] === "/orders") {
    $orderController->index();
} elseif ($_SERVER["REQUEST_URI"] === "/orders/create" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->create();
} elseif ($_SERVER["REQUEST_URI"] === "/orders/update-status" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->updateStatus();
} elseif (strpos($_SERVER["REQUEST_URI"], "/orders/filter") === 0) {
    $orderController->filterOrders();
} elseif ($_SERVER["REQUEST_URI"] === "/statistic") {
    $statictisController->index();
} elseif ($_SERVER["REQUEST_URI"] === "/statistic/result") {
    $statictisController->showStatistics();
} elseif  (strpos($_SERVER["REQUEST_URI"], "/statistic/viewOrders") === 0) {
    $statictisController->viewOrder();
   
}elseif  (strpos($_SERVER["REQUEST_URI"], "/satictic/orderdetail") === 0) {
    $orderController->getOrderDetailById();
} elseif ($_SERVER["REQUEST_URI"] === "/checkout") {
    $orderController->checkout();
}
elseif ($_SERVER["REQUEST_URI"] === "/process_checkout" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->processCheckout();
}
else {
    // Hiển thị lỗi nếu route không khớp
    http_response_code(404);
    echo "404 Not Found - Đường dẫn không hợp lệ: " . htmlspecialchars($_SERVER["REQUEST_URI"]);
}
