<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once("Controller/cStudent.php");
?>
<!-- Main Content -->
<div class="col-md-10 d-flex flex-column align-items-center">
    <h2 class="text-center mt-4 mb-4 display-4 fw-bold">CHỈNH SỬA THÔNG TIN SINH VIÊN</h2>
    <div class="content col-md-8">
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mssv'])) {
                    $mssv = $_POST['mssv'];
                    $p = new cStudent();
                    $student = $p->getAllStudentsByID($mssv);

                    if(is_array($student)) {
                        echo '
                        <form action="#" method="POST" name="formEdit" class="form-container">
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Mã số sinh viên</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="act" value="chinhSuaSV">
                                    <input type="hidden" name="txtstudentId" value="'.$student['mssv'].'">
                                    <input type="text" class="form-control" value="'.$student['mssv'].'" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Họ và tên sinh viên</label>
                                <div class="col-sm-8">
                                    <input type="text" id="studentName" name="txtstudentName" value="'.$student['hoten'].'" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Ngày sinh</label>
                                <div class="col-sm-8">
                                    <input type="date" id="birthDate" name="dbirthDate" value="'.$student['ngaysinh'].'" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Giới tính</label>
                                <div class="col-sm-8">
                                    <input type="radio" id="genderMale" name="gender" value="Nam"'.($student['gioitinh'] === 'Nam' ? 'checked' : '').'> Nam
                                    <input type="radio" id="genderFemale" name="gender" value="Nữ" class="ms-3"'.($student['gioitinh'] === 'Nữ' ? 'checked' : '').'> Nữ
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Lớp danh nghĩa</label>
                                <div class="col-sm-8">
                                    <input type="text" id="className" name="txtclassName" value="'.$student['lopdanhnghia'].'" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Điểm toán cao cấp</label>
                                <div class="col-sm-8">
                                    <input type="number" id="classToan" name="diemtoan" class="form-control" min="0" max="10" step="0.1" value="'.$student['toancaocap'].'">
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Điểm Anh văn</label>
                                <div class="col-sm-8">
                                    <input type="number" id="classAV" name="diemanhvan" class="form-control" min="0" max="10" step="0.1" value="'.$student['anhvan'].'">
                                </div>
                            </div>
                            <div class="form-group row mb-4 align-items-center">
                                <label class="col-sm-4 col-form-label text-secondary">Điểm Kỹ thuật lập trình</label>
                                <div class="col-sm-8">
                                    <input type="number" id="classLT" name="diemlaptrinh" class="form-control" min="0" max="10" step="0.1" value="'.$student['kythuatlt'].'">
                                </div>
                            </div>
                        ';
                    }else {
                        echo "<script>alert('Không có sinh viên')</script>";
                    }
                }
            ?>
            <div class="d-flex justify-content-end gap-4">
                <button type="reset" class="button-me btn btn-warning fw-bold text-dark">Đặt lại</button>
                <button type="submit" class="button-me btn btn-warning fw-bold text-dark" name="btnSave">Lưu lại</button>
            </div>
            <?php 
                if(isset($_POST['btnSave'])) {
                    include_once("Controller/cStudent.php");
                    $p = new cStudent();
                    $mssv = $_POST['txtstudentId'];
                    $hoten = $_POST['txtstudentName'];
                    $ngaysinh = $_POST['dbirthDate'];
                    $gioitinh = $_POST['gender'];
                    $lopdanhnghia = $_POST['txtclassName'];
                    $diemtoan = $_POST['diemtoan'];
                    $diemanhvan = $_POST['diemanhvan'];
                    $diemlaptrinh = $_POST['diemlaptrinh'];

                    $rs = $p->cUpdateStudent($mssv, $hoten, $ngaysinh, $gioitinh, $lopdanhnghia, $diemtoan, $diemanhvan, $diemlaptrinh);
                    
                    if ($rs) {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() { 
                                var myModal = new bootstrap.Modal(document.getElementById('LuuThanhcong'));
                                myModal.show();
                                
                                document.getElementById('LuuThanhcong').addEventListener('hidden.bs.modal', function () {
                                    window.location.href = 'index.php';
                                });
                            });
                        </script>";
                    } else {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() { 
                                var myModal = new bootstrap.Modal(document.getElementById('LoiKetNoi')); 
                                myModal.show(); 
                            });
                        </script>";
                    }
                }
            ?>
        </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>