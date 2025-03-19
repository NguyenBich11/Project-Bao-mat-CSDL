<?php
session_start();
    $act = isset($_GET['act']) ? $_GET['act'] : 'danhSachSV';

    switch($act) {
        case 'themSV': include("View/ThemSV.php"); break;
        case 'chinhSuaSV': include("View/ChinhSuaSV.php"); break; 
        // case 'xoaSV': include("View/xoaSV.php"); break; 
        case 'logout': include("View/Logout.php"); break;
        default: include("View/DanhSachSV.php"); break;
    }
?>
