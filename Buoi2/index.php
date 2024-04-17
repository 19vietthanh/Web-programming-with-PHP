<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập & Đăng xuất</title>
</head>

<body>
    <h1>HỆ THỐNG ĐĂNG NHẬP</h1>
    <?php
    session_start();
    // Khai báo biến email
    $email = "";

    // Kiểm tra trạng thái đăng nhập
    if (isset($_SESSION['email'])) {
        // Đã đăng nhập
        $email = $_SESSION['email'];
        header("Location: info.php");
        // echo "<p>Chào mừng " . $email . "!</p>";
        // echo "<a href=\"logout.php\">Đăng xuất</a>";
    } else {
        // Chưa đăng nhập
    ?>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="matkhau">Mật khẩu:</label>
            <input type="password" id="matkhau" name="matkhau" required>
            <br>
            <button type="submit">Đăng nhập</button>
        </form>
    <?php
    }
    ?>
</body>

</html>