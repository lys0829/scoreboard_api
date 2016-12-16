<?php
/**$_POST['change'] struct
 *$info->vpl_uid
 *$info->vpl_id
 *$info->change_score
 *$info->class_name
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
    
    $user_list[$info->uid]->scoresum = 0;
    foreach($user_list[$info->uid]->score as $sc){
        $user_list[$info->uid]->scoresum += $sc;
    }
    
    $sa[$info->uid] = $user_list[$info->uid]->scoresum;
    file_create($classn."/users/user{$info->uid}.json",json_encode($user_list[$info->uid]->score));
    
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
    exit('SUCC');
}
