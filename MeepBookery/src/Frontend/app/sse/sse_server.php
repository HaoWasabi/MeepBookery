<?php
// Thiết lập header cho SSE
function sendSse()
{
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');

    // Tiến hành gửi dữ liệu mỗi interval
    // while (true) {
    //     // Lấy dữ liệu sản phẩm mới
    //     $product = generateProductData();

    //     // Gửi dữ liệu dưới dạng JSON
    //     echo "data: " . json_encode($product) . "\n\n";
    //     flush(); // Đảm bảo gửi dữ liệu ngay lập tức
    //     sleep(5); // Cập nhật dữ liệu sau mỗi 5 giây    
    // }
}

// Phương thức tạo dữ liệu sản phẩm mới (ví dụ)
function generateProductData()
{
    // Tạo sản phẩm mới (có thể lấy từ cơ sở dữ liệu)
    return [
        'productId' => rand(1000, 9999),
        'productName' => 'Product ' . rand(1, 100),
        'timestamp' => time()
    ];
}

// Phương thức gửi dữ liệu tùy chỉnh, nhận tham số đầu vào
function sendCustomSse($productData)
{
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');

    // Gửi dữ liệu dưới dạng JSON
    echo "data: " . json_encode($productData) . "\n\n";
    flush(); // Đảm bảo gửi dữ liệu ngay lập tức
}