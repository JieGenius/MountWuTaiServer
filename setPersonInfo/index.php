<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/9/27
 * Time: 20:44
 */
$link = mysqli_connect('localhost','root','root');
if($link){
    mysqli_select_db($link,'mount_wutai');
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $job = $_POST['job'];
    $head_pic_stream=$_POST['head_pic_stream'];
    $signature = $_POST['signature'];
    $instruction = $_POST['instruction'];
    $sql = 'UPDATE `userinfo` SET `name`=?,`sex`=?,`head_pic_stream`=?,`job`=?,`signature`=?,`introduction`=? WHERE phone = ?';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param($stmt,"sssssss",$name,$sex,$head_pic_stream,$job,$signature,$instruction,$phone);
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_affected_rows($stmt)!=-1){
        echo "更新成功";
    }
    else{
        echo "更新失败".mysqli_stmt_affected_rows($stmt).mysqli_error($link);

    }
    mysqli_close($link);
}
