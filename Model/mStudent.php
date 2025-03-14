<?php 
    include("mConnect.php");
    include("mAES.php");
    class clsStudent{
        public function addStudent($mssv, $hoTen, $ngaySinh, $gioiTinh, $lopDN, $diemToanCC, $diemAV, $diemKTLT) {
            $p = new clsConnect();
            $conn = $p->mOpen();

            if (!$conn) {
                return 5; // Lỗi kết nối
            }
            try {
                // Kiểm tra xem MSSV đã tồn tại chưa
                $queryCheckmssv = "SELECT mssv FROM sinhvien WHERE mssv = '$mssv'";
                $resultCheck = $conn->query($queryCheckmssv);
                $key = 'mot_khoa_16_byte';
                $aes = new AesCtr($key);
                if ($resultCheck->num_rows > 0) {
                    return 2; // MSSV đã tồn tại
                } else {
                    $mssvMaHoa = $aes->encrypt($mssv, $key, 128);
                    $diemTCCMaHoa = $aes->encrypt($diemToanCC, $key, 128);
                    $diemAVMaHoa = $aes->encrypt($diemAV, $key, 128);
                    $diemKTLTMaHoa = $aes->encrypt($diemKTLT, $key, 128);

                    // Thêm sinh viên mới 
                    $queryAddStd = "INSERT INTO sinhvien (mssv, hoten, ngaysinh, gioitinh, lopdanhnghia) VALUES ('$mssvMaHoa', '$hoTen', '$ngaySinh', '$gioiTinh', '$lopDN')";
                    $rsAddSstudent = $conn->query($queryAddStd);
                    
                    // Thêm điểm
                    $diemTB = ($diemToanCC + $diemAV + $diemKTLT) / 3;
                    $diemTBMaHoa = $aes->encrypt($diemTB, $key, 128);
                    $queryAddDiem = "INSERT INTO diem (mssv, toancaocap, anhvan, kythuatlt, diemtb) VALUES ('$mssvMaHoa', '$diemTCCMaHoa', '$diemAVMaHoa', '$diemKTLTMaHoa', '$diemTBMaHoa')";
                    $rsAddDiem = $conn->query($queryAddDiem);
            
                    // Kiểm tra thành công 
                    if ($rsAddSstudent) {
                        if ($rsAddDiem) {
                            return 3; // Thêm sinh viên và điểm thành công
                        } else {
                            return 4; // Lỗi khi thêm điểm
                        }
                    } else {
                        return 4; // Lỗi khi thêm sinh viên
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
                $key = 'mot_khoa_16_byte';
                $aes = new AesCtr($key);
                $query = "SELECT sv.mssv, sv.hoten, sv.ngaysinh, sv.gioitinh, sv.lopdanhnghia, diem.diemtb
                            FROM sinhvien as sv join diem as diem on 
                            sv.mssv = diem.mssv";
                $result = $conn->query($query);

                if(!$result) {
                    return 4; //không có thông tin
                }

                $students = [];
    
                while ($row = $result->fetch_assoc()) {
                    $mssvDecrypted = $aes->decrypt($row['mssv'], $key, 128);
                    $diemtbDecrypted = $aes->decrypt($row['diemtb'], $key, 128);
                
                    if ($mssvDecrypted !== false && $diemtbDecrypted !== false) {
                        $students[] = [
                            'mssv' => strval($mssvDecrypted),
                            'hoten' => $row['hoten'],
                            'ngaysinh' => $row['ngaysinh'],
                            'gioitinh' => $row['gioitinh'],
                            'lopdanhnghia' => $row['lopdanhnghia'],
                            'diemtb' => round(floatval($diemtbDecrypted), 1) // Chuyển về số
                        ];
                    } else {
                        error_log("Giải mã thất bại! MSSV: " . $row['mssv']);
                    }
                }

                return $students; // Trả về danh sách đầy đủ
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
