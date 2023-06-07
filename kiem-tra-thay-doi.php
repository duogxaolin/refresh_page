<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'username', 'password', 'database');

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
  die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}

// Truy vấn cơ sở dữ liệu để kiểm tra sự thay đổi
$query = "SELECT COUNT(*) as count FROM users WHERE last_updated > NOW() - INTERVAL 5 SECOND";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $count = $row['count'];

  // Trả về true nếu có sự thay đổi, ngược lại trả về false
  if ($count > 0) {
    echo "true";
  } else {
    echo "false";
  }
} else {
  echo "false";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
