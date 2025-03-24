<?php
include("Controller/cStudent.php");

if (isset($_GET['mssv'])) {
    $mssv = $_GET['mssv'];
    $studentController = new cStudent();
    $result = $studentController->deleteStudent($mssv);
    
    if ($result) {
        header("Location: index.php?act=danhSachSV&status=delete_success");
    } else {
        header("Location: index.php?act=danhSachSV&status=delete_error");
    }
    exit();
} else {
    header("Location: index.php?act=danhSachSV&status=error");
    exit();
}
?>