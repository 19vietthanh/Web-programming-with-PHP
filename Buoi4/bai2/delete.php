<?php
if (isset($_GET['id'])) {
    // Lấy ID sinh viên từ URL
    $id = $_GET['id'];

    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "", "sinhvien");

    // Xóa sinh viên khỏi bảng
    $sql = "DELETE FROM sinhvien WHERE MaSV = '$id'";
    mysqli_query($conn, $sql);

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);

    // Chuyển hướng trang
    header("Location: sinhvien.php");
}
?>
