<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign up / Login Form</title>
  <link rel="stylesheet" href="./styleform.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
  <div class="main">  	
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
      <form id="signupForm">
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="username" placeholder="User name" required="">
        <input type="email" name="email" placeholder="Email" required="">
        <input type="password" name="password" placeholder="Password" required="">
        <button type="submit">Sign up</button>
      </form>
      <div id="signupResponse"></div>
    </div>

    <div class="login">
      <form id="loginForm">
        <label for="chk" aria-hidden="true">Login</label>
        <input type="text" name="username" placeholder="Username" required="">
        <input type="password" name="password" placeholder="Password" required="">
        <button type="submit">Login</button>
      </form>
      <div id="loginResponse"></div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#signupForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'controller/accounts.php?action=signup',
          data: $(this).serialize(),
          success: function(response) {
            if (response.toLowerCase().includes('success')) {
              toastr.success(response, 'Sign up');
              $('#signupForm')[0].reset(); // Clear the form fields
            } else {
              toastr.error(response, 'Sign up');
            }
          }
        });
      });
    
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'controller/accounts.php?action=login',
          data: $(this).serialize(),
          success: function(response) {
            if (response === 'admin') {
              window.location.href = 'admin/index.php';
            } else if (response === 'customer') {
              window.location.href = 'index.php';
            } else {
              toastr.error(response, 'Login');
            }
          }
        });
      });
    });
    </script>    
</body>
</html>
