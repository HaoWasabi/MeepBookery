<!-- Đơn hàng - MeepBookery -->

<!-- Order History Banner -->
<section class="order-history-banner py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="order-history-banner-content text-center">
                    <h1 class="order-title mb-4">Lịch sử đơn hàng</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Order History Section -->
<section class="order-history-section py-5">
    <div class="container">
        <!-- Search & Filter -->
        <div class="order-filter-container mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none text-danger" type="button"
                            data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true"
                            aria-controls="filterCollapse">
                            <i class="fas fa-filter me-2"></i> Tìm kiếm & Lọc đơn hàng
                        </button>
                    </h5>
                </div>
                <div id="filterCollapse" class="collapse show">
                    <div class="card-body">
                        <form action="" method="GET" class="row g-3">
                            <!-- Order ID -->
                            <div class="col-md-6 col-lg-3">
                                <label for="orderId" class="form-label">Mã đơn hàng</label>
                                <input type="text" class="form-control" id="orderId" name="order_id"
                                    placeholder="Nhập mã đơn hàng">
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-6 col-lg-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending">Chờ xác nhận</option>
                                    <option value="confirmed">Đã xác nhận</option>
                                    <!-- <option value="shipping">Đang giao hàng</option> -->
                                    <option value="delivered">Đã giao hàng</option>
                                    <option value="cancelled">Đã hủy</option>
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="col-md-6 col-lg-3">
                                <label for="startDate" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="startDate" name="start_date">
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <label for="endDate" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="endDate" name="end_date">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end">
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-redo-alt me-1"></i> Đặt lại
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-search me-1"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (!empty($orders)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Địa chỉ giao hàng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            $statusText = '';

                                            switch ($order['status']) {
                                                case 'pending':
                                                    $statusClass = 'warning';
                                                    $statusText = 'Chờ xác nhận';
                                                    break;
                                                case 'confirmed':
                                                    $statusClass = 'info';
                                                    $statusText = 'Đã xác nhận';
                                                    break;
                                                /* case 'shipping':
                                                    $statusClass = 'primary';
                                                    $statusText = 'Đang giao hàng';
                                                    break; */
                                                case 'delivered_success':
                                                    $statusClass = 'success';
                                                    $statusText = 'Đã giao hàng';
                                                    break;
                                                case 'canceled':
                                                    $statusClass = 'danger';
                                                    $statusText = 'Đã hủy';
                                                    break;
                                                default:
                                                    $statusClass = 'secondary';
                                                    $statusText = 'Không xác định';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </td>
                                        <td><?php echo number_format(str_replace('.', '', $order['total_amount']), 0, ',', '.'); ?>đ
                                        </td>
                                        <td><?php echo $order['payment_method']; ?></td>
                                        <td>
                                            <?php echo $order['address'] . ', ' . $order['ward'] . ', ' . $order['district'] . ', ' . $order['city']; ?>
                                        </td>
                                        <td>
                                            <a href="order-detail.php?id=<?php echo $order['id']; ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php else: ?>
                    <div class="text-center py-5">
                        <img src="../../img/empty-order.jpg" alt="Empty Orders" class="img-fluid mb-3"
                            style="max-width: 500px;">
                        <h4>Bạn chưa có đơn hàng nào</h4>
                        <p class="text-muted">Hãy khám phá các sản phẩm của chúng tôi và đặt hàng ngay!</p>
                        <a href="shop.php" class="btn btn-danger mt-3">
                            <i class="fas fa-shopping-cart me-2"></i> Mua sắm ngay
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Help Section -->
<section class="help-section py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="d-flex align-items-center">
                    <div class="help-icon me-3">
                        <i class="fas fa-truck text-danger"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Theo dõi đơn hàng</h5>
                        <p class="mb-0 small">Kiểm tra trạng thái đơn hàng của bạn</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="d-flex align-items-center">
                    <div class="help-icon me-3">
                        <i class="fas fa-exchange-alt text-danger"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Chính sách đổi trả</h5>
                        <p class="mb-0 small">Đổi trả sản phẩm trong vòng 7 ngày</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="help-icon me-3">
                        <i class="fas fa-headset text-danger"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Hỗ trợ 24/7</h5>
                        <p class="mb-0 small">Liên hệ: <a href="tel:+84123456789">(+84) 0123456789</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .order-history-banner {
        background-color: #f8f9fa;
    }

    .help-icon {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        font-weight: 500;
    }

    .pagination .page-link {
        color: #dc3545;
    }

    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
</style>

<!-- Custom JavaScript for Date Range Filter -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default date range (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date(today);
        thirtyDaysAgo.setDate(today.getDate() - 30);

        // Format dates for input
        document.getElementById('endDate').valueAsDate = today;
        document.getElementById('startDate').valueAsDate = thirtyDaysAgo;

        // Reset button handler
        document.querySelector('button[type="reset"]').addEventListener('click', function () {
            setTimeout(function () {
                document.getElementById('endDate').valueAsDate = today;
                document.getElementById('startDate').valueAsDate = thirtyDaysAgo;
            }, 10);
        });
    });
</script>