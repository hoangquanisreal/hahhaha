<?php
include '../../Db.class.php';

$db = new Db(); // Tạo kết nối
$sql = "SELECT * FROM tintuuc";
$tintuc_data = $db->select($sql); // Lấy dữ liệu

?>
