<?php 
    include_once("Model/mStudent.php");  
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

        public function getStudents($mssv) {
            $p = new clsStudent();
            $result = $p->getStudents($mssv);
        
            if ($result == 3) {
                return $result;
            } else {
                header("Location: index.php?act=danhSachSV&status=error_db"); // Lỗi CSDL
            }
        }
        
        public function getAllStudents() {
            $p = new clsStudent();
            $rsGet = $p->getAllStudents(); // Lấy danh sách sinh viên từ Model

            if($rsGet) {
                return $rsGet;
            }else {
                header("Location: index.php");
            }
        }

        public function deleteStudent($mssv) {
            $p = new clsStudent();
            $result = $p->mdeleteStudent($mssv);
        
            if ($result == 1) {
                return 1; // Lỗi kết nối
            } else if ($result == 2) {
                return 2; // Không có thông tin
            } else if ($result == 3) {
                return 3; // Xóa thành công
            } else if ($result == 4) {
                return 4; // Không tìm thấy MSSV
            }
        }

        public function getAllStudentsByID($mssv) {
            $p = new clsStudent();
            $rsGet = $p->mgetStudentById($mssv); // Lấy danh sách sinh viên từ Model

            if($rsGet) {
                return $rsGet;
            }else {
                header("Location: index.php");
            }
        }
    }
?>
