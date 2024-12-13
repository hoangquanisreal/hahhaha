<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./user.css">
</head>

<body>
    <?php
    include './header.php';
    ?>
    <div class="banner">
        <img src="./images/133eecf66088591cac64413118ff4c4a.jpg" alt="">
        <div class="inban">
            <h4>Giảm giá đến 40%</h4>
            <p class="h1_Gren">Flacio</p>
            <a href="">Mua ngay</a>
        </div>
    </div>

    <div class="popularproduct">
        <h1>Sản phẩm mới của cửa hàng</h1>

        <a href="">Đến cửa hàng</a>
    </div>
    <div class="container">
        <div class="saleproduct">
            <?php

            include '../../model/sanpham.php';
            $sanphammoinhat = array_slice($sanpham_data, -4);
            foreach ($sanphammoinhat as $sanpham) {
                echo "<div class='p1'>";
                echo "<img src='" . htmlspecialchars($sanpham['hinh']) . "' width='300px' height='400px' alt='ảnh'>";
                echo "<h2>{$sanpham['tensp']}</h2>";
                echo "<p>{$sanpham['gia']} VND</p>";
                echo "<a href='chitietsanpham.php?masp={$sanpham['masp']}'>Xem chi tiết</a>"; // Thêm liên kết chi tiết sản phẩm.
                echo "</div>";
            }
            ?>

        </div>
        <div class="container">
            <div class="news-container">
                <h2 class="news-title">Tin Tức Mới</h2>
                <div class="news-items">
                    <?php
                    include '../../model/tintuc.php';
                   
                        // Hiển thị tin tức
                        foreach ($tintuc_data as $tintuc) {
                       
                            echo "<div class='news-item'>";
                            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                            echo "</div>";
                        }
                  
                    ?>
                </div>
            </div>

        </div>
        <?php
        include './footer.php';
        ?>
</body>

</html>