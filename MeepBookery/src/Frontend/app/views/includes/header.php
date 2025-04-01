<!-- Top bar -->
<div class="top-bar py-1">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="me-2"><i class="fab fa-youtube"></i></a>
                <span class="ms-2">Chào mừng bạn đến với MeepBookery</span>
            </div>
            <div class="col-md-6 text-end">
                <a href="tel:+84123456789" class="me-3"><i class="fas fa-phone-alt me-1"></i> (+84) 0123456789</a>
                <a href="mailto:mbk@gmail.com"><i class="fas fa-envelope me-1"></i> mbk@gmail.com</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <div class="logo me-3">
                <a href="index.php">
                    <img src="../../img/logo.JPG" alt="MeepBookery Logo" class="img-fluid">
                </a>
            </div>

            <!-- Search Bar -->
            <div class="search-wrapper flex-grow-1">
                <div class="input-group">
                    <div class="dropdown">
                        <button class="category-toggle dropdown-toggle" type="button" id="categoryDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Danh mục
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item" href="#" data-category-id="">Tất cả danh mục</a></li>
                            <?php foreach ($categories as $category): ?>
                                <li><a class="dropdown-item" href="#"
                                        data-category-id="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                    <button class="btn search-btn" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- User Account & Cart -->
            <div class="header-actions d-flex ms-3">
                <a href="#" class="btn btn-danger account-btn me-2">
                    <i class="fas fa-user"></i>
                    <span>Tài khoản</span>
                </a>

                <a href="#" class="btn btn-danger cart-btn position-relative">
                    <div class="position-relative cart-icon-wrapper">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-white text-danger position-absolute">0</span>
                    </div>
                    <span>Giỏ hàng</span>
                </a>
            </div>
        </div>
    </div>
</header>