<?php
include("config.php");
extract($_POST);

$sql = "INSERT INTO `contactdata`(`firstname`, `lastname`, `phone`, `email`, `message`) VALUES ('".$firstname."','".$lastname."',".$phone.",'".$email."','".$message."')";
$result = $mysqli->query($sql);

if(!$result){
    die("Couldn't enter data: ".$mysqli->error);
}

echo "Thank You For Contacting Us ";
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <a href="../student/index.php" class="btn btn-primary mt-3">Back</a>
    </div>
</body>
</html>
