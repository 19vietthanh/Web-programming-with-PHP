<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            text-decoration: none;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>
    <form action="add.php" method="post">
        <input type="text" name="mssv" placeholder="MSSV">
        <input type="text" name="hoten" placeholder="Họ Tên">
        <button type="submit">Thêm</button>
    </form>
    <br>
    <h2>Danh sách sinh viên</h2>
    <table>
        <tr>
            <th>STT</th>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Xóa</th>
        </tr>
        <?php
        // Kết nối cơ sở dữ liệu
        $conn = mysqli_connect("localhost", "root", "", "sinhvien");

        // Lấy dữ liệu từ bảng sinhvien
        $sql = "SELECT * FROM sinhvien";
        $result = mysqli_query($conn, $sql);

        // Duyệt qua kết quả
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['STT']; ?></td>
                <td><?php echo $row['MaSV']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><a href="delete.php?id=<?php echo $row['MaSV']; ?>" class="delete">❌</a></td>
            </tr>
        <?php
        }

        // Đóng kết nối cơ sở dữ liệu
        mysqli_close($conn);
        ?>
    </table>

    <script>
        var buttons = document.querySelectorAll("a.delete");
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener("click", function(e) {
                // Hiển thị hộp thoại xác nhận
                var confirm = window.confirm("Bạn có chắc muốn xóa sinh viên này?");

                // Xử lý dựa trên lựa chọn của người dùng
                if (confirm) {
                    // Gửi yêu cầu xóa đến server
                    window.location.href = this.href;
                } else {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>

</html>