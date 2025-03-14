<?php 
    include("mConnect.php");
    class clsStudent{
        public function addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN) {
            $p = new clsConnect();
            $conn = $p->mOpen();

            if (!$conn) {
                return 5; // Lỗi kết nối
            }

            try {
                // Kiểm tra xem MSSV đã tồn tại chưa
                $queryCheckmssv = "SELECT mssv FROM sinhvien WHERE mssv = '$mssv'";
                $resultCheck = $conn->query($queryCheckmssv);
        
                if ($resultCheck->num_rows > 0) {
                    return 2; // MSSV đã tồn tại
                } else {
                    // Thêm sinh viên mới (sử dụng prepared statement)
                    $queryAddStd = "INSERT INTO sinhvien (mssv, hoten, ngaysinh, gioitinh, lopdanhnghia) 
                                    VALUES ('$mssv', '$hoTen', '$ngaySinh', '$gioiTinh', '$lopDN')";
                    $rsAddSstudent = $conn->query($queryAddStd);

                    if ($rsAddSstudent) {
                        return 3; // Thêm sinh viên thành công
                    } else {
                        return 4; // Lỗi khi thêm dữ liệu
                    }
                }
            } finally {
                $p->mClose($conn); // Đảm bảo đóng kết nối
            }
        }
        
        public function updateStudent() {

        }
        
        public function getStudents() {
            $p = new clsConnect();
            $conn = $p->mOpen();

            if(!$conn) {
                return 5; // lỗi kết nối
            }

            try {
                $query = "SELECT * FROM sinhvien ORDER BY mssv";
                $result = $conn->query($query);

                if($result) {
                    return $result; // lấy thông tin thành công
                }else {
                    return 4; //không có thông tin
                }
            }finally {
                $p->mClose($conn); // Đảm bảo đóng kết nối
            }
        }

        // Phương thức xóa sinh viên
        public function deleteStudent($mssv) {
            $p = new clsConnect();
            $conn = $p->mOpen(); // Mở kết nối

            if(!$conn) {
                return 5; //lỗi kết nối
            }
        
            try{
                // Kiểm tra xem sinh viên có tồn tại không
                $checkQuery = "SELECT mssv FROM sinhvien WHERE mssv = '$mssv'";
                $result = $conn->query($checkQuery);
            
                if ($result->num_rows == 0) {
                    return 2; // MSSV không tồn tại
                }
            
                // Xóa sinh viên
                $query = "DELETE FROM sinhvien WHERE mssv = '$mssv'";
                $deleteQuerry = $conn->query($query);
                if ($deleteQuerry) {
                    return 3; // Xóa thành công
                } else {
                    return 4; // Không xóa được 
                }

            }finally {
                $p->mClose($conn);
            }
        }
    }
?>
