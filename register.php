<?php
require 'db_config.php';
if(!empty($_POST["username"]) && !empty($_POST["pwd"])){
$input_username = $_POST["username"];
$input_password = $_POST["pwd"];
if(preg_match('/^[0-9a-zA-Z]+$/',$input_username) == true && preg_match('/^[0-9a-zA-Z]+$/',$input_password) == true){
$hash_pwd = password_hash($input_password, PASSWORD_BCRYPT);
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sqlsec="select username from user where username='$input_username' limit 1";
if ($check_reg = mysqli_query($conn, $sqlsec)){
if(mysqli_fetch_array($check_reg)){
    echo '错误：用户名 '.$input_username.' 已存在。';
    exit;
}
mysqli_free_result($check_reg);
$sqlreg = "INSERT INTO user (username, pwd) VALUES ('$input_username','$hash_pwd')";
if (mysqli_query($conn, $sqlreg)) {
    echo "注册成功";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);}
}
else {echo "只能使用大小写字母及数字！";}}
?>
<form method="post">
用户名: <input type="text" name="username">
密码: <input type="text" name="pwd">
<input type="submit" value="提交">
</form>