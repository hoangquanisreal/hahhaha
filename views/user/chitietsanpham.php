<?php
include '../../model/sanpham.php'; // Tải lớp Db để kết nối database.

session_start(); // Bắt đầu session

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    // Lưu lại trang hiện tại để chuyển hướng về sau khi đăng nhập
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: ../user/login.php'); // Chuyển hướng đến trang đăng nhập
    exit();
}

if (isset($_GET['masp'])) {
    $masp = htmlspecialchars($_GET['masp']); // Lấy mã sản phẩm từ URL và kiểm tra an toàn dữ liệu.

    $db = new Db();
    $sql = "SELECT * FROM sanpham WHERE masp = :masp"; // Câu lệnh SQL lấy thông tin chi tiết sản phẩm.
    $sanpham = $db->select($sql, [':masp' => $masp]);

    if (count($sanpham) > 0) {
        $sanpham = $sanpham[0]; // Lấy sản phẩm đầu tiên.
    } else {
        echo "Không tìm thấy sản phẩm.";
        exit();
    }
} else {
    echo "Không có sản phẩm được chọn.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="./chitietsp.css"> <!-- Liên kết file CSS -->
</head>
<body>
    <div class="product-detail">
        <h1><?php echo htmlspecialchars($sanpham['tensp']); ?></h1>
        <img src="<?php echo htmlspecialchars($sanpham['hinh']); ?>" alt="<?php echo htmlspecialchars($sanpham['tensp']); ?>" width="300">
        <p class="price">Giá: <?php echo number_format($sanpham['gia'], 0, ',', '.'); ?> VND</p>
        <p class="description">Mô tả: <?php echo htmlspecialchars($sanpham['mota'] ?? 'Đang cập nhật...'); ?></p>
        
        <!-- Thêm vào giỏ hàng form -->
        <form action="chitietgiohang.php" method="POST">
            <input type="hidden" name="masp" value="<?php echo $sanpham['masp']; ?>">
            <input type="hidden" name="tensp" value="<?php echo $sanpham['tensp']; ?>">
            <input type="hidden" name="gia" value="<?php echo $sanpham['gia']; ?>">
            <input type="hidden" name="hinh" value="<?php echo $sanpham['hinh']; ?>">
            <button type="submit" name="add_to_cart" class="btn">Thêm vào giỏ hàng</button>
        </form>

        <!-- Mua ngay form -->
        <form action="muasanpham.php" method="POST">
            <input type="hidden" name="masp" value="<?php echo $sanpham['masp']; ?>">
            <input type="hidden" name="tensp" value="<?php echo $sanpham['tensp']; ?>">
            <input type="hidden" name="gia" value="<?php echo $sanpham['gia']; ?>">
            <input type="hidden" name="hinh" value="<?php echo $sanpham['hinh']; ?>">
            <button type="submit" name="buy_now" class="btn buy-now">Mua ngay</button>
        </form>

        <a href="./index.php" class="back-link">Quay lại trang chính</a>
    </div>
</body>
</html>
