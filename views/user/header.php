<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./user.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img src="./images/logo.png" alt=""></div>
            <ul class="menu">
                <li><a href="../user/index.php">Trang chủ</a></li>
                <li><a href="">Về chúng tôi</a></li>
                <li class="product"><a href="./sanpham.php">Sản phẩm</a>
                    <ul class="list">
                        <li><a href="sanpham.php?maloai=1">Nike</a></li>
                        <li><a href="sanpham.php?maloai=2">Adidas</a></li>
                        <li><a href="sanpham.php?maloai=3">Converse</a></li>
                    </ul>
                </li>
                <li><a href="">Dịch vụ</a></li>
            </ul>
            <div class="icon">
                <form action="sanpham.php" method="GET">
                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div class="taikhoan">
                    <?php
                    include '../../Db.class.php';
                    session_start();

                    // Lấy ID người dùng từ session
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id'];

                        // Kết nối CSDL
                        $db = new Db();

                        // Câu truy vấn SQL để đếm số lượng sản phẩm trong giỏ hàng
                        $sql = "SELECT COUNT(*) AS total_items FROM chitietgiohang WHERE userId = :userId";
                        $params = [':userId' => $userId];

                        // Thực thi câu truy vấn
                        $result = $db->select($sql, $params);

                        if (!empty($result)) {
                            $soluong_giohang = $result[0]['total_items'];
                        }
                    }
                    ?>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Hiển thị tên người dùng và nút đăng xuất -->
                        <li><a href="thongtin.php"><i class="fa-solid fa-user"></i><?php echo $_SESSION['username']; ?></a></li>
                        <li><a href="dangxuat.php"><i class="fa-solid fa-sign-out-alt"></i> Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a href="login.php"><i class="fa-solid fa-user"></i> Tài Khoản</a></li>
                    <?php endif; ?>
                </div>
                <li><a href=""><i class="fa-solid fa-heart"></i></a></li>

                <li>
                    <a href="giohang.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count"><?php echo isset($soluong_giohang) ? $soluong_giohang : 0; ?></span>
                    </a>
                </li>
            </div>
        </div>
    </div>
</body>

</html>
