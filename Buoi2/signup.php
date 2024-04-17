<?php
// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buoi2";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$hoten = $_POST['hoten'];
$email = $_POST['email'];
$matkhau = sha1($_POST['matkhau']);
$namsinh = $_POST['namsinh'];
$gioitinh = $_POST['gioitinh'];

// Chuẩn bị câu lệnh SQL
$sql = "INSERT INTO thanhvien (hoten, email, matkhau, namsinh, gioitinh) VALUES (?, ?, ?, ?, ?)";

// Tạo prepared statement
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số
$stmt->bind_param("sssss", $hoten, $email, $matkhau, $namsinh, $gioitinh);

// Thực thi câu lệnh
$stmt->execute();

// Đóng kết nối
$stmt->close();
$conn->close();

// Thông báo thành công
echo "Đăng ký thành công!";
?>
