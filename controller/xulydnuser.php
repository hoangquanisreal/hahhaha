<?php
include '../Db.class.php'; // Import lớp Db

// Kiểm tra nếu phương thức yêu cầu là POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra xem đầu vào có rỗng không
    if (empty($username) || empty($password)) {
        die("Tên đăng nhập và mật khẩu không được để trống.");
    }

    // Tạo kết nối cơ sở dữ liệu
    $db = new Db();

    // Truy vấn lấy thông tin người dùng
    $sql = "SELECT id, password FROM nguoidung WHERE username = :username";
    $params = [':username' => $username];
    $result = $db->select($sql, $params);

    // Kiểm tra nếu người dùng tồn tại
    if (!empty($result)) {
        $hashed_password = $result[0]['password'];
        $user_id = $result[0]['id'];

        // Xác thực mật khẩu
        if (password_verify($password, $hashed_password)) {
            // Đăng nhập thành công, tạo session
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            echo "Đăng nhập thành công!";
            // Chuyển hướng đến trang chính (dashboard)
            header("Location: ../views/user/index.php");
            exit();
        } else {
            echo "Sai mật khẩu.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
