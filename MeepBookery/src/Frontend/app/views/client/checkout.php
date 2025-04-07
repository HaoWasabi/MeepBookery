<div class="container my-5">
    <h2 class="section-title mb-4">Thanh toán</h2>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <!-- User Information Form -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <!-- Error Alert -->
                    <div id="checkoutErrorAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <span id="errorAlertMessage">Vui lòng điền đầy đủ thông tin trước khi tiếp tục.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form id="checkoutForm" method="POST" action="/place-order">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" 
                                           placeholder="Họ và tên" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                                    <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           placeholder="Số điện thoại" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                                    <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="address" name="address" 
                                           placeholder="Địa chỉ" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
                                    <label for="address">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="city" name="city" required>
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        <!-- Options will be loaded via JavaScript or pre-populated -->
                                        <option value="city 1" <?= ($user['city'] ?? '') === 'city 1' ? 'selected' : '' ?>>Thành phố 1</option>
                                        <option value="city 2" <?= ($user['city'] ?? '') === 'city 2' ? 'selected' : '' ?>>Thành phố 2</option>
                                    </select>
                                    <label for="city">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="district" name="district" required>
                                        <option value="">Chọn Quận/Huyện</option>
                                        <!-- Options will be loaded via JavaScript or pre-populated -->
                                        <option value="district 1" <?= ($user['district'] ?? '') === 'district 1' ? 'selected' : '' ?>>Quận/Huyện 1</option>
                                        <option value="district 2" <?= ($user['district'] ?? '') === 'district 2' ? 'selected' : '' ?>>Quận/Huyện 2</option>
                                    </select>
                                    <label for="district">Quận/Huyện <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="ward" name="ward" required>
                                        <option value="">Chọn Phường/Xã</option>
                                        <!-- Options will be loaded via JavaScript or pre-populated -->
                                        <option value="ward 1" <?= ($user['ward'] ?? '') === 'ward 1' ? 'selected' : '' ?>>Phường/Xã 1</option>
                                        <option value="ward 2" <?= ($user['ward'] ?? '') === 'ward 2' ? 'selected' : '' ?>>Phường/Xã 2</option>
                                    </select>
                                    <label for="ward">Phường/Xã <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-floating mb-4">
                            <textarea class="form-control" id="notes" name="notes" style="height: 100px" 
                                      placeholder="Ghi chú về đơn hàng"></textarea>
                            <label for="notes">Ghi chú (tùy chọn)</label>
                        </div> -->
                    </form>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Phương thức thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="payment-methods">
                        <?php foreach ($payment_methods as $method): ?>
                        <div class="form-check payment-method-item mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" 
                                   id="payment-<?= $method['id'] ?>" value="<?= $method['id'] ?>" 
                                   <?= $method['id'] === 1 ? 'checked' : '' ?>>
                            <label class="form-check-label d-flex align-items-center" for="payment-<?= $method['id'] ?>">
                                <?php if ($method['id'] === 1): ?>
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <?php else: ?>
                                    <i class="fas fa-credit-card text-primary me-2"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($method['name']) ?>
                            </label>
                            <?php if ($method['id'] === 1): ?>
                                <div class="form-text ms-4">Thanh toán khi nhận hàng</div>
                            <?php else: ?>
                                <div class="form-text ms-4">Thanh toán qua thẻ hoặc ví điện tử</div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Order Items Preview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Đơn hàng của bạn</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Cart Items Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="80">Sản phẩm</th>
                                    <th scope="col">Tên sách</th>
                                    <th scope="col" class="text-center">Đơn giá</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="checkoutTableBody">
                                <!-- Cart items will be loaded here via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 position-sticky" style="top: 1rem;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Tổng đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tổng sản phẩm:</span>
                        <span id="orderSummaryCount">0 sản phẩm</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tạm tính:</span>
                        <span id="orderSubtotal" class="fw-bold">0 ₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển:</span>
                        <span id="orderShipping">30.000 ₫</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Tổng cộng:</span>
                        <span id="orderTotal" class="h5 text-danger">0 ₫</span>
                    </div>
                    <div class="d-grid gap-2">
                        <button id="placeOrderButton" class="btn btn-danger btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Đặt hàng
                        </button>
                        <a href="/cart" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get cart items container elements
    const checkoutTableBody = document.getElementById('checkoutTableBody');
    const orderSummaryCount = document.getElementById('orderSummaryCount');
    const orderSubtotal = document.getElementById('orderSubtotal');
    const orderShipping = document.getElementById('orderShipping');
    const orderTotal = document.getElementById('orderTotal');
    const placeOrderButton = document.getElementById('placeOrderButton');
    const checkoutForm = document.getElementById('checkoutForm');
    const errorAlert = document.getElementById('checkoutErrorAlert');
    const errorAlertMessage = document.getElementById('errorAlertMessage');

    // Parse shipping cost
    const shippingCost = parseFloat(orderShipping.textContent.replace(/[^\d]/g, ''));

    // Function to update checkout UI
    function updateCheckoutUI() {
        // Get cart data from localStorage
        const savedCart = localStorage.getItem('cart');
        let cartItems = [];

        if (savedCart) {
            try {
                const parsedData = JSON.parse(savedCart);
                if (Array.isArray(parsedData)) {
                    cartItems = parsedData;
                }
            } catch (error) {
                console.error('Error parsing cart data:', error);
            }
        }

        // If cart is empty, redirect to cart page
        if (cartItems.length === 0) {
            Swal.fire({
                title: 'Giỏ hàng trống',
                text: 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.',
                icon: 'warning',
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'Đi đến cửa hàng'
            }).then((result) => {
                window.location.href = '/shop';
            });
            return;
        }

        // Generate cart items HTML
        let html = '';
        let totalItems = 0;
        let subtotal = 0;

        cartItems.forEach(item => {
            // Find book details from allBooks array
            const book = allBooks.find(b => b.id == item.id);
            
            if (book) {
                const price = parseFloat(book.price.toString().replace(/[^\d]/g, ''));
                const itemTotal = price * item.quantity;
                totalItems += item.quantity;
                subtotal += itemTotal;
                
                html += `
                <tr>
                    <td>
                        <img src="${book.image}" alt="${book.name}" class="img-fluid" 
                            style="max-width: 60px; max-height: 90px;">
                    </td>
                    <td>
                        <h6 class="mb-0">${book.name}</h6>
                        <small class="text-muted">${book.author}</small>
                    </td>
                    <td class="text-center">${price.toLocaleString()} ₫</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-end fw-bold">${itemTotal.toLocaleString()} ₫</td>
                </tr>
                `;
            }
        });
        
        checkoutTableBody.innerHTML = html;
        
        // Update summary
        orderSummaryCount.textContent = `${totalItems} sản phẩm`;
        orderSubtotal.textContent = `${subtotal.toLocaleString()} ₫`;
        
        // Calculate total with shipping
        const total = subtotal + shippingCost;
        orderTotal.textContent = `${total.toLocaleString()} ₫`;
        
        // Store order summary for submission
        window.orderSummary = {
            items: cartItems,
            subtotal: subtotal,
            shipping: shippingCost,
            total: total,
            itemCount: totalItems
        };
    }
    
    // Handle place order button click
    placeOrderButton.addEventListener('click', function() {
        // Validate form
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalidField = null;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            // Show error message
            errorAlert.classList.remove('d-none');
            errorAlertMessage.textContent = 'Vui lòng điền đầy đủ thông tin trước khi tiếp tục.';
            
            // Scroll to first invalid field
            if (firstInvalidField) {
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalidField.focus();
            }
            
            return;
        }
        
        // Get selected payment method
        const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
        if (!selectedPaymentMethod) {
            // Show error message
            errorAlert.classList.remove('d-none');
            errorAlertMessage.textContent = 'Vui lòng chọn phương thức thanh toán.';
            return;
        }
        
        // Prepare order data
        const formData = new FormData(checkoutForm);
        const paymentMethodId = selectedPaymentMethod.value;
        
        // Add order summary to form data
        formData.append('items', JSON.stringify(window.orderSummary.items));
        formData.append('subtotal', window.orderSummary.subtotal);
        formData.append('shipping', window.orderSummary.shipping);
        formData.append('total', window.orderSummary.total);
        formData.append('paymentMethodId', paymentMethodId);
        
        // Simulate order submission
        Swal.fire({
            title: 'Đang xử lý',
            text: 'Đơn hàng của bạn đang được xử lý...',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Simulate AJAX request
        setTimeout(() => {
            // This would be replaced with actual AJAX call:
            /*
            fetch('/place-order', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        title: 'Đặt hàng thành công!',
                        text: `Đơn hàng #${data.orderId} đã được đặt thành công. Cảm ơn bạn đã mua hàng!`,
                        icon: 'success',
                        confirmButtonColor: '#e74c3c',
                        confirmButtonText: 'Xem đơn hàng'
                    }).then((result) => {
                        // Clear cart
                        localStorage.removeItem('cart');
                        // Redirect to order detail page
                        window.location.href = `/order-detail?id=${data.orderId}`;
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        title: 'Đặt hàng thất bại',
                        text: data.message || 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.',
                        icon: 'error',
                        confirmButtonColor: '#e74c3c',
                        confirmButtonText: 'Đóng'
                    });
                }
            })
            .catch(error => {
                // Show error message
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c',
                    confirmButtonText: 'Đóng'
                });
            });
            */
            
            // Simulate success (for demo purposes)
            Swal.fire({
                title: 'Đặt hàng thành công!',
                text: 'Đơn hàng #12345 đã được đặt thành công. Cảm ơn bạn đã mua hàng!',
                icon: 'success',
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'Xem đơn hàng'
            }).then((result) => {
                // Clear cart
                localStorage.removeItem('cart');
                
                // Update global cart interface if available
                if (typeof window.updateCartInterface === 'function') {
                    window.updateCartInterface();
                }
                
                // Redirect to order history page (replace with actual route)
                window.location.href = '/order-history';
            });
        }, 1500);
    });
    
    // Form input event listeners to clear validation errors
    checkoutForm.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
            
            // Hide error alert if all required fields are filled
            const invalidFields = checkoutForm.querySelectorAll('.is-invalid');
            if (invalidFields.length === 0) {
                errorAlert.classList.add('d-none');
            }
        });
    });
    
    // Initialize checkout UI
    updateCheckoutUI();
});
</script>

<style>
/* Checkout page specific styles */
.payment-method-item {
    padding: 0.75rem;
    border-radius: 0.25rem;
    transition: all 0.2s;
}

.payment-method-item:hover {
    background-color: rgba(231, 76, 60, 0.05);
}

.payment-method-item .form-check-input:checked {
    background-color: #e74c3c;
    border-color: #e74c3c;
}

.payment-method-item .form-check-label {
    cursor: pointer;
    font-weight: 500;
}

/* Form validation */
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-select.is-invalid {
    padding-right: 4.125rem;
    background-position: right 0.75rem center, center right 2.25rem;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
}
</style>
