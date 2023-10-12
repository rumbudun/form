<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  // Validate reCAPTCHA response
  if(isset($_POST['g-recaptcha-response'])) {
    $captcha_response = $_POST['g-recaptcha-response'];
    $secret_key = '6Lc1ZqEkAAAAACglgKxebGtcmubbxBhiOe-dfeV-';
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $data = array(
      'secret' => $secret_key,
      'response' => $captcha_response
    );

    $options = array(
      'http' => array(
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    if($response->success) {
      // Validate form data
      if(!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Send email
        $to = 'balguzhinov2016@gmail.com';
        $subject = 'New message from Contact Form';
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email\nReply-To: $email";

        // Set up mail server configuration
        ini_set('SMTP', 'your_mail_server_here');
        ini_set('smtp_port', 'your_mail_server_port_here');
        ini_set('sendmail_from', 'your_email_address_here');

        if(mail($to, $subject, $body, $headers)) {
          // Send success response
          http_response_code(200);
          echo "Thank you! Your message has been sent.";
        } else {
          // Send error response
          http_response_code(500);
          echo "Oops! Something went wrong and we couldn't send your message.";
        }
      } else {
        // Send error response
        http_response_code(400);
        echo "Please fill in all required fields and enter a valid email address.";
      }
    } else {
      // Send error response
      http_response_code(400);
      echo "Please verify that you are not a robot.";
    }
  } else {
    // Send error response
    http_response_code(400);
    echo "Please verify that you are not a robot.";
  }
} else {
  // Send error response
  http_response_code(405);
  echo "Method not allowed.";
}

?>
