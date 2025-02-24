<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database_name = "zaras";

    $conn = mysqli_connect($server_name, $username, $password, $database_name);

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];

        // Server-side validation
        $errors = [];

        if (empty($name) || preg_match('/^\d+$/', $name)) {
            $errors[] = "Name cannot be empty or contain digits.";
        }

        if (empty($phone) || !preg_match('/^\d+$/', $phone)) {
            $errors[] = "Phone must contain only digits.";
        }

        if (empty($errors)) {
            $sql_query = "INSERT INTO zdetail (name, subject, email, phone, message) VALUES ('$name', '$subject', '$email', '$phone', '$message')";

            if (mysqli_query($conn, $sql_query)) {
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="icon" type="image/png" href="favicon1.png">
                    <link rel="stylesheet" href="style.css">
                    <title>Thank You</title>
                </head>
                <body>
                    <div class="copy">
                        <div class="container">
                            <h1>Thank you for contacting us. We will get back to you as soon as possible!</h1>
                            <p class="back">Go back to the <a href="./index.html">homepage</a></p>
                        </div>
                    </div>
                </body>
                </html>
                ';
            } else {
                echo "Error: " . $sql_query . " " . mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        }
    }
} else {
    echo "Invalid Request Method.";
}
?>
