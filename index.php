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
