  // Kiểm tra mật khẩu và xác nhận mật khẩu
  document.getElementById('register-form').addEventListener('submit', function(e) {
    password = document.getElementById('password').value;
    repassword = document.getElementById('repassword').value;

    if(password != repassword) {
        e.preventDefault();
        alert("Mật khẩu và xác nhận mật khẩu phải bằng nhau");
    }
});

// Chuyển đổi sang form đăng ký
document.getElementById('toggle-form').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('login-form').classList.add('d-none');
    document.getElementById('register-form').classList.remove('d-none');
    document.getElementById('form-title').innerText = "Đăng ký";
});

// Chuyển sang form đăng nhập
document.getElementById('toggle-form-back').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('register-form').classList.add('d-none');
    document.getElementById('login-form').classList.remove('d-none');
    document.getElementById('form-title').innerText = "Đăng nhập";
});