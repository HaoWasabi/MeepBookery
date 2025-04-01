<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeepBookery - Nhà Sách Trực Tuyến</title>
    <!-- Favicon -->
    <link rel="icon" href="../../img/logo.JPG" type="image/jpeg">
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
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
            overflow: hidden;
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
            height: 600px;
            margin-bottom: 30px;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 80px;
        }

        .slide-content {
            max-width: 600px;
            text-align: left;
        }

        .slide-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
        }

        .slide-content p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }

        .btn-slider {
            display: inline-block;
            padding: 12px 30px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 16px;
            font-weight: 600;
            border: none;
        }

        .btn-slider:hover {
            background-color: #c0392b;
            color: #fff;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #fff;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #e74c3c;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #e74c3c;
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
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .book-img {
            height: 200px;
            object-fit: cover;
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

        .all-books {
            margin-bottom: 40px;
        }

        .pagination-container {
            margin-top: 30px;
        }

        .pagination .page-link {
            color: #333;
            border-color: #ddd;
            font-size: 16px;
        }

        .pagination .page-item.active .page-link {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
            color: #e74c3c;
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
    </style>
</head>

<body>
    <?php require_once 'includes/header.php'; ?>

    <!-- Swiper Slider -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"
                style="background-image: url('https://cdn.shopify.com/s/files/1/0905/2012/files/slider01_712e9c3f-9fd2-4389-93f7-941abfddc722.jpg?v=1611909453');">
                <div class="slide-content">
                    <h1>Khám phá thế giới sách tại MeepBookery</h1>
                    <p>Nơi bạn có thể tìm thấy hàng ngàn đầu sách chất lượng với giá cả hợp lý</p>
                    <button class="btn-slider">Khám phá ngay</button>
                </div>
            </div>
            <div class="swiper-slide"
                style="background-image: url('https://cdn.shopify.com/s/files/1/0905/2012/files/slider01_712e9c3f-9fd2-4389-93f7-941abfddc722.jpg?v=1611909453');">
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

    <!-- Featured Books Section -->
    <section class="featured-books">
        <div class="container">
            <h2 class="section-title">Sách bán chạy</h2>
            <div class="row">
                <!-- Book 1 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Đắc Nhân Tâm</h3>
                            <p class="book-category">Tâm lý - Kỹ năng sống</p>
                            <p class="book-author">Dale Carnegie</p>
                            <p class="book-price">120.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 2 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Nhà Giả Kim</h3>
                            <p class="book-category">Tiểu thuyết</p>
                            <p class="book-author">Paulo Coelho</p>
                            <p class="book-price">90.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Tuổi Trẻ Đáng Giá Bao Nhiêu</h3>
                            <p class="book-category">Kỹ năng sống</p>
                            <p class="book-author">Rosie Nguyễn</p>
                            <p class="book-price">85.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Tôi Thấy Hoa Vàng Trên Cỏ Xanh</h3>
                            <p class="book-category">Văn học Việt Nam</p>
                            <p class="book-author">Nguyễn Nhật Ánh</p>
                            <p class="book-price">75.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Books Section -->
    <section class="all-books">
        <div class="container">
            <h2 class="section-title">Tất cả sách</h2>
            <div class="row">
                <!-- Book 1 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Cây Cam Ngọt Của Tôi</h3>
                            <p class="book-category">Văn học nước ngoài</p>
                            <p class="book-author">José Mauro de Vasconcelos</p>
                            <p class="book-price">108.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 2 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Điều Kỳ Diệu Của Tiệm Tạp Hóa Namiya</h3>
                            <p class="book-category">Văn học Nhật Bản</p>
                            <p class="book-author">Higashino Keigo</p>
                            <p class="book-price">110.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Atomic Habits</h3>
                            <p class="book-category">Kỹ năng sống</p>
                            <p class="book-author">James Clear</p>
                            <p class="book-price">155.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Tư Duy Phản Biện</h3>
                            <p class="book-category">Tâm lý - Kỹ năng sống</p>
                            <p class="book-author">Richard Paul & Linda Elder</p>
                            <p class="book-price">90.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 5 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Khéo Ăn Nói Sẽ Có Được Thiên Hạ</h3>
                            <p class="book-category">Kỹ năng giao tiếp</p>
                            <p class="book-author">Trác Nhã</p>
                            <p class="book-price">99.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 6 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Đàn Ông Sao Hỏa Đàn Bà Sao Kim</h3>
                            <p class="book-category">Tâm lý - Kỹ năng sống</p>
                            <p class="book-author">John Gray</p>
                            <p class="book-price">118.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 7 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Sapiens: Lược Sử Loài Người</h3>
                            <p class="book-category">Lịch sử - Khoa học</p>
                            <p class="book-author">Yuval Noah Harari</p>
                            <p class="book-price">189.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <!-- Book 8 -->
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="../../img/b002.png" alt="Book Cover" class="book-img">
                        <div class="book-info">
                            <h3 class="book-title">Nghĩ Giàu Làm Giàu</h3>
                            <p class="book-category">Kinh tế - Tài chính</p>
                            <p class="book-author">Napoleon Hill</p>
                            <p class="book-price">110.000 ₫</p>
                            <button class="btn btn-add-cart">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-container mt-4 mb-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <?php require_once 'includes/footer.php'; ?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
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
        });
    </script>
</body>

</html>