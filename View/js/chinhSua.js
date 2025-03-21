document.getElementById('studentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn chặn form submit mặc định

    // Lấy giá trị từ các trường input
    const studentId = document.getElementById('studentId').value.trim();
    const studentName = document.getElementById('studentName').value.trim();
    const birthDate = document.getElementById('birthDate').value.trim();
    const className = document.getElementById('className').value.trim();

    // Kiểm tra xem các trường có được nhập đầy đủ không
    if (!studentId || !studentName || !birthDate || !className) {
        // Hiển thị modal lỗi nếu thiếu thông tin
        const errorModal = new bootstrap.Modal(document.getElementById('LuuLoi'));
        errorModal.show();
    } else {
        // Nếu đầy đủ thông tin, hiển thị modal thành công
        const successModal = new bootstrap.Modal(document.getElementById('LuuThanhcong'));
        successModal.show();
    }
});

document.getElementById('resetButton').addEventListener('click', function() {
    // Reset form
    document.getElementById('studentForm').reset();
});