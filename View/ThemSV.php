<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);    
?>
<!-- Main Content -->
<div class="col-md-10 d-flex flex-column align-items-center">
    <h2 class="text-center mt-4 mb-4 display-4 fw-bold">THÊM THÔNG TIN SINH VIÊN</h2>
    <div class="content col-md-8">
        <form id="studentForm" action="#" method="POST" name="formEdit" class="form-container">
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
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Điểm toán cao cấp</label>
                <div class="col-sm-8">
                    <input type="number" id="classToan" name="diemtoan" class="form-control" placeholder="Nhập điểm toán cao cấp" min="0" max="10" step="0.1">
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Điểm Anh văn</label>
                <div class="col-sm-8">
                    <input type="number" id="classAV" name="diemanhvan" class="form-control" placeholder="Nhập điểm anh văn" min="0" max="10" step="0.1">
                </div>
            </div>
            <div class="form-group row mb-4 align-items-center">
                <label class="col-sm-4 col-form-label text-secondary">Điểm Kỹ thuật lập trình</label>
                <div class="col-sm-8">
                    <input type="number" id="classLT" name="diemlaptrinh" class="form-control" placeholder="Nhập điểm kỹ thuật lập trình" min="0" max="10" step="0.1">
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold text-danger">Lỗi khi lưu thông tin sinh viên!</p>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Lỗi! Không nhập đủ các trường thông tin!</p>
            </div>
        </div>
    </div>
</div>

<?php
   if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnAddStd'])) {
    include("Controller/cStudent.php");
    $p = new cStudent();
    $p->addStudent($_POST["txtstudentId"], $_POST["txtstudentName"], $_POST["dbirthDate"], $_POST["gender"], $_POST["txtclassName"], $_POST["diemtoan"], $_POST["diemanhvan"], $_POST["diemlaptrinh"]);
}
?>
<script src="View/js/themSV.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>