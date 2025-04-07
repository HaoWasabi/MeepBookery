<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="mb-4">📚 Quản lý danh mục</h2>
        <a href="/category/create" class="btn btn-success mb-3">➕ Thêm danh mục</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category as $cat): ?>
                    <tr>
                        <td><?= $cat['CategoryID'] ?></td>
                        <td><?= htmlspecialchars($cat['Name']) ?></td>
                        <td><?= htmlspecialchars($cat['Description']) ?></td>
                        <td>
                            <a href="/category/edit?id=<?= $cat['CategoryID'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                            <a href="/category/delete?id=<?= $cat['CategoryID'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa không?')">🗑️ Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>