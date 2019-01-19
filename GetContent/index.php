<?php
/**
 * Created by PhpStorm.
 * User: Genius
 * Date: 2018/7/19
 * Time: 14:25
 */

$resultS = new ResultSet();
$resultS->num = 0;
$resultS->list=array();
$link = mysqli_connect('localhost','root','root');
mysqli_select_db($link,'mount_wutai');
$sql = 'select * from community order by share_id desc';

$result = mysqli_query($link,$sql);

/**
 * function __construct($shareAuthor,$shareContent,$shareTime,$sharePicPath,$AuthorPic)
 */
while ($rows = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    $nameAndPath = getAuthorAndPicPath($link,$rows["user_id"]);
    $resultS->list[]=new ItemCommunity($nameAndPath[0],$rows["share_content"],
        $rows["share_time"],explode(";",$rows["share_pic_positi"]),$nameAndPath[1]);
}
$s = json_encode($resultS);
echo $s;


function getAuthorAndPicPath($link,$id){
    $sql = "select user_name,user_head_portrait from user where user_id = $id";
    $rresult = mysqli_query($link,$sql);
    $rows = mysqli_fetch_array($rresult,MYSQLI_ASSOC);
    $res = array($rows["user_name"],$rows["user_head_portrait"]);
    return $res;
}



class ResultSet
{
    public $num;
    public $list;
}

class ItemCommunity
{
    public $shareAuthor;
    public $shareContent;
    public $shareTime;
    public $sharePicPath;
    public $AuthorPic;
    public function __construct($shareAuthor,$shareContent,$shareTime,$sharePicPath,$AuthorPic)
    {
        $this->shareAuthor = $shareAuthor;
        $this->shareContent = $shareContent;
        $this->shareTime = $shareTime;
        $this->sharePicPath = $sharePicPath;
        $this->AuthorPic = $AuthorPic;
    }

}


