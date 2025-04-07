<?php
    require_once __DIR__ . '/../controllers/BookController.php';
    $bookController = new BookController();
    $books = $bookController->getAllBooks();
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        $result = $bookController->deleteBook();
        $message = $result ? "Xóa sách thành công!" : "Xóa sách thất bại!";
        echo "<script>alert('" . addslashes($message) . "');</script>";
        // Sau khi xóa thì redirect để load lại danh sách mới
        header("Location: admin-books.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Meep Bookery</title>
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
        .actions { margin-bottom: 20px; }
        .actions a { display: inline-block; padding: 10px 20px; background-color: #e74c3c; color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s; }
        .actions a:hover { background-color: #c0392b; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .table td img { width: 50px; height: auto; }
        .action-button {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 14px;
            color: #fff;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-right: 5px;
        }
        .edit-button { background-color: #f39c12; }
        .edit-button:hover { background-color: #e67e22; }
        .delete-button { background-color: #e74c3c; }
        .delete-button:hover { background-color: #c0392b; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo">Meep Bookery Admin</div>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Manage Products</a></li>
        <li><a href="#">Manage Books</a></li>
        <li><a href="#">Manage Users</a></li>
        <li><a href="#">Manage Reports</a></li>
        <li><a href="#">Manage Statistics</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Manage Products</h1>

    <div class="actions">
        <a href="admin-create-book.php">Add New Product</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($book['ImgURL']) ?>" alt="Book Image"></td>
                    <td><?= htmlspecialchars($book['Name']) ?></td>
                    <td><?= htmlspecialchars($book['Price']) ?></td>
                    <td>
                        <?php
                            $statusText = '';
                            switch ($book['Status']) {
                                case 1:
                                    $statusText = 'Available';
                                    break;
                                case 2:
                                    $statusText = 'Hide';
                                    break;
                                case 0:
                                    $statusText = 'Deleted';
                                    break;
                                default:
                                    $statusText = 'Unknown';
                            }
                            echo $statusText;
                        ?>
                    </td>
                    <td>
                        <a href="admin-update-book.php?id=<?= htmlspecialchars($book['BookID']) ?>" class="action-button edit-button">Edit</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?');">
                            <input type="hidden" name="form_name" value="deleteForm">
                            <input type="hidden" name="bookId" value="<?= htmlspecialchars($book['BookID']) ?>">
                            <button type="submit" class="action-button delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
