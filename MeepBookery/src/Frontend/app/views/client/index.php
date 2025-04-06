<!DOCTYPE html>
<html lang="vi">

<?php require_once 'head.php'; ?>
<?php require_once 'scripts.php'; ?>

<body>
    <?php require_once 'header.php'; ?>
    <?php require_once 'cart-offcanvas.php'; ?>

    <!-- Hiển thị breadcrumb nếu không phải trang chủ -->
    <?php if (isset($show_breadcrumb) && $show_breadcrumb): ?>
        <?php require_once 'breadcrumb.php'; ?>
    <?php endif; ?>

    <!-- Nội dung chính -->
    <main>
        <?php echo $content; ?>
    </main>

    <?php require_once 'footer.php'; ?>
    <?php require_once 'auth-modal.php'; ?>

</body>

</html>