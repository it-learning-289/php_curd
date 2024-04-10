document.getElementById("loginForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Ngăn form submit mặc định

  // Lấy giá trị của email và password
  var username = document.getElementById("loginEmail").value;
  var password = document.getElementById("loginPassword").value;

  // In ra console để kiểm tra
  console.log("username: " + username);
  console.log("Password: " + password);
  const apiUrl = 'http://10.110.69.13:8081/api/shoes/1125';
  // const apiUrl = 'https://jsonplaceholder.typicode.com/todos/';
  const token = btoa(username + password);
  console.log(token);

// Tạo một XMLHttpRequest object
// Tạo một request và thiết lập các options
var requestOptions = {
  method: 'GET',
  headers: new Headers({
      'Access-Control-Allow-Origin': '*'
  })
};

// Gửi request đến API
fetch('http://10.110.69.13:8081/api/shoes/1125', requestOptions)
  .then(function(response) {
      // Kiểm tra trạng thái của response
      if (response.ok) {
        return response.json();
        // console.log(response);
      }
      
      throw new Error('Network response was not ok.');
    })
    .then(function(data) {
      // Xử lý dữ liệu nhận được
      console.log('Data:', data);
    })
    .catch(function(error) {
      // Xử lý lỗi nếu có
      console.log("asdfv");
      console.error('Fetch error:', error);
  });

  // Ở đây bạn có thể thêm các xử lý khác, ví dụ như gửi dữ liệu đăng nhập đến server
});