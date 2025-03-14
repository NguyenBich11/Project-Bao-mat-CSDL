<?php 
    include("Model/mStudent.php");  
    class cStudent{
        public function addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN, $diemToanCC, $diemAV, $diemKTLT) {
            $p = new clsStudent();
            $tblSinhvien = $p->addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN, $diemToanCC, $diemAV, $diemKTLT);

            if($tblSinhvien == 2){
                header("Location: index.php?act=themSV&status=exist");// MSSV đã tồn tại
            } else if($tblSinhvien == 5){
                header("Location: index.php?act=themSV&status=error_db");
            }
            else if($tblSinhvien == 3){
                header("Location: index.php?act=themSV&status=success"); // Thêm SV thành công
            } else {
                header("Location: index.php?act=themSV&status=fail");// Không thể thêm SV
            }
        }

        public function updateStudent() {

        }
        
        public function getStudents() {
            $p = new clsStudent();
            $rsGet = $p->getStudents(); // Lấy danh sách sinh viên từ Model

            if($rsGet) {
                return $rsGet;
            }else {
                header("Location: index.php");
            }
        }

        public function deleteStudent($mssv) {
            $p = new clsStudent();
            $result = $p->deleteStudent($mssv);
        
            if ($result == 3) {
                echo "<script>
                    showAlert('Xóa sinh viên thành công!', 'warning');
                    setTimeout(2000);
                </script>"; // Xóa thành công
            } else {
                header("Location: index.php?act=danhSachSV&status=error_db"); // Lỗi CSDL
            }
            // header('Location: index.php');
            // exit();
        }
    }
?>
