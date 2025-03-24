<?php
// Kiểm tra và hiển thị thông báo dựa trên status
if(isset($_GET['status'])) {
    $status = $_GET['status'];
    $modalId = '';
    
    switch($status) {
        case 'not_exist':
        case 'error_db':
            $modalId = 'Loixoa';
            break;
    }
    
    if(!empty($modalId)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('$modalId'));
                myModal.show();
            });
        </script>";
    }
}
?>

<!-- Main Content -->
<div class="content col-10">
    <!-- ... các phần code hiện có ... -->

    <h2 class="text-center mb-3"><b>DANH SÁCH SINH VIÊN</b></h2>
    <form name="formSearch" method="GET" class="width-100">
        <input type="hidden" name="act" value="danhSachSV">
        <input type="submit" name="btnSearch" class="btn btn-primary btn-action float-end" value="Tìm kiếm">
        <input type="text" name="inputSearch" class="w-25 p-2 rounded-3 border border-1 fs-4 float-end mb-3" placeholder="Nhập mã số sinh viên cần tìm">
    </form>
    <!-- Bảng danh sách sinh viên -->
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
            <th>STT</th>
                <th>MSSV</th>
                <th>Họ và tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Lớp danh nghĩa</th>
                <th>Điểm Toán cao cấp</th>
                <th>Điểm Anh văn</th>
                <th>Điểm KTLT</th>
                <th>Điểm trung bình</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Lấy danh sách sinh viên từ database
            include_once("Controller/cStudent.php");
            $student = new cStudent();
            $valueSearch = isset($_GET['inputSearch']) ? $_GET['inputSearch'] : '';

            if(isset($_GET['btnSearch']) && !empty($valueSearch)) {
                $rs = $student->cSearch($valueSearch);
                $stt = 1;
                if(isset($_GET['btnSearch']) && !empty($valueSearch)) {
                    $rs = $student->cSearch($valueSearch);
                    if($rs !== null && is_array($rs)) {  // Check if result is array and not null
                        echo "<tr>";
                        echo "<td>".$stt."</td>";
                        echo "<td>".$rs['mssv']."</td>";
                        echo "<td>".$rs['hoten']."</td>";
                        echo "<td>".$rs['ngaysinh']."</td>";
                        echo "<td>".$rs['gioitinh']."</td>";
                        echo "<td>".$rs['lopdanhnghia']."</td>";
                        echo "<td>".$rs['toancaocap']."</td>";
                        echo "<td>".$rs['anhvan']."</td>";
                        echo "<td>".$rs['kythuatlt']."</td>";
                        echo "<td>".$rs['diemtb']."</td>";
                        echo "<td style='display: flex; align-items: center; justify-content: center;'>
                                <form method='post' action='index.php?act=chinhSuaSV' style='margin-right: 5px;'>
                                    <input type='hidden' name='mssv' value='".$rs['mssv']."'>
                                    <button type='submit' class='btn btn-primary btn-action'>
                                        <i class='fa-solid fa-pen'></i>
                                    </button>
                                </form>
                                <button type='button' class='btn btn-primary btn-action btn-delete' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#confirmModal' 
                                    data-mssv='".$rs['mssv']."'>
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                            </td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>Không tìm thấy sinh viên</td></tr>";
                    
                    }
                }else {
                    echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu sinh viên</td></tr>";
                }
            }else {
                //In ra sinh viên
                $result = $student->getAllStudents();
                            
                if (is_array($result)) {
                    $stt = 1;
                    foreach($result as $key=>$row) {
                        echo "<tr>
                            <td>".$stt++."</td>
                            <td>".$row['mssv']."</td>
                            <td>".$row['hoten']."</td>
                            <td>".$row['ngaysinh']."</td>
                            <td>".$row['gioitinh']."</td>
                            <td>".$row['lopdanhnghia']."</td>
                            <td>".$row['toancaocap']."</td>
                            <td>".$row['anhvan']."</td>
                            <td>".$row['kythuatlt']."</td>
                            <td>".$row['diemtb']."</td>
                            <td style='display: flex; align-items: center; justify-content: center;'>
                                <form method='post' action='index.php?act=chinhSuaSV' style='margin-right: 5px;'>
                                    <input type='hidden' name='mssv' value='".$row['mssv']."'>
                                    <button type='submit' class='btn btn-primary btn-action'>
                                        <i class='fa-solid fa-pen'></i>
                                    </button>
                                </form>
                                <button type='button' class='btn btn-primary btn-action btn-delete' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#confirmModal' 
                                    data-mssv='".$row['mssv']."'>
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu sinh viên nào</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Xóa thành công -->
<div class="modal fade" id="XoaThanhcong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Xóa sinh viên thành công!</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận Xóa -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Bạn có chắc chắn xóa thông tin không?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-warning btn-lg" data-bs-dismiss="modal">Hủy</button>
                <a id="confirmDelete" href="#" class="btn btn-warning btn-lg">Xác nhận</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lỗi! Không thể xóa -->
<div class="modal fade" id="Loixoa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-bold">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fw-bold">Lỗi! Không thể xóa</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
        // Check for status parameter
        const params = new URLSearchParams(window.location.search);
        const status = params.get("status");

        if (status === "delete_success") {
            const modal = new bootstrap.Modal(document.getElementById('XoaThanhcong'));
            modal.show();
            
            // Remove status parameter after showing modal
            document.getElementById('XoaThanhcong').addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('status');
                window.history.replaceState({}, '', url);
            });
        }

        // Existing delete confirmation code
        let deleteButtons = document.querySelectorAll(".btn-delete");
        let confirmDelete = document.getElementById("confirmDelete");
        
        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                let mssv = this.getAttribute("data-mssv");
                confirmDelete.href = "index.php?act=xoaSV&mssv=" + mssv;
            });
        });
    });
</script>