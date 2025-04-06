document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        speed: 1000,
    });



    // Update cart UI when page loads
    updateCartInterface();

    // Handle search form submission
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const searchInput = this.querySelector('input[name="search"]');
            const searchTerm = searchInput.value.trim();

            // Always redirect to shop.php, with or without search term
            let url = 'shop.php';
            if (searchTerm) {
                url += '?search=' + encodeURIComponent(searchTerm);
            }

            window.location.href = url;
        });
    }

    // Highlight active category in dropdown
    const highlightActiveCategory = () => {
        const urlParams = new URLSearchParams(window.location.search);
        const categoryParam = urlParams.get('category');

        if (categoryParam) {
            const categoryItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
            categoryItems.forEach(item => {
                const itemCategory = item.textContent.trim();
                if (itemCategory === decodeURIComponent(categoryParam)) {
                    // Remove active class from all items
                    categoryItems.forEach(i => i.classList.remove('active'));
                    // Add active to current item
                    item.classList.add('active');
                    // Update dropdown button text
                    document.getElementById('categoryDropdown').textContent = itemCategory;
                }
            });
        }
    };

    // Call function to highlight active category
    highlightActiveCategory();

    // Set active navigation menu based on current URL
    const setActiveNavigation = () => {
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-menu .nav-item');

        // Remove all active classes first
        navItems.forEach(item => item.classList.remove('active'));

        // Set active class based on path
        if (currentPath.includes('products')) {
            document.querySelector('.nav-menu .nav-item:nth-child(2)').classList.add('active');
        } else if (currentPath.includes('about') || currentPath.includes('gioi-thieu')) {
            document.querySelector('.nav-menu .nav-item:nth-child(3)').classList.add('active');
        } else if (currentPath.includes('contact') || currentPath.includes('lien-he')) {
            document.querySelector('.nav-menu .nav-item:nth-child(4)').classList.add('active');
        } else {
            // Default to home
            document.querySelector('.nav-menu .nav-item:nth-child(1)').classList.add('active');
        }
    };

    // Call the function to set active menu
    setActiveNavigation();

    // Hiển thị sách bán chạy
    let bestSellerBooksHtml = '';

    // Filter only active books (include ones with stock=0 to show "out of stock")
    const availableBestSellers = bestSellerBooks.filter(book => book.status === 1);

    availableBestSellers.forEach(book => {
        bestSellerBooksHtml += createBookCard(book);
    });

    document.getElementById('featured-books-container').innerHTML = bestSellerBooksHtml;

    // Khởi tạo phân trang với paginationjs
    // Filter only active books (include ones with stock=0 to show "out of stock")
    const availableBooks = allBooks.filter(book => book.status === 1);

    $('#pagination-container').pagination({
        dataSource: availableBooks,
        pageSize: 8,
        autoHidePrevious: true,
        autoHideNext: true,
        prevText: '<i class="fas fa-chevron-left"></i>',
        nextText: '<i class="fas fa-chevron-right"></i>',
        pageRange: 2,
        hideOnlyOnePage: true,
        callback: (data, pagination) => {
            // Render HTML
            let html = '';

            data.forEach(book => {
                html += createBookCard(book);
            });

            $('#books-container').html(html);

            // Scroll to pagination position if navigating pages
            if (pagination.pageNumber >= 1) {
                $('html, body').animate({
                    scrollTop: $('#books-container').offset().top - 100
                }, 200);
            }
        },
        locator: 'items'
    });

    // Kiểm tra nếu đang ở trang shop
    if (!document.getElementById('shop-products-container')) return;

    // Set active navigation
    document.querySelector('.nav-menu .nav-item:nth-child(2)').classList.add('active');

    // Price slider initialization
    const priceSlider = document.getElementById('price-range-slider');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const priceMinLabel = document.querySelector('.price-min');
    const priceMaxLabel = document.querySelector('.price-max');

    // Get min and max price from all books
    const prices = allBooks.map(book => parseFloat(book.price.replace(/[^0-9]/g, '')));
    // const minPrice = Math.min(...prices);
    const minPrice = 0;
    const maxPrice = Math.max(...prices);

    // Set initial values for inputs
    minPriceInput.value = minPrice;
    maxPriceInput.value = maxPrice;

    // Hàm định dạng tiền tệ
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    };

    // Hàm định dạng số cho tooltip
    const formatNumber = (value) => {
        return new Intl.NumberFormat('vi-VN', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    };

    // Định dạng input giá theo tiền tệ khi nhập xong
    const formatPriceInput = (input) => {
        // Tạo phần tử hiển thị giá định dạng nếu chưa có
        let displayElement = input.nextElementSibling;
        if (!displayElement || !displayElement.classList.contains('price-display')) {
            displayElement = document.createElement('div');
            displayElement.className = 'price-display';
            input.parentNode.appendChild(displayElement);
        }

        // Lưu giá trị số (dùng cho tính toán)
        const numericValue = parseInt(input.value);
        if (!isNaN(numericValue)) {
            // Hiển thị giá trị định dạng
            displayElement.textContent = formatCurrency(numericValue);
            // Hiển thị phần tử định dạng
            displayElement.style.display = 'block';
            // Ẩn input số
            input.classList.add('has-price-display');
        } else {
            // Ẩn phần tử định dạng nếu giá trị không hợp lệ
            displayElement.style.display = 'none';
            // Hiện lại input
            input.classList.remove('has-price-display');
        }
    };

    // Thêm sự kiện cho các input giá
    document.querySelectorAll('.price-input').forEach(input => {
        // Khi click vào hiển thị giá, ẩn nó đi và hiển thị input
        input.parentNode.addEventListener('click', function (e) {
            const displayElement = this.querySelector('.price-display');
            if (displayElement && e.target === displayElement) {
                displayElement.style.display = 'none';
                input.classList.remove('has-price-display');
                input.focus();
            }
        });

        // Khi blur, định dạng giá
        input.addEventListener('blur', function () {
            formatPriceInput(this);
        });

        // Khi nhấn Enter, định dạng giá
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                this.blur();
            }
        });
    });

    // Initialize noUiSlider
    noUiSlider.create(priceSlider, {
        start: [minPrice, maxPrice],
        connect: true,
        step: 1,
        range: {
            'min': minPrice,
            'max': maxPrice
        },
        format: {
            to: function (value) {
                return Math.round(value);
            },
            from: function (value) {
                return Number(value);
            }
        },
        tooltips: [
            {
                to: function (value) {
                    return formatNumber(value);
                }
            },
            {
                to: function (value) {
                    return formatNumber(value);
                }
            }
        ]
    });

    // Khởi tạo labels min-max
    priceMinLabel.textContent = formatCurrency(minPrice);
    priceMaxLabel.textContent = formatCurrency(maxPrice);

    // Set the initial values
    priceSlider.noUiSlider.on('update', function (values, handle) {
        const value = Math.round(values[handle]);
        const minValue = Math.round(values[0]);
        const maxValue = Math.round(values[1]);

        // Update labels
        document.querySelector('.price-min').textContent = formatCurrency(minValue);
        document.querySelector('.price-max').textContent = formatCurrency(maxValue);

        // Update input fields
        if (handle === 0) {
            document.getElementById('min-price').value = minValue;
        } else {
            document.getElementById('max-price').value = maxValue;
        }
    });

    // Apply filter when slider stops
    priceSlider.noUiSlider.on('change', function (values) {
        const minValue = Math.round(values[0]);
        const maxValue = Math.round(values[1]);
        updateSlider(minValue, maxValue);
    });

    // Populate category filter
    const categories = [...new Set(allBooks.map(book => book.category))];
    const categorySelect = document.getElementById('category-filter');
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });

    // Filter and display products
    let filteredBooks = [...allBooks];
    let currentPage = 1;
    const booksPerPage = 8;

    function applyFilters() {
        const searchTerm = document.getElementById('search-term').value.toLowerCase();
        const selectedCategory = document.getElementById('category-filter').value;
        const minPrice = parseFloat(document.getElementById('min-price').value);
        const maxPrice = parseFloat(document.getElementById('max-price').value);
        const sortBy = document.getElementById('sort-by').value;

        // Get min and max price from all books for comparison
        const prices = allBooks.map(book => parseFloat(book.price.replace(/[^0-9]/g, '')));
        const initialMinPrice = 0;
        const initialMaxPrice = Math.max(...prices);

        // Filter books
        filteredBooks = allBooks.filter(book => {
            // Filter by status (active books)
            if (book.status !== 1) return false;

            // Filter by search term
            if (searchTerm &&
                !book.name.toLowerCase().includes(searchTerm)
                // && !book.author.toLowerCase().includes(searchTerm)
            ) {
                return false;
            }

            // Filter by category
            if (selectedCategory && book.category !== selectedCategory) {
                return false;
            }

            // Filter by price
            const bookPrice = parseFloat(book.price.replace(/[^0-9]/g, ''));
            if (bookPrice < minPrice || bookPrice > maxPrice) {
                return false;
            }

            return true;
        });

        // Sort books
        switch (sortBy) {
            case 'price-asc':
                filteredBooks.sort((a, b) =>
                    parseFloat(a.price.replace(/[^0-9]/g, '')) -
                    parseFloat(b.price.replace(/[^0-9]/g, '')));
                break;

            case 'price-desc':
                filteredBooks.sort((a, b) =>
                    parseFloat(b.price.replace(/[^0-9]/g, '')) -
                    parseFloat(a.price.replace(/[^0-9]/g, '')));
                break;

            case 'name-asc':
                filteredBooks.sort((a, b) => a.name.localeCompare(b.name));
                break;

            case 'name-desc':
                filteredBooks.sort((a, b) => b.name.localeCompare(a.name));
                break;

            default:
                // Default sorting (no specific sort)
                break;
        }

        // Show/hide clear filters button
        const clearFiltersBtn = document.getElementById('clear-filters');
        if (searchTerm ||
            selectedCategory ||
            minPrice > initialMinPrice ||
            maxPrice < initialMaxPrice ||
            sortBy !== 'default') {
            clearFiltersBtn.style.display = 'inline-block';
        } else {
            clearFiltersBtn.style.display = 'none';
        }

        // Update result count
        document.getElementById('result-count').textContent = `${filteredBooks.length} sản phẩm`;

        // Reinitialize pagination
        initPagination();
    }

    // Initialize pagination
    function initPagination() {
        $('#shop-pagination-container').pagination({
            dataSource: filteredBooks,
            pageSize: booksPerPage,
            autoHidePrevious: true,
            autoHideNext: true,
            prevText: '<i class="fas fa-chevron-left"></i>',
            nextText: '<i class="fas fa-chevron-right"></i>',
            pageRange: 2,
            callback: function (data, pagination) {
                // Render HTML
                let html = '';

                if (data.length === 0) {
                    html = `
                        <div class="col-12 py-5 text-center no-results-container">
                            <div class="no-results">
                                <img src="../../img/product-not-found.png" alt="Không tìm thấy sản phẩm" class="img-fluid mb-4 no-results-img">
                                <h3>Oops! Không tìm thấy cuốn sách nào phù hợp!</h3>
                                <p class="text-muted">Chúng tôi đã tìm khắp kệ mà vẫn không thấy!</p>
                                <p class="mt-2 fun-quote">Hãy kiểm tra lại từ khóa hoặc thử tìm cách khác nhé!</p>
                            </div>
                        </div>
                    `;
                } else {
                    data.forEach(book => {
                        html += window.createBookCard(book);
                    });
                }

                $('#shop-products-container').html(html);

                // Scroll to shop section when changing pages
                if (pagination.pageNumber >= 1) {
                    $('html, body').animate({
                        scrollTop: $('.shop-controls').offset().top - 120
                    }, 200);
                }
            }
        });
    }

    // Cập nhật giá trị slider khi thay đổi giá trị input
    const updateSlider = (minValue, maxValue) => {
        if (minValue === undefined || maxValue === undefined) {
            minValue = parseFloat(document.getElementById('min-price').value) || 0;
            maxValue = parseFloat(document.getElementById('max-price').value) || maxPrice;
        }

        // Cập nhật giá trị slider
        if (priceSlider && priceSlider.noUiSlider) {
            priceSlider.noUiSlider.set([minValue, maxValue]);
        }

        // Cập nhật giá trị input
        document.getElementById('min-price').value = minValue;
        document.getElementById('max-price').value = maxValue;

        // Cập nhật labels
        document.querySelector('.price-min').textContent = formatCurrency(minValue);
        document.querySelector('.price-max').textContent = formatCurrency(maxValue);

        // Áp dụng bộ lọc sau khi thay đổi slider
        // applyFilters();
    };

    // Apply filters button
    document.getElementById('apply-filter').addEventListener('click', function () {
        applyFilters();
    });

    // Apply filter when inputs change
    document.getElementById('min-price').addEventListener('change', function () {
        const minValue = parseFloat(this.value);
        const maxValue = parseFloat(document.getElementById('max-price').value);
        updateSlider(minValue, maxValue);
    });

    document.getElementById('max-price').addEventListener('change', function () {
        const minValue = parseFloat(document.getElementById('min-price').value);
        const maxValue = parseFloat(this.value);
        updateSlider(minValue, maxValue);
    });

    // Clear all filters
    document.getElementById('clear-filters').addEventListener('click', function () {
        document.getElementById('search-term').value = '';
        document.getElementById('category-filter').value = '';
        document.getElementById('sort-by').value = 'default';

        // Reset price range slider
        if (priceSlider && priceSlider.noUiSlider) {
            updateSlider(minPrice, maxPrice);
        }

        applyFilters();
    });

    // Sort by change
    document.getElementById('sort-by').addEventListener('change', function () {
        applyFilters();
    });

    // Initialize on page load
    applyFilters();
});

