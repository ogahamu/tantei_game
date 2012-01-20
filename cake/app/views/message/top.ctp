<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><H2>1.お知らせ</H2><a href="/cake/message/detail/1/">-もっと見る-</a>
      <hr></td>
  </tr>
  <tr>
    <td><table width="310" border="0" cellpadding="0" cellspacing="0">
      <?php foreach($data1 as $datas1): ?>
      <tr bgcolor="#000000">
        <td></td>
        <td><span class="mail_title"><?php echo $datas1['Message']['title'] ?>(<?php echo $datas1['Message']['insert_time'] ?>)</span></td>
      </tr>
      <tr>
        <td colspan="3"><hr></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
  <tr>
    <td><H2>2.事件の通知</H2><a href="/cake/message/detail/2/">-もっと見る-</a>
      <hr></td>
  </tr>
  <tr>
    <td><table width="310" border="0" cellpadding="0" cellspacing="0">
      <?php foreach($data2 as $datas2): ?>
      <tr bgcolor="#000000">
        <td></td>
        <td><span class="mail_title"><?php echo $datas2['Message']['title'] ?>(<?php echo $datas2['Message']['insert_time'] ?>)</span></td>
      </tr>
      <tr>
        <td colspan="3"><hr></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
  <tr>
    <td><H2>3.事件解決の記録</H2><a href="/cake/message/detail/3/">-もっと見る-</a>
    <hr></td>
  </tr>
  <tr>
    <td><table width="310" border="0" cellpadding="0" cellspacing="0">
      <?php foreach($data3 as $datas3): ?>
      <tr bgcolor="#000000">
        <td></td>
        <td><span class="mail_title"><?php echo $datas3['Message']['title'] ?>(<?php echo $datas3['Message']['insert_time'] ?>)</span></td>
      </tr>
      <tr>
        <td colspan="3"><hr></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
  <tr>
    <td><H2>4.対決の記録</H2><a href="/cake/message/detail/1/">-もっと見る-</a><br>
    <hr></td>
  </tr>
  <tr>
    <td><table width="310" border="0" cellpadding="0" cellspacing="0">
      <?php foreach($data4 as $datas4): ?>
      <tr bgcolor="#000000">
        <td></td>
        <td><span class="mail_title"><?php echo $datas4['Message']['title'] ?>(<?php echo $datas4['Message']['insert_time'] ?>)</span></td>
      </tr>
      <tr>
        <td colspan="3"><hr></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

