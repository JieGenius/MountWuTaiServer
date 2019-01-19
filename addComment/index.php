<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/7
 * Time: 20:41
 */
    $userPhone = $_POST["user_phone"];
    $talkId = $_POST["talk_id"];
    $commentContent = $_POST["comment_content"];
    date_default_timezone_set("Asia/Shanghai");
    $share_time = date("y-m-d h:i:m");
    $link = mysqli_connect('localhost','root','root',"mount_wutai");
    if($link){
        $sql = "select id from userinfo where phone=$userPhone";
        $userIdResult = mysqli_query($link,$sql);
        if(!$userIdResult){
            printf("Error: %s\n", mysqli_error($link));
            exit();
        }
        else{
            $rowId = mysqli_fetch_array($userIdResult);
            $userId = $rowId[0];

            $sql = "insert into comminfo (talk_id,user_id,content,time) values (?,?,?,?)";
            $stmt = mysqli_prepare($link,$sql);
            mysqli_stmt_bind_param($stmt,"iiss",$talkId,$userId,$commentContent,$share_time);
            $result = mysqli_stmt_execute($stmt);

            if($result){
                echo "插入成功";
            }
            else{
                echo "插入失败";
            }
        }

    }