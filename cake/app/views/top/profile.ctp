<link href="/js/progress/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/progress/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/js/progress/jquery-ui-1.8.11.custom.min.js"></script>
<style type="text/css">
#progressbar {width: 120px; height: 10px;}
#progressbar .ui-progressbar-value { background-color: #0033CC;}
.status_data {color: #FFFFFF}
.style2 {font-size: 10px}
.status_title {color: #FFFFFF; font-size: 10px; font-weight: bold; }
</style>
<script type="text/javascript">
$(function(){
    // プログレスバーを生成
    $("#progressbar").progressbar();
    $(window).load(function() {
            var start = $(this);
            var value =100;
            var timer = setInterval(function(){
                if(value <= <?php echo $power; ?>) {
                    clearInterval(timer);
                    value = <?php echo $power; ?>;
                } else {
                    value = value - 5;
                }
                // プログレスバーの値を変更
                $("#progressbar").progressbar("option", "value", value);
            }, 100);
        })
});
</script>
<table width="310"  border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td bgcolor="#000000"></td>
  </tr>
  <tr>
    <td height="135"> <?php foreach($mdata as $mdatas): ?>
      <table width="310" border="0" bgcolor="#000000">
        <tr class="status_data">
          <td colspan="2"><span class="status_data">自分 <a href="/cake/top/change_avatar/">アバターの変更</a><br>
            </span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td width="71"><span class="status_title">レべル</span></td>
          <td width="215"><span class="status_data">lv<?php echo $mdatas['lv'];?></span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td width="71"><span class="status_title">Exp</span></td>
          <td width="215"><span class="status_data">Exp<?php echo $mdatas['exp'];?>[次のレベルまで<?php echo $mdatas['least_next_exp'];?>]</span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td><span class="status_title">体力</span></td>
          <td><span class="status_data">
            <div id="progressbar"> <span class="style2"></span></div>
            </span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td><span class="status_title">所持金</span></td>
          <td><span class="status_data">$<?php echo $mdatas['money'];?></span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td rowspan="3"><span class="status_title">能力</span></td>
          <td><span class="status_data">推理力<?php echo $mdatas['attack_power'];?></span>
            <hr></td>
        </tr>
        <tr>
          <td><span class="status_data">弁護力<?php echo $mdatas['defence_power'];?></span>
            <hr></td>
        </tr>
        <tr>
          <td><span class="status_data">運<?php echo $mdatas['fortune_power'];?></span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td><span class="status_title">順位</span></td>
          <td><span class="status_data"><?php echo $mdatas['rank_no'];?>/<?php echo $mdatas['total_members'];?></span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td>&nbsp;</td>
          <td><span class="status_data"></span></td>
        </tr>
        <tr class="status_data">
          <td colspan="2"><span class="status_title">事件</span>
          <hr></td>
        </tr>
        <tr class="status_data">
          <td rowspan="3"><span class="status_title">事件解決数</span></td>
          <td><span class="status_data"><?php echo $mdatas['mission_count'];?>件</span>
            <hr></td>
        </tr>
        <tr>
          <td class="status_data">真相の解決：</td>
        </tr>
        <tr>
          <td class="status_data">証拠完全収集：</td>
        </tr>
        <tr class="status_data">
          <td rowspan="2"><span class="status_title">検挙勝敗数</span></td>
          <td><span class="status_data">成功　<?php echo $mdatas['win_count'];?>件</span></td>
        </tr>
        <tr>
          <td class="status_data">失敗　<?php echo $mdatas['lose_count'];?>件<br>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="status_data">
          <td colspan="2"><span class="status_title">証拠</span>
          <hr></td>
        </tr>
        <tr class="status_data">
          <td><span class="status_title">集めた証拠数</span></td>
          <td><span class="status_data"><?php echo $evidence_count;?>個</span>
            <hr></td>
        </tr>
        <tr class="status_data">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?php endforeach; ?> </td>
  </tr>
</table>
