<?php
include '../../Db.class.php'; // File kết nối cơ sở dữ liệu

session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$userId = $_SESSION['user_id']; // Lấy userId từ session
$db = new Db(); // Tạo đối tượng kết nối cơ sở dữ liệu

// Lấy dữ liệu từ bảng `chitietgiohang`
$sql = "SELECT * FROM chitietgiohang WHERE userId = :userId";
$params = [':userId' => $userId];
$giohang = $db->select($sql, $params); // Lấy dữ liệu giỏ hàng

if (isset($_POST['action'])) {
    // echo $_POST["action"];
      $params = [
        ':userId' => $userId,
        ':masp' => $_POST["action"],
    ];
    $sqlCheck = "SELECT * FROM chitietgiohang WHERE userId = :userId AND masp = :masp";

    $result = $db->select($sqlCheck, $params);

    if (count($result) > 0) {
        echo 'hehe';
        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
        $sqlUpdate = "UPDATE chitietgiohang SET soluong = soluong + 1 WHERE userId = :userId AND masp = :masp";
        $db->query($sqlUpdate, $params);
        header("Location: ./giohang.php");

    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới
        $sqlInsert = "INSERT INTO chitietgiohang (userId, masp, tensp, gia, soluong) VALUES (:userId, :masp, :tensp, :gia, 1)";
        $paramsInsert = [
            ':userId' => $userId,
            ':masp' => $masp,
            ':tensp' => $tensp,
            ':gia' => $gia,
        ];
        $db->query($sqlInsert, $paramsInsert);
    }
}
// Xử lý thêm sản phẩm vào cơ sở dữ liệu
if (isset($_POST['add_to_cart'])) {
    $userId = $_SESSION['user_id']; // Lấy userId từ session
    $masp = htmlspecialchars($_POST['masp']);
    $tensp = htmlspecialchars($_POST['tensp']);
    $gia = floatval($_POST['gia']);
    $hinh = htmlspecialchars($_POST['hinh']);
    echo $hinh;

    // Kết nối database
    try {
        $db = new Db();     
     $sqlInsert = "INSERT INTO chitietgiohang (userId, masp, tensp, gia, soluong, hinh) VALUES (:userId, :masp, :tensp, :gia, 1, :hinh)";
            $paramsInsert = [
                ':userId' => $userId,
                ':masp' => $masp,
                ':tensp' => $tensp,
                ':gia' => $gia,
                ':hinh'=>$hinh
            ];
            $db->query($sqlInsert, $paramsInsert);
    } catch (\Throwable $th) {
        
    }
    

    // Chuyển hướng lại giỏ hàng
    header("Location: giohang.php");
    exit();
}
if (isset($_POST['actions'])) {
    // echo $_POST["action"];
      $params = [
        ':userId' => $userId,
        ':masp' => $_POST["actions"],
    ];
    $sqlCheck = "SELECT * FROM chitietgiohang WHERE userId = :userId AND masp = :masp";

    $result = $db->select($sqlCheck, $params);

    if (count($result) > 0) {
        // if() 
        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
        $sqlUpdate = "UPDATE chitietgiohang SET soluong = soluong - 1 WHERE userId = :userId AND masp = :masp";

        $db->query($sqlUpdate, $params);
        header("Location: ./giohang.php");

    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới
        $sqlInsert = "INSERT INTO chitietgiohang (userId, masp, tensp, gia, soluong) VALUES (:userId, :masp, :tensp, :gia, 1)";
        $paramsInsert = [
            ':userId' => $userId,
            ':masp' => $masp,
            ':tensp' => $tensp,
            ':gia' => $gia,
        ];
        $db->query($sqlInsert, $paramsInsert);
    }
}
?>
