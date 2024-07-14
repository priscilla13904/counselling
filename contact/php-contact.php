<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $msg = $_POST['msg'];

    // Validate inputs (add more validation as needed)
    if (empty($name) || empty($subject) || empty($email) || empty($phone) || empty($msg)) {
        echo json_encode(["status" => 400, "msg" => "All fields are required."]);
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contacts (name, subject, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $subject, $email, $phone, $msg);

    if ($stmt->execute()) {
        echo json_encode(["status" => 200, "msg" => "Data submitted successfully."]);
    } else {
        echo json_encode(["status" => 500, "msg" => "Error submitting data."]);
    }

    $stmt->close();
    $conn->close();
}
?>
