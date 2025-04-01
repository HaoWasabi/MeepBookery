<!DOCTYPE html>
<html lang="en">

<?php
require_once "data.php";
$allBooks = array_values($books);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeepBookery - Nhà Sách Trực Tuyến</title>
    <!-- Favicon -->
    <link rel="icon" href="../../img/logo.JPG" type="image/jpeg">
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" /> -->
    <!-- PaginationJS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.css" />
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
        href="/css/app-wa-44192eecbbdcf8e8c5ae233465736f34.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-light.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-light.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-light.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS (đã bao gồm cả Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- PaginationJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>

    <style>
        body {
            padding-top: 0;
            background-color: #f8f9fa;
            font-size: 16px;
        }

        .top-bar {
            background-color: #e74c3c;
            padding: 5px 0;
            font-size: 16px;
            color: white;
        }

        .top-bar a {
            color: white !important;
            text-decoration: none;
        }

        .top-bar i {
            color: white;
        }

        .main-header {
            padding: 15px 0;
            background-color: white;
            z-index: 1000;
            position: sticky;
            top: 0;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            max-height: 60px;
        }

        /* Search bar styling */
        .search-wrapper {
            max-width: 800px;
        }

        .input-group {
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        .input-group .form-control {
            border: none;
            font-size: 16px;
            background-color: #f5f5f5;
        }

        .input-group .form-control:focus {
            border-color: transparent;
            box-shadow: none;
            outline: 0;
            background-color: #f5f5f5;
        }

        .category-toggle {
            background-color: #e74c3c;
            border: none;
            border-right: 1px solid #ddd;
            color: white;
            font-size: 16px;
            text-align: left;
            padding: 0.375rem 0.75rem;
            width: 120px;
        }

        .category-toggle:hover,
        .category-toggle:focus {
            background-color: #e74c3c;
            border-color: transparent;
            color: white;
        }

        .dropdown-menu {
            border-radius: 0;
            padding: 0;
            border-color: #ddd;
            width: 170px;
        }

        .dropdown-item {
            padding: 8px 15px;
            font-size: 16px;
            color: #333;
        }

        .dropdown-item.active {
            background-color: #e74c3c;
            color: white;
        }

        .dropdown-item:hover:not(.active) {
            background-color: #f5f5f5;
        }

        .search-btn {
            background-color: transparent;
            border: none;
            color: #333;
        }

        .search-btn:hover {
            background-color: transparent;
            color: #e74c3c;
        }

        /* Tài khoản và giỏ hàng */
        .account-btn,
        .cart-btn {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-size: 16px;
        }

        .account-btn:hover,
        .cart-btn:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            color: white;
        }

        .account-btn i,
        .cart-btn i {
            font-size: 16px;
            margin-right: 5px;
        }

        .cart-icon-wrapper {
            position: relative;
            display: inline-block;
            margin-right: 5px;
        }

        .cart-icon-wrapper .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 16px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .top-bar {
                font-size: 16px;
            }

            .logo img {
                max-height: 50px;
            }

            .account-btn span,
            .cart-btn span:not(.badge) {
                display: none;
            }

            .account-btn,
            .cart-btn {
                padding: 8px 10px;
            }

            .account-btn i,
            .cart-btn i {
                margin-right: 0;
            }

            .category-toggle {
                width: 100px;
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .logo img {
                max-height: 40px;
            }
        }

        /* Swiper Slider Styling */
        .swiper-container {
            width: 100%;
            height: auto;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .swiper-slide {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .slide-content {
            max-width: 600px;
            text-align: left;
            position: absolute;
            left: 80px;
            z-index: 2;
        }

        .slide-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #fff;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .slide-content p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn-slider {
            display: inline-block;
            padding: 12px 30px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 16px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-slider:hover {
            background-color: #c0392b;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .swiper-pagination {
            position: absolute;
            bottom: 20px !important;
            z-index: 10;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #fff;
            opacity: 0.7;
            margin: 0 5px;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #e74c3c;
            transform: scale(1.2);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            background: rgba(231, 76, 60, 0.7);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(231, 76, 60, 1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
        }

        .featured-books {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e74c3c;
        }

        .book-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            background-color: white;
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .book-card .out-of-stock-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(220, 53, 69, 0.9);
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 4px 10px;
            border-radius: 4px;
            z-index: 2;
        }

        .book-card .book-img-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .book-card .book-img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .book-card.out-of-stock .book-img-overlay {
            opacity: 1;
        }

        .book-img {
            height: 200px;
            object-fit: contain;
            width: 100%;
        }

        .book-info {
            padding: 15px;
        }

        .book-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .book-category {
            font-size: 16px;
            color: #e74c3c;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .book-author {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .book-price {
            font-size: 18px;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .btn-add-cart {
            background-color: #e74c3c;
            color: white;
            border: none;
            width: 100%;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: 600;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .btn-add-cart:hover {
            background-color: #c0392b;
        }

        .btn-add-cart:disabled {
            background-color: #6c757d;
            opacity: 0.65;
            cursor: not-allowed;
        }

        .all-books {
            margin-bottom: 40px;
        }

        /* Pagination styles */
        #pagination-container {
            margin-top: 30px;
        }

        .paginationjs {
            display: flex;
            justify-content: center;
        }

        .paginationjs .paginationjs-pages {
            margin-bottom: 25px;
        }

        .paginationjs .paginationjs-pages ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .paginationjs .paginationjs-pages li {
            margin: 0 2px;
        }

        .paginationjs .paginationjs-pages li>a {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }

        .paginationjs .paginationjs-pages li.active>a {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
        }

        .paginationjs .paginationjs-pages li>a:hover:not(.active) {
            background-color: #f8f9fa;
            color: #e74c3c;
        }

        .paginationjs .paginationjs-pages li.disabled>a {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
        }

        .paginationjs .paginationjs-pages li.paginationjs-prev a,
        .paginationjs .paginationjs-pages li.paginationjs-next a {
            font-size: 14px;
            padding: 8px 15px;
            min-width: auto;
            font-weight: 600;
        }

        .paginationjs .paginationjs-pages li.paginationjs-prev a {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .paginationjs .paginationjs-pages li.paginationjs-next a {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .paginationjs .paginationjs-pages li.paginationjs-prev a:hover,
        .paginationjs .paginationjs-pages li.paginationjs-next a:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
        }

        .paginationjs .paginationjs-pages li.paginationjs-prev a i,
        .paginationjs .paginationjs-pages li.paginationjs-next a i {
            font-size: 12px;
            margin: 0 4px;
        }

        /* Footer styles */
        footer {
            font-size: 16px;
        }

        footer h5 {
            font-size: 18px;
        }

        footer .list-unstyled li {
            font-size: 16px;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Badge animation */
        @keyframes badgePulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .badge-animated {
            animation: badgePulse 0.5s ease;
        }

        /* Style for remove button in cart */
        .remove-item {
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .remove-item:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .paginationjs-nav {
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
            text-align: center;
            display: block;
        }

        .paginationjs .paginationjs-pages li.paginationjs-prev a i,
        .paginationjs .paginationjs-pages li.paginationjs-next a i {
            font-size: 12px;
            margin: 0 4px;
        }

        /* Empty cart styles */
        .empty-cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            text-align: center;
        }

        .empty-cart-image {
            width: 180px;
            height: auto;
            margin-bottom: 20px;
        }

        .empty-cart-message {
            font-size: 18px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-cart-submessage {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .empty-cart-button {
            padding: 8px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .empty-cart-button:hover {
            background-color: #c0392b;
            color: white;
        }

        .category-btn {
            background-color: #e74c3c;
            color: white;
            padding: 10px 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px 0 0 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 120px;
            border-right: 1px solid #c0392b;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 999;
            max-height: 300px;
            overflow-y: auto;
            border-radius: 4px;
        }

        /* Input group adjustments for simple dropdown */
        .simple-dropdown+.form-control {
            border-left: none;
            border-radius: 0;
        }

        /* Button border radius adjustments */
        .input-group .btn-primary {
            border-radius: 0 4px 4px 0;
        }

        .dropdown-content a:first-child {
            border-radius: 4px 4px 0 0;
        }

        .dropdown-content a:last-child {
            border-bottom: none;
            border-radius: 0 0 4px 4px;
        }
    </style>
</head>

<body>
    <?php require_once 'includes/header.php'; ?>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">Sản phẩm trong giỏ hàng:</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div id="cartItems">
                <!-- Cart items will be loaded here -->
            </div>
            <div id="cartSummary" class="p-3 border-top mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Tổng số mục:</span>
                    <span id="cartTotalItems">0 sản phẩm cho <b class="text-danger">0 đ</b></span>
                </div>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary">Xem giỏ hàng</a>
                    <a href="#" class="btn btn-danger">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper Slider -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="../../img/ms_banner_img3.webp" alt="Khám phá thế giới sách">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <h1>Khám phá thế giới sách tại MeepBookery</h1>
                    <p>Nơi bạn có thể tìm thấy hàng ngàn đầu sách chất lượng với giá cả hợp lý</p>
                    <button class="btn-slider">Khám phá ngay</button>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="../../img/ms_banner_img1.webp" alt="Sách bán chạy nhất">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <h1>Sách bán chạy nhất</h1>
                    <p>Khám phá những cuốn sách được yêu thích nhất của độc giả</p>
                    <button class="btn-slider">Xem ngay</button>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Best Seller Books Section -->
    <section class="featured-books">
        <div class="container">
            <h2 class="section-title">Sách bán chạy</h2>
            <div id="featured-books-container" class="row">
                <!-- Sách sẽ được render bằng JavaScript -->
            </div>
        </div>
    </section>

    <!-- All Books Section -->
    <section class="all-books">
        <div class="container">
            <h2 class="section-title">Tất cả sách</h2>
            <div id="books-container" class="row">
                <!-- Sách sẽ được render bằng JavaScript -->
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="mt-4 mb-5"></div>
        </div>
    </section>

    <?php require_once 'includes/footer.php'; ?>

    <script>
        // Swiper initialization
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            speed: 1000,
        });

        // Dữ liệu sách
        var allBooks = <?php echo json_encode($allBooks); ?>;
        var bestSellerBooks = <?php echo json_encode($best_seller_books); ?>;

        // Hàm tạo HTML cho card sách
        function createBookCard(book) {
            const isOutOfStock = book.stock === 0;

            return `
                <div class="col-md-3 col-sm-6">
                    <div class="book-card ${isOutOfStock ? 'out-of-stock' : ''}">
                        ${isOutOfStock ? '<div class="out-of-stock-label">Tạm hết hàng</div>' : ''}
                        <div class="book-img-container">
                            <img src="${book.image}" alt="${book.name}" class="book-img">
                            ${isOutOfStock ? '<div class="book-img-overlay">Tạm hết hàng</div>' : ''}
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">${book.name}</h3>
                            <p class="book-category">${book.category}</p>
                            <p class="book-author">${book.author}</p>
                            <p class="book-price">${book.price} ₫</p>
                            <button class="btn btn-add-cart" data-book-id="${book.id}" ${isOutOfStock ? 'disabled' : ''}>
                                ${isOutOfStock ? 'Tạm hết hàng' : 'Thêm vào giỏ'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Hiển thị sách bán chạy
        $(function () {
            let bestSellerBooksHtml = '';

            // Filter only active books (include ones with stock=0 to show "out of stock")
            const availableBestSellers = bestSellerBooks.filter(book => book.status === 1);

            $.each(availableBestSellers, function (index, book) {
                bestSellerBooksHtml += createBookCard(book);
            });

            $('#featured-books-container').html(bestSellerBooksHtml);
        });

        // Khởi tạo phân trang với paginationjs
        $(function () {
            // Filter only active books (include ones with stock=0 to show "out of stock")
            const availableBooks = allBooks.filter(book => book.status === 1);

            $('#pagination-container').pagination({
                dataSource: availableBooks,
                pageSize: 8,
                autoHidePrevious: true,
                autoHideNext: true,
                prevText: '<i class="fas fa-chevron-left"></i>',
                nextText: '<i class="fas fa-chevron-right"></i>',
                pageRange: 2,
                hideOnlyOnePage: true,
                // showNavigator: true,
                // formatNavigator: 'Trang <strong><%= currentPage %></strong> / <%= totalPage %>, Hiển thị <%= totalNumber %> sản phẩm',
                callback: function (data, pagination) {
                    // Render HTML
                    var html = '';

                    $.each(data, function (index, book) {
                        html += createBookCard(book);
                    });

                    $('#books-container').html(html);

                    // Scroll to pagination position if navigating pages
                    if (pagination.pageNumber >= 1) {
                        $('html, body').animate({
                            scrollTop: $('#books-container').offset().top - 100
                        }, 200);
                    }
                },
                locator: 'items'
            });
        });
    </script>

    <!-- Cart Functionality Script -->
    <script>
        $(document).ready(function () {
            // Initialize cart object
            let cart = {
                items: [],
                totalItems: 0,
                totalPrice: 0
            };

            // Initialize Bootstrap Toast component
            const toastLiveExample = document.getElementById('liveToast');
            let toastBootstrap;
            if (toastLiveExample) {
                toastBootstrap = new bootstrap.Toast(toastLiveExample);
            }

            // Initialize cart offcanvas
            const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));

            // Check if cart is empty on initialization
            if (cart.items.length === 0) {
                $('#cartSummary').hide();
            }

            updateCartSummary();

            // Show cart when clicking cart button
            $('.cart-btn').on('click', function (e) {
                e.preventDefault();
                renderCartItems();
                cartOffcanvas.show();
            });

            // Add to cart functionality
            $('.btn-add-cart').on('click', function () {
                const bookId = $(this).data('book-id');
                // Find the book in allBooks array
                const book = allBooks.find(b => b.id == bookId);

                if (book) {
                    // Return value indicates if item was successfully added or not
                    const added = addToCart(book);

                    if (added) {
                        showNotification(`Đã thêm "${book.name}" vào giỏ hàng`, {
                            type: 'success',
                            title: 'Giỏ hàng'
                        });
                    }
                    // Don't show cart offcanvas when adding items
                    // cartOffcanvas.show();
                }
            });

            // Function to add items to cart
            function addToCart(book) {
                // Check if item already exists in cart
                const existingItem = cart.items.find(item => item.id === book.id);

                // Check current stock
                const currentStock = book.stock || 0;

                if (existingItem) {
                    // Check if adding one more would exceed stock
                    if (existingItem.quantity >= currentStock) {
                        showNotification(`Đã đạt giới hạn tồn kho của sách "${book.name}"`, {
                            type: 'error',
                            title: 'Giỏ hàng'
                        });
                        return false; // Item was not added
                    }
                    existingItem.quantity++;
                } else {
                    // Don't add if stock is 0
                    if (currentStock <= 0) {
                        showNotification(`Rất tiếc, sách "${book.name}" đã hết hàng`, {
                            type: 'error',
                            title: 'Giỏ hàng'
                        });
                        return false; // Item was not added
                    }
                    cart.items.push({
                        id: book.id,
                        name: book.name,
                        price: parseFloat(book.price.replace(/[^\d]/g, '')),
                        quantity: 1,
                        image: book.image
                    });
                }

                // Update cart summary and badge
                updateCartSummary();
                return true; // Item was successfully added
            }

            // Function to render cart items
            function renderCartItems() {
                let cartItemsHtml = '';

                if (cart.items.length === 0) {
                    // Empty cart view with image
                    cartItemsHtml = `
                        <div class="empty-cart-container">
                            <img src="../../img/empty-cart.png" alt="Giỏ hàng trống" class="empty-cart-image">
                            <div class="empty-cart-message">Giỏ hàng của bạn đang trống</div>
                            <div class="empty-cart-submessage">Hãy thêm sản phẩm vào giỏ hàng của bạn</div>
                            <button class="empty-cart-button" data-bs-dismiss="offcanvas">Tiếp tục mua sắm</button>
                        </div>
                    `;
                    // Hide cart summary
                    $('#cartSummary').hide();
                } else {
                    // Show cart summary
                    $('#cartSummary').show();

                    cart.items.forEach(item => {
                        // Find book in allBooks to get current stock
                        const book = allBooks.find(b => b.id === item.id);
                        const maxStock = book ? book.stock : 99; // Fallback to 99 if book not found

                        cartItemsHtml += `
                            <div class="card border-0 rounded-0 border-bottom">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <img src="${item.image}" alt="${item.name}" style="width: 80px; height: 100px; object-fit: cover;" class="me-3">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1" style="font-size: 14px;">${item.name}</h6>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="text-danger fw-bold" style="font-size: 14px;">${item.price.toLocaleString()} đ</div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="input-group input-group-sm" style="width: 120px;">
                                                    <button class="btn btn-outline-danger decrease-qty" type="button" data-id="${item.id}">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control text-center item-qty" value="${item.quantity}" 
                                                           data-id="${item.id}" min="1" max="${maxStock}" 
                                                           style="border-left: 0; border-right: 0;">
                                                    <button class="btn btn-outline-danger increase-qty" type="button" data-id="${item.id}" 
                                                           ${item.quantity >= maxStock ? 'disabled' : ''} 
                                                           style="${item.quantity >= maxStock ? 'opacity: 0.25; cursor: not-allowed;' : ''}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <button class="btn btn-sm text-danger remove-item ms-3" data-id="${item.id}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            ${maxStock < 10 ? `<small class="text-muted mt-1 d-block">Còn ${maxStock} "${item.name}" trong kho</small>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }

                $('#cartItems').html(cartItemsHtml);

                // Only attach event handlers if cart is not empty
                if (cart.items.length > 0) {
                    // Attach event handlers
                    $('.remove-item').on('click', function () {
                        const itemId = parseInt($(this).data('id'));
                        removeFromCart(itemId);
                    });

                    // Add quantity control event handlers
                    $('.increase-qty').on('click', function () {
                        const itemId = parseInt($(this).data('id'));
                        updateItemQuantity(itemId, 1);
                    });

                    $('.decrease-qty').on('click', function () {
                        const itemId = parseInt($(this).data('id'));
                        updateItemQuantity(itemId, -1);
                    });

                    $('.item-qty').on('change', function () {
                        const itemId = parseInt($(this).data('id'));
                        const newQty = parseInt($(this).val());
                        const maxStock = parseInt($(this).attr('max'));

                        if (!isNaN(newQty)) {
                            // Validate input within constraints
                            if (newQty <= 0) {
                                setItemQuantity(itemId, 1); // Minimum is 1
                            } else if (newQty > maxStock) {
                                setItemQuantity(itemId, maxStock);
                                const book = allBooks.find(b => b.id === itemId);
                                const bookName = book ? book.name : 'Sản phẩm này';
                                showNotification(`Chỉ còn ${maxStock} "${bookName}" trong kho`, {
                                    type: 'warning',
                                    title: 'Giỏ hàng'
                                });
                            } else {
                                setItemQuantity(itemId, newQty);
                            }
                        }
                    });
                }
            }

            // Function to update item quantity
            function updateItemQuantity(itemId, change) {
                const item = cart.items.find(item => item.id === itemId);
                if (item) {
                    const book = allBooks.find(b => b.id === itemId);
                    const maxStock = book ? book.stock : 99;

                    const newQty = item.quantity + change;
                    if (newQty > 0 && newQty <= maxStock) {
                        item.quantity = newQty;
                        updateCartSummary();
                        renderCartItems();
                    } else if (newQty > maxStock) {
                        showNotification(`Chỉ còn ${maxStock} "${book ? book.name : 'sản phẩm này'}" trong kho`, {
                            type: 'warning',
                            title: 'Giỏ hàng'
                        });
                    } else if (newQty <= 0) {
                        removeFromCart(itemId);
                    }
                }
            }

            // Function to set item quantity directly
            function setItemQuantity(itemId, quantity) {
                const item = cart.items.find(item => item.id === itemId);
                if (item) {
                    const book = allBooks.find(b => b.id === itemId);
                    const maxStock = book ? book.stock : 99;

                    if (quantity > 0 && quantity <= maxStock) {
                        item.quantity = quantity;
                        updateCartSummary();
                        renderCartItems();
                    } else if (quantity > maxStock) {
                        item.quantity = maxStock;
                        updateCartSummary();
                        renderCartItems();
                        showNotification(`Chỉ còn ${maxStock} "${book ? book.name : 'sản phẩm này'}" trong kho`, {
                            type: 'warning',
                            title: 'Giỏ hàng'
                        });
                    } else if (quantity <= 0) {
                        removeFromCart(itemId);
                    }
                }
            }

            // Function to remove items from cart
            function removeFromCart(itemId) {
                const itemIndex = cart.items.findIndex(item => item.id === itemId);

                if (itemIndex !== -1) {
                    cart.items.splice(itemIndex, 1);
                    // Update cart summary and badge
                    updateCartSummary();
                    renderCartItems();
                }
            }

            // Function to update cart summary
            function updateCartSummary() {
                cart.totalItems = cart.items.reduce((total, item) => total + item.quantity, 0);
                cart.totalPrice = cart.items.reduce((total, item) => total + (item.price * item.quantity), 0);

                // Update cart total in the offcanvas
                $('#cartTotalItems').html(`${cart.totalItems} sản phẩm cho <b class="text-danger">${cart.totalPrice.toLocaleString()} đ</b>`);

                // Update the badge on the cart icon with animation
                const $badge = $('.cart-icon-wrapper .badge');
                $badge.text(cart.totalItems);
                $badge.removeClass('badge-animated');
                // Trigger reflow to restart animation
                void $badge[0].offsetWidth;
                $badge.addClass('badge-animated');
            }

            // Function to show notification
            function showNotification(message, options = {}) {
                // Default options
                const defaults = {
                    type: 'success', // success, error, warning, info
                    title: 'Thông báo',
                    duration: 3000,
                    position: 'bottom-right' // top-right, top-left, bottom-left, bottom-right
                };

                // Merge default options with provided options
                const settings = { ...defaults, ...options };

                // For backward compatibility
                if (options === true) {
                    settings.type = 'error';
                    settings.title = 'Giỏ hàng';
                } else if (typeof options === 'string') {
                    settings.title = options;
                }

                // Create toast container if it doesn't exist
                if (!$('#toastContainer').length) {
                    $('body').append(`
                        <div class="toast-container position-fixed p-3" id="toastContainer"></div>
                    `);
                }

                // Set position
                const toastContainer = $('#toastContainer');
                toastContainer.removeClass('top-0 bottom-0 start-0 end-0');
                switch (settings.position) {
                    case 'top-right':
                        toastContainer.addClass('top-0 end-0');
                        break;
                    case 'top-left':
                        toastContainer.addClass('top-0 start-0');
                        break;
                    case 'bottom-left':
                        toastContainer.addClass('bottom-0 start-0');
                        break;
                    default: // bottom-right
                        toastContainer.addClass('bottom-0 end-0');
                        break;
                }

                // Generate unique ID for this toast
                const toastId = 'toast-' + new Date().getTime();

                // Set color scheme based on type
                let headerClass = 'bg-info';
                let icon = 'fa-info-circle';

                switch (settings.type) {
                    case 'success':
                        headerClass = 'bg-success';
                        icon = 'fa-check-circle';
                        break;
                    case 'error':
                        headerClass = 'bg-danger';
                        icon = 'fa-times-circle';
                        break;
                    case 'warning':
                        headerClass = 'bg-warning';
                        icon = 'fa-exclamation-triangle';
                        break;
                }

                // Append toast to container
                toastContainer.append(`
                    <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="${settings.duration}">
                        <div class="toast-header ${headerClass} text-white">
                            <i class="fas ${icon} me-2"></i>
                            <strong class="me-auto">${settings.title}</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">${message}</div>
                    </div>
                `);

                // Show the toast
                const toast = new bootstrap.Toast(document.getElementById(toastId));
                toast.show();

                // Remove toast element after it hides
                $(`#${toastId}`).on('hidden.bs.toast', function () {
                    $(this).remove();
                });
            }
        });
    </script>
</body>

</html>