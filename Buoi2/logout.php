<?php
session_start();

// Xóa session
session_unset();
session_destroy();

// Chuyển hướng về trang chủ
header("Location: index.php");
?>
