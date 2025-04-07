<?php
// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

//Tạm thời sài dữ liệu giả :v
// Lấy thông tin sản phẩm từ data

$product = null;
$allbooks = $books;
foreach ($allbooks as $book) {
    if ($book['id'] == $product_id) {
        $product = $book;
        break;
    }
}

// Kiểm tra nếu không tìm thấy sản phẩm
// if (!$product) {
//     header('Location: index.php');
//     exit;
// }
//
?>
<div class="container my-5">

    <!-- Product Name -->
    <!-- <h1 class="product-title mb-4">< ?= $product['name'] ?></h1> -->

    <!-- Product Main Section -->
    <div class="row mb-5">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="product-image-container">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="img-fluid product-main-image">
                <?php if ($product['stock'] <= 0): ?>
                    <div class="out-of-stock-overlay">
                        <span class="out-of-stock-badge">Tạm hết hàng</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Details & Purchase Options -->
        <div class="col-md-7">
            <div class="product-info-container p-4">
                <!-- Product Name -->
                <h2 class="product-title mb-3"><?= $product['name'] ?></h2>

                <!-- Product Information in two columns -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <span class="text-muted">Tác giả:</span>
                            <span style="color: #dc3545"><?= $product['author'] ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Nhà xuất bản:</span>
                            <span style="color: #dc3545"><?= $product['publisher'] ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <span class="text-muted">Thể loại:</span>
                            <span class="product-category"><?= $product['category'] ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Định dạng:</span>
                            <span><?= $product['format'] ?></span>
                        </div>
                    </div>
                </div>

                <div class="product-price mb-4">
                    <span class="price-value"><?= $product['price'] ?></span>
                </div>

                <!-- <div class="product-stock mb-4">
                    <span class="text-muted">Tình trạng:</span>
                    < ?php if ($product['stock'] > 0): ?>
                        <span class="text-success">Còn hàng (< ?= $product['stock'] ?> sản phẩm)</span>
                    < ?php else: ?>
                        <span class="text-danger">Tạm hết hàng</span>
                    < ?php endif; ?>
                </div>  -->

                <div class="purchase-options">
                    <div class="row g-3">
                        <!-- Quantity control at the top -->
                        <div class="col-12 mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <div class="input-group" style="max-width: 150px;">
                                <button class="btn btn-outline-danger" type="button" id="decrease-qty">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center" id="quantity" value="1" min="1"
                                    max="<?= $product['stock'] ?>" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>
                                    style="border-color: #dc3545 !important; box-shadow: none !important;">
                                <button class="btn btn-outline-danger" type="button" id="increase-qty"
                                    <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Buttons below -->
                        <div class="col-12">
                            <div class="d-flex flex-column gap-2">
                                <button class="btn btn-lg w-100" id="buy-now"
                                    style="background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; border-radius: 6px !important; transition: opacity 0.2s !important;"
                                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'"
                                    <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-bolt me-2"></i>Mua ngay
                                </button>
                                <button class="btn btn-lg w-100" id="add-to-cart"
                                    style="background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; border-radius: 6px !important; transition: opacity 0.2s !important;"
                                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'"
                                    <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs Section -->
    <div class="product-tabs mb-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                    type="button" role="tab" aria-controls="description" aria-selected="true">
                    Mô tả sản phẩm
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button"
                    role="tab" aria-controls="details" aria-selected="false">
                    Chi tiết sản phẩm
                </button>
            </li>
        </ul>
        <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <p><?= $product['description'] ?></p>
            </div>
            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nhà xuất bản:</th>
                                    <td><?= $product['publisher'] ?></td>
                                </tr>
                                <tr>
                                    <th>Kích thước:</th>
                                    <td><?= $product['dimensions'] ?></td>
                                </tr>
                                <tr>
                                    <th>Số trang:</th>
                                    <td><?= $product['length'] ?></td>
                                </tr>
                                <tr>
                                    <th>Trọng lượng:</th>
                                    <td><?= $product['weight'] ?> kg</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Ngôn ngữ:</th>
                                    <td><?= $product['language'] ?></td>
                                </tr>
                                <tr>
                                    <th>Định dạng:</th>
                                    <td><?= $product['format'] ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày phát hành:</th>
                                    <td><?= $product['release_date'] ?></td>
                                </tr>
                                <tr>
                                    <th>Thể loại:</th>
                                    <td><?= $product['category'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product detail page -->
<script type="module">
    import { showSweetAlert } from '/assets/client/js/util.js';

    document.addEventListener('DOMContentLoaded', () => {
        const productId = <?= $product_id ?>;
        const product = allBooks.find(book => book.id == productId);
        const maxStock = <?= $product['stock'] ?>;

        // Quantity controls
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');

        // Update quantity functions
        function updateQuantity(change) {
            let currentQty = parseInt(quantityInput.value);
            let newQty = currentQty + change;

            if (newQty < 1) newQty = 1;
            if (newQty > maxStock) newQty = maxStock;

            quantityInput.value = newQty;
        }

        // Add event listeners
        decreaseBtn.addEventListener('click', () => updateQuantity(-1));
        increaseBtn.addEventListener('click', () => updateQuantity(1));

        // Direct input validation
        quantityInput.addEventListener('change', () => {
            let qty = parseInt(quantityInput.value);
            if (isNaN(qty) || qty < 1) qty = 1;
            if (qty > maxStock) qty = maxStock;
            quantityInput.value = qty;
        });

        // Add to cart button
        document.getElementById('add-to-cart').addEventListener('click', () => {
            if (!product) return;

            // Get current quantity
            const quantity = parseInt(quantityInput.value);

            // Simulate multiple adds to cart
            let added = false;
            for (let i = 0; i < quantity; i++) {
                added = window.addToCart(product, i > 0); // Only show notification for first addition
            }

            if (added && quantity > 1) {
                showToast(`Đã thêm ${quantity} sản phẩm "${product.name}" vào giỏ hàng`, {
                    type: 'success',
                    title: 'Giỏ hàng'
                });
            }

            // Update the cart interface
            updateCartInterface();
        });

        // Buy now button
        document.getElementById('buy-now').addEventListener('click', () => {
            <?php if (!isset($_SESSION['UserID'])): ?>
                Swal.fire({
                    title: 'Đăng nhập',
                    text: 'Vui lòng đăng nhập để tiến hành thanh toán',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Đăng nhập',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show login modal
                        const authModal = new bootstrap.Modal(document.getElementById('authModal'));
                        authModal.show();
                        // Set the tab to login
                        const loginTab = document.querySelector('#authModal [data-bs-target="#login-tab-pane"]');
                        if (loginTab) {
                            loginTab.click();
                        }
                    }
                });
            <?php else: ?>

                if (!product) return;

                // Get current quantity
                const quantity = parseInt(quantityInput.value);

                // Add to cart first without notification
                let added = false;
                for (let i = 0; i < quantity; i++) {
                    added = window.addToCart(product, true);
                }

                // Update the cart interface
                updateCartInterface();

                if (added) {
                    window.location.href = '/cart';
                }
            <?php endif ?>
        });
    });
