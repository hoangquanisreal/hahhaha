<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Sản phẩm</title>
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép các sản phẩm xuống dòng khi hết không gian */
            justify-content: space-around;
            /* Căn giữa các sản phẩm */
            gap: 20px;
            /* Khoảng cách giữa các sản phẩm */
        }

        .product-card {
            display: flex;
            flex-direction: column;
            /* Đảm bảo các phần tử trong card xếp theo chiều dọc */
            align-items: stretch;
            /* Các phần tử trong card sẽ kéo dài ngang bằng nhau */
            width: 280px;
            /* Điều chỉnh chiều rộng của mỗi card */
            height: 400px;
            /* Đảm bảo tất cả các card có chiều cao bằng nhau */
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;

            cursor: pointer;

        }

        .product-card:hover {
            transform: translateY(-5px);
            /* Tạo hiệu ứng hover */
        }

        .product-card img {
            width: 100%;
            height: 200px;
            /* Đảm bảo hình ảnh có chiều cao cố định */
            object-fit: cover;
            /* Cắt ảnh theo tỷ lệ để phù hợp với chiều cao */
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 10px 0;
            flex-grow: 1;
            /* Đảm bảo tên sản phẩm có không gian phát triển nếu cần */
        }

        .product-card .price {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-card .details-link {
            display: inline-block;
            padding: 5px 10px;
            background-color: #008CBA;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .product-card .details-link:hover {
            background-color: #005f6b;
        }
    </style>
</head>

<body>

    <?php include './header.php'; ?>

    <?php
    // Kết nối cơ sở dữ liệu
    include '../../model/sanpham.php';  // Đảm bảo đường dẫn đúng đến tệp kết nối cơ sở dữ liệu

    // Lấy mã loại sản phẩm từ tham số URL
    $maloai = isset($_GET['maloai']) ? $_GET['maloai'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : '';  // Lấy từ khóa tìm kiếm

    // Tạo truy vấn SQL để lấy sản phẩm theo mã loại và từ khóa tìm kiếm
    if ($maloai && $search) {
        // Truy vấn sản phẩm theo mã loại và từ khóa tìm kiếm
        $query = "SELECT * FROM sanpham WHERE maloai = $maloai AND tensp LIKE '%$search%'";
    } elseif ($maloai) {
        // Truy vấn sản phẩm theo mã loại
        $query = "SELECT * FROM sanpham WHERE maloai = $maloai";
    } elseif ($search) {
        // Truy vấn sản phẩm theo từ khóa tìm kiếm
        $query = "SELECT * FROM sanpham WHERE tensp LIKE '%$search%'";
    } else {
        // Nếu không có mã loại và từ khóa, lấy tất cả sản phẩm
        $query = "SELECT * FROM sanpham";
    }

    // Thực thi truy vấn
    $sanpham_data = $db->select($query);

    // Nếu không có sản phẩm nào
    if (empty($sanpham_data)) {
        echo "<p>Không có sản phẩm nào!</p>";
    } else {
        // Hiển thị danh sách sản phẩm
        echo '<div class="product-list">';
        foreach ($sanpham_data as $sanpham):
    ?>
            <a href="chitietsanpham.php?masp=<?php echo $sanpham['masp']; ?>" class="product-card-link">
                <div class="product-card">
                    <img src="<?php echo $sanpham['hinh']; ?>" alt="<?php echo $sanpham['tensp']; ?>">
                    <h3><?php echo $sanpham['tensp']; ?></h3>
                    <p><?php echo $sanpham['mota'];?></p>
                    <p><?php echo number_format($sanpham['gia'], 0, ',', '.') . " VND"; ?></p>
                </div>
            </a>

    <?php
        endforeach;
        echo '</div>';
    }
    ?>

    <?php include './footer.php'; ?>

</body>

</html>