// Add event listener for logout button - Modified to use standard link
$(document).on('click', '#logoutBtn', function (e) {
    e.preventDefault();

    // Show confirmation dialog
    showSweetAlert('Bạn có chắc chắn muốn đăng xuất?', {
        icon: 'question',
        title: 'Đăng xuất',
        showCancelButton: true,
        confirmButtonText: 'Đăng xuất',
        cancelButtonText: 'Hủy',
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to logout route
            window.location.href = 'logout';
        }
    });
});

// Biến theo dõi toast hiện tại
let toastTimeout = null;

/**
 * Hiển thị thông báo dạng toast
 * @param {string} message - Nội dung thông báo
 * @param {object} options - Tùy chọn (type, title, duration, position)
 * @returns {string} ID của toast để có thể tham chiếu sau này
 */
const showToast = (message, options = {}) => {
    // Clear previous toast timeout if exists
    if (toastTimeout !== null) {
        clearTimeout(toastTimeout);
    }

    // Default options
    const defaults = {
        type: 'success', // success, error, warning, info
        title: 'Thông báo',
        duration: 3000,
        position: 'top-right' // top-right, top-left, bottom-left, bottom-right
    };

    // Merge default options with provided options
    const settings = { ...defaults, ...options };

    // For backward compatibility
    if (options === true) {
        settings.type = 'error';
        settings.title = 'Thông báo';
    } else if (typeof options === 'string') {
        settings.title = options;
    }

    // Create toast container if it doesn't exist
    if (!$('#toastContainer').length) {
        $('body').append(`
            <div class="toast-container position-fixed p-3" id="toastContainer"></div>
        `);
    }

    // Set position
    const toastContainer = $('#toastContainer');
    toastContainer.removeClass('top-0 bottom-0 start-0 end-0');
    switch (settings.position) {
        case 'top-right':
            toastContainer.addClass('top-0 end-0');
            break;
        case 'top-left':
            toastContainer.addClass('top-0 start-0');
            break;
        case 'bottom-left':
            toastContainer.addClass('bottom-0 start-0');
            break;
        default: // bottom-right
            toastContainer.addClass('bottom-0 end-0');
            break;
    }

    // Generate unique ID for this toast
    const toastId = 'toast-' + new Date().getTime();

    // Set color scheme based on type
    let headerClass = 'bg-info';
    let icon = 'fa-info-circle';

    switch (settings.type) {
        case 'success':
            headerClass = 'bg-success';
            icon = 'fa-check-circle';
            break;
        case 'error':
            headerClass = 'bg-danger';
            icon = 'fa-times-circle';
            break;
        case 'warning':
            headerClass = 'bg-warning';
            icon = 'fa-exclamation-triangle';
            break;
    }

    // Determine animation based on position
    let animationIn = '';

    if (settings.position.includes('top')) {
        animationIn = 'animate__fadeInDown';
    } else {
        animationIn = 'animate__fadeInUp';
    }

    if (settings.position.includes('left')) {
        animationIn = 'animate__fadeInLeft';
    } else if (settings.position.includes('right')) {
        animationIn = 'animate__fadeInRight';
    }

    // Remove any existing toasts
    $('#toastContainer .toast').each(function () {
        $(this).remove();
    });

    // Append toast to container
    toastContainer.append(`
        <div id="${toastId}" class="toast show animate__animated ${animationIn} animate__faster" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${headerClass} text-white">
                <i class="fas ${icon} me-2"></i>
                <strong class="me-auto">${settings.title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${message}</div>
        </div>
    `);

    // Determine exit animation based on position
    let animationOut = '';

    if (settings.position.includes('top')) {
        animationOut = 'animate__fadeOutUp';
    } else {
        animationOut = 'animate__fadeOutDown';
    }

    if (settings.position.includes('left')) {
        animationOut = 'animate__fadeOutLeft';
    } else if (settings.position.includes('right')) {
        animationOut = 'animate__fadeOutRight';
    }

    // Function to handle toast removal with animation
    const removeToastWithAnimation = (toastElement) => {
        $(toastElement)
            .removeClass(animationIn)
            .addClass(animationOut)
            .on('animationend', function () {
                $(this).remove();
            });
    };

    // Set timeout to auto-hide the toast
    toastTimeout = setTimeout(() => {
        removeToastWithAnimation($(`#${toastId}`));
        toastTimeout = null;
    }, settings.duration);

    // Enable manual closing
    $(`#${toastId} .btn-close`).on('click', function () {
        removeToastWithAnimation($(`#${toastId}`));

        if (toastTimeout !== null) {
            clearTimeout(toastTimeout);
            toastTimeout = null;
        }
    });

    return toastId;
};

