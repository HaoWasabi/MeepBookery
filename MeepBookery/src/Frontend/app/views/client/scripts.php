<!-- Dữ liệu mẫu để chạy giao diện -->
<?php require_once __DIR__ . '/../../controllers/data.php'; ?>
<?php extract($data); ?>
<script>
    let allBooks = <?php echo json_encode($books); ?>;
    let bestSellerBooks = <?php echo json_encode($best_seller_books); ?>;
    let categories = <?php echo json_encode($categories); ?>;
</script>