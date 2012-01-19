<table width="320" border="0" class="treasure">
  <tr>
    <td height="47"><img src="/img/evidence/<?php echo $img_id;?>.png" width="32" height="32"><?php echo $evidence_name;?>を所持しているユーザー。<br>
    もしかすると彼らが犯人かもしれない...怪しい人物がいたら事情聴取しよう。</td>
  </tr>
</table>
<br>
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#666666">
          <th height="19" colspan="2">名前</th>
          <th width="98">選択</th>
        </tr>
        <?php foreach($data as $datas): ?>
        <tr bgcolor="#CCCCCC">
          <td width="48" height="33"><img src="<?php echo $datas['members']['thumnail_url'] ?>" width="48" height="55"></td>
          <td width="164"><?php echo $datas['members']['name'] ?>さん(Lv<?php echo $datas['members']['lv'] ?>)<br>
            <?php echo $datas['members']['win_count'] ?>勝<?php echo $datas['members']['lose_count'] ?>敗</td>
          <td><a href="/cake/confront/rob_battle/member_evidence_id:<?php echo $datas[0]['member_evidence_id'] ?>/enemy_member_id:<?php echo $datas['members']['id'] ?>#header-menu">事情聴取</a></td>
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
            対象のアイテムを持っているユーザーがいません。</span> <br> </td>
        </tr>
      </table>
      <?php } ?></td>
  </tr>
</table>
