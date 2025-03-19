<?php 
    // header('Content-Type: application/json'); // Bắt buộc JSON
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mssv'])) {
        $mssv = $_POST['mssv'];
    
        include("Controller/cStudent.php");
        $p = new cStudent();
        $result = $p->deleteStudent($mssv);
    
        if ($result == 3) {
            echo json_encode(["status" => "success", "message" => "Xóa thành công!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Xóa thất bại!"]);
        }
        exit(); // Ngăn chặn lỗi khác in ra ngoài JSON
    } else {
        echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
        exit();
    }    
?>
