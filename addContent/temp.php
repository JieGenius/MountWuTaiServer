<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/7/19
 * Time: 14:25
 */
/*print_r($_POST);
print_r($_FILES);*/
/*$b= move_uploaded_file($_FILES["headImage"]["tmp_name"],"C:\Users\Administrator\\"."d.jpg");
echo $b;
var_dump($b);*/

$link = mysqli_connect('localhost','root','root');
mysqli_select_db($link,'mount_wutai');
$sql = 'select max(share_id) from community';
$b = mysqli_query($link,$sql);
$rows = mysqli_fetch_array($b,MYSQLI_NUM);
echo $rows[0];
print_r($rows);