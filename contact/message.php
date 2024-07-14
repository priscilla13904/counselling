<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edoc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM contact_us WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve data from the contact_us table
$sql = "SELECT id, c_name, c_subject, c_email, c_phone_no, c_msg FROM contact_us";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Contact Us Data</h2>
    <a href="../counsellor/index.php" class="btn btn-primary mb-3">Back</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["c_name"] . "</td>";
                    echo "<td>" . $row["c_subject"] . "</td>";
                    echo "<td>" . $row["c_email"] . "</td>";
                    echo "<td>" . $row["c_phone_no"] . "</td>";
                    echo "<td>" . $row["c_msg"] . "</td>";
                    echo "<td>
                        <form method='post' action='' style='display:inline-block;'>
                            <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                        <button class='btn btn-info' onclick='viewRecord(" . $row["id"] . ")'>View</button>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No results found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
function viewRecord(id) {
    alert("View record with ID: " + id);
    // You can implement more complex view functionality here, such as opening a modal or navigating to another page
}
</script>
</body>
</html>
