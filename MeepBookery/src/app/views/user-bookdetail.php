<?php
// Gọi phương thức để xemxem danh sách sách
require_once __DIR__ . '/../controllers/BookController.php';
$bookController = new BookController();
$bookId = $_GET['id'] ?? 1; // Lấy ID từ URL, mặc định là 1 nếu không có ID
$book = $bookController->getBookById($bookId); // Lấy thông tin sách theo ID
if (!$book) {
    echo "<p>Book not found.</p>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Adventure Begins - Meep Bookery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Header (giữ nguyên từ trang chủ) */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #fff;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .header .logo {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .header .nav ul {
            list-style: none;
            display: flex;
        }
        .header .nav ul li {
            margin: 0 20px;
        }
        .header .nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }
        .header .nav ul li a:hover {
            color: #e74c3c;
        }
        .header .icons {
            display: flex;
            align-items: center;
        }
        .header .icons .search-bar {
            position: relative;
            margin-right: 20px;
        }
        .header .icons .search-bar input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            width: 200px;
            transition: width 0.3s;
        }
        .header .icons .search-bar input:focus {
            width: 250px;
        }
        .header .icons .search-bar button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #333;
        }
        .header .icons a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            transition: color 0.3s;
        }
        .header .icons a:hover {
            color: #e74c3c;
        }

        /* Product Detail */
        .product-detail {
            max-width: 1200px;
            margin: 100px auto 40px;
            display: flex;
            padding: 0 20px;
        }
        .product-images {
            flex: 1;
            padding-right: 20px;
        }
        .product-images img {
            max-width: 100%;
            height: auto;
        }
        .product-info {
            flex: 1;
        }
        .product-info h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
        }
        .product-info .price {
            font-size: 24px;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .product-info .description {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }
        .product-info .options {
            margin-bottom: 20px;
        }
        .product-info .options label {
            font-weight: bold;
            margin-right: 10px;
        }
        .product-info .options select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .product-info .quantity {
            margin-bottom: 20px;
        }
        .product-info .quantity input {
            width: 50px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .product-info .add-to-cart {
            display: inline-block;
            padding: 12px 30px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .product-info .add-to-cart:hover {
            background-color: #c0392b;
        }

        /* Tabs */
        .tabs {
            max-width: 1200px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }
        .tabs .tab-buttons {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .tabs .tab-buttons button {
            padding: 10px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            color: #333;
            transition: color 0.3s;
        }
        .tabs .tab-buttons button.active {
            color: #e74c3c;
            border-bottom: 2px solid #e74c3c;
        }
        .tabs .tab-content {
            display: none;
        }
        .tabs .tab-content.active {
            display: block;
        }
        .tabs .tab-content p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
        }

        /* Footer (giữ nguyên từ trang chủ) */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
        }
        .footer p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">Meep Bookery</div>
        <nav class="nav">
            <ul>
                <li><a href="user-home.php">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="icons">
            <div class="search-bar">
                <input type="text" placeholder="Search books...">
                <button type="submit">🔍</button>
            </div>
            <a href="cart.html">🛒</a>
            <a href="#">👤</a>
        </div>
    </header>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="product-images">
            <img src="<?= htmlspecialchars($book['ImageURL'])?>" alt="Book Image">
        </div>
        <div class="product-info">
            <h1><?= htmlspecialchars($book['Name'])?></h1>
            <div class="price"><?= htmlspecialchars($book['Price']) ?> đồng</div>
            <div class="options">
                <b class="size">Language:</b>
                <p><?= htmlspecialchars($book['Language']) ?></p>
            </div>
            <div class="options">
                <b class="size">Author:</b>
                <p><?= htmlspecialchars($book['Author']) ?></p>
            </div>
            <div class="options">
                <b class="size">Publisher:</b>
                <p><?= htmlspecialchars($book['Publisher']) ?></p>
            </div>
            <div class="options">
                <b class="size">Release date:</b>
                <p><?= htmlspecialchars($book['ReleaseDate']) ?></p>
            </div>
            <a href="#" class="add-to-cart">Add to Cart</a>
        </div>
    </section>

    <!-- Tabs -->
    <section class="tabs">
        <div class="tab-buttons">
            <button class="active" onclick="openTab('description')">Description</button>
            <button onclick="openTab('additional')">Additional Information</button>
            <button onclick="openTab('reviews')">Reviews (0)</button>
        </div>
        <div id="description" class="tab-content active">
            <p><?= htmlspecialchars($book['Description']) ?></p>
        </div>
        <div id="additional" class="tab-content">
            <p>
                <strong>Dimensions: </strong><?= htmlspecialchars($book['Dimensions']) ?><br>
                <strong>Format: </strong><?= htmlspecialchars($book['Format']) ?><br>
                <strong>Weight: </strong><?= htmlspecialchars($book['Weight']) ?> kg<br>
                <strong>Length: </strong><?= htmlspecialchars($book['Length']) ?> cm<br>
            </p>
        </div>
        <div id="reviews" class="tab-content">
            <p>No reviews yet. Be the first to review this product!</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 Meep Bookery. All rights reserved.</p>
        <p>Contact us: info@meepbookery.com | +123 456 789</p>
    </footer>

    <script>
        function openTab(tabName) {
            var i;
            var tabContents = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove("active");
            }
            var tabButtons = document.getElementsByClassName("tab-buttons")[0].getElementsByTagName("button");
            for (i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            event.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>