/**
 * Hiển thị thông báo sử dụng SweetAlert2
 * @param {string} message - Nội dung thông báo
 * @param {object} options - Tùy chọn (icon, title, confirmButtonText, ...)
 * @returns {Promise} Promise từ SweetAlert2 để có thể xử lý kết quả
 */
const showSweetAlert = (message, options = {}) => {
    // Default options
    const defaults = {
        icon: 'success', // success, error, warning, info, question
        title: 'Thông báo',
        confirmButtonText: 'Đồng ý',
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        focusConfirm: false,
        returnFocus: false,
    };

    // Merge default options with provided options
    const settings = { ...defaults, ...options };

    // Add the message to the settings
    settings.text = message;

    // Special case for confirmation dialogs
    if (options.showCancelButton) {
        if (!settings.cancelButtonText) {
            settings.cancelButtonText = 'Hủy';
        }
    }

    // Return the SweetAlert2 promise for further handling if needed
    return Swal.fire(settings);
};

/**
 * Hàm tạo HTML cho card sách - khai báo toàn cục để có thể sử dụng ở mọi nơi
 * @param {object} book - Đối tượng sách cần hiển thị
 * @returns {string} HTML cho card sách
 */
window.createBookCard = (book) => {
    const isOutOfStock = book.stock === 0;

    return `
        <div class="col-md-3 col-sm-6">
            <div class="book-card ${isOutOfStock ? 'out-of-stock' : ''}">
                ${isOutOfStock ? '<div class="out-of-stock-label">Tạm hết hàng</div>' : ''}
                <div class="book-img-container">
                    <a href="product-detail.php?id=${book.id}" title="${book.name}">
                        <img src="${book.image}" alt="${book.name}" class="book-img">
                    </a>
                    ${isOutOfStock ? '<div class="book-img-overlay"></div>' : ''}
                    
                    </div>
                <div class="book-info">
                    <h3 class="book-title">
                        <a href="product-detail.php?id=${book.id}" title="${book.name}">${book.name}</a>
                    </h3>
                    <p class="book-category">${book.category}</p>
                    <p class="book-author">${book.author}</p>
                    <p class="book-price">${book.price} ₫</p>

                    <!-- Hover action buttons -->
                    <div class="book-hover-actions">
                        <button class="action-btn buy-now-btn" data-book-id="${book.id}" ${isOutOfStock ? 'disabled' : ''} title="Mua ngay">
                            <span class="btn-icon"><i class="fas fa-bolt"></i></span>
                            <span class="btn-text">Mua ngay</span>
                        </button>
                        <button class="action-btn add-cart-btn" data-book-id="${book.id}" ${isOutOfStock ? 'disabled' : ''} title="Thêm vào giỏ hàng">
                            <span class="btn-icon"><i class="fas fa-cart-plus"></i></span>
                            <span class="btn-text">Thêm vào giỏ</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
};

// Add event listeners for the hover action buttons
$(document).on('click', '.add-cart-btn', function (e) {
    e.preventDefault();
    const bookId = $(this).data('book-id');
    // Find the book in allBooks array
    const book = allBooks.find(b => b.id == bookId);
    if (book) {
        addToCart(book);
    }
});

$(document).on('click', '.buy-now-btn', function (e) {
    e.preventDefault();
    const bookId = $(this).data('book-id');
    // Find the book in allBooks array
    const book = allBooks.find(b => b.id == bookId);

    if (book) {
        // Add to cart first (without showing notification)
        const added = addToCart(book, true);

        // Redirect to product detail or checkout
        if (added) {
            setTimeout(() => {
                window.location.href = 'product-detail.php?id=' + bookId;
            }, 300);
        }
    }
});

// Cart functionality
$(document).ready(() => {
    // Initialize cart object
    let cart = {
        items: [],
        totalItems: 0,
        totalPrice: 0
    };

    // Initialize cart offcanvas
    const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));

    // Function definitions

    // Function to update cart summary (totals, badges)
    const updateCartSummary = () => {
        // Calculate total items & price
        cart.totalItems = cart.items.reduce((total, item) => total + item.quantity, 0);
        cart.totalPrice = cart.items.reduce((total, item) => total + (item.price * item.quantity), 0);

        // Update UI
        $('.cart-count').text(cart.totalItems);
        $('#cartTotalPrice').text(`${cart.totalPrice.toLocaleString()} đ`);
        $('#cartTotalItems').text(`${cart.totalItems} sản phẩm`);

        // Also update global cart interface
        updateCartInterface();
    };

    // Update a single cart item's quantity and price in the UI
    // without re-rendering the entire cart
    const updateCartItemUI = (itemId, quantity) => {
        const item = cart.items.find(item => item.id === itemId);
        if (!item) return;

        const itemContainer = $(`.cart-item input[data-id="${itemId}"]`).closest('.cart-item');
        if (itemContainer.length === 0) return;

        // Update quantity input
        itemContainer.find('.item-qty').val(quantity);

        // Update item total price
        const itemTotal = item.price * quantity;
        itemContainer.find('.d-flex.justify-content-between .text-danger:last-child').text(`${itemTotal.toLocaleString()} đ`);

        // Update quantity in display
        itemContainer.find('.text-secondary').text(`SL: ${quantity} x`);

        // Update increase button state based on stock
        const book = allBooks.find(b => b.id === itemId);
        const maxStock = book ? book.stock : 99;
        const increaseBtn = itemContainer.find('.increase-qty');

        if (quantity >= maxStock) {
            increaseBtn.prop('disabled', true);
            increaseBtn.css({ 'opacity': '0.25', 'cursor': 'not-allowed' });
        } else {
            increaseBtn.prop('disabled', false);
            increaseBtn.css({ 'opacity': '', 'cursor': '' });
        }

        // Update stock warning message if needed
        const stockWarningContainer = itemContainer.find('small.text-muted');
        if (maxStock < 10) {
            if (stockWarningContainer.length === 0) {
                itemContainer.find('.d-flex.align-items-center').after(
                    `<small class="text-muted mt-1 d-block">Còn ${maxStock} "${item.name}" trong kho</small>`
                );
            } else {
                stockWarningContainer.text(`Còn ${maxStock} "${item.name}" trong kho`);
            }
        } else if (stockWarningContainer.length > 0) {
            stockWarningContainer.remove();
        }
    };

    // Save cart to browser local storage
    const saveCartToLocalStorage = () => {
        // Only save minimal data (id and quantity) to localStorage
        const minimalCart = cart.items.map(item => ({
            id: item.id,
            quantity: item.quantity
        }));

        localStorage.setItem('cart', JSON.stringify(minimalCart));
    };

    // Load cart from browser local storage
    const loadCartFromLocalStorage = () => {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            try {
                const parsedData = JSON.parse(savedCart);

                // Check which format the saved cart is in
                if (parsedData && typeof parsedData === 'object') {
                    // Reset cart items
                    cart.items = [];

                    if (Array.isArray(parsedData)) {
                        // New format: array of {id, quantity}
                        parsedData.forEach(item => {
                            // Find book in allBooks array
                            const book = allBooks.find(b => b.id == item.id);

                            if (book) {
                                // Add to cart with saved quantity
                                cart.items.push({
                                    id: book.id,
                                    name: book.name,
                                    price: parseFloat(book.price.toString().replace(/[^\d]/g, '')),
                                    quantity: item.quantity,
                                    image: book.image
                                });
                            }
                        });
                    } else if (Array.isArray(parsedData.items)) {
                        // Old format: full cart object
                        // Migrate to new format while loading
                        parsedData.items.forEach(item => {
                            // Verify item exists in current books
                            const book = allBooks.find(b => b.id == item.id);

                            if (book) {
                                // Add to cart with saved data but updated book info
                                cart.items.push({
                                    id: book.id,
                                    name: book.name,
                                    price: parseFloat(book.price.toString().replace(/[^\d]/g, '')),
                                    quantity: item.quantity,
                                    image: book.image
                                });
                            }
                        });

                        // Save in new format immediately
                        saveCartToLocalStorage();
                    }

                    // Update cart summary
                    updateCartSummary();
                }
            } catch (error) {
                console.error('Error parsing cart from localStorage:', error);
                // Reset cart and localStorage on error
                cart.items = [];
                localStorage.removeItem('cart');
            }
        }
    };

    // Function to render cart items
    const renderCartItems = () => {
        let cartItemsHtml = '';

        if (cart.items.length === 0) {
            // Empty cart view with image
            cartItemsHtml = $('#emptyCartTemplate').html();
            // Hide cart summary
            $('#cartSummary').hide();
        } else {
            // Show cart summary
            $('#cartSummary').show();

            cart.items.forEach(item => {
                // Find book in allBooks to get current stock
                const book = allBooks.find(b => b.id === item.id);
                const maxStock = book ? book.stock : 99; // Fallback to 99 if book not found

                cartItemsHtml += `
                    <div class="card border-0 rounded-0 border-bottom cart-item">
                        <div class="card-body p-3">
                            <div class="d-flex">
                                <a href="product-detail.php?id=${item.id}" class="cart-item-img-link">
                                    <img src="${item.image}" alt="${item.name}" class="cart-item-img me-3">
                                </a>
                                <div class="flex-grow-1">
                                    <a href="product-detail.php?id=${item.id}" class="cart-item-name">
                                        <h6 class="card-title mb-1">${item.name}</h6>
                                    </a>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="text-danger fw-bold" style="font-size: 16px;">
                                            <span class="text-secondary me-2">SL: ${item.quantity} x</span>${item.price.toLocaleString()} đ
                                        </div>
                                        <div class="text-danger fw-bold" style="font-size: 16px;">
                                            ${(item.price * item.quantity).toLocaleString()} đ
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <button class="btn btn-outline-danger decrease-qty" type="button" data-id="${item.id}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center item-qty" value="${item.quantity}" 
                                                   data-id="${item.id}" min="1" max="${maxStock}" 
                                                   style="border-color: #dc3545 !important; box-shadow: none !important;">
                                            <button class="btn btn-outline-danger increase-qty" type="button" data-id="${item.id}" 
                                                   ${item.quantity >= maxStock ? 'disabled' : ''} 
                                                   style="${item.quantity >= maxStock ? 'opacity: 0.25; cursor: not-allowed;' : ''}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <button class="btn btn-sm text-danger remove-item ms-3" data-id="${item.id}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    ${maxStock < 10 ? `<small class="text-muted mt-1 d-block">Còn ${maxStock} "${item.name}" trong kho</small>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $('#cartItems').html(cartItemsHtml);
    };

    // Function to remove items from cart
    const removeFromCart = (itemId) => {
        const itemIndex = cart.items.findIndex(item => item.id === itemId);
        if (itemIndex !== -1) {
            const item = cart.items[itemIndex];
            cart.items.splice(itemIndex, 1);
            updateCartSummary();
            renderCartItems(); // We need to re-render the entire cart when removing items
            saveCartToLocalStorage();
            showToast(`Đã xóa "${item.name}" khỏi giỏ hàng`, {
                type: 'success',
                title: 'Giỏ hàng'
            });
        }
    };

    // Function to update item quantity
    const updateItemQuantity = (itemId, change) => {
        const item = cart.items.find(item => item.id === itemId);
        if (item) {
            const book = allBooks.find(b => b.id === itemId);
            const maxStock = book ? book.stock : 99;

            const newQty = item.quantity + change;
            if (newQty > 0 && newQty <= maxStock) {
                item.quantity = newQty;
                updateCartSummary();
                updateCartItemUI(itemId, newQty); // Update only the relevant parts of the UI
                saveCartToLocalStorage();
            } else if (newQty > maxStock) {
                showToast(`Chỉ còn ${maxStock} "${book ? book.name : 'sản phẩm này'}" trong kho`, {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
            } else if (newQty <= 0) {
                removeFromCart(itemId);
            }
        }
    };

    // Function to set item quantity directly
    const setItemQuantity = (itemId, quantity) => {
        const item = cart.items.find(item => item.id === itemId);
        if (item) {
            const book = allBooks.find(b => b.id === itemId);
            const maxStock = book ? book.stock : 99;

            // Handle invalid quantity input (empty, NaN, or contains non-numeric characters)
            if (quantity === '' || isNaN(quantity) || !/^\d+$/.test(String(quantity))) {
                // Reset to current quantity in data model
                updateCartItemUI(itemId, item.quantity);
                showToast('Vui lòng nhập số lượng hợp lệ', {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
                return;
            }

            // Convert to integer if it's a valid number string
            quantity = parseInt(quantity);

            // Handle zero stock case
            if (maxStock <= 0) {
                removeFromCart(itemId);
                showToast(`Sản phẩm "${book ? book.name : 'này'}" đã hết hàng và đã được xóa khỏi giỏ hàng`, {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
                return;
            }

            if (quantity > 0 && quantity <= maxStock) {
                item.quantity = quantity;
                updateCartSummary();
                updateCartItemUI(itemId, quantity);
                saveCartToLocalStorage();
            } else if (quantity > maxStock) {
                item.quantity = maxStock;
                updateCartSummary();
                updateCartItemUI(itemId, maxStock);
                saveCartToLocalStorage();
                showToast(`Chỉ còn ${maxStock} "${book ? book.name : 'sản phẩm này'}" trong kho`, {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
            } else if (quantity <= 0) {
                removeFromCart(itemId);
            }
        }
    };

    // Function to add items to cart - global scope for accessibility from other functions
    window.addToCart = (book, skipNotification = false) => {
        // Check if item already exists in cart
        const existingItem = cart.items.find(item => item.id === book.id);

        // Check current stock
        const currentStock = book.stock || 0;

        // Explicitly check for zero stock
        if (currentStock <= 0) {
            if (!skipNotification) {
                showToast(`Rất tiếc, sách "${book.name}" đã hết hàng`, {
                    type: 'error',
                    title: 'Giỏ hàng'
                });
            }
            return false; // Item was not added
        }

        if (existingItem) {
            // Check if adding one more would exceed stock
            if (existingItem.quantity >= currentStock) {
                if (!skipNotification) {
                    showToast(`Đã đạt giới hạn tồn kho của sách "${book.name}"`, {
                        type: 'error',
                        title: 'Giỏ hàng'
                    });
                }
                return false; // Item was not added
            }
            existingItem.quantity++;

            // If the cart is open, update the item in the UI
            if ($('#cartOffcanvas').hasClass('show')) {
                updateCartItemUI(book.id, existingItem.quantity);
            }
        } else {
            cart.items.push({
                id: book.id,
                name: book.name,
                price: parseFloat(book.price.toString().replace(/[^\d]/g, '')),
                quantity: 1,
                image: book.image
            });

            // If cart is open, we need to re-render to show the new item
            if ($('#cartOffcanvas').hasClass('show')) {
                renderCartItems();
            }
        }

        // Update cart summary and badge
        updateCartSummary();

        // Save cart to localStorage
        saveCartToLocalStorage();

        // Show notification unless skipNotification is true
        if (!skipNotification) {
            showToast(`Đã thêm "${book.name}" vào giỏ hàng`, {
                type: 'success',
                title: 'Giỏ hàng'
            });
        }

        return true; // Item was successfully added
    };

    // Load cart from localStorage on page load
    loadCartFromLocalStorage();

    // Show cart when clicking cart button
    $('.cart-btn').on('click', (e) => {
        e.preventDefault();
        renderCartItems();
        cartOffcanvas.show();
    });

    // Event delegation for cart item controls
    $(document).on('click', '.remove-item', function () {
        const itemId = parseInt($(this).data('id'));
        removeFromCart(itemId);
    });

    // Add quantity control event handlers with event delegation
    $(document).on('click', '.increase-qty', function () {
        const itemId = parseInt($(this).data('id'));
        updateItemQuantity(itemId, 1);
    });

    $(document).on('click', '.decrease-qty', function () {
        const itemId = parseInt($(this).data('id'));
        updateItemQuantity(itemId, -1);
    });

    $(document).on('change', '.item-qty', function () {
        const itemId = parseInt($(this).data('id'));
        const newQty = $(this).val(); // Get raw value to handle empty or non-numeric inputs
        // const maxStock = parseInt($(this).attr('max'));

        // Handle quantity changes - setItemQuantity will now validate the input
        setItemQuantity(itemId, newQty);
    });

    // Clear entire cart
    $('#clearCart').on('click', () => {
        // Show confirmation dialog
        showSweetAlert('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?', {
            icon: 'warning',
            title: 'Xóa giỏ hàng',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            focusConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                cart.items = [];
                updateCartSummary();
                renderCartItems();
                saveCartToLocalStorage();
                showToast('Đã xóa toàn bộ giỏ hàng', {
                    type: 'success',
                    title: 'Giỏ hàng'
                });
            }
        });
    });

    // Handle checkout button click
    $('#checkoutBtn').on('click', () => {
        // Redirect to checkout page
        window.location.href = 'checkout.php';
    });

    // Check stock levels of items in cart on page load
    // This ensures out-of-stock items are removed from cart
    const checkStockLevels = () => {
        let removedItems = [];

        // Create a copy of the array to safely iterate while removing items
        [...cart.items].forEach(item => {
            // Find book in allBooks array
            const book = allBooks.find(b => b.id === item.id);

            // Remove item if book no longer exists or is out of stock
            if (!book || book.stock <= 0) {
                // Remove item from cart
                const itemIndex = cart.items.findIndex(i => i.id === item.id);
                if (itemIndex !== -1) {
                    const removedItem = cart.items.splice(itemIndex, 1)[0];
                    removedItems.push(removedItem.name);
                }
            } else if (book && item.quantity > book.stock) {
                // Adjust quantity if it exceeds current stock
                item.quantity = book.stock;
            }
        });

        // Update cart if any items were removed
        if (removedItems.length > 0) {
            updateCartSummary();
            saveCartToLocalStorage();

            if (removedItems.length === 1) {
                showToast(`Sản phẩm "${removedItems[0]}" đã hết hàng và đã được xóa khỏi giỏ hàng`, {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
            } else if (removedItems.length > 1) {
                showToast(`${removedItems.length} sản phẩm đã hết hàng và đã được xóa khỏi giỏ hàng`, {
                    type: 'warning',
                    title: 'Giỏ hàng'
                });
            }
        }
    };

    // Check stock levels after loading cart
    checkStockLevels();
});

/**
 * Cập nhật giỏ hàng dựa trên dữ liệu lưu trữ cục bộ
 */
const updateCartInterface = () => {
    // Get cart items from localStorage
    const savedCart = localStorage.getItem('cart');
    let cartCount = 0;

    if (savedCart) {
        try {
            const parsedData = JSON.parse(savedCart);

            if (Array.isArray(parsedData)) {
                // Count total items in cart
                cartCount = parsedData.reduce((total, item) => total + item.quantity, 0);
            } else if (parsedData && typeof parsedData === 'object' && Array.isArray(parsedData.items)) {
                // Old format support
                cartCount = parsedData.items.reduce((total, item) => total + item.quantity, 0);
            }
        } catch (error) {
            console.error('Error parsing cart data:', error);
        }
    }

    // Update cart count in the UI
    document.querySelectorAll('.cart-count').forEach(badge => {
        badge.textContent = cartCount;
    });
};

