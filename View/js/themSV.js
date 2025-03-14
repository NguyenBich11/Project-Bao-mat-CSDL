document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const status = params.get("status");

    if (status === "success") {
        showModalAndRemoveStatus('LuuThanhcong');
    } else if (status === "fail") {
        showModalAndRemoveStatus('LuuLoi');
    } else if (status === "error_db") {
        showModalAndRemoveStatus('LoiKetNoi');
    } else if (status === "exist") {
        showModalAndRemoveStatus('TonTai');
    }

    function showModalAndRemoveStatus(modalId) {
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();

        // Lắng nghe sự kiện đóng modal
        document.getElementById(modalId).addEventListener('hidden.bs.modal', function () {
            // Loại bỏ tham số status khỏi URL
            removeStatusFromUrl();
        });
    }

    function removeStatusFromUrl() {
        const params = new URLSearchParams(window.location.search);
        params.delete('status'); // Xóa tham số status

        // Tạo URL mới mà không có tham số status
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');

        // Thay đổi URL mà không tải lại trang
        window.history.replaceState({}, document.title, newUrl);
    }

});

document.getElementById('studentForm').addEventListener('submit', function(event) {
    // event.preventDefault(); // Ngăn chặn form submit mặc định

    // Lấy giá trị từ các trường input
    const studentId = document.getElementById('studentId').value.trim();
    const studentName = document.getElementById('studentName').value.trim();
    const birthDate = document.getElementById('birthDate').value.trim();
    const className = document.getElementById('className').value.trim();

    // Kiểm tra xem các trường có được nhập đầy đủ không
    if (!studentId || !studentName || !birthDate || !className) {
        event.preventDefault(); // Ngăn form submit nếu thiếu thông tin
        // Hiển thị modal lỗi nếu thiếu thông tin
        const errorModal = new bootstrap.Modal(document.getElementById('LuuLoi'));
        errorModal.show();
    } else {
        // Nếu đầy đủ thông tin, hiển thị modal thành công
        // const successModal = new bootstrap.Modal(document.getElementById('LuuThanhcong'));
        // successModal.show();
        // return true;
    }
});

document.getElementById('resetButton').addEventListener('click', function() {
    // Reset form
    document.getElementById('studentForm').reset();
});