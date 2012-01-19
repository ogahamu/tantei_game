<style type="text/css">
<!--
.style1 {
  color: #CCCCCC;
  font-size: 14px;
}
-->
</style>
<table width="320" border="0" bgcolor="#000000">
  <tr>
    <td height="17"><div align="center"><img src="<?php echo $enemy_thumnail_url;?>" width="225" height="64"></div></td>
  </tr>
  <tr>
    <td height="82"><img src="<?php echo $enemy_thumnail_url;?>" width="63" height="64"><span class="style1"><br>
      <?php echo $enemy_name;?> を事件の犯人だと疑う</span></td>
  </tr>
  <tr>
    <td height="15">
    <?php if($power>=50){ ?>
      <div align="center">
        <a href="<?php echo $link_url;?>">「犯人はこの人です！」</a>
      </div>
      <?php }else{ ?>
      <div align="center">
                パワーが足りない為、バトル開始できません。<a href="/cake/item/item_power_top/">体力回復する</a>
      </div>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td height="165">&nbsp;</td>
  </tr>
</table>
