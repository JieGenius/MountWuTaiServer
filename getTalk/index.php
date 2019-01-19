<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/10/2
 * Time: 23:15
 */
$page = 0;
$link = mysqli_connect('localhost','root','root');
/*
 * 获取一个新的连接。
 */
$link2=mysqli_connect("localhost","root","root","mount_wutai");
$link3 = mysqli_connect("localhost","root","root","mount_wutai");

if($link){
    mysqli_select_db($link,'mount_wutai');
    $sql = 'select * from talkinfo order by id desc limit ?,?';
    $stmt = mysqli_prepare($link,$sql);
    $startRow = $page *20;
    $rowCount = 20;
    mysqli_stmt_bind_param($stmt,"ii",$startRow,$rowCount);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$id,$user_id,$content,$picCount,$time);
    $talks = new Talks();
    while(mysqli_stmt_fetch($stmt)){
        $talkItem = new TalkItem();

        /*
         * 获取用户名
         */
        $getNameSql ="select name,head_pic_stream from userinfo where id=$user_id";
        $nameResult = mysqli_query($link2, $getNameSql);
        if(!$nameResult){
            printf("Error: %s\n", mysqli_error($link2));
            exit();
        }
        $rowName = mysqli_fetch_array($nameResult);
        $talkItem->id = $id;
        $talkItem->userName=$rowName[0];
        $talkItem->userPic=$rowName[1];
        $talkItem->content = $content;
        $talkItem->sendTime = $time;

        /*
         * 获取图片名称集合
         */
        $talkItem->picArr=array();
        $getPicNameSql = "select name from talkpic where talk_id = $id";
        $picNameResult = mysqli_query($link2,$getPicNameSql);
        if(!$picNameResult){
            printf("Error: %s\n", mysqli_error($link2));
            exit();
        }

        while($rowPic = mysqli_fetch_array($picNameResult)){
            $talkItem->picArr[]=$rowPic[0];
        }

        /*
         * 获取评论集合
         */
        $talkItem->commArr=array();
        $getCommSql = "select content,name from comminfo,userinfo where comminfo.user_id = userinfo.id and comminfo.talk_id = $id";
        $commResult = mysqli_query($link3,$getCommSql);
        if(!$commResult){
            printf("Error: %s\n", mysqli_error($link3));
            exit();
        }
        while ($rowComm = mysqli_fetch_array($commResult)){
            $commItem = new commItem();
            $commItem->name=$rowComm[1];
            $commItem->content=$rowComm[0];
            $commItem->time="2018-10-3 17:02:55";
            $talkItem->commArr[]=$commItem;
        }
        $talks->addATalk($talkItem);
    }

    echo json_encode($talks);
}
class Talks{
    public $talkArr;
    public function __construct()
    {
        $this->talkArr=array();
    }
    public function addATalk(TalkItem $talkItem){
        $this->talkArr[]=$talkItem;
    }
}
class TalkItem{
    public $id;
    public $userName;
    public $content;
    public $sendTime;
    public $picArr;
    public $commArr;
    public $userPic;
}
class commItem{
    public $name;
    public $time;
    public $content;
}