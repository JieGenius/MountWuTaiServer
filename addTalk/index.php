<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/10/2
 * Time: 19:06
 */
$phone = $_POST["phone"];
$content = $_POST["content"];
//$user_head_portraits = "http://139.199.37.80/use_head_portraits_pic/$user_id.png";
date_default_timezone_set("Asia/Shanghai");
$share_time = date("y-m-d H:i:m");
$link = mysqli_connect('localhost','root','root');
if($link){
    mysqli_select_db($link,'mount_wutai');
    /*
     * 获取下一个自增值
     */
    $sql = 'select AUTO_INCREMENT from INFORMATION_SCHEMA.TABLES where  TABLE_NAME = "talkinfo"';
    $result = mysqli_query($link,$sql);
    $rows = mysqli_fetch_array($result,MYSQLI_NUM);
    $id = $rows[0];
    /*
     * 根据phone获取user_id
     */
    $sql="select id from userinfo where phone = $phone";
    $result = mysqli_query($link,$sql);
    $rows = mysqli_fetch_array($result,MYSQLI_NUM);
    $user_id = $rows[0];


    /**
     * 存取图片信息
     */

    $pic_count=count($_FILES);
    for($i=0;$i<$pic_count;$i++){
        $temp_path = $_FILES[$i]['tmp_name'];
        $pic_name = "$id"."_"."$i.jpg";
        move_uploaded_file($temp_path,"C:\phpStudy\PHPTutorial\WWW\userTalkPic\\".$pic_name);
        $sql = "insert into talkpic(name,talk_id,level)values (?,?,?)";
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt,"ssi",$pic_name,$id,$i);
        mysqli_stmt_execute($stmt);
	echo mysqli_stmt_affected_rows($stmt);
    }
    /*
     * 存取说说
     */
    $sql = 'insert into talkinfo(user_id,content,pic_num,time)values(?,?,?,?) ';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param($stmt,'isss',$user_id,$content,$pic_count,$share_time);
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_affected_rows($stmt)>0) {
        echo mysqli_stmt_affected_rows($stmt);
        echo "添加成功 ";
    }
    else{
        echo "添加失败";
    }
}
else{
    echo "数据库连接失败";
}