<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin cá nhân</title>
</head>

<body>
    <h1>THÔNG TIN CÁ NHÂN</h1>
    <?php
    session_start();

    // Kiểm tra trạng thái đăng nhập
    if (isset($_SESSION['email'])) {
        // Đã đăng nhập
        $email = $_SESSION['email'];

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


        // Chuẩn bị câu lệnh SQL
        $sql = "SELECT * FROM thanhvien WHERE email = ?";

        // Tạo prepared statement
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho tham số
        $stmt->bind_param("s", $email);

        // Thực thi câu lệnh
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Đóng kết nối
        $stmt->close();
        $conn->close();
        echo "<script>alert('Chào mừng $email')</script>";
        // Xử lý kết quả
        if ($result->num_rows === 1) {
            // Lấy thông tin cá nhân
            $row = $result->fetch_assoc();

            // Hiển thị thông tin
            echo "<p>Họ tên: " . $row['hoten'] . "</p>";
            echo "<p>Email: " . $row['email'] . "</p>";
            echo "<p>Ngày sinh: " . $row['namsinh'] . "</p>";
            echo "<p>Giới tính: " . $row['gioitinh'] . "</p>";
            echo "<a href=\"logout.php\">Đăng xuất</a>";
        } else {
            // Lỗi không tìm thấy thông tin
            echo "<p>Lỗi: Không tìm thấy thông tin cá nhân!</p>";
        }
    } else {
        // Chưa đăng nhập
        header('Location: index.php');
    }
    ?>
</body>

</html>