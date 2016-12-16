<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'/>
        <link rel="shortcut icon" href="<?=$siteroot?>/img/favicon.ico" />
        <link rel='stylesheet' href='<?=$siteroot?>/Ranking.css'>
        <script type="text/javascript" src="<?=$siteroot?>/jquery.min.js"></script>
        <script type="text/javascript">
        </script>
        <title>Ranking</title>
    </head>
    <body>
        <div id="OuterFrame">
            <div id="InnerFrame">
            <center><h1><?=$title?></h1></center>
                <table id="Scoreboard">
                    <colgroup id="Scoreboard_cols">
                        <col class="rank" />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                        <col />
                    </colgroup>
                    <thead id="Scoreboard_head">
                        <tr>
                            <th>rank</th>
                            <th>name</th>
                            <?php foreach($problem_list as $res){ ?>
                            <th class="score task" ><?=$res->name?></th>
                            <?php } ?>
                            <th class="score task" ><?=$title?></th>
                        </tr>
                    </thead>
                    <tbody id="Scoreboard_body">
                        <?php for($j=0;$j<count($contest->ranklist);$j++){
                            $res=$user_list[$contest->ranklist[$j]];?>
                        <tr class="user">
                            <td class="rank"><?=$res->rank?></td>
                            <td class="name"><?=$res->name?></td>
                            <?php 
                            $all_score = 0;
                            for($i=0;$i<$pr_num;$i++){
                                $all_score += $problem_list[$i]->grade;
                                $range = (int)((int)(($res->score[$i]/$problem_list[$i]->grade)*10)*10);
                                if($range<10)$range=10;
                                if($range>100)$range=100;?>
                            <td class="score task score_<?=$range-10 ?>_<?=$range?>"><?=$res->score[$i]?></td>
                            <?php } ?>
                            <?php
                                $sumrange = (int)((int)(($res->scoresum/$all_score)*10)*10);
                                if($sumrange<10)$sumrange=10;
                                if($sumrange>100)$sumrange=100;
                            ?>
                            <td class="score task score_<?=$sumrange-10 ?>_<?=$sumrange?>"><?=$res->scoresum?></td>
                        </tr>
                        <?php } ?>
                        <!--<tr class="user">
                            <td class="rank">1</td>
                            <td class="f_name">test</td>
                            <td class="l_name">test</td>
                            <td class="score task score_10_20">15</td>
                            <td class="score task score_20_30">25</td>
                            <td class="score task score_30_40">35</td>
                            <td class="score task score_40_50">45</td>
                            <td class="score task score_50_60">55</td>
                            <td class="score task score_60_70">65</td>
                            <td class="score task score_70_80">75</td>
                            <td class="score task score_80_90">85</td>
                            <td class="score task score_100">100</td>
                        </tr>
                        <tr class="user">
                            <td class="rank">2</td>
                            <td class="f_name">test2</td>
                            <td class="l_name">test2</td>
                            <td class="score task score_10_20">15</td>
                            <td class="score task score_20_30">25</td>
                            <td class="score task score_30_40">35</td>
                            <td class="score task score_40_50">45</td>
                            <td class="score task score_50_60">55</td>
                            <td class="score task score_60_70">65</td>
                            <td class="score task score_70_80">75</td>
                            <td class="score task score_80_90">80</td>
                            <td class="score task score_100">90</td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        
    </body>
</html> 
