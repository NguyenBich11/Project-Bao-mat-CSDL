<?php
include("../Model/mUser.php");  
    class cUser{
        public function login($userName, $password) {
            $p = new mUser();
            $passw = md5($password);// cách để mã hóa 
            $tblUser = $p->login($userName, $passw);
            if(!$tblUser){
                echo "<script>alert('Lỗi kết nối!')</script>";
            }elseif($tblUser->num_rows > 0){
                $_SESSION['user'] = $userName;
                header("Location: ../index.php");
                exit(); // Kết thúc script để tránh lỗi
            } else {
                echo "<script>alert('Sai thông tin đăng nhập!')</script>";
            }
        }

        public function register($stdName, $userName, $password) {
            $p = new mUser();
            $passw = md5($password);// cách để mã hóa 
            $tblUser = $p->register($stdName, $userName, $passw);
            if($tblUser == 2){
                echo "<script>alert('Tài khoản đã tồn tại')</script>";
            } else if($tblUser == 5){
                echo "<script>alert('Lỗi kết nối!')</script>";
            }
            else if($tblUser == 3){
                echo "<script>alert('Đăng ký thành công!')</script>";
            } else {
                echo "<script>alert('Không thể thêm tài khoản! ')</script>";
            }
        }
    }
?>