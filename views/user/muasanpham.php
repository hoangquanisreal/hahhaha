<?php
// Kết nối database nếu cần, hoặc lấy thông tin sản phẩm từ giỏ hàng hoặc tham số GET
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masp = $_POST['masp'];
    $tensp = $_POST['tensp'];
    $gia = $_POST['gia'];
    $hinh = $_POST['hinh'];
} else {
    echo "Không có thông tin sản phẩm.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Thông tin thanh toán cho sản phẩm: <?php echo htmlspecialchars($tensp); ?></h1>

    <div class="product-info">
        <img src="<?php echo htmlspecialchars($hinh); ?>" alt="<?php echo htmlspecialchars($tensp); ?>" width="100">
        <p><strong>Tên sản phẩm:</strong> <?php echo htmlspecialchars($tensp); ?></p>
        <p><strong>Giá:</strong> <?php echo number_format($gia, 0, ',', '.'); ?> VND</p>
    </div>

    <form action="xulithanhtoan.php" method="POST">
        <label for="fullname">Tên đầy đủ:</label>
        <input type="text" id="fullname" name="fullname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="phone">Dia chi:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="phone">Số điện thoại:</label>
        <input type="tel" id="phone" name="phone" required>

        <input type="hidden" name="masp" value="<?php echo $masp; ?>">
        <input type="hidden" name="tensp" value="<?php echo $tensp; ?>">
        <input type="hidden" name="gia" value="<?php echo $gia; ?>">
        <input type="hidden" name="hinh" value="<?php echo $hinh; ?>">

        <button type="submit">Hoàn tất thanh toán</button>
    </form>

    <a href="./index.php">Quay lại trang chính</a>
</body>

</html>
