<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th height="19" class="status_title">リスト</th>
        </tr>
      <?php foreach($data as $datas): ?>
      <tr bgcolor="#000000">
        <td class="status_data"><?php echo $datas['Message']['title'];?><?php echo $datas['Message']['insert_time'];?></td>
        </tr>
      <tr>
        <td><hr></td>
        </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
</table>

