<?php
    require_once __DIR__ . '/../controllers/BookController.php';
    $bookController = new BookController();
    $message = ""; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $bookController->createBook();
        $message = $result ? "Thêm sách thành công!" : "Thêm sách thất bại!";
        echo "<script>alert('" . addslashes($message) . "');</script>";
        header("Location: admin-books.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Leo Bookery</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100%; background-color: #333; color: #fff; padding: 20px; }
        .sidebar .logo { font-size: 24px; font-weight: bold; margin-bottom: 30px; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 20px; }
        .sidebar ul li a { color: #fff; text-decoration: none; font-size: 16px; transition: color 0.3s; }
        .sidebar ul li a:hover { color: #e74c3c; }
        .main-content { margin-left: 250px; padding: 20px; }
        .main-content h1 { font-size: 32px; color: #333; margin-bottom: 20px; }
        .form { max-width: 600px; }
        .form label { font-weight: bold; display: block; margin-bottom: 5px; }
        .form input, .form textarea, .form select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; outline: none; }
        .form button { padding: 12px 20px; background-color: #e74c3c; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; }
        .form button:hover { background-color: #c0392b; }
        .message { margin-bottom: 20px; padding: 10px; border-radius: 5px; text-align: center; }
        .success { background-color: #2ecc71; color: white; }
        .error { background-color: #e74c3c; color: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Meep Bookery Admin</div>
        <ul>
            <li><a href="admin.html">Dashboard</a></li>
            <li><a href="admin-products.html">Manage Products</a></li>
            <li><a href="admin-orders.html">Manage Orders</a></li>
            <li><a href="admin-users.html">Manage Users</a></li>
            <li><a href="admin-reports.html">Manage Reports</a></li>
            <li><a href="admin-statistics.html">Manage Statistics</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="index.html">Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <h1>Add New Book</h1>

        <form class="form" method="POST">
            <label for="name">Book Name</label>
            <input type="text" name="name" id="name" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3"></textarea>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <input type="hidden" name="stock" id="stock" value="1">

            <label for="imageURL">Image URL</label>
            <input type="text" name="imageURL" id="imageURL" required>

            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" required>

            <label for="length">Length</label>
            <input type="number" name="length" id="length">

            <label for="weight">Weight</label>
            <input type="number" name="weight" id="weight">

            <label for="dimensions">Dimensions</label>
            <input type="text" name="dimensions" id="dimensions">

            <label for="language">Language</label>
            <input type="text" name="language" id="language" required>

            <label for="format">Format</label>
            <input type="text" name="format" id="format" required>

            <label for="author">Author</label>
            <input type="text" name="author" id="author" required>

            <label for="publisher">Publisher</label>
            <input type="text" name="publisher" id="publisher" required>

            <label for="releaseDate">Release Date</label>
            <input type="date" name="releaseDate" id="releaseDate" required>

            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="1">Available</option>
                <option value="2">Hide</option>
                <option value="0">Deleted</option>
            </select>

            <button type="submit">Add Book</button>
        </form>
    </div>

</body>
</html>

