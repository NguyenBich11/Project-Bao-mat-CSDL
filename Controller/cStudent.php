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

        public function cUpdateStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN, $diemToanCC, $diemAV, $diemKTLT) {
            $p = new clsStudent();
            $rsUpdate = $p->mUpdateStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN, $diemToanCC, $diemAV, $diemKTLT);

            if($rsUpdate){
                return true;
            }else {
                return false;
            }
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
                return null;
                // header("Location: index.php");
            }
        }

        public function deleteStudent($mssv) {
            $p = new clsStudent();
            $result = $p->mdeleteStudent($mssv);
        
            if ($result == 3) {
                return true;
            } else {
                return null;
            }
        }

        public function getAllStudentsByID($mssv) {
            $p = new clsStudent();
            $rsGet = $p->mgetStudentById($mssv); // Lấy danh sách sinh viên từ Model

            if($rsGet) {
                return $rsGet;
            }else {
                return null;
                // header("Location: index.php");
            }
        }

        public function cSearch($mssv) {
            $p = new clsStudent($mssv);
            $rs = $p->mSearch($mssv);

            if($rs) {
                return $rs;
            }else {
                return null;
            }
        }
    }
?>