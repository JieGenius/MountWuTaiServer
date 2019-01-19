<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/7/19
 * Time: 14:23
 */
$user_id = $_POST["userId"];
$share_content = $_POST["content"];
//$user_head_portraits = "http://139.199.37.80/use_head_portraits_pic/$user_id.png";
date_default_timezone_set("Asia/Shanghai");
$share_time = date("y-m-d h:i:m");
$link = mysqli_connect('localhost','root','root');
if($link){
    mysqli_select_db($link,'mount_wutai');
    $sql = 'select max(share_id) from community';//为了确定下标
    $result = mysqli_query($link,$sql);
    $rows = mysqli_fetch_array($result,MYSQLI_NUM);
    $share_id = $rows[0]+1;
    /**
     * 根据用户的id查寻
     */
    $share_pic_position="";
    for($i=0;$i<count($_FILES);$i++){
        $temp_path = $_FILES[$i]['tmp_name'];
        move_uploaded_file($_FILES[$i]["tmp_name"],"C:\phpStudy\PHPTutorial\WWW\use_comment_pic\\"."$share_id"."_"."$i.jpg");
        $share_pic_position = $share_pic_position."/use_comment_pic/$share_id"."_"."$i.jpg;";
    }

    $sql = 'insert into community(user_id,share_time,share_content,share_pic_positi)values(?,?,?,?) ';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param($stmt,'isss',$user_id,$share_time,$share_content,$share_pic_position);
    mysqli_stmt_execute($stmt);
    echo mysqli_stmt_error($stmt);
    if(mysqli_stmt_affected_rows($stmt)!=-1&&mysqli_stmt_affected_rows($stmt)!=0) {
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