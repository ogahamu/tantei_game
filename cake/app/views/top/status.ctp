<?php foreach($data as $datas): ?>
 <table width="320" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td colspan="3"><H1>図書室_画面<img src="/img/tosyokan_img.png" width="320" height="120"></H1>
     <br>       <table width="320" border="0" id="message">
       <tr>
         <td>「推理小説」を１冊読むことで、自分の能力を一つ上昇できます。<br>
          ※推理小説は事件解決、真相解明、一騎打ち成功、またはガチャで貰えます。</td>
       </tr>
     </table></td>
   </tr>
  <tr>
     <td colspan="3">ステータス</td>
   </tr>
  <tr>
     <td width="59">体力</td>
     <td width="153"><?php echo $datas['Member']['max_power']; ?> </td>
     <td width="94"><a href="/cake/top/status_up/1/">読む<img src="/img/book-a1-16si.gif" width="18" height="18">×<?php echo $datas['Member']['star_count']; ?>つ</a></td>
   </tr>
  <tr>
     <td>推理力</td>
     <td><?php echo $datas['Member']['attack_power']; ?></td>
     <td><a href="/cake/top/status_up/2/">読む<img src="/img/book-a1-16si.gif" width="18" height="18">×<?php echo $datas['Member']['star_count']; ?>つ</a></td>
   </tr>
  <tr>
     <td>弁護力</td>
     <td><?php echo $datas['Member']['defence_power']; ?></td>
     <td><a href="/cake/top/status_up/3/">読む<img src="/img/book-a1-16si.gif" width="18" height="18">×<?php echo $datas['Member']['star_count']; ?>つ</a></td>
   </tr>
  <tr>
     <td>運</td>
     <td><?php echo $datas['Member']['fortune_power']; ?> </td>
     <td><a href="/cake/top/status_up/4/">読む<img src="/img/book-a1-16si.gif" width="18" height="18">×<?php echo $datas['Member']['star_count']; ?>つ</a></td>
   </tr>
  <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
  <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
</table>
<?php endforeach; ?>