</script>

<style>
    /* Product Detail Page Styles */
    .product-title {
        font-size: 2rem;
        color: #333;
        font-weight: 700;
        border-bottom: 1px solid #bdbdbd;
        padding-bottom: 0.5rem;
    }

    .product-image-container {
        position: relative;
        background-color: #f9f9f9;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-main-image {
        max-height: 400px;
        object-fit: contain;
    }

    .out-of-stock-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }

    .out-of-stock-badge {
        background-color: #808991;
        color: white;
        padding: 0.5rem 1.5rem;
        font-size: 1.2rem;
        font-weight: 700;
        border-radius: 0.25rem;
        transform: rotate(-10deg);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .product-info-container {
        background-color: #f9f9f9;
        border-radius: 0.5rem;
        height: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .product-category {
        font-size: 0.9rem;
        padding: 0.3rem 0.8rem;
    }

    .product-author {
        font-size: 1.1rem;
    }

    .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #e74c3c;
    }

    .price-value::after {
        content: " ₫";
    }

    .purchase-options {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px dashed #A5D6A7;
    }

    /* Quantity Input Styling */
    .input-group .form-control {
        height: calc(2rem + 8px);
    }

    .input-group .btn {
        padding: 0.25rem 0.75rem;
    }

    /* Tab Content Styling */
    .product-tabs .nav-tabs .nav-link {
        color: #555;
        font-weight: 500;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .product-tabs .nav-tabs .nav-link.active {
        color: #e74c3c;
        font-weight: 700;
        border-top: 3px solid #e74c3c;
    }

    .tab-content {
        background-color: #fff;
    }

    .tab-pane {
        min-height: 200px;
    }

    /* Table styling for product details */
    .tab-pane .table {
        margin-bottom: 0;
    }

    .tab-pane .table th {
        width: 40%;
        color: #666;
        font-weight: 600;
    }

    .tab-pane .table td {
        color: #333;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.5rem;
        }

        .product-image-container {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .purchase-options .row {
            flex-direction: column;
        }

        .purchase-options .col-md-3 {
            width: 100%;
            margin-bottom: 1rem;
        }

        .purchase-options .col-md-9 {
            width: 100%;
        }
    }
</style>