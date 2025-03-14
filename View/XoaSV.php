<?php
include("Controller/cStudent.php");

if (isset($_GET['mssv'])) {
    $mssv = $_GET['mssv'];
    $studentController = new cStudent();
    $studentController->deleteStudent($mssv);
    header("Location: index.php");
} else {
    header("Location: index.php?act=danhSachSV&status=error");
    exit();
}
?>
