<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        .quantity-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>

<body>
    <?php
    include 'chitietgiohang.php';
    if (count($giohang) > 0) { // Kiểm tra nếu giỏ hàng có sản phẩm
        echo "<h1>Giỏ hàng của bạn</h1>";
        echo "<form action='./chitietgiohang.php' method='POST'>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Hình ảnh</th>";
        echo "<th>Tên sản phẩm</th>";
        echo "<th>Mã sản phẩm</th>";
        echo "<th>Giá</th>";
        echo "<th>Số lượng</th>";
        echo "<th>Tổng giá</th>";
        echo "<th>Hành động</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($giohang as $item) {
            $tonggia = $item['gia'] * $item['soluong'];
            echo "<tr>";

            // Hiển thị hình ảnh
            $imagePath = $item['hinh'];
            echo "<td><img src='$imagePath' alt='{$item['tensp']}'></td>";

            // if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            //     echo "<td><img src='{$imagePath}' alt='{$item['tensp']}'></td>";
            // } elseif (file_exists('../user/images/' . $imagePath)) {
            //     echo "<td><img src='../user/images/{$imagePath}' alt='{$item['tensp']}'></td>";
            // } else {
            //     echo "<td><img src='../images/no-image.png' alt='ảnh'></td>";
            // }

            // Hiển thị thông tin sản phẩm
            echo "<td>{$item['tensp']}</td>";
            echo "<td>{$item['masp']}</td>";
            echo "<td>" . number_format($item['gia'], 0, ',', '.') . " VND</td>";
            echo "<td>";
            echo "<div class='quantity-buttons'>";
            $disableDecrease = $item['soluong'] <=1 ? 'disabled' : '';
            echo "<button type='submit' name='actions' value='{$item['masp']}' {$disableDecrease}>-</button>";

            // echo "<button type='submit' name='actions value='{$item['masp']}'>-</button>";
            echo "<input type='text' name='quantity[{$item['masp']}]' value='{$item['soluong']}' readonly>";
            echo "<button type='submit' name='action' value='{$item['masp']}'>+</button>";
            echo "</div>";
            echo "</td>";
            echo "<td>" . number_format($tonggia, 0, ',', '.') . " VND</td>";
            echo "<td><button type='submit' name='action' value='remove_{$item['masp']}'>Xóa</button></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</form>";
    } else {
        echo "<h1>Giỏ hàng của bạn hiện tại trống.</h1>";
    }
    ?>
    <a href="./index.php">Quay lại trang chính</a>
</body>

</html>