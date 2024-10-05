<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup Page</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif;
    /* background: linear-gradient(to right, #6a11cb, #2575fc); */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    /* color: #fff; */
    color: #440f5f;
    overflow: hidden;
    background: url('assets/img/signuphero.jpg') no-repeat center center transparent;
    background-size: cover;
  }
  .container-fluid {
    /* background: rgba(255, 255, 255, 0.9); */
    background: rgba(144, 209, 252, 0.9);
    /* background: rgba(188, 226, 250, 0.9); */
    /* background: transparent; */
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 450px;
    margin: 20px;
    position: relative;
    z-index: 10;
    animation: fadeIn 1s ease-in-out;
  }
  .container-fluid h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 28px;
    font-weight: 600;
  }
  .form-group {
    margin-bottom: 20px;
  }
  label {
    font-weight: bold;
    /* color: #555; */
    color: #440f5f;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"],
  textarea {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background: rgba(176, 205, 235, 0.9);
    /* background: transparent; */
    color: #010d24;
  }
  .button {
    width: 100%;
    padding: 12px;
    background-color: #6a11cb;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 16px;
    font-weight: 600;
  }
  .button:hover {
    background-color: #4a00e0;
  }
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .background-decor {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    background: url('https://www.transparenttextures.com/patterns/memphis-mini.png');
    opacity: 0.3;
  }
  .background-decor::before,
  .background-decor::after {
    content: '';
    position: absolute;
    background: radial-gradient(circle, #ff7e5f, #feb47b);
    border-radius: 50%;
    opacity: 0.6;
    mix-blend-mode: screen;
  }
  .background-decor::before {
    width: 300px;
    height: 300px;
    top: -50px;
    left: -50px;
  }
  .background-decor::after {
    width: 400px;
    height: 400px;
    bottom: -100px;
    right: -100px;
  }
</style>
</head>
<body>

<!-- <div class="background-decor"></div> -->

<div class="container-fluid">
  <h2>Signup</h2>
  <form action="" id="signup-frm">
    <div class="form-group">
      <label for="name" class="control-label">Name</label>
      <input type="text" id="name" name="name" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="contact" class="control-label">Contact</label>
      <input type="text" id="contact" name="contact" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="address" class="control-label">Address</label>
      <textarea id="address" cols="30" rows="3" name="address" required="" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label for="email" class="control-label">Email</label>
      <input type="email" id="email" name="email" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="password" class="control-label">Password</label>
      <input type="password" id="password" name="password" required="" class="form-control">
    </div>
    <button type="submit" class="button btn btn-info btn-sm">Create</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Handle form submission
  $('#signup-frm').submit(function(e) {
    e.preventDefault();
    $('#signup-frm button[type="submit"]').attr('disabled', true).html('Saving...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'admin/ajax.php?action=signup',
      method: 'POST',
      data: $(this).serialize(),
      error: function(err) {
        console.log(err);
        $('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
      },
      success: function(resp) {
        if (resp == 1) {
          window.location.href = 'index.php';
        } else {
          $('#signup-frm').prepend('<div class="alert alert-danger">Email already exists.</div>')
          $('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
        }
      }
    });
  });
});
</script>

</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup Page</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .container-fluid {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    margin: 20px;
  }
  .container-fluid h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  .container-fluid .form-group {
    margin-bottom: 15px;
  }
  .container-fluid label {
    font-weight: bold;
    color: #555;
  }
  .container-fluid input[type="text"],
  .container-fluid input[type="email"],
  .container-fluid input[type="password"],
  .container-fluid textarea {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  .container-fluid .button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .container-fluid .button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>

<div class="container-fluid">
  <h2>Signup</h2>
  <form action="" id="signup-frm">
    <div class="form-group">
      <label for="name" class="control-label">Name</label>
      <input type="text" id="name" name="name" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="contact" class="control-label">Contact</label>
      <input type="text" id="contact" name="contact" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="address" class="control-label">Address</label>
      <textarea id="address" cols="30" rows="3" name="address" required="" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label for="email" class="control-label">Email</label>
      <input type="email" id="email" name="email" required="" class="form-control">
    </div>
    <div class="form-group">
      <label for="password" class="control-label">Password</label>
      <input type="password" id="password" name="password" required="" class="form-control">
    </div>
    <button type="submit" class="button btn btn-info btn-sm">Create</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Handle form submission
  $('#signup-frm').submit(function(e) {
    e.preventDefault();
    $('#signup-frm button[type="submit"]').attr('disabled', true).html('Saving...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'admin/ajax.php?action=signup',
      method: 'POST',
      data: $(this).serialize(),
      error: function(err) {
        console.log(err);
        $('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
      },
      success: function(resp) {
        if (resp == 1) {
          window.location.href = 'index.php';
        } else {
          $('#signup-frm').prepend('<div class="alert alert-danger">Email already exists.</div>')
          $('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
        }
      }
    });
  });
});
</script>

</body>
</html> -->
