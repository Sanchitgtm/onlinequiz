
<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'session');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['user'];
$pass = $_POST['pswd'];

$sql = "SELECT * FROM signin WHERE name='$name'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    header('Location: form.php?error=user_exists');
} else {
    $sql1 = "INSERT INTO signin(name, password) VALUES ('$name', '$pass')";
    if (mysqli_query($conn, $sql1)) {
        header('Location: form.php?success=signup_successful');
    } else {
        header('Location: form.php?error=signup_failed');
    }
}
?>
