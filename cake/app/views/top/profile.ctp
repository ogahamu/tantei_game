<link href="/js/progress/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/progress/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/js/progress/jquery-ui-1.8.11.custom.min.js"></script>
<style type="text/css">
#progressbar {width: 120px; height: 10px;}
#progressbar .ui-progressbar-value { background-color: #0033CC;}
.style1 {color: #FFFFFF}
.style2 {font-size: 10px}
.style13 {color: #FFFFFF; font-size: 10px; font-weight: bold; }
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
        <tr class="style1">
          <td colspan="2"><span class="style1">自分 <a href="/cake/top/change_avatar/">アバターの変更</a><br>
            </span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td width="71"><span class="style13">レべル</span></td>
          <td width="215"><span class="style1">lv<?php echo $mdatas['lv'];?></span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td width="71"><span class="style13">Exp</span></td>
          <td width="215"><span class="style1">Exp<?php echo $mdatas['exp'];?>[次のレベルまで<?php echo $mdatas['least_next_exp'];?>]</span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td><span class="style13">体力</span></td>
          <td><span class="style1">
            <div id="progressbar"> <span class="style2"></span></div>
            </span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td><span class="style13">所持金</span></td>
          <td><span class="style1">$<?php echo $mdatas['money'];?></span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td rowspan="3"><span class="style13">能力</span></td>
          <td><span class="style1">推理力<?php echo $mdatas['attack_power'];?></span>
            <hr></td>
        </tr>
        <tr>
          <td><span class="style1">弁護力<?php echo $mdatas['defence_power'];?></span>
            <hr></td>
        </tr>
        <tr>
          <td><span class="style1">運<?php echo $mdatas['fortune_power'];?></span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td><span class="style13">順位</span></td>
          <td><span class="style1"><?php echo $ranking_txt;?></span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td>&nbsp;</td>
          <td><span class="style1"></span></td>
        </tr>
        <tr class="style1">
          <td colspan="2"><span class="style13">事件</span>
          <hr></td>
        </tr>
        <tr class="style1">
          <td rowspan="3"><span class="style13">事件解決数</span></td>
          <td><span class="style1"><?php echo $mdatas['mission_count'];?>件</span>
            <hr></td>
        </tr>
        <tr>
          <td class="style1">真相の解決：</td>
        </tr>
        <tr>
          <td class="style1">証拠完全収集：</td>
        </tr>
        <tr class="style1">
          <td rowspan="2"><span class="style13">検挙勝敗</span></td>
          <td><span class="style1">成功　<?php echo $mdatas['win_count'];?>件</span></td>
        </tr>
        <tr>
          <td class="style1">失敗　<?php echo $mdatas['lose_count'];?>件<br>
            <hr></td>
        </tr>
        <tr class="style1">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="style1">
          <td colspan="2"><span class="style13">証拠</span>
          <hr></td>
        </tr>
        <tr class="style1">
          <td><span class="style13">集めた証拠数</span></td>
          <td><span class="style1"><?php echo $evidence_count;?>個</span>
            <hr></td>
        </tr>
        <tr class="style1">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?php endforeach; ?> </td>
  </tr>
</table>
