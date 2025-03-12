<?php 
    include("Model/mStudent.php");  
    class cStudent{
        public function addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN) {
            $p = new clsStudent();
            $tblSinhvien = $p->addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN);
            if($tblSinhvien == 2){
                header("Location: index.php?act=themSV&status=exist");// MSSV đã tồn tại
            } else if($tblSinhvien == 5){
                // echo "<script>alert('Lỗi kết nối!')</script>";
                header("Location: index.php?act=themSV&status=error_db");
            }
            else if($tblSinhvien == 3){
                header("Location: index.php?act=themSV&status=success");// Thêm SV thành công
            } else {
                // echo "<script>alert('Không thể thêm sinh viên!')</script>";
                header("Location: index.php?act=themSV&status=fail");// Không thể thêm SV
            }
        }

        public function updateStudent() {

        }

        public function insertStudent() {
            public function insertStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN) {
        $p = new clsConnect();
        $result = $p->insertStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN);

        if ($result == "MSSV đã tồn tại!") {
            header("Location: index.php?act=themSV&status=exist"); // MSSV đã tồn tại
        } else if ($result == "Danh sách sinh viên!") {
            header("Location: index.php?act=themSV&status=success"); // Thêm SV thành công
        } else {
            header("Location: index.php?act=themSV&status=fail"); // Không thể thêm SV
        }
    }

        }

        public function deleteStudent() {
            
        }
    }
?>
