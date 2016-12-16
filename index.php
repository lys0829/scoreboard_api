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
if(!is_dir($classn))exit ('no class');
$contest = json_decode(file_read($classn.'/contest.json'));
$pr_num = $contest->pro_num;
$title = $contest->name;
$problem_list = $contest->problem;
$user_list = json_decode(file_read($classn.'/userlist.json'));
$sa = [];
foreach($user_list as $u){
    $user_list[$u->id]->score = json_decode(file_read($classn."/users/user{$u->id}.json"));
    $user_list[$u->id]->scoresum = 0;
    foreach($user_list[$u->id]->score as $sc){
        $user_list[$u->id]->scoresum += $sc;
    }
    $sa[$u->id] = $user_list[$u->id]->scoresum;
}

require_once "update.php";

arsort($sa);
$urankl = [];
$i=0;
$uranknum = 1;
$uranknumsh = 1;
$upuscore = 0;
foreach($sa as $key => $val){
    //echo "$key <p>";
    if($user_list[$key]->scoresum != $upuscore && $i!=0){
        $uranknumsh = $uranknum;
    }
    $user_list[$key]->rank = $uranknumsh;
    $urankl[$i] = $key;
    $upuscore = $val;
    $uranknum++;
    $i++;
}
$contest->ranklist = $urankl;
file_create($classn.'/contest.json',json_encode($contest));
//$urankl = json_encode($urankl);
//echo $urankl;

//echo "loaded";
require_once 'rank.php';
