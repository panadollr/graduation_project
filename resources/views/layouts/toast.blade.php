<style>
.toast-container {
    position: fixed; /* Định vị cố định */
    left: 50%; /* Định vị ở giữa */
    top: 100px; /* Đặt ở phía dưới */
    transform: translateX(-50%); /* Căn giữa theo chiều ngang */
    z-index: 1; /* Đặt nó lên trên cùng */
}

.toast {
    visibility: hidden; /* Ẩn toast ban đầu */
    min-width: 250px;
    margin: 5px 0; /* Khoảng cách giữa các toast */
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 16px;
    opacity: 0; /* Ban đầu không nhìn thấy */
    transition: opacity 0.5s, visibility 0s 0.5s; /* Hiệu ứng chuyển động */
}

.toast.show {
    visibility: visible;
    opacity: 1;
}

.toast.success {
    background-color: #4CAF50; /* Màu xanh cho thành công */
}

.toast.error {
    background-color: #f44336; /* Màu đỏ cho lỗi */
}

.toast.info {
    background-color: #2196F3; /* Màu xanh dương cho thông tin */
}

/* Keyframes for animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

</style>

<script>
function showToast(message, type) {
    const toastContainer = document.getElementById("toast-container");

    // Create a new toast element
    const toast = document.createElement("div");
    toast.className = 'toast show'; // Hiển thị toast

    // Thêm lớp cho loại thông báo
    if (type === 'success') {
        toast.classList.add('success');
    } else if (type === 'error') {
        toast.classList.add('error');
    } else if (type === 'info') {
        toast.classList.add('info');
    }

    // Cập nhật nội dung thông báo
    toast.textContent = message; 
    toastContainer.appendChild(toast); // Thêm toast vào container

    // Hiện thông báo
    setTimeout(() => {
        toast.classList.remove("show"); // Ẩn toast
        toast.classList.remove('success', 'error', 'info'); // Xóa các lớp loại thông báo
    }, 3000);

    // Ẩn toast sau 3 giây
    setTimeout(() => {
        toast.remove(); // Xóa toast khỏi DOM sau khi ẩn
    }, 3500); // Thời gian ẩn + 0.5 giây
}

</script>

<div id="toast-container" class="toast-container"></div>