<?php 
    include("mConnect.php");
    class clsStudent{
        public function addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN) {
            $p = new clsConnect();
            $conn = $p->mOpen();

            // Kiểm tra xem MSSV đã tồn tại chưa
            $queryCheckmssv = "SELECT mssv FROM sinhvien WHERE mssv = '$mssv'";
            $resultCheck = $conn-> query($queryCheckmssv);
            if ($resultCheck->num_rows > 0) {
                return 2; // MSSV đã tồn tại
            } else{
                $queryAddStd = "INSERT INTO sinhvien (mssv, hoten, ngaysinh, gioitinh, lopdanhnghia) 
                                VALUES ('$mssv', '$hoTen', '$ngaySinh', '$gioiTinh', '$lopDN')";
                if($conn){ 
                    $resultAddstd = $conn->query($queryAddStd);
                    if($resultAddstd){
                        return 3; // Thêm SVSV thành công
                    }else{
                        return 4; // Lỗi khi thêm dữ liệu
                    }
                }else{
                    return 5; // Lỗi kết nối
                }
                $p ->mClose($conn);
            }
        }

        public function updateStudent() {

        }

        public function insertStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN) {
            $p = new clsConnect();
            $conn = $p->mOpen();
            // Kiểm tra MSSV đã tồn tại chưa
            $queryCheck = "SELECT mssv FROM sinhvien WHERE mssv = '$mssv'";
            $resultCheck = $conn->query($queryCheck);

            if ($resultCheck->num_rows > 0) {
                return "MSSV đã tồn tại!";
            } else {
                // Nếu MSSV chưa tồn tại, thêm sinh viên
                $queryInsert = "INSERT INTO sinhvien (mssv, hoten, ngaysinh, gioitinh, lopdanhnghia) 
                                VALUES ('$mssv', '$hoTen', '$ngaySinh', '$gioiTinh', '$lopDN')";
                
                if ($conn->query($queryInsert)) {
                    return "Xem danh sách sinh viên !";
                } else {
                    return "Sinh viên không có trong danh sách!";
                }
            }
        }

        public function deleteStudent() {
            
        }
    }
?>
