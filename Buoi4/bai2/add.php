<?php
if (isset($_POST['mssv']) && isset($_POST['hoten'])) {
    // Lấy dữ liệu từ form
    $mssv = $_POST['mssv'];
    $hoten = $_POST['hoten'];

    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "", "sinhvien");

    // Thêm sinh viên vào bảng
    $sql = "INSERT INTO sinhvien (MaSV, HoTen) VALUES ('$mssv', '$hoten')";
    mysqli_query($conn, $sql);

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);

    // Chuyển hướng trang
    header("Location: sinhvien.php");
}
?>
