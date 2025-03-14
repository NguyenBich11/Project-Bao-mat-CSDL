<style>
    .content {
        /*margin-left: 260px; */
        padding: 20px;
    }

    .table th, .table td {
        text-align: center;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        padding: 6px; 
        font-size: 15px;
    }

    .btn-action {
        background-color: #ffc107;
        color: black;
        border: none;
        font-size: 15px;
        padding: 4px 8px;
        border-radius: 5px;
        margin: 0 2px;
    }

    .serach-input input, .serach-input button {
        font-size: 1.2rem;
    }

    form {
        margin: 0 6px;
    }
</style>

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

// Lấy danh sách sinh viên từ controller
include_once("Controller/cStudent.php");
$studentController = new cStudent();
$studentList = $studentController->getStudents();
?>

<!-- Main Content -->
<div class="content col-10">
    <!-- ... các phần code hiện có ... -->

    <h2 class="text-center mb-3"><b>DANH SÁCH SINH VIÊN</b></h2>
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
                <th>Điểm số</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Lấy danh sách sinh viên từ database
            include_once("Model/clsStudent.php");
            $student = new clsStudent();
            $result = $student->getStudents(); // Bạn cần thêm method này vào class clsStudent
            
            if ($result->num_rows > 0) {
                $stt = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>".$stt++."</td>
                        <td>".$row['mssv']."</td>
                        <td>".$row['hoten']."</td>
                        <td>".$row['ngaysinh']."</td>
                        <td>".$row['gioitinh']."</td>
                        <td>".$row['lop']."</td>
                        <td>".$row['diem']."</td>
                        <td style='display: flex; align-items: center; justify-content: center;'>
                            <form action='index.php' method='GET' name='formXemTTCTSV'>
                                <input type='hidden' name='act' value='xemTTCT'>
                                <input type='hidden' name='mssv' value='".$row['mssv']."'>
                                <button class='btn btn-primary btn-action'><i class='fa-solid fa-eye'></i></button>
                            </form>
                            <form action='index.php' method='GET' name='formChinhSuaSV'>
                                <input type='hidden' name='act' value='chinhSuaSV'>
                                <input type='hidden' name='mssv' value='".$row['mssv']."'>
                                <button class='btn btn-primary btn-action'><i class='fa-solid fa-pen'></i></button>
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
                echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu sinh viên</td></tr>";
            }
            ?>
        </tbody>
    </table>
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