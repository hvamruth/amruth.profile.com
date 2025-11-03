<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Recipient email
    $to = "amsgr4@gmail.com";

    // Subject
    $subject = "New Contact Form Submission from $name";

    // Email content
    $body = "
    You have received a new message from your website contact form.

    Name: $name
    Email: $email
    Message:
    $message
    ";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "<h2>Thank you, $name. Your message has been sent successfully!</h2>";
    } else {
        echo "<h2>Sorry, something went wrong. Please try again later.</h2>";
    }
} else {
    echo "<h2>Access Denied!</h2>";
}
?>
