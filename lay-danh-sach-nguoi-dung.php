<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'username', 'password', 'database');

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
  die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}

// Truy vấn cơ sở dữ liệu để lấy danh sách người dùng
$query = "SELECT * FROM users";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['username'] . "</li>";
  }
} else {
  echo "<li>Không có người dùng nào.</li>";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
