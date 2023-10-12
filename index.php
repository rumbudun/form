<!DOCTYPE html>
<html>
<head>
  <title>Contact Form</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script>
    $(document).ready(function() {
      $('#submit').click(function(e) {
        e.preventDefault();

        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();
        var captcha = $('#g-recaptcha-response').val();

        $.ajax({
          url: 'process.php',
          type: 'POST',
          data: {
            name: name,
            email: email,
            message: message,
            captcha: captcha
          },
          success: function(response) {
            $('#form')[0].reset();
            $('#success').html(response);
          },
          error: function(response) {
            $('#error').html(response.responseText);
          }
        });
      });
    });
  </script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<h1>Contact Form</h1>
  <form id="contact-form" method="post" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" placeholder="Enter your message" required></textarea>

    <div class="g-recaptcha" data-sitekey="6Lc1ZqEkAAAAACglgKxebGtcmubbxBhiOe"></div>

    <input type="submit" value="Submit">
  </form>
</body>
</html>



