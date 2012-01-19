<style type="text/css">
<!--
.style1 {
  color: #CCCCCC;
  font-size: 14px;
}
.style12 {
  color: #FF0000;
  font-weight: bold;
}
-->
</style>
<table width="320" border="0" class="treasure">
  <tr>
    <td height="47"><span class="style1">レベルの近いユーザー一覧。<br>
    バトルをすることで経験値やアイテムを奪うことができます。</span></td>
  </tr>
</table><br>
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#666666">
        <th height="19" colspan="2">名前</th>
        <th width="98">選択</th>
      </tr>
      <?php foreach($data as $datas): ?>
      <tr bgcolor="#CCCCCC">
        <td width="48" height="33" bgcolor="#000000"><img src="<?php echo $datas['members']['thumnail_url'] ?>" width="48" height="55"><span class="style1"><br>
        </span></td>
        <td width="164" bgcolor="#000000"><span class="style1"><?php echo $datas['members']['name'] ?>さん (Lv.<?php echo $datas['members']['lv'] ?>)<br>
        <?php echo $datas['members']['win_count'] ?>勝<?php echo $datas['members']['lose_count'] ?>敗
        </span></td>
        <td bgcolor="#000000"><a href="/cake/confront/battle_top/<?php echo $datas['members']['id'] ?>">バトル開始</a></td>
      </tr>
      <tr>
        <td colspan="5"><hr></td>
        </tr>
      <?php endforeach; ?>
    </table>
      <?php if(count($data)<=0){?>
      <br>
      <table width="315" height="150" border="0" bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="message">
        <tr>
          <td><span class="style12">【対象なし】<br>
            近いレベルのユーザーがいません。</span> <br>

      </td>
        </tr>
      </table>      <?php } ?></td>
  </tr>
</table>

