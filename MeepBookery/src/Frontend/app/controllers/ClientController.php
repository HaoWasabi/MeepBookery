<?php

class ClientController
{
    public function __construct()
    {
        // Khởi tạo dữ liệu mẫu chung cho tất cả các trang
        // $this->data = $data;
    }

    public function index()
    {
        $page_title = "MeepBookery";
        $content = $this->renderView('home');
        $show_breadcrumb = false;
        include('../app/views/client/index.php');
    }

    public function shop()
    {
        $page_title = "Cửa hàng";
        $content = $this->renderView('shop');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Cửa hàng', 'url' => 'shop.php']
        ];
        include('../app/views/client/index.php');
    }

    public function productDetail()
    {
        $page_title = "Chi tiết sản phẩm";
        $content = $this->renderView('product-detail');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Cửa hàng', 'url' => 'shop.php'],
            ['title' => 'Chi tiết sản phẩm', 'url' => '#']
        ];
        include('../app/views/client/index.php');
    }

    public function cart()
    {
        $page_title = "Giỏ hàng";
        $content = $this->renderView('cart');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Giỏ hàng', 'url' => 'cart.php']
        ];
        include('../app/views/client/index.php');
    }

    public function checkout()
    {
        $page_title = "Thanh toán";
        $content = $this->renderView('checkout');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Giỏ hàng', 'url' => 'cart.php'],
            ['title' => 'Thanh toán', 'url' => 'checkout.php']
        ];
        include('../app/views/client/index.php');
    }

    public function orderHistory()
    {
        if (!isset($_SESSION['UserID'])) {
            header('Location: index.php?auth=login');
            exit();
        }

        $page_title = "Lịch sử đơn hàng - MeepBookery";
        $content = $this->renderView('order-history');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Tài khoản', 'url' => 'profile.php'],
            ['title' => 'Lịch sử đơn hàng', 'url' => 'order-history.php']
        ];
        include('../app/views/client/index.php');
    }

    public function orderDetail()
    {
        if (!isset($_SESSION['UserID'])) {
            header('Location: index.php?auth=login');
            exit();
        }

        $page_title = "Chi tiết đơn hàng - MeepBookery";
        $content = $this->renderView('order-detail');
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Tài khoản', 'url' => 'profile.php'],
            ['title' => 'Lịch sử đơn hàng', 'url' => 'order-history.php'],
            ['title' => 'Chi tiết đơn hàng', 'url' => '#']
        ];
        include('../app/views/client/index.php');
    }

    // Hiển thị trang lỗi 404
    public function notFound()
    {
        $page_title = "404 - Trang không tìm thấy | MeepBookery";
        $content = $this->renderView('../error/404');

        $show_breadcrumb = false;
        $breadcrumbs = [
            ['title' => 'Lỗi 404', 'url' => '#']
        ];

        // Thiết lập HTTP status code
        http_response_code(404);

        include('../app/views/client/index.php');
    }

    // Hiển thị trang giới thiệu
    public function aboutUs()
    {
        $page_title = "Giới thiệu - MeepBookery";
        $content = $this->renderView('about-us');

        // Thiết lập breadcrumb
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Giới thiệu', 'url' => '/about-us']
        ];

        include('../app/views/client/index.php');
    }

    // Hiển thị trang liên hệ
    public function contactUs()
    {
        $page_title = "Liên hệ - MeepBookery";
        $content = $this->renderView('contact-us');

        // Thiết lập breadcrumb
        $show_breadcrumb = true;
        $breadcrumbs = [
            ['title' => 'Liên hệ', 'url' => '/contact-us']
        ];

        include('../app/views/client/index.php');
    }

    private function renderView($viewName)
    {
        ob_start();
        include("../app/views/client/{$viewName}.php");
        return ob_get_clean();
    }
}