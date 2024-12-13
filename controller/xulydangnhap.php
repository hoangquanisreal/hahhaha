<?php
session_start();
include '../Db.class.php';    

$db = new Db(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
 
    $query = "SELECT * FROM admins WHERE username = :username";
    $params = [':username' => $username];
    $result = $db->select($query, $params);


    if (count($result) > 0) {
        $admin = $result[0];

        // Nếu sử dụng password_hash() khi lưu mật khẩu vào cơ sở dữ liệu
        // if (password_verify($password, $admin['password']))
        if($password===$admin['password'])
         {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: ../views/admin/index.php");
            exit();
        } else {
            echo "<p>Sai mật khẩu.</p>";
        }
    } else {
        echo "<p>Sai tên đăng nhập.</p>";
    }
}
?>
