<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/9/27
 * Time: 20:02
 */
$phone = $_POST['phone'];
$link = mysqli_connect('localhost','root','root');
if($link){
    mysqli_select_db($link,'mount_wutai');
    $sql = 'select name,head_pic_stream,sex,job,signature,introduction from userinfo where phone = ?';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param($stmt,"s",$phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$name,$head_pic_stream,$sex,$job,$signature,$introduction);
    mysqli_stmt_fetch($stmt);
    $information = new UserInfo($name,$head_pic_stream,$sex,$job,$signature,$introduction);
    echo json_encode($information);
}
class UserInfo{
    public $name;
    public $head_pic_stream;
    public $sex;
    public $job;
    public $signature;
    public $introduction;
    public function __construct($name,$head_pic_stream,$sex,$job,$signature,$introduction)
    {
        $this->name = $name;
        $this->head_pic_stream = $head_pic_stream;
        $this->sex = $sex;
        $this->job = $job;
        $this->signature = $signature;
        $this->introduction = $introduction;
    }
}