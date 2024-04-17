<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật thông tin cá nhân</title>
</head>
<body>
    <h1>CẬP NHẬT THÔNG TIN CÁ NHÂN</h1>
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

        // Xử lý cập nhật thông tin
        if (isset($_POST['submit'])) {
            // Lấy dữ liệu từ form
            $hoten = $_POST['hoten'];
            $namsinh = $_POST['namsinh'];
            $gioitinh = $_POST['gioitinh'];

            // Chuẩn bị câu lệnh SQL
            $sql = "UPDATE thanhvien SET hoten = ?, namsinh = ?, gioitinh = ? WHERE email = ?";

            // Tạo prepared statement
            $stmt = $conn->prepare($sql);

            // Gán giá trị cho tham số
            $stmt->bind_param("sssi", $hoten, $namsinh, $gioitinh, $email);

            // Thực thi câu lệnh
            $stmt->execute();

            // Đóng kết nối
            $stmt->close();
            $conn->close();

            // Hiển thị thông báo
            if ($stmt->affected_rows === 1) {
                echo "<p>Cập nhật thông tin thành công!</p>";
            } else {
                echo "<p>Cập nhật thông tin thất bại!</p>";
            }
        }

        // Lấy thông tin cá nhân
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

        // Xử lý kết quả
        if ($result->num_rows === 1) {
            // Lấy thông tin cá nhân
            $row = $result->fetch_assoc();

            // Hiển thị form cập nhật
            ?>
            <form action="update.php" method="post">
                <label for="hoten">Họ tên:</label>
                <input type="text" id="hoten" name="hoten" value="<?php echo $row['hoten']; ?>" required>
                <br>
                <label for="namsinh">Ngày sinh:</label>
                <input type="date" id="namsinh" name="namsinh" value="<?php echo $row['namsinh']; ?>" required>
                <br>
                <label for="gioitinh">Giới tính:</label>
                <select id="gioitinh" name="gioitinh" required>
                    <option value="Nam" <?php if ($row['gioitinh'] === "Nam") echo "selected"; ?>>Nam</option>
                    <option value="Nữ" <?php if ($row['gioitinh'] === "Nữ") echo "selected"; ?>>Nữ</option>
                </select>
                <br>
                <button type="submit" name="submit">Cập nhật</button>
            </form>
            <?php
        } else {
            // Lỗi không tìm thấy thông tin cá nhân
            echo "<p>Lỗi: Không tìm thấy thông tin cá nhân!</p>";
        }
    } else {
        // Chưa đăng nhập
        echo "<p>Bạn cần đăng nhập để xem thông tin cá nhân!</p>";
        echo "<a href=\"index.php\">Đăng nhập</a>";
    }
    ?>
</body>
</html>
