# refresh_page
* Tạo một trang HTML đơn giản với một danh sách người dùng và một nút để làm mới danh sách.
```php
<!DOCTYPE html>
<html>
<head>
  <title>AJAX Example</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // Hàm để tải lại danh sách người dùng
      function loadUserList() {
        $.ajax({
          url: 'lay-danh-sach-nguoi-dung.php',
          method: 'GET',
          success: function(response) {
            $('#userList').html(response);
          }
        });
      }

      // Gọi hàm để tải danh sách người dùng khi trang được tải lần đầu
      loadUserList();

      // Thiết lập tác vụ AJAX định kỳ
      setInterval(function() {
        $.ajax({
          url: 'kiem-tra-thay-doi.php',
          method: 'GET',
          success: function(response) {
            if (response === 'true') {
              loadUserList();
            }
          }
        });
      }, 5000); // Gửi yêu cầu mỗi 5 giây

      // Xử lý sự kiện khi người dùng nhấp vào nút làm mới danh sách
      $('#refreshButton').click(function() {
        loadUserList();
      });
    });
  </script>
</head>
<body>
  <button id="refreshButton">Làm mới danh sách</button>
  <ul id="userList"></ul>
</body>
</html>
```
*Tạo một tệp PHP (lay-danh-sach-nguoi-dung.php) để lấy danh sách người dùng từ cơ sở dữ liệu và hiển thị trên trang.
```php
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
```
*Tạo một tệp PHP (kiem-tra-thay-doi.php) để kiểm tra sự thay đổi dữ liệu trên cơ sở dữ liệu SQL. Trong ví dụ này, chúng ta giả định có một bảng "users" với một trường "last_updated" để lưu thời gian cập nhật gần nhất.
```php
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
```
Trong ví dụ này, chúng ta hiển thị danh sách người dùng từ cơ sở dữ liệu và kiểm tra sự thay đổi dữ liệu mỗi 5 giây. Khi có sự thay đổi, danh sách người dùng sẽ được tải lại và hiển thị lại trên trang. Bạn cũng có thể nhấp vào nút "Làm mới danh sách" để thủ công làm mới danh sách người dùng.

Hãy chắc chắn thay thế 'localhost', 'username', 'password', 'database' bằng các giá trị kết nối cơ sở dữ liệu của bạn.
