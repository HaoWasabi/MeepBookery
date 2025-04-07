<?php
    require_once __DIR__ . '/../controllers/BookController.php';
    $bookController = new BookController();
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $bookController->updateBook();
        $message = $result ? "Sửa sách thành công!" : "Sửa sách thất bại!";
        echo "<script>alert('" . addslashes($message) . "');</script>";
    }

    $bookId = $_GET['id'] ?? 1;
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
        <h1>Edit Book <?php echo htmlspecialchars($book['Name'] ?? ''); ?></h1>
        
        <form class="form" method="POST">
            <input type="hidden" name="bookId" value="<?php echo htmlspecialchars($book['BookID'] ?? ''); ?>">

            <label for="name">Book Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($book['Name'] ?? ''); ?>" required>
            
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($book['Description'] ?? ''); ?></textarea>
            
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($book['Price'] ?? ''); ?>" required>
           
            <input type="hidden" id="stock" name="stock" value="<?php echo htmlspecialchars($book['Stock'] ?? ''); ?>" required>
            
            <label for="image">Image URL</label>
            <input type="text" id="image" name="imageURL" value="<?php echo htmlspecialchars($book['ImageURL'] ?? ''); ?>" required>
            
            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" value="<?php echo htmlspecialchars($book['CategoryID'] ?? ''); ?>" required>

            <label for="length">Length</label>
            <input type="text" id="length" name="length" value="<?php echo htmlspecialchars($book['Length'] ?? ''); ?>" required>
            
            <label for="weight">Weight</label>
            <input type="text" id="weight" name="weight" value="<?php echo htmlspecialchars($book['Weight'] ?? ''); ?>" required>

            <label for="dimensions">Dimensions</label>
            <input type="text" id="dimensions" name="dimensions" value="<?php echo htmlspecialchars($book['Dimensions'] ?? ''); ?>" required>

            <label for="language">Language</label>
            <input type="text" id="language" name="language" value="<?php echo htmlspecialchars($book['Language'] ?? ''); ?>" required>

            <label for="format">Format</label>
            <input type="text" id="format" name="format" value="<?php echo htmlspecialchars($book['Format'] ?? ''); ?>" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['Author'] ?? ''); ?>" required>

            <label for="publisher">Publisher</label>
            <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['Publisher'] ?? ''); ?>" required>

            <label for="releaseDate">Release Date</label>
            <input type="date" id="releaseDate" name="releaseDate" value="<?php echo htmlspecialchars($book['ReleaseDate'] ?? ''); ?>" required>

            <label for="status">Status</label>
            <select name="status" id="status" required value="<?php echo htmlspecialchars($book['Status'] ?? ''); ?>">
                <option value="1" <?php echo ($book['Status'] ?? '') == 1 ? 'selected' : ''; ?>>Available</option>
                <option value="2" <?php echo ($book['Status'] ?? '') == 2 ? 'selected' : ''; ?>>Hide</option>
                <option value="0" <?php echo ($book['Status'] ?? '') == 0 ? 'selected' : ''; ?>>Deleted</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
