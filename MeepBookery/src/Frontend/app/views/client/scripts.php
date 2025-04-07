<!-- Dữ liệu mẫu để chạy giao diện -->
<!-- < ?php
require_once ROOT_PATH . '/app/controllers/data.php';
?>
< ?php extract($data); ?> -->
<!-- <script>
    let allBooks = < ?php echo json_encode($data['books']); ?>;
    let bestSellerBooks = < ?php echo json_encode($data['best_seller_books']); ?>;
    let categories = < ?php echo json_encode($data['categories']); ?>;
</script> -->

<script>
    let allBooks = <?php echo json_encode($books); ?>;
    let bestSellerBooks = <?php echo json_encode($best_seller_books); ?>;
    let categories = <?php echo json_encode($categories); ?>;
    let paymentMethods = <?php echo json_encode($payment_methods); ?>;
    let orders = <?php echo json_encode($orders); ?>;
    
</script>