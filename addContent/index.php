<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/12
 * Time: 17:20
 */

    $link = mysqli_connect('localhost','root','root');
    if($link){
        $share_author=$_GET['author'];
        echo $share_author."<br>";
        date_default_timezone_set("Asia/Shanghai");
        $share_time = date("y-m-d h:i:m");
        echo $share_time;
        $share_content = $_GET['content'];
        echo $share_content;
        mysqli_select_db($link,'mount_wutai');
        $sql = 'insert into community(share_author,share_time,share_content)values(?,?,?) ';
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($stmt,'sss',$share_author,$share_time,$share_content);
        //mysqli_query($link,$sql);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)) {
            echo "添加成功";
        }
        else{
            echo "添加失败";
        }
    }
    else{
        echo "数据库连接失败";
    }

