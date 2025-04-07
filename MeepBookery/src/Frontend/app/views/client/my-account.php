<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="account-sidebar card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Tài khoản của tôi</h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="/my-account" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i> Thông tin tài khoản
                    </a>
                    <a href="/order-history" class="list-group-item list-group-item-action">
                        <i class="fas fa-clipboard-list me-2"></i> Lịch sử đơn hàng
                    </a>
                    <a href="/cart" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng
                    </a>
                    <a href="/logout" class="list-group-item list-group-item-action text-danger" id="sidebar-logout">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Thông tin cá nhân</h4>
                </div>
                <div class="card-body">
                    <!-- Success/Error Alert -->
                    <div id="accountUpdateAlert" class="alert alert-success alert-dismissible fade show d-none"
                        role="alert">
                        <span id="alertMessage">Thông tin đã được cập nhật thành công!</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Account Form -->
                    <form id="accountForm" method="POST" action="/update-account" data-aos="fade-up">
                        <!-- This form will POST to /update-account endpoint -->

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Họ và tên" value="<?= htmlspecialchars($user['name']) ?>" required>
                                    <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                        value="<?= htmlspecialchars($user['email']) ?>" required>
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="Số điện thoại"
                                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                    <label for="phone">Số điện thoại</label>
                                    <div class="form-text">Vui lòng nhập số điện thoại nếu có</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-4 mb-4">
                            <h5 class="mb-3">Địa chỉ giao hàng mặc định</h5>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Địa chỉ"
                                            value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                                        <label for="address">Địa chỉ chi tiết</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="city" name="city">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                            <!-- Các tùy chọn sẽ được tải bằng JavaScript -->
                                            <option value="city 1" <?= ($user['city'] ?? '') == 'city 1' ? 'selected' : '' ?>>Thành phố 1</option>
                                            <option value="city 2" <?= ($user['city'] ?? '') == 'city 2' ? 'selected' : '' ?>>Thành phố 2</option>
                                        </select>
                                        <label for="city">Tỉnh/Thành phố</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="district" name="district">
                                            <option value="">Chọn Quận/Huyện</option>
                                            <!-- Các tùy chọn sẽ được tải bằng JavaScript -->
                                            <option value="district 1" <?= ($user['district'] ?? '') == 'district 1' ? 'selected' : '' ?>>Quận/Huyện 1</option>
                                            <option value="district 2" <?= ($user['district'] ?? '') == 'district 2' ? 'selected' : '' ?>>Quận/Huyện 2</option>
                                        </select>
                                        <label for="district">Quận/Huyện</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="ward" name="ward">
                                            <option value="">Chọn Phường/Xã</option>
                                            <!-- Các tùy chọn sẽ được tải bằng JavaScript -->
                                            <option value="ward 1" <?= ($user['ward'] ?? '') == 'ward 1' ? 'selected' : '' ?>>Phường/Xã 1</option>
                                            <option value="ward 2" <?= ($user['ward'] ?? '') == 'ward 2' ? 'selected' : '' ?>>Phường/Xã 2</option>
                                        </select>
                                        <label for="ward">Phường/Xã</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i> Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script để xử lý form và hiệu ứng -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Form validation và xử lý
        const accountForm = document.getElementById('accountForm');
        const alertBox = document.getElementById('accountUpdateAlert');
        const alertMessage = document.getElementById('alertMessage');

        if (accountForm) {
            accountForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Perform form validation
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();

                if (!name || !email) {
                    showAlert('Vui lòng điền đầy đủ thông tin bắt buộc', 'danger');
                    return;
                }

                // Here you would normally send the data to the server
                // For demonstration, we'll just show a success message

                // Simulate AJAX request
                setTimeout(() => {
                    // This would be replaced with actual AJAX call:
                    /*
                    fetch('/update-account', {
                        method: 'POST',
                        body: new FormData(accountForm),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Thông tin đã được cập nhật thành công!', 'success');
                        } else {
                            showAlert(data.message || 'Có lỗi xảy ra khi cập nhật thông tin', 'danger');
                        }
                    })
                    .catch(error => {
                        showAlert('Có lỗi xảy ra khi cập nhật thông tin', 'danger');
                    });
                    */

                    // Show success message (for demo)
                    showAlert('Thông tin đã được cập nhật thành công!', 'success');
                }, 800);
            });
        }

        // Handle sidebar logout confirmation
        const sidebarLogout = document.getElementById('sidebar-logout');
        if (sidebarLogout) {
            sidebarLogout.addEventListener('click', function (e) {
                e.preventDefault();

                // Use SweetAlert2 for confirmation (already included in head.php)
                Swal.fire({
                    title: 'Đăng xuất',
                    text: 'Bạn có chắc chắn muốn đăng xuất?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Đăng xuất',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/logout';
                    }
                });
            });
        }

        // Function to show alert messages
        function showAlert(message, type = 'success') {
            alertBox.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-warning');
            alertBox.classList.add(`alert-${type}`);
            alertMessage.textContent = message;
            alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Auto hide after 5 seconds
            setTimeout(() => {
                alertBox.classList.add('d-none');
            }, 5000);
        }

        // Initialize any additional libraries or components
        // You could add address selection dropdowns here

        // Example of how you might load city/district/ward options dynamically
        /*
        function populateCities() {
            fetch('/api/cities')
                .then(response => response.json())
                .then(data => {
                    const citySelect = document.getElementById('city');
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                });
        }
        
        // Call functions to load data
        populateCities();
        */
    });
</script>

<!-- CSS để tùy chỉnh giao diện (có thể chuyển sang file riêng) -->
<style>
    .account-sidebar .list-group-item {
        border-radius: 0;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .account-sidebar .list-group-item.active {
        background-color: #e74c3c;
        border-color: #e74c3c;
        color: white;
    }

    .account-sidebar .list-group-item:hover:not(.active) {
        background-color: #f8f9fa;
    }

    .form-floating>.form-control {
        padding: 1rem 0.75rem;
    }

    .form-floating>label {
        padding: 1rem 0.75rem;
    }

    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label {
        opacity: 0.65;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }
</style>