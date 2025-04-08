<?php

define('ROOT_PATH', dirname(__DIR__));

require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/StaticController.php";
require_once "../app/controllers/ClientController.php";
require_once "../app/controllers/AuthController.php";

$orderController = new OrderController();
$statictisController = new StatisticsController();
$authController = new AuthController();
$clientController = new ClientController();

// Parse the URL path
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// Admin routes
// elseif ($_SERVER["REQUEST_URI"] === "/orders") {
//     $orderController->index();
// } elseif ($_SERVER["REQUEST_URI"] === "/orders/create" && $_SERVER["REQUEST_METHOD"] === "POST") {
//     $orderController->create();
// } elseif ($_SERVER["REQUEST_URI"] === "/orders/update-status" && $_SERVER["REQUEST_METHOD"] === "POST") {
//     $orderController->updateStatus();
// } elseif (strpos($_SERVER["REQUEST_URI"], "/orders/filter") === 0) {
//     $orderController->filterOrders();
// } elseif ($_SERVER["REQUEST_URI"] === "/statistic") {
//     $statictisController->index();
// } elseif ($_SERVER["REQUEST_URI"] === "/statistic/result") {
//     $statictisController->showStatistics();
// } elseif (strpos($_SERVER["REQUEST_URI"], "/statistic/viewOrders") === 0) {
//     $statictisController->viewOrder();
// } elseif (strpos($_SERVER["REQUEST_URI"], "/satictic/orderdetail") === 0) {
//     $orderController->getOrderDetailById();
// }

// Auth routes
if ($requestUri === "/admin/login") {
    $authController->login('admin');
} elseif ($requestUri === "/login") {
    $authController->login('client');
} elseif ($requestUri === "/register") {
    $authController->register();
} elseif ($requestUri === "/admin/logout") {
    $authController->logout('/admin/auth');
} elseif ($requestUri === "/logout") {
    $authController->logout('/');
} 
// Client Routes
elseif ($requestUri === "/" || $requestUri === "/index") {
    $clientController->index();
} elseif (preg_match("/^\/shop/", $requestUri)) {
    $clientController->shop();
} elseif (preg_match("/^\/product-detail/", $requestUri)) {
    $clientController->productDetail();
} elseif ($requestUri === "/cart") {
    $clientController->cart();
} elseif ($requestUri === "/checkout") {
    $clientController->checkout();
} elseif ($requestUri === "/order-history") {
    $clientController->orderHistory();
} elseif ($requestUri === "/order-detail") {
    $clientController->orderDetail();
} elseif ($requestUri === "/about-us") {
    $clientController->aboutUs();
} elseif ($requestUri === "/contact-us") {
    $clientController->contactUs();
} elseif ($requestUri === "/my-account") {
    $clientController->myAccount();
} else {
    $clientController->notFound();
}