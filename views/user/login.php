<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Nhập & Đăng Ký</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>
    <div class="container">
        <!-- Form Đăng Nhập -->
        <form action="../../controller/xulydnuser.php" method="POST">
            <h2>Đăng Nhập</h2>
            
            <!-- Tên đăng nhập -->
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            
            <!-- Mật khẩu -->
            <input type="password" name="password" placeholder="Mật khẩu" required>
            
            <button type="submit">Đăng Nhập</button>
            
            <p>nếu bạn chưa có tài khoản hãy</p>
            <a href="../user/sigin.php">Đăng kí</a>
        </form>
        
        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
        ?>
    </div>
</body>
</html>
