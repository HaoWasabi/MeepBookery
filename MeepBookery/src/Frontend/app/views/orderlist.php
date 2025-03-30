<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
</head>
<body>
    <h2>Danh sách đơn hàng</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Thao tác thành công!</p>
    <?php elseif (isset($_GET['error'])): ?>
        <p style="color: red;">Thao tác thất bại!</p>
    <?php endif; ?>

    <form action="/orders/filter" method="GET">
        <label>Trạng thái:</label>
        <select name="status">
            <option value="">Tất cả</option>
            <option value="pending">Chờ xác nhận</option>
            <option value="confirmed">Đã xác nhận</option>
            <option value="delivered_success">Giao thành công</option>
            <option value="canceled">Đã hủy</option>
        </select>

        <label>Từ ngày:</label>
        <input type="date" name="startDate">
        <label>Đến ngày:</label>
        <input type="date" name="endDate">

        <label>Thành phố:</label>
        <input type="text" name="city">

        <label>Quận/Huyện:</label>
        <input type="text" name="district">

        <button type="submit">Lọc</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Địa chỉ</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['OrderID'] ?></td>
            <td><?= $order['OrderDate'] ?></td>
            <td><?= $order['Status'] ?></td>
            <td><?= $order['Address'] ?>, <?= $order['District'] ?>, <?= $order['City'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
