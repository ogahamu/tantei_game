<?php
function return_wordwrap($line){
  $n=45; #改行させる（半角での）文字数
  $rtntxt = '';
  for($i=0;$i<mb_strlen($line);$i+=$len){
    for($j=1;$j<=$n;$j++){
      $wk=mb_substr($line,$i,$j);
      if(strlen($wk)>=$n) break;
    }
    $len=mb_strlen($wk);
    $rtntxt .= "$wk<br>";
  }
  return $rtntxt;
}
?>
<?php echo $vlist;?>
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th width="158" height="19" class="status_title">名前 </th>
        <th width="57" class="status_title">解決</th>
        <th class="status_title">真相</th>
        </tr>
      <?php foreach($data as $datas): ?>
      <tr bgcolor="#000000">
        <td class="status_data"><?php echo $datas['Member']['rank_no'] ?>位 / <img src="<?php echo $datas['Member']['thumnail_url'] ?>" width="27" height="34"><?php echo $datas['Member']['name'] ?>(Lv.<?php echo $datas['Member']['lv'] ?>)</td>
        <td class="status_data"><?php echo $datas['Member']['mission_count'] ?>件</td>
        <td class="status_data"><?php echo $datas['Member']['win_count'] ?>勝/<?php echo $datas['Member']['lose_count'] ?>敗</td>
        </tr>
      <tr>
        <td colspan="3"><hr></td>
        </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
</table>

