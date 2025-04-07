export const createBookCard = (book) => {
    const isOutOfStock = book.stock === 0;

    return `
        <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
            <div class="book-card ${isOutOfStock ? 'out-of-stock' : ''}">
                ${isOutOfStock ? '<div class="out-of-stock-label">Tạm hết hàng</div>' : ''}
                <div class="book-img-container">
                    <a href="/product-detail?id=${encodeURIComponent(book.id)}" title="${book.name}">
                        <img src="${book.image ? book.image : '../../../img/img-not-available.png'}" class="book-img">
                    </a>
                    ${isOutOfStock ? '<div class="book-img-overlay"></div>' : ''}
                    
                    </div>
                <div class="book-info">
                    <h3 class="book-title">
                        <a href="/product-detail?id=${book.id}" title="${book.name}">${book.name}</a>
                    </h3>
                    <p class="book-category">
                        <a href="/shop?category=${encodeURIComponent(book.category)}" class="category-link">${book.category}</a>
                    </p>
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
