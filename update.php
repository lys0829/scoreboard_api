<?php
/**$_POST['change'] struct
 *$info->vpl_uid
 *$info->vpl_id
 *$info->change_score
 *$info->class_name
 *$info->contest_name
 **/
if(isset($_POST['change'])){
    $info = json_decode($_POST['change']);
    foreach($user_list as $u){
        if($user_list[$u->id]->vpl_uid == $info->vpl_uid){
            $info->uid = $u->id;
            break;
        }
    }
    $rpid = 0;
    $info->pid = -1;
    foreach($problem_list as $pro){
        if($pro->vpl_id == $info->vpl_id){
            $info->pid = $rpid;
            break;
        }
        $rpid++;
    }
    if($info->pid==-1)exit('no problem');
    if($info->change_score>$user_list[$info->uid]->score[$info->pid])$user_list[$info->uid]->score[$info->pid] = (int)$info->change_score;
    file_create($dir."/users/user{$info->uid}.json",json_encode($user_list[$info->uid]->score));
    
    $user_list[$info->uid]->scoresum = 0;
    foreach($user_list[$info->uid]->score as $sc){
        $user_list[$info->uid]->scoresum += $sc;
    }
    
    $sa[$info->uid] = $user_list[$info->uid]->scoresum;
    
    arsort($sa);
    $urankl = [];
    $i=0;
    $uranknum = 1;
    $uranknumsh = 1;
    $upuscore = 0;
    $user_list_save = [];
    for($j=0;$j<count($user_list);$j++)$user_list_save[$j] = new stdclass;
    foreach($sa as $key => $val){
        //echo "$key <p>";
        if($user_list[$key]->scoresum != $upuscore && $i!=0){
            $uranknumsh = $uranknum;
        }
        $user_list[$key]->rank = $uranknumsh;
        $user_list_save[$key]->vpl_uid = $user_list[$key]->vpl_uid;
        $user_list_save[$key]->rank = $user_list[$key]->rank;
        $user_list_save[$key]->id = $user_list[$key]->id;
        $user_list_save[$key]->name = $user_list[$key]->name;
        $urankl[$i] = $key;
        $upuscore = $val;
        $uranknum++;
        $i++;
    }
    $contest->ranklist = $urankl;
    file_create($dir.'/contest.json',json_encode($contest));
    
    $sublist = [];
    $sublist = json_decode(file_read($dir.'/submission_list.json'));
    $sid = 0;
    if(count($sublist)>0)$sid = sublist[count($sublist)-1]->id;
    //$info = json_decode($_POST['change']);
    $sublist_add = new stdclass();
    $sublist_add->id = $sid;
    $sublist_add->time_update = time();
    $sublist_add->uid = $info->uid;
    $sublist_add->pid = $info->pid;
    $sublist_add->score = $info->change_score;
    $sublist[count($sublist)] = $sublist_add;
    file_create($dir.'/submission_list.json',json_encode($sublist));
    //file_create($classn.'/userlist.json',json_encode($user_list_save));
    exit('SUCC');
}
