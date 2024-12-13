<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .success-msg {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="title">Sửa Thông Tin Sản Phẩm</h2>
        <?php
        include '../../Db.class.php';
        $db = new Db();

        // Lấy masp từ URL hoặc từ POST
        $masp = isset($_GET['masp']) ? $_GET['masp'] : '';

        if ($masp) {
            // Truy vấn lấy thông tin sản phẩm hiện tại
            $sql = "SELECT * FROM sanpham WHERE masp = :masp";
            $params = [':masp' => $masp];
            $product = $db->select($sql, $params);

            if ($product) {
                $product = $product[0]; // Lấy sản phẩm đầu tiên
            } else {
                echo "<div class='error-msg'>Sản phẩm không tồn tại.</div>";
                exit;
            }
        }

        // Xử lý cập nhật thông tin sản phẩm
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $masp = $_POST['masp'];
            $tensp = $_POST['tensp'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $mota = $_POST['mota'];
            $maloai = $_POST['maloai'];
            $hinh_anh = $product['hinh']; // Giữ hình cũ nếu không có hình mới

            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $hinh_anh_tmp = $_FILES['hinh']['tmp_name'];
                $target_dir = '../user/images/';
                $hinh_anh_name = basename($_FILES['hinh']['name']);
                $hinh_anh = $target_dir . $hinh_anh_name;

                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (move_uploaded_file($hinh_anh_tmp, $hinh_anh)) {
                    echo "<div class='success-msg'>Tệp đã được upload thành công!</div>";
                } else {
                    echo "<div class='error-msg'>Có lỗi khi upload tệp.</div>";
                }
            }

            // Cập nhật thông tin sản phẩm
            $sql_update = "UPDATE sanpham SET tensp = :tensp, gia = :gia, soluong = :soluong, hinh = :hinh, mota = :mota, maloai = :maloai WHERE masp = :masp";
            $params_update = [
                ':masp' => $masp,
                ':tensp' => $tensp,
                ':gia' => $gia,
                ':soluong' => $soluong,
                ':hinh' => $hinh_anh,
                ':mota' => $mota,
                ':maloai' => $maloai,
            ];
            $db->update($sql_update, $params_update);
            echo "<div class='success-msg'>Cập nhật sản phẩm thành công!</div>";
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="masp" value="<?php echo $product['masp']; ?>">

            <div class="form-group">
                <label for="tensp">Tên sản phẩm:</label>
                <input type="text" id="tensp" name="tensp" value="<?php echo $product['tensp']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="number" id="gia" name="gia" value="<?php echo $product['gia']; ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="soluong">Số lượng tồn:</label>
                <input type="number" id="soluong" name="soluong" value="<?php echo $product['soluong']; ?>" required>
            </div>

            <div class="form-group">
                <label for="hinh">Chọn hình ảnh mới:</label>
                <input type="file" id="hinh" name="hinh" accept="image/*">
                <br>
                <?php if ($product['hinh']) { ?>
                    <img src="<?php echo $product['hinh']; ?>" alt="Product Image" width="100">
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="mota">Mô tả:</label>
                <textarea id="mota" name="mota" rows="4"><?php echo $product['mota']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="maloai">Mã Loại:</label>
                <input type="number" id="maloai" name="maloai" value="<?php echo $product['maloai']; ?>" required>
            </div>

            <button type="submit" class="submit-btn">Cập Nhật Sản Phẩm</button>
        </form>
    </div>

</body>

</html>
