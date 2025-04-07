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

// Client routes
if ($requestUri === "/" || $requestUri === "/index" || $requestUri === "/index.php") {
    $clientController->index();
    // } elseif ($requestUri === "/shop" || $requestUri === "/shop.php") {
} elseif (preg_match("/^\/shop/", $requestUri)) {
    $clientController->shop();
} elseif (preg_match("/^\/product-detail/", $requestUri)) {
    $clientController->productDetail();
} elseif ($requestUri === "/cart" || $requestUri === "/cart.php") {
    $clientController->cart();
} elseif ($requestUri === "/checkout" || $requestUri === "/checkout.php") {
    $clientController->checkout();
} elseif ($requestUri === "/order-history" || $requestUri === "/order-history.php") {
    $clientController->orderHistory();
} elseif ($requestUri === "/order-detail" || $requestUri === "/order-detail.php") {
    $clientController->orderDetail();
} elseif ($requestUri === "/about-us" || $requestUri === "/about-us.php") {
    $clientController->aboutUs();
} elseif ($requestUri === "/contact-us" || $requestUri === "/contact-us.php") {
    $clientController->contactUs();
} elseif ($requestUri === "/my-account" || $requestUri === "/my-account.php") {
    $clientController->myAccount();
}

// Auth routes
elseif ($requestUri === "/login") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $authController->login();
    } else {
        // Redirect to home page
        header('Location: /');
        exit();
    }
} elseif ($requestUri === "/register") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $authController->register();
    } else {
        // Redirect to home page
        header('Location: /');
        exit();
    }
} elseif ($requestUri === "/logout" || $requestUri) {
    $authController->logout();
}

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
else {
    $clientController->notFound();
}
