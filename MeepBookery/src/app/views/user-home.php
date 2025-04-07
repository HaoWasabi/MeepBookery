<?php
require_once __DIR__ . '/../controllers/BookController.php';

// Gọi phương thức để xemxem danh sách sách
$bookController = new BookController();
$books = $bookController->getAllBooks();
if (!$books) {
    echo("No books found.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Meep Bookery</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        /* Header */
        .header { position: fixed; top: 0; width: 100%; background-color: #fff; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); z-index: 1000; }
        .header .logo { font-size: 28px; font-weight: bold; color: #333; }
        .header .nav ul { list-style: none; display: flex; }
        .header .nav ul  li { margin: 0 20px; }
        .header .nav ul li a { text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; }
        .header .nav ul li a:hover { color: #e74c3c; }
        .header .icons { display: flex; align-items: center; }
        .header .icons .search-bar { position: relative; margin-right: 20px; }
        .header .icons .search-bar input { padding: 8px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none; width: 200px; transition: width 0.3s; }
        .header .icons .search-bar input:focus { width: 250px; }
        .header .icons .search-bar button { position: absolute; right: 5px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #333; }
        .header .icons a { margin-left: 20px; text-decoration: none; color: #333; font-size: 18px; transition: color 0.3s; }
        .header .icons a:hover { color: #e74c3c; }

        /* Slider */
        .swiper-container { width: 100%; height: 600px; margin-top: 70px; }
        .swiper-slide { background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff; }
        .swiper-slide .content { max-width: 600px; }
        .swiper-slide h1 { font-size: 48px; margin-bottom: 20px; color: #000; }
        .swiper-slide p { font-size: 18px; margin-bottom: 30px; color: #000; }
        .swiper-slide a { display: inline-block; padding: 12px 30px; background-color: #e74c3c; color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        .swiper-slide a:hover { background-color: #c0392b; }

        /* Featured Products with Filter */
        .featured-products { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: flex; }
        .filter-sidebar { width: 250px; padding-right: 20px; }
        .filter-sidebar h3 { font-size: 20px; color: #333; margin-bottom: 15px; }
        .filter-sidebar .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; }
        .filter-sidebar .breadcrumb a { color: #333; text-decoration: none; }
        .filter-sidebar .breadcrumb a:hover { color: #e74c3c; }
        .filter-sidebar .filter-group { margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 15px; }
        .filter-sidebar .filter-group h4 { font-size: 16px; color: #333; margin-bottom: 10px; text-transform: uppercase; }
        .filter-sidebar .filter-group label { display: flex; justify-content: space-between; margin-bottom: 10px; color: #666; font-size: 14px; }
        .filter-sidebar .filter-group input[type="checkbox"] { margin-right: 5px; }

        /* Price Filter */
        .filter-group.price-filter { position: relative; }
        .price-filter .price-range { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666; }
        .price-filter .range-container { position: relative; height: 5px; background: #ddd; border-radius: 5px; }
        .price-filter .range-container .range-fill { position: absolute; height: 100%; background: #e74c3c; border-radius: 5px; }
        .price-filter input[type="range"] { position: absolute; width: 100%; top: -5px; pointer-events: none; appearance: none; background: none; }
        .price-filter input[type="range"]::-webkit-slider-thumb { pointer-events: all; width: 15px; height: 15px; background: #e74c3c; border-radius: 50%; cursor: pointer; appearance: none; }
        .price-filter input[type="range"]::-moz-range-thumb { pointer-events: all; width: 15px; height: 15px; background: #e74c3c; border-radius: 50%; cursor: pointer; }

        .products-content { flex: 1; text-align: center; }
        .products-content h2 { font-size: 32px; color: #333; margin-bottom: 30px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px; }
        .product-item { position: relative; border: 1px solid #eee; padding: 15px; transition: transform 0.3s, box-shadow 0.3s; display: none; }
        .product-item.visible { display: block; }
        .product-item:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .product-item img { max-width: 100%; height: auto; }
        .product-item h3 { font-size: 16px; margin: 15px 0; color: #333; }
        .product-item p { color: #e74c3c; font-weight: bold; font-size: 18px; }
        .product-item .add-to-cart { position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%); padding: 8px 20px; background-color: #e74c3c; color: #fff; text-decoration: none; opacity: 0; transition: opacity 0.3s, bottom 0.3s; }
        .product-item:hover .add-to-cart { bottom: 10px; opacity: 1; }
        .product-item { display: block !important; } /* !!!: Ensure all items are displayed by default */

        /* Pagination */
        .pagination { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; font-size: 14px; color: #666; }
        .pagination .info { color: #666; }
        .pagination .pages { display: flex; align-items: center; }
        .pagination .pages a { margin: 0 5px; text-decoration: none; color: #333; padding: 5px 10px; border: 1px solid #ddd; border-radius: 5px; transition: background-color 0.3s; }
        .pagination .pages a.active { background-color: #e74c3c; color: #fff; border-color: #e74c3c; }
        .pagination .pages a:hover { background-color: #f5f5f5; }

        /* Footer */
        .footer { background-color: #333; color: #fff; padding: 40px 20px; text-align: center; }
        .footer p { margin-bottom: 10px; }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">Meep Bookery</div>
        <nav class="nav">
            <ul>
                <li><a href="user-home.html">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="icons">
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search books...">
                <button type="submit" id="search-button">🔍</button>
            </div>
            <a href="cart.html">🛒</a>
            <a href="#">👤</a>
        </div>
    </header>

    <!-- Slider -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url('https://cdn.shopify.com/s/files/1/0905/2012/files/slider01_712e9c3f-9fd2-4389-93f7-941abfddc722.jpg?v=1611909453');">
                <div class="content">
                    <h1>New Arrivals</h1>
                    <p>Discover the latest books in our collection</p>
                    <a href="#">Shop Now</a>
                </div>
            </div>
            <div class="swiper-slide" style="background-image: url('https://cdn.shopify.com/s/files/1/0905/2012/files/slider01_712e9c3f-9fd2-4389-93f7-941abfddc722.jpg?v=1611909453');">
                <div class="content">
                    <h1>Best Sellers</h1>
                    <p>Explore top picks from our readers</p>
                    <a href="#">Discover More</a>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Featured Products with Filter -->
    <section class="featured-products">
        <div class="filter-sidebar">
            <div class="breadcrumb">
                <a href="index.html">Home</a> > <a href="#">Sci-fi</a> > <a href="#">Comedy</a>
            </div>
            <h3>Filter By</h3>
            <div class="filter-group">
                <h4>Category</h4>
                <label><input type="checkbox" name="category" value="comedy"> Comedy <span>(8)</span></label>
                <label><input type="checkbox" name="category" value="romance"> Romance <span>(14)</span></label>
                <label><input type="checkbox" name="category" value="sci-fi"> Sci-fi <span>(11)</span></label>
            </div>
            <div class="filter-group">
                <h4>Size</h4>
                <label><input type="checkbox" name="size" value="s"> S <span>(2)</span></label>
                <label><input type="checkbox" name="size" value="m"> M <span>(2)</span></label>
                <label><input type="checkbox" name="size" value="l"> L <span>(2)</span></label>
            </div>
            <div class="filter-group price-filter">
                <h4>Price</h4>
                <div class="price-range">
                    <span id="price-min">$9.00</span>
                    <span id="price-max">$36.00</span>
                </div>
                <div class="range-container">
                    <div class="range-fill" id="range-fill"></div>
                    <input type="range" id="price-min-input" min="0" max="50" value="9">
                    <input type="range" id="price-max-input" min="0" max="50" value="36">
                </div>
            </div>
        </div>
        <div class="products-content">
            <h2>Featured Products</h2>
            <div class="product-grid" id="product-grid">
                <?php foreach ($books as $book): ?>
                <div class="product-item" data-category="<?php echo $book['CategoryID']; ?>" data-size="<?php echo $book['Size']; ?>" data-price="<?php echo $book['Price']; ?>">
                    <img src="<?php echo $book['ImageURL']; ?>" alt="<?php echo $book['Name']; ?>" />
                    <h3><?php echo $book['Name']; ?></h3>
                    <p>$<?php echo number_format($book['Price'], 2); ?></p>
                    <a href="user-bookdetail.php?id=<?= htmlspecialchars($book['BookID']) ?>" class="add-to-cart">Show Info</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 Meep Bookery. All rights reserved.</p>
        <p>Contact us: info@meepbookery.com | +123 456 789</p>
    </footer>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
         // Swiper initialization
         var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false, },
            pagination: { el: '.swiper-pagination', clickable: true, },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', },
        });
</script>
</body>
</html>