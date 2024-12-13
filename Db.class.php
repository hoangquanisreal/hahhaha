<?php

if (!class_exists('Db')) {
    class Db {
        private $_numRow;
        private $dbh = null;

        public function __construct() {
            $driver = "mysql:host=localhost;dbname=giaysneaker";
            try {
                $this->dbh = new PDO($driver, 'root', '');
                $this->dbh->query("set names 'utf8'");
            } catch (PDOException $e) {
                echo "Err: " . $e->getMessage();
                exit();
            }
        }

        public function __destruct() {
            $this->dbh = null;
        }

        public function getRowCount() {
            return $this->_numRow;
        }

        public function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
            $stm = $this->dbh->prepare($sql);
            if (!$stm->execute($arr)) {
                echo "Sql lỗi.";
                exit;
            }
            $this->_numRow = $stm->rowCount();
            return $stm->fetchAll($mode);
        }

        public function select($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
            return $this->query($sql, $arr, $mode);
        }

        public function insert($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
            $this->query($sql, $arr, $mode);
            return $this->getRowCount();
        }

        public function addSanPham($masp, $tensp, $gia, $hinh, $mota, $maloai) {
            $sql_check = "SELECT COUNT(*) FROM sanpham WHERE masp = :masp";
            $params_check = [':masp' => $masp];
            $result = $this->select($sql_check, $params_check);

            if ($result[0]['COUNT(*)'] > 0) {
                echo "Mã sản phẩm này đã tồn tại. Vui lòng nhập mã khác.";
                return;
            }

            $sql = "INSERT INTO sanpham (masp, tensp, gia, hinh, mota, maloai) 
                    VALUES (:masp, :tensp, :gia, :hinh, :mota, :maloai)";
            $arr = [
                ':masp' => $masp,
                ':tensp' => $tensp,
                ':gia' => $gia,
                ':hinh' => $hinh,
                ':mota' => $mota,
                ':maloai' => $maloai,
            ];
            return $this->insert($sql, $arr);
        }

        public function update($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
            $this->query($sql, $arr, $mode);
            return $this->getRowCount();
        }

        public function delete($masp) {
            $sql = "DELETE FROM sanpham WHERE masp = :masp";
            $arr = [':masp' => $masp];
            return $this->query($sql, $arr);
        }
    }
}


?>