<?php
ob_start();
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/css/base.css">
    <link rel="stylesheet" href="View/css/main.css">
    <link rel="stylesheet" href="View/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Hệ thống quản lý sinh viên</title>
</head>
<body>
<div class="container-fluid d-flex justify-content-center align-items-center">
    <div class="card">
        <h3 class="text-center text-dark fw-bold" id="form-title">Đăng nhập</h3>
        <form action="#" name="formLogin" id="login-form" method="POST">
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" name="txtUserName" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" name="txtPassword" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold" name="btnLogin">Đăng nhập</button>
            <p class="text-center mt-3">
                Chưa có tài khoản? <a href="#" class="text-primary fw-bold" id="toggle-form">Đăng ký</a>
            </p>
        </form>
        <form action="#" id="register-form" name="formRegister" class="d-none" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ và Tên</label>
                <input type="text" class="form-control" name="txtName" placeholder="Nhập họ và tên" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" name="txtUserName" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="txtPassword" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="repassword" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold" name="btnRegis">Đăng ký</button>
            <p class="text-center mt-3">
                Đã có tài khoản? <a href="#" class="text-primary fw-bold" id="toggle-form-back">Đăng nhập</a>
            </p>
        </form>
    </div>
</div>

</body>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnLogin'])) {
        include("../Controller/cUser.php");
        $p = new cUser();
        $p->login($_POST["txtUserName"], $_POST["txtPassword"]);
    }

    if(isset($_POST["btnRegis"])){
        include("../Controller/cUser.php");
        $p = new cUser();
        $p->register($_POST["txtName"], $_POST["txtUserName"], $_POST["txtPassword"]);
    }
?>