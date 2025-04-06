<?php
// Hiển thị lỗi (chỉ dùng khi debug)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_set_cookie_params([
//     'lifetime' => 86400, // Thời gian sống của cookie
//     'path' => '/',
//     'domain' => '',
//     'secure' => true, // Chỉ gửi cookie qua kết nối HTTPS
//     'httponly' => true, // Không cho JavaScript truy cập cookie
//     'samesite' => 'Strict' // Giới hạn cookie theo chính sách SameSite
// ]);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Kết nối database
require_once "../config/database.php";

// Định tuyến (sử dụng routes.php để xử lý request)
require_once "../routes/routes.php";
