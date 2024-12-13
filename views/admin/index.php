<?php
include '../../controller/baovead.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./admin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Trang chủ Admin</title>
    <style>
        /* Thêm các style tùy chỉnh ở đây nếu cần */
        .container {
            margin-top: 20px;
        }

        .header ul {
            list-style: none;
            padding: 0;
            text-align: right;
        }

        .header ul li {
            display: inline;
            margin-right: 15px;
        }

        .header ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .header ul li a:hover {
            color: #007bff;
        }

        .content {
            display: flex;
            justify-content: space-between;
        }

        .left {
            width: 20%;
        }

        .right {
            width: 75%;
        }

        .danhmuc h3 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .chucnang {
            margin-bottom: 20px;
        }

        .chucnang a button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .chucnang a button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }

        td img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        button {
            padding: 5px 10px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <ul>
                <li><a href="#">Adminstrator</a></li>
                <li><a href="#">Vào trang web</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Đơn hàng</a></li>
            </ul>
        </div>

        <div class="content">
            <!-- Menu quản lý -->
            <div class="left">
                <div class="danhmuc">
                    <h3>Quản trị danh mục</h3>
                    <p><a href="danhmuc.php">Loại danh mục</a></p>
                    <p><a href="sanpham.php">Sản phẩm</a></p>
                </div>
            </div>

            <!-- Nội dung quản lý sản phẩm -->
            <div class="right">
                <!-- Form tìm kiếm sản phẩm -->
                <form method="GET" action="" class="form-inline">
                    <input type="text" name="search" class="form-control" placeholder="Nhập tên sản phẩm" style="width: 250px;">
                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                </form>

                <!-- Thêm sản phẩm -->
                <div class="chucnang">
                    <a href="them.php"><button>Thêm Sản Phẩm</button></a>
                </div>

                <!-- Bảng danh sách sản phẩm -->
                <table>
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Mã loại</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../model/sanpham.php';
                        if (!empty($sanpham_data)) : ?>
                            <?php foreach ($sanpham_data as $sanpham) : ?>
                                <tr>
                                    <td><?= $sanpham['masp'] ?></td>
                                    <td><?= $sanpham['tensp'] ?></td>
                                    <td><?= number_format($sanpham['gia'], 0, ',', '.') ?> VND</td>
                                    <td>
                                        <?php
                                        // Kiểm tra đường dẫn hình ảnh và hiển thị hình ảnh
                                        $imagePath = $sanpham['hinh'];
                                        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                            echo "<img src='{$imagePath}' alt='ảnh'>";
                                        } elseif (file_exists($imagePath)) {
                                            echo "<img src='{$imagePath}' alt='ảnh'>";
                                        } else {
                                            echo "<img src='../images/no-image.png' alt='ảnh'>";
                                        }
                                        ?>
                                    </td>
                                    <td><?= $sanpham['maloai'] ?></td>
                                    <td>
                                        <a href="sua.php?masp=<?= $sanpham['masp'] ?>"><button>Sửa</button></a>
                                        <a href="xoa.php?masp=<?= $sanpham['masp'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                                            <button>Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
