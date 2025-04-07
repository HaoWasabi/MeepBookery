
// Tạo đối tượng EventSource để nhận sự kiện từ server
const eventSource = new EventSource('../../../../app/sse/sse_server.php');

// Lắng nghe sự kiện 'message' từ server
eventSource.onmessage = function (event) {
    // Giải mã dữ liệu JSON từ server
    const product = JSON.parse(event.data);
    console.log('Received new product:', product);

    // Hiển thị sản phẩm mới trong giao diện người dùng
    const productList = document.getElementById('product-list');
    const newProductDiv = document.createElement('div');
    newProductDiv.innerHTML = `<p><strong>${product.productName}</strong> (ID: ${product.productId}) - Time: ${new Date(product.timestamp * 1000).toLocaleString()}</p>`;
    productList.appendChild(newProductDiv);
};

// Xử lý lỗi nếu có
eventSource.onerror = function (event) {
    console.error('Error occurred:', event);
    eventSource.close();
};