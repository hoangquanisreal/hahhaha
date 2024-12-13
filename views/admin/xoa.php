<?php
include '../../Db.class.php';

// Kiểm tra nếu có mã sản phẩm trong URL
if (isset($_GET['masp'])) {
    $masp = $_GET['masp'];

    // Tạo đối tượng Db và gọi phương thức delete
    $db = new Db();
    $result = $db->delete($masp);

    // Kiểm tra kết quả và thông báo cho người dùng
    if ($result > 0) {
        echo "Sản phẩm đã được xóa thành công!";
    } else {
        echo "Lỗi! Không tìm thấy sản phẩm hoặc không thể xóa.";
    }
} else {
    echo "Không có mã sản phẩm để xóa!";
}
?>
