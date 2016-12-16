<?php
//echo "in";
require_once "File.php";

srand();
$classn = "2016109";
if(!is_dir($classn))mkdir($classn);
if(!is_dir($classn.'/users'))mkdir($classn.'/users');

$data = read_csv("rankdata/{$classn}.csv");
$contest = json_decode(file_read('rankdata/contest.json'));
$problem = $contest->problem;
$pro_num = $contest->pro_num;
//echo json_encode($data);
$json = [];
$i=0;
foreach($data as $res){
    $score = [];
    for($j=0;$j<$pro_num;$j++)$score[$j] = 0;
    $score = json_encode($score);
    $user = new Stdclass();
    $user->vpl_uid = (int)$res[0];
    $user->id = $i;
    $user->name = (string)$res[2];
    //echo $user->name."<p>";
    $user->rank = (int)1;
    $json[$i] = $user;
    file_create("{$classn}/users/user{$i}.json", $score);
    $i++;
}
$json = json_encode($json);
//echo $json;
file_create("{$classn}/userlist.json", $json);
file_create("{$classn}/contest.json", json_encode($contest));

echo "SUCC";
