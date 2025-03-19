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
            $result = $student->getAllStudents(); // Bạn cần thêm method này vào class clsStudent
            
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
                            <form action='#' method='GET' name='formChinhSuaSV'>
                                <input type='hidden' name='act' value='chinhSuaSV'>
                                <input type='hidden' name='mssv' value='".$row['mssv']."'>
                                <button class='btn btn-primary btn-action'><i class='fa-solid fa-pen'></i></button>
                            </form>
                            <button 
                            data-id='".$row['mssv']."'
                            class=\"btn btn-primary btn-action btn-delete\">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="View/js/xoaSV.js"></script> -->