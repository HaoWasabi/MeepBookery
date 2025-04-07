<?php

class ClientController
{
    private $data;
    public function __construct()
    {
        // Khởi tạo dữ liệu mẫu chung cho tất cả các trang

        require_once ROOT_PATH . '/app/controllers/data.php';
        $this->data = $data;
    }

    public function index()
    {
        $page_title = "MeepBookery";
        $content = $this->renderView('home');
        $show_breadcrumb = false;
        $show_nav = true;
        include('../app/views/client/index.php');
    }

    public function shop()
    {
        $page_title = "Cửa hàng";
        $content = $this->renderView('shop');
        $show_breadcrumb = true;
        $show_nav = true;
        $breadcrumbs = [
            ['title' => 'Cửa hàng', 'url' => 'shop']
        ];
        include('../app/views/client/index.php');
    }

    public function productDetail()
    {
        $page_title = "Chi tiết sản phẩm";
        $content = $this->renderView('product-detail');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Cửa hàng', 'url' => 'shop'],
            ['title' => 'Chi tiết sản phẩm', 'url' => '#']
        ];
        include('../app/views/client/index.php');
    }

    public function cart()
    {
        $page_title = "Giỏ hàng";
        $content = $this->renderView('cart');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Giỏ hàng', 'url' => 'cart']
        ];
        include('../app/views/client/index.php');
    }

    public function checkout()
    {
        // $this->checkLogin();

        $page_title = "Thanh toán";
        $content = $this->renderView('checkout');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Giỏ hàng', 'url' => 'cart'],
            ['title' => 'Thanh toán', 'url' => 'checkout']
        ];
        include('../app/views/client/index.php');
    }

    public function orderHistory()
    {
        $this->checkLogin();

        $page_title = "Lịch sử đơn hàng";
        $content = $this->renderView('order-history');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Tài khoản', 'url' => 'my-account'],
            ['title' => 'Lịch sử đơn hàng', 'url' => 'order-history']
        ];
        include('../app/views/client/index.php');
    }

    public function orderDetail()
    {
        $this->checkLogin();

        $page_title = "Chi tiết đơn hàng";
        $content = $this->renderView('order-detail');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Tài khoản', 'url' => 'my-account'],
            ['title' => 'Lịch sử đơn hàng', 'url' => 'order-history'],
            ['title' => 'Chi tiết đơn hàng', 'url' => '#']
        ];
        include('../app/views/client/index.php');
    }

    public function myAccount()
    {
        $this->checkLogin();

        $page_title = "Tài khoản";
        $content = $this->renderView('my-account');
        $show_breadcrumb = true;
        $show_nav = false;
        $breadcrumbs = [
            ['title' => 'Tài khoản', 'url' => 'my-account']
        ];
        include('../app/views/client/index.php');
    }

    // Hiển thị trang lỗi 404
    public function notFound()
    {
        $page_title = "404 - Trang không tìm thấy";
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
        $page_title = "Giới thiệu";
        $content = $this->renderView('about-us');
        $show_breadcrumb = true;
        $show_nav = true;
        $breadcrumbs = [
            ['title' => 'Giới thiệu', 'url' => '/about-us']
        ];

        include('../app/views/client/index.php');
    }

    // Hiển thị trang liên hệ
    public function contactUs()
    {
        $page_title = "Liên hệ";
        $content = $this->renderView('contact-us');
        $show_breadcrumb = true;
        $show_nav = true;
        $breadcrumbs = [
            ['title' => 'Liên hệ', 'url' => '/contact-us']
        ];

        include('../app/views/client/index.php');
    }

    private function checkLogin()
    {
        if (!isset($_SESSION['UserID'])) {
            header('Location: /');
            exit();
        }
    }
    private function renderView($viewName)
    {
        ob_start();
        extract($this->data);
        require_once ROOT_PATH . "/app/views/client/scripts.php";
        include("../app/views/client/{$viewName}.php");
        return ob_get_clean();
    }
}