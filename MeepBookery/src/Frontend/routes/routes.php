<?php

define('ROOT_PATH', dirname(__DIR__));

require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/StaticController.php";
require_once "../app/controllers/ClientController.php";
require_once "../app/controllers/AuthController.php";
require_once "../app/controllers/CategoryController.php";
require_once "../app/controllers/UserController.php";
// require_once "../app/controllers/AdminController.php";

$orderController = new OrderController();
$statictisController = new StatisticsController();
$authController = new AuthController();
$clientController = new ClientController();
$userController = new UserController();

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
// elseif ($_SERVER["REQUEST_URI"] === "/checkout") {
//     $orderController->checkout();
// } 
elseif ($_SERVER["REQUEST_URI"] === "/process_checkout" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->processCheckout();
} elseif ($requestUri === "/orders/update-status" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $orderController->updateStatus();
}
// elseif (strpos($_SERVER["REQUEST_URI"], "/orderCustomer") === 0) {
//     $orderController->getOrdersByCustomerId();
// } elseif ($_SERVER["REQUEST_URI"] === "/category"  && $_SERVER["REQUEST_METHOD"] === "GET") {
//     $categoryController->index();
// } elseif (strpos($_SERVER["REQUEST_URI"], "/category/delete") === 0) {
//     $categoryController->delete();
// } elseif ($_SERVER["REQUEST_URI"] === "/category/create") {
//     $categoryController->create();
// } elseif (strpos($_SERVER["REQUEST_URI"], "/category/edit") === 0) {
//     $categoryController->edit();


// Client Routes
elseif ($requestUri === "/" || $requestUri === "/index") {
    $clientController->index();
} elseif (preg_match("/^\/shop/", $requestUri)) {
    $clientController->shop();
} elseif (preg_match("/^\/product-detail/", $requestUri)) {
    $clientController->productDetail();
} elseif ($requestUri === "/cart") {
    $clientController->cart();
} elseif ($requestUri === "/cart/checkout") {
    $clientController->checkout();
} elseif ($requestUri === "/my-account/order-history") {
    $clientController->orderHistory();
} elseif ($requestUri === "/my-account/order-history/order-detail") {
    $clientController->orderDetail();
} elseif ($requestUri === "/about-us") {
    $clientController->aboutUs();
} elseif ($requestUri === "/contact-us") {
    $clientController->contactUs();
} elseif ($requestUri === "/my-account") {
    $clientController->myAccount();
} elseif ($requestUri === "/my-account/update") {
    $userController->updateUserInfo();
} elseif ($requestUri === "/sync-cart" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $clientController->syncCart();
} else {
    $clientController->notFound();
}
