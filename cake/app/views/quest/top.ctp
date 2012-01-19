
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><H1>事件簿_一覧</H1>
      <hr>
      <table width="320" border="0" class="message">
        <tr>
          <td>解決する事件を選択してください。<br>
          <img src="/img/shitai_icon.png" width="20" height="20">未解決<img src="/img/shitai_icon.png" width="20" height="20">犯人逮捕<img src="/img/shitai_icon.png" width="20" height="20">真相究明<br></td>
        </tr>
      </table>
      <br>
      <?php echo $vlist;?>
      <table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th width="210" height="19">&nbsp;</th>
        <th width="100">&nbsp;</th>
      </tr>
      <?php foreach($data as $datas): ?>
      <tr>
        <td><H2><?php if($datas['MemberQuest']['resolved_flag']==1){ ?><img src="/img/shitai_icon.png" width="18" height="18"><?php }else{ ?><img src="/img/shitai_icon.png" width="18" height="18"><?php } ?><?php echo $datas['MemberQuest']['title'] ?></H2>
          目撃者：<?php for($i=0;$i<$datas['MemberQuest']['challenge_count'];$i++){?><img src="/img/eye_icon.png" width="15" height="15"><?php } ?>
          <br>
          集めた証拠：<?php for($i=0;$i<$datas['MemberQuest']['evidence_count'];$i++){?><img src="/img/evidence_icon.png" width="15" height="15"><?php } ?>
          <br>
          <?php if(($datas['MemberQuest']['resolved_flag']==1)&&($datas['MemberQuest']['evidence_compleate_flag']==1)&&($datas['MemberQuest']['real_fact_resolved_flag']==0)){ ?><img src="/img_0113.png" alt="真相の扉" width="163" height="20"><?php } ?>
      <?php if(($datas['MemberQuest']['resolved_flag']==1)&&($datas['MemberQuest']['evidence_compleate_flag']==1)&&($datas['MemberQuest']['real_fact_resolved_flag']==1)){ ?><img src="/img_0113.png" alt="真相解決" width="163" height="20"><?php } ?>
      </td>
        <td><a href="/cake/quest/datalist/<?php echo $datas['MemberQuest']['id'] ?>#header-menu"><img src="/img/evidence2_icon.png" width="18" height="18">事件簿を見る</a></td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
        </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
</table>



