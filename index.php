<?php
//echo "in";
require_once "File.php";

$siteport = '80';
$sitedir = '/scoreboard/';
$siteroot = '//'.$_SERVER['SERVER_NAME'].':'.$siteport.$sitedir;

//echo "load data...";
$QUEST = '';
if (isset($_SERVER['PATH_INFO'])) {
    $QUEST = $_SERVER['PATH_INFO'];
}
if (!empty($QUEST)) { //remove first '/'
    $QUEST = substr($QUEST, 1);
}
$QUEST = explode('/', $QUEST);

$contestn="";
$classn="";
if(empty($QUEST[0])){
    if(!isset($_POST['change'])){
        exit ('please add class name!!!');
    }
    else{
        $classn = json_decode($_POST['change'])->class_name;
    }
}
else{
    $classn = (string)$QUEST[0];
    
}
if(empty($QUEST[1])){
    if(!isset($_POST['change'])){
        exit ('please add contest name!!!');
    }
    else{
        $contestn = json_decode($_POST['change'])->contest_name;
    }
}
else{
    $contestn = (string)$QUEST[1];
}
if(!is_dir($classn))exit ('no class');
if(!is_dir($classn.'/'.$contestn))exit ('no contest');
$dir = $classn.'/'.$contestn; 
$contest = json_decode(file_read($dir.'/contest.json'));
$pr_num = $contest->pro_num;
$title = $contest->name;
$problem_list = $contest->problem;
$user_list = json_decode(file_read($dir.'/userlist.json'));
$sa = [];
foreach($user_list as $u){
    $user_list[$u->id]->score = json_decode(file_read($dir."/users/user{$u->id}.json"));
    $user_list[$u->id]->scoresum = 0;
    foreach($user_list[$u->id]->score as $sc){
        $user_list[$u->id]->scoresum += $sc;
    }
    $sa[$u->id] = $user_list[$u->id]->scoresum;
}

require_once "update.php";

$uranknum = 1;
$uranknumsh = 1;
$upuscore = 0;
$i=0;
foreach($contest->ranklist as $key){
    if($user_list[$key]->scoresum != $upuscore && $i!=0){
        $uranknumsh = $uranknum;
    }
    $user_list[$key]->rank = $uranknumsh;
    $upuscore = $user_list[$key]->scoresum;
    $uranknum++;
    $i++;
}

require_once 'rank.php';
