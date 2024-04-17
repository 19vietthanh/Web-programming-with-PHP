<?php
session_start();

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
$email = $_POST['email'];
$matkhau = sha1($_POST['matkhau']);

// Chuẩn bị câu lệnh SQL
$sql = "SELECT * FROM thanhvien WHERE email = ? AND matkhau = ?";

// Tạo prepared statement
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số
$stmt->bind_param("ss", $email, $matkhau);

// Thực thi câu lệnh
$stmt->execute();

// Lấy kết quả
$result = $stmt->get_result();

// Đóng kết nối
$stmt->close();
$conn->close();

// Xử lý kết quả
if ($result->num_rows === 1) {
    // Đăng nhập thành công
    $_SESSION['email'] = $email;
    header("Location: index.php");
} else {
    // Đăng nhập thất bại
    echo "<p>Đăng nhập thất bại!</p>";
    echo "<a href=\"index.php\">Quay lại</a>";
}
?>
