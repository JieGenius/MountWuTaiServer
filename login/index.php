<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/9/27
 * Time: 14:53
 */
$phone = $_POST['phone'];
$password = $_POST['password'];
date_default_timezone_set("Asia/Shanghai");
$link = mysqli_connect('localhost','root','root');
if($link){
    mysqli_select_db($link,'mount_wutai');
    $sql = "select password from registerinfo where phone =?";
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param($stmt,"s",$phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$correctPassword);
    if(mysqli_stmt_fetch($stmt)){
        if($password == $correctPassword){
            echo "密码正确";
        }
        else{
            echo "密码错误";
        }
    }
    else{
        $nowTime = date("y-m-d H:i:m");
        $sql = 'INSERT INTO `registerinfo`(`phone`, `password`, `register_time`) VALUES (?,?,?)';
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$phone,$password,$nowTime);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) ==1){
            echo "注册成功";
            $sql = "INSERT INTO `userinfo`(`phone`, `name`) VALUES (?,?)";
            $name = "user".time();
            $stmt = mysqli_prepare($link,$sql);
            mysqli_stmt_bind_param($stmt,"ss",$phone,$name);
            mysqli_stmt_execute($stmt);
        }
        else{
            echo "注册失败";
        }
    }
}