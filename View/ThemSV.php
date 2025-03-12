<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);    
?>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f8f9fa;
    }
    .form-container {
        font-size: 2.1rem;
    }
    .form-label {
        text-align: right;
    }
    .form-control {
        height: 48px;
        font-size: 1.7rem;
    }
    .button-me {
        width: 148px;
        height: 44px;
        font-size: 1.7rem;
        text-align: center;
        border-radius: 36px;
    }
</style>
<!-- Main Content -->
<div class="col-md-10 d-flex flex-column align-items-center">
    <h2 class="text-center mt-4 mb-4 display-4 fw-bold">THÊM THÔNG TIN SINH VIÊN</h2>
    <div class="content col-md-8">
        <form id="studentForm" action="" method="POST" name="formEdit" class="form-container">
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Mã số sinh viên</label>
                <div class="col-sm-8">
                    <input type="text" id="studentId" name="txtstudentId" class="form-control" placeholder="Nhập mã số sinh viên">
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Họ và tên sinh viên</label>
                <div class="col-sm-8">
                    <input type="text" id="studentName" name="txtstudentName" class="form-control" placeholder="Nhập họ và tên">
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Ngày sinh</label>
                <div class="col-sm-8">
                    <input type="date" id="birthDate" name="dbirthDate" class="form-control">
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Giới tính</label>
                <div class="col-sm-8">
                    <input type="radio" id="genderMale" name="gender" value="Nam" checked> Nam
                    <input type="radio" id="genderFemale" name="gender" value="Nữ" class="ms-3"> Nữ
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Lớp danh nghĩa</label>
                <div class="col-sm-8">
                    <input type="text" id="className" name="txtclassName" class="form-control" placeholder="Nhập lớp danh nghĩa">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-4">
                <button type="reset" id="resetButton" class="button-me btn btn-warning fw-bold text-dark">Đặt lại</button>
                <button type="submit" id="submitButton" class="button-me btn btn-warning fw-bold text-dark" name="btnAddStd">Thêm</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Lỗi! MSSV đã tồn tại -->
<div class="modal fade" id="TonTai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Lỗi! MSSV đã tồn tại!</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lưu thông tin thành công -->
<div class="modal fade" id="LuuThanhcong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Lưu thông tin thành công!</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lỗi kết nối -->
<div class="modal fade" id="LoiKetNoi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold text-danger">Lưu lỗi!</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lỗi! Không thể lưu -->
<div class="modal fade" id="LuuLoi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Lỗi! Nhập đủ các trường thông tin!</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const status = params.get("status");

        if (status === "success") {
            new bootstrap.Modal(document.getElementById('LuuThanhcong')).show();
        } else if (status === "fail") {
            new bootstrap.Modal(document.getElementById('LuuLoi')).show();
        } else if (status === "error_db") {
            new bootstrap.Modal(document.getElementById('LoiKetNoi')).show();
        } else if (status === "exist") {
            new bootstrap.Modal(document.getElementById('TonTai')).show();
        } 
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
</script>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnAddStd'])) {
        include("Controller/cStudent.php");
        $p = new cStudent();
        $p->addStudent($_POST["txtstudentId"], $_POST["txtstudentName"], $_POST["dbirthDate"], $_POST["gender"], $_POST["txtclassName"]);
    }
?>