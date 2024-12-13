<?php
include '../Db.class.php'; // Import lớp Db
session_start(); // Đảm bảo session được bắt đầu

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['nguoidung'])) {
    // Nếu đã đăng nhập, chuyển hướng đến trang chính
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Kiểm tra xem đầu vào có rỗng không
    if (empty($username) || empty($email) || empty($sdt) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
        header("Location: sigin.php");
        exit();
    }

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email không hợp lệ.";
        header("Location: ../views/user/sigin.php");
        exit();
    }

    // Kiểm tra định dạng số điện thoại
    if (!preg_match('/^\d{10,15}$/', $sdt)) {
        $_SESSION['error'] = "Số điện thoại không hợp lệ. Vui lòng nhập số có từ 10-15 chữ số.";
        header("Location: ../views/user/sigin.php");
        exit();
    }

    // Kiểm tra mật khẩu khớp
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Mật khẩu không khớp.";
        header("Location: ../views/user/sigin.php");
        exit();
    }

    // Sử dụng lớp Db để kết nối cơ sở dữ liệu
    $db = new Db();

    // Kiểm tra xem username, email, hoặc số điện thoại đã tồn tại chưa
    $sql_check = "SELECT COUNT(*) FROM nguoidung WHERE username = :username OR email = :email OR sdt = :sdt";
    $params_check = [':username' => $username, ':email' => $email, ':sdt' => $sdt];
    $result = $db->select($sql_check, $params_check);

    if ($result[0]['COUNT(*)'] > 0) {
        $_SESSION['error'] = "Tên đăng nhập, email, hoặc số điện thoại đã được sử dụng.";
        header("Location: ../views/user/sigin.php");
        exit();
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Chèn thông tin vào bảng
    $sql_insert = "INSERT INTO nguoidung (username, email, sdt, password) VALUES (:username, :email, :sdt, :password)";
    $params_insert = [
        ':username' => $username,
        ':email' => $email,
        ':sdt' => $sdt,
        ':password' => $hashed_password,
    ];
    $rows_affected = $db->insert($sql_insert, $params_insert);

    if ($rows_affected > 0) {
        // Đăng ký thành công, chuyển hướng đến trang đăng nhập
        $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
        header("Location: ../views/user/login.php");
        exit();
    } else {
        $_SESSION['error'] = "Lỗi khi thực hiện đăng ký.";
        header("Location: ../views/user/sigin.php");
        exit();
    }
} else {
    // Nếu không phải POST request
    $_SESSION['error'] = "Yêu cầu không hợp lệ.";
    header("Location: ../views/user/sigin.php");
    exit();
}
?>
