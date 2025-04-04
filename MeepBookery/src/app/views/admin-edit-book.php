<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Leo Bookery</title>
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Leo Bookery Admin</div>
        <ul>
            <li><a href="admin.html">Dashboard</a></li>
            <li><a href="admin-books.html">Manage Books</a></li>
            <li><a href="admin-orders.html">Manage Orders</a></li>
            <li><a href="admin-users.html">Manage Users</a></li>
            <li><a href="admin-reports.html">Manage Reports</a></li>
            <li><a href="admin-statistics.html">Manage Statistics</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="index.html">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <?php
            require_once __DIR__ . '/../controllers/BookController.php';
            $bookController = new BookController();
            $bookId = $_GET['id'] ?? 1;
            $book = $bookController->getBookById($bookId); // Lấy thông tin sách theo ID
            if (!$book) {
                echo "<p>Book not found.</p>";
                exit;
            }
            ?>
        <h1>Edit Book <?php echo htmlspecialchars($book['Name'] ?? ''); ?></h1>
        <form class="form" action="/books/update" method="POST">
            <input type="hidden" name="bookId" value="<?php echo $book['BookId'] ?? ''; ?>">
            <label for="name">Book Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($book['Name'] ?? ''); ?>" required>
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($book['Price'] ?? ''); ?>" required>
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($book['Stock'] ?? ''); ?>" required>
            <label for="category">Category</label>
            <select id="category" name="categoryId">
                <option value="1" <?php echo ($book['CategoryId'] ?? '') == 1 ? 'selected' : ''; ?>>Comedy</option>
                <option value="2" <?php echo ($book['CategoryId'] ?? '') == 2 ? 'selected' : ''; ?>>Drama</option>
                <option value="3" <?php echo ($book['CategoryId'] ?? '') == 3 ? 'selected' : ''; ?>>Adventure</option>
            </select>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($book['Description'] ?? ''); ?></textarea>
            <label for="image">Image URL</label>
            <input type="text" id="image" name="imageURL" value="<?php echo htmlspecialchars($book['ImageURL'] ?? ''); ?>">
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
