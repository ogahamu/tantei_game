<table width="320" border="0">
  <tr>
  <?php $i=1;?>
  <?php foreach($data as $datas): ?>
    <td width="30"><a href="/cake/evidence/evidence_detail/<?php echo $datas['evidences']['id'];?>#header-menu"><img src="/img/evidence/<?php echo $datas[0]['evidence_img_id'];?>.png" width="40" height="40" border="0">(<?php echo $datas[0]['count'];?>)</a></td>
  <?php if($i%7==0){ ?></tr><tr><?php } ?>
  <?php $i+=1;?>
  <?php endforeach; ?>
</table>
戻る