<?php 
    include_once("mConnect.php");
    include_once("mAES.php");

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

        public function getStudents($mssv) {
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
            
                // xem sinh viên
                $query = "Select * FROM sinhvien WHERE mssv = '$mssv'";
                $tblStudent = $conn->query($query);
                if ($tblStudent) {
                    return 3; // có sinh viên
                } else {
                    return 4; // không có sinh viên
                }

            }finally {
                $p->mClose($conn);
            }
        }
        
        public function getAllStudents() {
            $p = new clsConnect();
            $conn = $p->mOpen();

            if(!$conn) {
                return 5; // lỗi kết nối
            }

            try {
                $key = 'mot_khoa_16_byte';
                $aes = new AesCtr($key);
                $query = "SELECT sv.mssv, sv.hoten, sv.ngaysinh, sv.gioitinh, sv.lopdanhnghia, 
                            diem.toancaocap, diem.anhvan, diem.kythuatlt, diem.diemtb
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
                    $diemToanDecrypted = $aes->decrypt($row['toancaocap'], $key, 128);
                    $diemAnhvanDecrypted = $aes->decrypt($row['anhvan'], $key, 128);
                    $diemKTLTDecrypted = $aes->decrypt($row['kythuatlt'], $key, 128);
                
                    if ($mssvDecrypted !== false && $diemtbDecrypted !== false) {
                        $students[] = [
                            'mssv' => strval($mssvDecrypted),
                            'hoten' => $row['hoten'],
                            'ngaysinh' => $row['ngaysinh'],
                            'gioitinh' => $row['gioitinh'],
                            'lopdanhnghia' => $row['lopdanhnghia'],
                            'toancaocap' => round(floatval($diemToanDecrypted), 1),
                            'anhvan' => round(floatval($diemAnhvanDecrypted), 1),
                            'kythuatlt' => round(floatval($diemKTLTDecrypted), 1),
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
        public function mdeleteStudent($mssv) {
            $p = new clsConnect();
            $conn = $p->mOpen();

            if (!$conn) {
                return 1; // Lỗi kết nối
            }

            try {
                $key = 'mot_khoa_16_byte';
                $aes = new AesCtr($key);
                $query = "SELECT mssv FROM sinhvien";
                $result = $conn->query($query);

                if(!$result) {
                    return 2; //không có thông tin
                }
    
                while ($row = $result->fetch_assoc()) {
                    $mssvDecrypted = $aes->decrypt($row['mssv'], $key, 128);
                   
                    // Kiểm tra nếu MSSV trong DB (sau khi giải mã) trùng với MSSV truyền vào
                    if ($mssvDecrypted === $mssv) {
                        // Thực hiện xóa nếu cần
                        $queryDeleteDiem = "DELETE FROM diem WHERE mssv = '{$row['mssv']}'";
                        $conn->query($queryDeleteDiem);

                        $queryDeleteSinhVien = "DELETE FROM sinhvien WHERE mssv = '{$row['mssv']}'";
                        $conn->query($queryDeleteSinhVien);

                        return 3; // Xóa thành công
                    }
                }
                return 4;
            } finally {
                $p->mClose($conn); // Đảm bảo đóng kết nối
            }
        }

        public function mgetStudentById($mssv) {
            $p = new clsConnect();
            $conn = $p->mOpen();
        
            if (!$conn) {
                return null; // Lỗi kết nối
            }
        
            try {
                $key = 'mot_khoa_16_byte';
                $aes = new AesCtr($key);
                $query = "SELECT mssv FROM sinhvien";
                $result = $conn->query($query);
        
                while($row = $result->fetch_assoc()) {
                    $mssvDecrypted = $aes->decrypt($row['mssv'], $key, 128);
                    
                    if ($mssvDecrypted !== $mssv) {
                        $diemtbDecrypted = $aes->decrypt($row['diemtb'], $key, 128);
                        $diemToanDecrypted = $aes->decrypt($row['toancaocap'], $key, 128);
                        $diemAnhvanDecrypted = $aes->decrypt($row['anhvan'], $key, 128);
                        $diemKTLTDecrypted = $aes->decrypt($row['kythuatlt'], $key, 128);
                        $students[] = [
                            'mssv' => strval($mssvDecrypted),
                            'hoten' => $row['hoten'],
                            'ngaysinh' => $row['ngaysinh'],
                            'gioitinh' => $row['gioitinh'],
                            'lopdanhnghia' => $row['lopdanhnghia'],
                            'toancaocap' => round(floatval($diemToanDecrypted), 1),
                            'anhvan' => round(floatval($diemAnhvanDecrypted), 1),
                            'kythuatlt' => round(floatval($diemKTLTDecrypted), 1),
                            'diemtb' => round(floatval($diemtbDecrypted), 1) // Chuyển về số
                        ];
                    }
                }
                return null; // Không tìm thấy sinh viên
            } finally {
                $p->mClose($conn);
            }
        }        
    }
?>
