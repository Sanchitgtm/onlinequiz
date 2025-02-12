<?php
session_start();

$conn = mysqli_connect('localhost','root','','session');
if($conn){
    echo "connection success";
}
else{
    echo"no connection";
}
$name=$_POST['user'];
$pass=$_POST['pswd'];

$sql="select * from signin where name='$name' && password='$pass' ";
 
$result = mysqli_query($conn,$sql);

$num = mysqli_num_rows($result);

if($num == 1){
    $_SESSION['username']=$name;
    header('location:home.php');
}
else{

    header('location:form.php');
}
?>