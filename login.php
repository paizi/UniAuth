<?php 
require 'db_config.php';
if(!empty($_POST["username"]) && !empty($_POST["pwd"])){
$input_username = $_POST["username"];
$input_password = $_POST["pwd"];
if(preg_match('/^[0-9a-zA-Z]+$/',$input_username) == true && preg_match('/^[0-9a-zA-Z]+$/',$input_password) == true){
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
} 
$sql = "SELECT id, username, pwd FROM user WHERE username='$input_username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $verify = $row['pwd'];
        }
} else {
    echo '无法找到此用户！<a href="register.php">点我注册</a>';
}
mysqli_close($conn);
if(!empty($verify)){
if (password_verify($input_password, $verify)) {
    echo '登录成功！';
} else {
    echo '登录失败！请检查密码是否正确！';
}}}
else {echo "只能使用大小写字母及数字！";}
}
?>
<form method="post">
用户名: <input type="text" name="username">
密码: <input type="text" name="pwd">
<input type="submit" value="提交">
</form>