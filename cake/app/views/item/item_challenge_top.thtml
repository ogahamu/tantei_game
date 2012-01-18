<table width="320" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="/cake/item/top/">購買部に戻る</a> </td>
  </tr>
  <tr>
    <td><div align="center"><img src="/jpg/no_battle.png" width="156" height="144"></div></td>
  </tr>
  <tr>
    <td>

  <?php if(strlen($member_quest_id)>0){ ?>
  購買部<br>[解決編_挑戦回数:<?php echo $max_challenge_count; ?>回[集めた証拠：<?php echo $ev_count;?>個  + 目撃者:<?php echo $challenge_count; ?>]<br>

<?php if($max_challenge_count>=9){ ?><span class="warning01">最大数９個に達しています。これ以上増やしても意味がありません。</span><?php } ?>
      <a href="/cake/item/item_challenge_exe/<?php echo $member_quest_id; ?>">-アイテム使う[残り<?php echo $amount; ?>個]-</a>
    <br><br>
    <a href="/cake/quest/datalist/<?php echo $member_quest_id;?>">捜査に戻る</a>
<?php }else{ ?>
--ここでは使用できません。[<?php echo $item_challenge;?>個所持]--
<?php } ?>
<br><br><?php if($after_money<0){ ?><span class="warning01">残高が不足しています..</span><br><?php } ?>
      <a href="/cake/item/item_challenge_get/">-購入する[所持金$<?php echo $money;?>->$<?php echo $after_money;?>]-</a>

    </td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
