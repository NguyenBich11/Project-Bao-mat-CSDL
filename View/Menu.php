<?php
    $activePage = isset($_GET['act']) ? $_GET['act'] : 'danhSachSV'; // Mặc định là danhSachSV
?>
<!-- Sidebar -->
<div class="sidebar col-2" id="sidebar">
    <div class="brand"><?php echo $_SESSION['user']; ?></div>

    <a href="index.php?act=danhSachSV" class="menu-item <?php echo ($activePage == 'danhSachSV') ? 'active' : ''; ?>">
        <i class="fa-solid fa-list"></i> Danh sách sinh viên
    </a>
    <a href="index.php?act=themSV" class="menu-item <?php echo ($activePage == 'themSV') ? 'active' : ''; ?>">
        <i class="fa-solid fa-user-plus"></i> Thêm sinh viên
    </a>
</div>