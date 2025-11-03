<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $to = "amsgr4@gmail.com";
    $subject = "New Contact Form Message";

    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Validate fields
    if(empty($name) || empty($email) || empty($message)){
        echo "Please fill all fields!";
        exit;
    }

    $body = "You have received a new message from the contact form.\n\n".
            "Name: $name\n".
            "Email: $email\n".
            "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    if(mail($to, $subject, $body, $headers)){
        echo "✅ Message sent successfully!";
    } else {
        echo "❌ Failed to send message. Server mail function may be disabled.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <form action="form.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Message:</label><br>
        <textarea name="message" required></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>
</body>
</html>
